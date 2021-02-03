<?php
namespace Cyrille\NounCaptcha ;

require_once(__DIR__.'/Utils.php');

/**
 * 
 */
class Plugin
{
    const NAME = 'nouncaptcha' ;

    const IMAGES_COUNT = 5 ;

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
        $folder = basename( dirname(__DIR__) ) ;
        $this->plugin_dir = WP_PLUGIN_DIR . '/'.$folder ;
        $this->plugin_url = WP_PLUGIN_URL . '/'.$folder ;

        $this->templates_dir = $this->plugin_dir.'/templates';

        $this->images_url = $this->plugin_url.'/images' ;
        $this->nouns_dir = $this->plugin_dir.'/nouns';
        $this->nouns_url = $this->plugin_url.'/nouns';

        $this->createServices();
    }

    protected function createServices()
    {
        if( $this->get_option('on_comment') )
        {
            require_once(__DIR__.'/Services/Comment.php');
            new Services\Comment( $this );
        }

        if( $this->get_option('on_wpcf7') )
        {
            require_once(__DIR__.'/Services/ContactForm7.php');
            new Services\ContactForm7( $this );
        }

        if( $this->get_option('on_cma') )
        {
            require_once(__DIR__.'/Services/CMAnswers.php');
            new Services\CMAnswers( $this );
        }
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

    protected function computeQuestion()
    {
        $images_count = self::IMAGES_COUNT ;

        //
        // Charge toutes les questions des nouns actifs.
        //

        $questions = [];
        foreach( $this->get_option('nouns', []) as $name )
        {
            $noun = $this->getNoun( $name );
            if( $noun == null )
                continue ;
            for( $i=0; $i<count($noun['questions']); $i ++ )
            {
                $questions[] = [$i, $noun] ;
            }
        }

        //
        // Pioche une question
        //

        $i = rand(0,count($questions)-1) ;
        $noun = $questions[ $i ][1];

        $question = $noun['questions'][ $questions[$i][0] ];
        // Keep some other data
        $question['attribution'] = $noun['attribution'];
        $question['folder'] = \substr( $noun['folder'], strlen(ABSPATH)-1 );

        // Randomize images
        shuffle($question['images']);
        // Keep only some
        $question['images'] = array_slice( $question['images'], 0 , $images_count - 1 );
        // Add the good answer image
        $question['images'][] = $question['answer'];
        // Randomize images
        shuffle($question['images']);

        // Then retrieve the position of the good answer
        for( $i=0; $i<count($question['images']); $i++ )
        {
            if( $question['images'][$i] == $question['answer'] )
            {
                // replace answer image filename by it's position
                $question['answer'] = $i ;
                return $question ;
            }
        }
        return null ;
    }

    public function captchaHtml( $form = null, $class = null )
    {

        $question = $this->computeQuestion();

        /*Utils::debug(__METHOD__,[
            'WP_CONTENT_DIR' => WP_CONTENT_DIR,
            $question,
        ]);*/
        //unset($question['answer']);

        $data = [
            'q' => $question['answer'],
        ];
        // Json encoding need heavier load
        // but php serialize is less secure with data that comes for outside.
        $question['response'] = Utils::encrypt( \json_encode($data), NONCE_KEY );

        ob_start();
        require_once $this->templates_dir . '/captcha-html.php' ;
        $h = ob_get_contents() ;
        ob_end_clean();

        if( !empty($form) )
        {
            $h = $form . $h ;
        }
        return $h ;
    }

    /**
     * Check input data for valid Captcha response.
     *
     * @return bool
     */
    public function captchaCheck( &$input )
    {
        if( empty($input) || (!isset($input['nouncaptcha_response'])) || !isset($input['nouncaptcha_image']) )
            return false ;
        // Decrypt response data
        $response = \json_decode( Utils::decrypt( $input['nouncaptcha_response'], NONCE_KEY ) );
        if( empty($response) )
            return false ;
        // Check image response
        if(  (intval($input['nouncaptcha_image'])-1) != $response->q )
            return false ;
        return true ;
    }

    /**
     * Folders to explore for Nouns.
     * @return array
     */
    public function getNounsFolders()
    {
        static $folders ;
        if( empty($folders) )
        {
            $folders = [
                $this->nouns_dir
            ];
            if( \file_exists( get_stylesheet_directory().'/nouns') )
                $folders[] = get_stylesheet_directory().'/nouns' ;
    
        }
        return $folders ;
    }

    /**
     * Get current user language
     *
     * @return string
     */
    protected function getLang()
    {
        return  \substr( get_locale(), 0, 2 );
    }

    public function &getNoun( $name )
    {
        $lang = $this->getLang();

        foreach( $this->getNounsFolders() as $folder )
        {
            // Load a Noun
            $noun = $this->loadNoun( $folder, $name, $lang );
            if( $noun != null )
                return $noun ;
        }
        return null ;
    }

    /**
     * Look in $this->nouns_dir for subfolders.
     * It takes each subfolder name a the Noun name.
     * Load file "captchas.php" found in Noun folder,
     * and override its values if file "captchas_<lang>.php" exists.
     *
     * @return Array
     */
    public function getNouns()
    {
        static $nouns = null ;

        if( !empty($nouns) )
            return $nouns ;

        $lang = $this->getLang();

        /*Utils::debug(__METHOD__,[
            //get_stylesheet_directory(),
        ]);*/

        foreach( $this->getNounsFolders() as $folder )
        {
            if ($dir = opendir($folder) )
            {
                while( false !== ($f = readdir($dir)) )
                {
                    //echo "$f\n";
                    if( $f[0] == '.' )
                        continue ;

                    // Load a Noun
                    $n = $this->loadNoun( $folder, $f, $lang );
                    if( $n != null )
                        $nouns[$f] = $n ;

                    /*
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
                    }*/
                }
            }
        }
        //Utils::debug(__METHOD__,$nouns);
        return $nouns ;
    }

    /**
     * Undocumented function
     *
     * @param [type] $folder
     * @param [type] $name
     * @return void
     */
    protected function loadNoun( $folder, $name, $lang )
    {
        $ff = $folder.'/'.$name ;
        if( ! is_dir( $ff ) )
            return null ;
        $captcha_file = $ff.'/captchas.php' ;
        if( ! file_exists($captcha_file ))
            return null ;
        $noun = require($captcha_file) ;

        // Overide language's values (like question text) for this Noun
        $captcha_file = $ff.'/captchas_'.$lang.'.php' ;
        if( file_exists($captcha_file ))
        {
            $overide = require($captcha_file);
            $noun = \array_replace_recursive($noun, $overide);
        }

        $noun['folder'] = $ff ;
        return $noun ;
    }

    public function getNounsNames()
    {
        return array_keys( $this->getNouns() );
    }
}
