<?php
namespace Cyrille\NounCaptcha ;

require_once(__DIR__.'/Plugin.php');

/**
 * 
 */
class Front extends Plugin
{
    public function __construct()
    {
        parent::__construct();

        /*Utils::debug(__METHOD__, [
            'opts' => get_option( Plugin::NAME ),
        ]);*/

    }
}