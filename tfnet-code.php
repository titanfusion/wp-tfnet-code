<?php
/**
 * @package TFnet_Code
 * @version 1.2.0
 */
/*
Plugin Name:TitanFusion.net Code
Plugin URI: https://www.titanfusion.net/projects/tfnet-code
Description: This plug-in will add any code necessary for TitanFusion.net to properly function. The intent is to maintain the additional code across theme and WordPress version updates.
Author: Alexandar I. Tzanov
Version: 1.2.0
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

// Add Filters
add_filter( 'jetpack_remove_login_form', '__return_true' );
add_filter( 'jetpack_sso_bypass_login_forward_wpcom', '__return_true' );

// Add Actions
add_action( 'phpmailer_init', 'send_smtp_email' );
