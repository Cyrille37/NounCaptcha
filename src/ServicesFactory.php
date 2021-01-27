<?php
namespace Cyrille\NounCaptcha ;

require_once(__DIR__.'/services/Comment.php');
require_once(__DIR__.'/services/ContactForm7.php');

class ServicesFactory
{
    protected $nc ;

    public function __construct( $nounCaptcha )
    {
        $this->nc = $nounCaptcha ;

        if( $this->nc->get_option('on_comment') )
        {
            new Services\Comment();
        }

        if( $this->nc->get_option('on_wpcf7') )
        {
            new Services\ContactForm7();
        }

    }
}