<?php
/*
 Plugin Name: NounCaptcha
Plugin URI: http://profiles.wordpress.org/cyrille37
Description: Adds NounCaptcha anti-spam solution to WordPress on the comment form and registration form.
Version: 2.1
Author: Cyrille Giquello
Author URI: http://cyrille37.myopenid.com/
License: GNU LGPL v3
*/

/* Debug
require_once(__DIR__.'/src/Utils.php');
use Cyrille\NounCaptcha\Utils ;
Utils::debug(__METHOD__, [
	'request_method'=>$_SERVER['REQUEST_METHOD'],
	'doing_ajax'=> (defined('DOING_AJAX') && DOING_AJAX ? true : false),
	'is_admin'=>is_admin(),
	'is_blog_admin' => is_blog_admin(),
	'pagenow' => isset($GLOBALS['pagenow']) ? $GLOBALS['pagenow'] : 'null',
	'nouncaptcha' => (isset($_POST['nouncaptcha']) ? $_POST['nouncaptcha'] : 'null'),
]);
*/

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
	new Cyrille\NounCaptcha\Front();
}
