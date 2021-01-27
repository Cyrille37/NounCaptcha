<?php
namespace Cyrille\NounCaptcha ;

require_once(__DIR__.'/Plugin.php');

/**
 * 
 */
class Back extends Plugin
{
    public function __construct()
    {
        if( $this->ignoreRequest() )
            return ;

        parent::__construct();

        add_action('admin_init', [$this, 'wp_admin_init'] );
        add_action('admin_menu', [$this, 'wp_admin_menu']);

        if( ! isset($GLOBALS['pagenow']) || ($GLOBALS['pagenow'] != 'options-general.php') )
            return ;

        add_action('admin_enqueue_scripts', [$this, 'wp_admin_enqueue_scripts']);
    }

    protected function ignoreRequest()
    {
        if( defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) )
        {
            switch($_REQUEST['action'])
            {
                case 'heartbeat':
                case 'closed-postboxes':
                case 'health-check-site-status-result':
                case 'oembed-cache':
                    return true ;
            }
        }

        $uri = $_SERVER['REQUEST_URI'];

        // Javacript .map files when browser in dev mode.
        if( strpos($uri, '.map', -5 ) !== false )
            return true ;

        return false ;
    }

    /**
     *
     * @return void
     */
    public function wp_admin_init()
    {
        // Register our settings so that $_POST handling is done for us
        register_setting( Plugin::NAME, Plugin::NAME );
    }

    public function wp_admin_enqueue_scripts()
    {
        Utils::debug(__METHOD__);

        $handle = Plugin::NAME.'-admin-css' ;
        $ver = filemtime( $this->plugin_dir . '/css/admin.css' );
        wp_enqueue_style( $handle, $this->plugin_url . '/css/admin.css', [], $ver, 'all');

        $handle = Plugin::NAME.'-admin-js' ;
        $ver = filemtime( $this->plugin_dir . '/js/admin.js' );
        wp_register_script( $handle, $this->plugin_url . '/js/admin.js', ['jquery'], $ver, true );
        wp_localize_script( $handle, Plugin::NAME, [
            'nouns_url' => $this->nouns_url,
            'nouns'=>$this->getNouns()
        ] );
        wp_enqueue_script( $handle );

    }

    /**
     * Add NounCaptcha settings link to admin menu
     * @return void
    */
    public function wp_admin_menu()
    {
        //add_menu_page(
        // NOUNCAPTCHA_URL.'/images/nouncaptcha-logo-16x16.png'

        add_options_page(
            __('NounCaptcha', Plugin::NAME),
            __('NounCaptcha', Plugin::NAME),
            'manage_options',
            Plugin::NAME,
            [$this,'options_page']
        );
    
    }
    
    /**
     * Displays the NounCaptcha options page
     * @return void
     */
    public function options_page() {
        
        // user has the required capability
        if( ! current_user_can('manage_options') )
            wp_die(__('Argh!'));

        //Utils::debug( __METHOD__, 'nouns:',$this->get_option('nouns') );

        require_once $this->templates_dir  . '/options-page.php';
    }

}
