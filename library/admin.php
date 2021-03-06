<?php

add_action( 'admin_init', 'nouncaptcha_admin_init' );
// add link to settings menu
add_action('admin_menu', 'nouncaptcha_admin_menu');

/**
 *
 * @return void
 */
function nouncaptcha_admin_init()
{
	// Register our settings so that $_POST handling is done for us

	register_setting( 'nouncaptcha_settings', 'nouncaptcha_settings' );
	wp_enqueue_style( 'nouncaptcha_css', NOUNCAPTCHA_URL. '/css/admin.css'  );

}

/**
 * Add NounCaptcha settings link to admin menu
 * @return void
*/
function nouncaptcha_admin_menu()
{
	//add_menu_page(
	// NOUNCAPTCHA_URL.'/images/nouncaptcha-logo-16x16.png'

	add_options_page(
		__('NounCaptcha', 'nouncaptcha'),
		__('NounCaptcha', 'nouncaptcha'),
		'manage_options',
		'nouncaptcha',
		'nouncaptcha_options_page'
	);

}

/**
 * Displays the  NounCaptcha options page
 * @return void
 */
function nouncaptcha_options_page() {
	
	//must check that the user has the required capability
	if (!current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}

	require_once NOUNCAPTCHA_TEMPLATE . '/admin-options.php';

}

