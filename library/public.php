<?php

<<<<<<< HEAD
//wp_enqueue_style( 'nouncaptcha_css', NOUNCAPTCHA_URL. '/css/public.css'  );
=======
wp_enqueue_style( 'nouncaptcha_css', NOUNCAPTCHA_URL. '/css/public.css'  );
>>>>>>> 872cbda841303318975071afaebb3203ce0eb19b

// add Sweet Captcha to registration form
if ( nouncaptcha_get_option('on_form_registration') ) {

	add_action('register_form', 'nouncaptcha_registration_form' );
	add_filter('registration_errors', 'nouncaptcha_register_form_check', 1);

}

// add Sweet Captcha to comment form
if ( nouncaptcha_get_option( 'on_comment' ) ) {

	//add_filter( 'comment_form_defaults', 'nouncaptcha_comment_form');
	//add_filter( 'comment_form_field_email', 'nouncaptcha_comment_form');
	add_filter( 'comment_form_field_comment', 'nouncaptcha_comment_form');
		
	// pre_comment_on_post
	add_filter( 'preprocess_comment', 'nouncaptcha_comment_form_check', 1 );
}

function nouncaptcha_get_secret_key()
{
	$secret_key = nouncaptcha_get_option( 'secret_key' );
	if( isset($secret_key))
	{
		return $secret_key ;
	}
	$secret_key = sha1(microtime().rand(0,9999).microtime().rand(0,9999));
	nouncaptcha_set_option('secret_key',$secret_key);
}

/**
 * Add NounCaptcha to registration form
 * @return boolean
 */
function nouncaptcha_registration_form() {

	if( ! nouncaptcha_get_option('on_form_registration') )
		return true ;

	require_once NOUNCAPTCHA_TEMPLATE . '/captcha-html.php';

	return true;
}

/**
 * Add NounCaptcha registration form check
 * @param $errors
 * @return WP_Errors
 */
function nouncaptcha_register_form_check($errors) {

	$code = isset($_POST['nouncaptcha_code']) ? $_POST['nouncaptcha_code'] : null ;
	$response = isset($_POST['nouncaptcha_response']) ? $_POST['nouncaptcha_response'] : null ;
	if( ! isset($response) || ! isset($code ) )
		$errors->add( 'captcha_wrong', '<strong>' . __( 'ERROR', 'nouncaptcha' ) . '</strong>: ' . __(NOUNCAPTCHA_ERROR_MESSAGE, 'nouncaptcha' ) );
	else
	{
		$nouncaptcha_code = sha1(nouncaptcha_get_secret_key().($response-1));
		if( $code != $nouncaptcha_code )
			$errors->add( 'captcha_wrong', '<strong>' . __( 'ERROR', 'nouncaptcha' ) . '</strong>: ' . __(NOUNCAPTCHA_ERROR_MESSAGE, 'nouncaptcha' ) );
	}

	//error_log( '======================== ' .$response.' '.$code);
	return $errors;
}

/**
 * Add NounCaptcha to comment form
 * @return boolean
 */
function nouncaptcha_comment_form($default) {

	global $user_ID, $wp_version;

	if ( isset($user_ID) && (int)$user_ID > 0 ) {
		return $default;
	}

	$with_require_star = true ;

	ob_start();
	require_once NOUNCAPTCHA_TEMPLATE . '/captcha-html.php' ;
	$content = ob_get_contents() ;
	ob_end_clean();

	$default .= $content ;

	return $default ;
}

/**
 * Add NounCaptcha comment form check
 * @param $errors
 * @return WP_Errors
 */
function nouncaptcha_comment_form_check( $commentdata )
{
	$code = isset($_POST['nouncaptcha_code']) ? $_POST['nouncaptcha_code'] : null ;
	$response = isset($_POST['nouncaptcha_response']) ? $_POST['nouncaptcha_response'] : null ;
	if( ! isset($response) || ! isset($code ) )
		wp_die( __(NOUNCAPTCHA_ERROR_MESSAGE) );

	$nouncaptcha_code = sha1(nouncaptcha_get_secret_key().($response-1));
	if( $code != $nouncaptcha_code )
		wp_die( __(NOUNCAPTCHA_ERROR_MESSAGE) );

	//error_log( '======================== ' .$response.' '.$code);
	return $commentdata;

}

