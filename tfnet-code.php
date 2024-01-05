<?php
/**
 * @package TFnet_Code
 * @version 1.0.2
 */
/*
Plugin Name:TitanFusion.net Code
Plugin URI: https://www.titanfusion.net/projects/tfnet-code
Description: This plug-in will add any code necessary for TitanFusion.net to properly function. The intent is to maintain the additional code across theme and WordPress version updates.
Author: Alexandar I. Tzanov
Version: 1.0.2
Author URI: https://www.alexandartzanov.com/
*/

// Mail hook to phpmailer
if ( ! function_exists( 'send_smtp_email' ) ) :

	/**
	 * @name send_smtp_mail
	 * @description set values for SMTP mail
	 * @return void
	 */
	function send_smtp_email( $phpmailer ) {
		$phpmailer->isSMTP();
		$phpmailer->Host       = SMTP_HOST;
		$phpmailer->SMTPAuth   = SMTP_AUTH;
		$phpmailer->Port       = SMTP_PORT;
		$phpmailer->Username   = SMTP_USER;
		$phpmailer->Password   = SMTP_PASS;
		$phpmailer->SMTPSecure = SMTP_SECURE;
		$phpmailer->From       = SMTP_FROM;
		$phpmailer->FromName   = SMTP_NAME;
	}

endif;

// Enable client caching of content.
if ( ! function_exists( 'tfnet_client_cache' ) ) :
	/**
	 * @name tfnet_client_cache
	 * @description Enable client caching. Disabled by default by WordPress for compatibility with third-party cache plug-ins. Will run last.
	 * @return array
	 */
	function tfnet_client_cache( $headers, $wp ) {
		$current_request_path = $wp->request;

		// Update headers if not viewing WordPress admin dashboard
		if ( ! empty( $current_request_path) && ! is_admin() ) {
			$headers[ 'Cache-Control' ] = 'private, max-age=365';
		}
		
		return $headers;
	}
endif;

// Add Filters
add_filter( 'jetpack_remove_login_form', '__return_true' );
add_filter( 'jetpack_sso_bypass_login_forward_wpcom', '__return_true' );
add_filter( 'wp_headers', 'tfnet_client_cache', 100, 2);

// Add Actions
add_action( 'phpmailer_init', 'send_smtp_email' );
