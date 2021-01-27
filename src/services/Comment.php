<?php
namespace Cyrille\NounCaptcha\Services ;

use Cyrille\NounCaptcha\Utils ;

class Comment
{
    public function __construct()
    {
        Utils::debug(__METHOD__);

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

}