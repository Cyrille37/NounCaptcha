<?php
namespace Cyrille\NounCaptcha\Services ;

use Cyrille\NounCaptcha\Utils ;
use Cyrille\NounCaptcha\Plugin ;

class CMAnswers
{
	/**
	 * @var Plugin
	 */
	protected $nc ;

    public function __construct( Plugin $nounCaptcha )
    {
        //Utils::debug(__METHOD__);

		$this->nc = $nounCaptcha ;

        if( is_blog_admin() )
        {
        }
        else if( is_admin() )
        {
        }
        else
        {
            add_action('cma_frontend_answer_form_body_after', [$this,'form'], 100);
            add_action('cma_frontend_question_form_body_after', [$this,'form']);
            add_action('cma_frontend_comment_form_body_after', [$this,'form']);
    
            add_action('cma_question_post_before', [$this,'check']);
            add_action('cma_answer_post_before', [$this,'check'], 1, 2);
            add_action('cma_comment_post_before', [$this,'check'], 1, 2);
        }
        
    }

    public function form()
    {
        //Utils::debug(__METHOD__, $form );

        echo $this->nc->captchaHtml();
    }

    public function check( $comment )
    {
        if ( empty( $_POST ) )
            return ;

        /* TODO
        // skip captcha for comment replies from the admin menu
        if ( isset( $_POST['action'] ) && $_POST['action'] == 'replyto-comment'
            && ( check_ajax_referer( 'replyto-comment', '_ajax_nonce', false )
                || check_ajax_referer( 'replyto-comment', '_ajax_nonce-replyto-comment', false ) )
            )
        {
			return $comment;
		}*/

        if( $this->nc->captchaCheck($_POST) )
        {
            return $comment ;
        }

        //$e = new \WP_Error() and redirect is not in WP world :-(
        wp_die( __('Invalid captcha', Plugin::NAME) );
    }

}
