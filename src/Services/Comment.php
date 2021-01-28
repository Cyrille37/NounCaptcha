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
            add_filter( 'comment_form_field_comment', [$this, 'form']);
            // pre_comment_on_post
            add_filter( 'preprocess_comment', [$this,'check'], 1 );       
        }
        
    }

    public function form()
    {
        return $this->nc->captchaHtml() ;
    }

    public function check()
    {

    }

}