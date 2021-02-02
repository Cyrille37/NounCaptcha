<?php
namespace Cyrille\NounCaptcha\Services ;

use Cyrille\NounCaptcha\Utils ;
use Cyrille\NounCaptcha\Plugin ;

class Comment
{
	/**
	 * Undocumented variable
	 *
	 * @var Plugin
	 */
	protected $nc ;

    public function __construct( Plugin $nounCaptcha )
    {
        Utils::debug(__METHOD__);

		$this->nc = $nounCaptcha ;

        if( is_blog_admin() )
        {
        }
        else if( is_admin() )
        {
        }
        else
        {
            // add captcha to comment form
            add_filter( 'comment_form_defaults', [$this, 'form']);
            // check captcha at comment form submit
            add_filter( 'preprocess_comment', [$this,'check'] );       
        }
        
    }

    public function form( Array $form )
    {
        //Utils::debug(__METHOD__, $form );

        $form['fields']['captcha'] = $this->nc->captchaHtml();

        return $form ;
    }

    public function check( $comment )
    {
        if ( empty( $_POST ) )
            return ;

        // skip captcha for comment replies from the admin menu
        if ( isset( $_POST['action'] ) && $_POST['action'] == 'replyto-comment'
            && ( check_ajax_referer( 'replyto-comment', '_ajax_nonce', false )
                || check_ajax_referer( 'replyto-comment', '_ajax_nonce-replyto-comment', false ) )
            )
        {
			return $comment;
		}

        if( $this->nc->captchaCheck($_POST) )
        {
            return $comment ;
        }

        //$e = new \WP_Error() and redirect is not in WP world :-(
        wp_die( __('Invalid captcha') );
    }

}
