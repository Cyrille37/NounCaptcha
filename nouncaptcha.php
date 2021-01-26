<?php
/*
 Plugin Name: NounCaptcha
Plugin URI: http://profiles.wordpress.org/cyrille37
Description: Adds NounCaptcha anti-spam solution to WordPress on the comment form and registration form.
Version: 1.0
Author: Cyrille Giquello
Author URI: http://cyrille37.myopenid.com/
License: GNU LGPL v3
*/

// for backward compatibility - 2.0
<<<<<<< HEAD
defined('WP_PLUGIN_DIR')
	or define('WP_PLUGIN_DIR', ABSPATH . '/wp-content/plugins');
=======
defined('WP_PLUGIN_DIR') or define('WP_PLUGIN_DIR', ABSPATH . '/wp-content/plugins');
>>>>>>> 872cbda841303318975071afaebb3203ce0eb19b

// define absolute path to plugin
define('NOUNCAPTCHA_DIR_NAME', basename( dirname(__FILE__) ));
define('NOUNCAPTCHA_ROOT', WP_PLUGIN_DIR . '/' . NOUNCAPTCHA_DIR_NAME);
define('NOUNCAPTCHA_URL', WP_PLUGIN_URL . '/' . NOUNCAPTCHA_DIR_NAME);
define('NOUNCAPTCHA_LIBRARY', NOUNCAPTCHA_ROOT . '/library');
define('NOUNCAPTCHA_TEMPLATE', NOUNCAPTCHA_ROOT . '/templates');
<<<<<<< HEAD
define('NOUNCAPTCHA_IMAGES_URL',NOUNCAPTCHA_URL . '/images');
=======
>>>>>>> 872cbda841303318975071afaebb3203ce0eb19b

define('NOUNCAPTCHA_NOUNS_PATH', NOUNCAPTCHA_ROOT . '/nouns' );
define('NOUNCAPTCHA_NOUNS_URL', NOUNCAPTCHA_URL . '/nouns' );

define('NOUNCAPTCHA_BAD_CONFIG_MESSAGE', '<h1 style="color: red">Plugin NounCaptcha is badly configured !</h1>');
define('NOUNCAPTCHA_ERROR_MESSAGE', 'The response you submitted was incorrect. Please try again.');
define('NOUNCAPTCHA_ERROR_MESSAGE_BR', 'The response you submitted was incorrect.<br/>Please try again.');

$nouncaptcha_settings = get_option( 'nouncaptcha_settings' );
if( ! is_array($nouncaptcha_settings) )
{
	$nouncaptcha_settings = array();
}

function nouncaptcha_get_option( $name, $default=null )
{
	global $nouncaptcha_settings ;
	return isset($nouncaptcha_settings[$name]) ? $nouncaptcha_settings[$name] : $default ;
}

function nouncaptcha_set_option( $name, $value )
{
	global $nouncaptcha_settings ;
	update_option('nouncaptcha_settings',$nouncaptcha_settings);
}

<<<<<<< HEAD
=======
add_action('init', 'nouncaptcha_init', 100);
add_action( 'plugins_loaded', 'nouncaptcha_plugins_loaded', 1 );

>>>>>>> 872cbda841303318975071afaebb3203ce0eb19b
function nouncaptcha_init() {
	//global $wpdb;
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'nouncaptcha.js', plugins_url( 'js/nouncaptcha.js', __FILE__ ) );
}
<<<<<<< HEAD
add_action('init', 'nouncaptcha_init', 100);

/*
function nouncaptcha_plugins_loaded() {
}
add_action( 'plugins_loaded', 'nouncaptcha_plugins_loaded', 1 );
*/
=======

function nouncaptcha_plugins_loaded() {
}
>>>>>>> 872cbda841303318975071afaebb3203ce0eb19b

if (is_admin()) {
	require_once NOUNCAPTCHA_LIBRARY . '/admin.php';

}else {
	require_once NOUNCAPTCHA_LIBRARY . '/public.php';

}
