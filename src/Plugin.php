<?php
namespace Cyrille\NounCaptcha ;

require_once(__DIR__.'/Utils.php');

/**
 * 
 */
class Plugin
{
    const NAME = 'nouncaptcha' ;
    public $templates_dir ;
    public $plugin_dir ;
    public $plugin_url ;
    public $images_url ;
    public $nouns_dir ;
    public $nouns_url ;

    public function __construct()
    {
        /*
        define('NOUNCAPTCHA_DIR_NAME', basename( dirname(__FILE__) ));
define('NOUNCAPTCHA_ROOT', WP_PLUGIN_DIR . '/' . NOUNCAPTCHA_DIR_NAME);
define('NOUNCAPTCHA_URL', WP_PLUGIN_URL . '/' . NOUNCAPTCHA_DIR_NAME);
define('NOUNCAPTCHA_LIBRARY', NOUNCAPTCHA_ROOT . '/library');
define('NOUNCAPTCHA_TEMPLATE', NOUNCAPTCHA_ROOT . '/templates');
define('NOUNCAPTCHA_IMAGES_URL',NOUNCAPTCHA_URL . '/images');

define('NOUNCAPTCHA_NOUNS_PATH', NOUNCAPTCHA_ROOT . '/nouns' );
define('NOUNCAPTCHA_NOUNS_URL', NOUNCAPTCHA_URL . '/nouns' );
        */
        $folder = basename( dirname(__DIR__) ) ;
        $this->plugin_dir = WP_PLUGIN_DIR . '/'.$folder ;
        $this->plugin_url = WP_PLUGIN_URL . '/'.$folder ;

        $this->templates_dir = $this->plugin_dir.'/templates';

        $this->images_url = $this->plugin_url.'/images' ;
        $this->nouns_dir = $this->plugin_dir.'/nouns';
        $this->nouns_url = $this->plugin_url.'/nouns';
    }

    function get_option( $name, $default=null )
    {
        $opts = get_option( Plugin::NAME );
        if( empty($opts) )
            $opts = [];
    	return isset($opts[$name]) ? $opts[$name] : $default ;
    }

    function set_option( $name, $value )
    {
        $opts = get_option( Plugin::NAME );
        if( empty($opts) )
            $opts = [];
        $opts[$name] = $value ;
	    update_option(Plugin::NAME,$opts);
    }

    public function getNouns()
    {
        static $nouns = null ;

        if( !empty($nouns) )
            return $nouns ;

        $lang = substr( get_locale(), 0, 2 );
        if ($dir = opendir($this->nouns_dir) )
        {
            while( false !== ($f = readdir($dir)) )
            {
                //echo "$f\n";
                if( $f[0] == '.' )
                    continue ;
                if( ! is_dir( $this->nouns_dir.'/'.$f ) )
                    continue ;
                
                $captcha_file = $this->nouns_dir.'/'.$f.'/captchas_'.$lang.'.php' ;
                if( ! file_exists($captcha_file ))
                    $captcha_file = $this->nouns_dir.'/'.$f.'/captchas.php' ;
                if( ! file_exists($captcha_file ))
                    continue ;
                $nouns[$f] = require($captcha_file) ;
            }
        }
        //Utils::debug(__METHOD__,$nouns);
        return $nouns ;
    }

    public function getNounsNames()
    {
        
        /*
        $names = [] ;
        if ($dir = opendir($this->nouns_dir) )
        {
            while( false !== ($f = readdir($dir)) )
            {
                //echo "$f\n";
                if( $f[0] == '.' )
                    continue ;
                if( is_dir( $this->nouns_dir.'/'.$f ) )
                    $captcha_file = $this->nouns_dir.'/'.$f.'/captchas.php' ;
                if( ! file_exists($captcha_file ))
                    continue ;
                $names[] = $f ;
            }
        }*/
        return array_keys( $this->getNouns() );
    }
}
