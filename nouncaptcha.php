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

require_once(__DIR__.'/src/Utils.php');
use Cyrille\NounCaptcha\Utils ;
Utils::debug(__METHOD__, [
	'doing_ajax'=> (defined('DOING_AJAX') && DOING_AJAX ? true : false),
	'is_admin'=>is_admin(),
	'is_blog_admin' => is_blog_admin(),
	'pagenow' => isset($GLOBALS['pagenow']) ? $GLOBALS['pagenow'] : 'null',
	'request_method'=>$_SERVER['REQUEST_METHOD'],
]);

if( is_blog_admin() )
{
	require_once(__DIR__.'/src/Back.php');
	new Cyrille\NounCaptcha\Back();
}
else if( is_admin() )
{
}
else
{
	require_once(__DIR__.'/src/Front.php');
}

/*
// define absolute path to plugin
define('NOUNCAPTCHA_DIR_NAME', basename( dirname(__FILE__) ));
define('NOUNCAPTCHA_ROOT', WP_PLUGIN_DIR . '/' . NOUNCAPTCHA_DIR_NAME);
define('NOUNCAPTCHA_URL', WP_PLUGIN_URL . '/' . NOUNCAPTCHA_DIR_NAME);
define('NOUNCAPTCHA_LIBRARY', NOUNCAPTCHA_ROOT . '/library');
define('NOUNCAPTCHA_TEMPLATE', NOUNCAPTCHA_ROOT . '/templates');
define('NOUNCAPTCHA_IMAGES_URL',NOUNCAPTCHA_URL . '/images');

define('NOUNCAPTCHA_NOUNS_PATH', NOUNCAPTCHA_ROOT . '/nouns' );
define('NOUNCAPTCHA_NOUNS_URL', NOUNCAPTCHA_URL . '/nouns' );

define('NOUNCAPTCHA_BAD_CONFIG_MESSAGE', '<h1 style="color: red">Plugin NounCaptcha is badly configured !</h1>');
define('NOUNCAPTCHA_ERROR_MESSAGE', 'The response you submitted was incorrect. Please try again.');
define('NOUNCAPTCHA_ERROR_MESSAGE_BR', 'The response you submitted was incorrect.<br/>Please try again.');


function nouncaptcha_init() {
	//global $wpdb;
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'nouncaptcha.js', plugins_url( 'js/nouncaptcha.js', __FILE__ ) );
}
add_action('init', 'nouncaptcha_init', 100);
*/