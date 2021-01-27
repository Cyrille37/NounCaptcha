<?php
namespace Cyrille\NounCaptcha ;

require_once(__DIR__.'/Utils.php');
require_once(__DIR__.'/ServicesFactory.php');

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

    /**
     * Initialize path & url.
     */
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

        new ServicesFactory( $this );
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
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

    /**
     * Folders to explore for Nouns.
     * @return array
     */
    public function getNounsFolders()
    {
        $folders = [
            $this->nouns_dir
        ];
        if( \file_exists( get_stylesheet_directory().'/nouns') )
            $folders[] = get_stylesheet_directory().'/nouns' ;
        return $folders ;
    }

    /**
     * Look in $this->nouns_dir for subfolders.
     * It takes each subfolder name a the Noun name.
     * Load file "captchas.php" found in Noun folder,
     * and override its values if file "captchas_<lang>.php" exists.
     *
     * @return void
     */
    public function getNouns()
    {
        static $nouns = null ;

        if( !empty($nouns) )
            return $nouns ;

        $lang = \substr( get_locale(), 0, 2 );

        Utils::debug(__METHOD__,[
            get_stylesheet_directory(),
        ]);

        foreach( $this->getNounsFolders() as $folder )
        {
            if ($dir = opendir($folder) )
            {
                while( false !== ($f = readdir($dir)) )
                {
                    //echo "$f\n";
                    if( $f[0] == '.' )
                        continue ;
                    $ff = $folder.'/'.$f ;
                    if( ! is_dir( $ff ) )
                        continue ;

                    // Load a Noun
                    $captcha_file = $ff.'/captchas.php' ;
                    if( ! file_exists($captcha_file ))
                        continue ;
                    $nouns[$f] = require($captcha_file) ;

                    // Overide language's values (like question text) for this Noun
                    $captcha_file = $ff.'/captchas_'.$lang.'.php' ;
                    if( file_exists($captcha_file ))
                    {
                        $overide = require($captcha_file);
                        $nouns[$f] = \array_replace_recursive($nouns[$f], $overide);
                    }
                }
            }
        }
        //Utils::debug(__METHOD__,$nouns);
        return $nouns ;
    }

    public function getNounsNames()
    {
        return array_keys( $this->getNouns() );
    }
}
