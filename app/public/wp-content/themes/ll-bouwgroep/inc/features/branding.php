<?php
/**
 * Login page and dashboard branding.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Styles the WordPress login screen in brand colors.
 *
 * @return void
 */
function llb_login_styles() {
	$red   = trim( (string) llb_get_option( 'llb_color_red' ) );
	$green = trim( (string) llb_get_option( 'llb_color_green' ) );

	if ( '' === $red ) {
		$red = '#D0021B';
	}
	if ( '' === $green ) {
		$green = '#0B6B3A';
	}

	$logo = llb_asset( 'images/ll-logo.webp' );

	$css = '
		body.login{background:#F5F5F3}
		.login h1 a{background-image:url(' . esc_url_raw( $logo ) . ');background-size:contain;background-position:center;width:200px;height:72px;margin-bottom:20px}
		.login form{border:1px solid #E3E2DE;border-radius:12px;box-shadow:0 8px 24px rgba(31,31,31,.06)}
		.login form .input,.login input[type=text],.login input[type=password]{border-radius:12px}
		.login .button.button-primary{background:' . esc_attr( $red ) . ';border-color:' . esc_attr( $red ) . ';border-radius:12px;text-shadow:none;box-shadow:none;font-weight:600}
		.login .button.button-primary:hover,.login .button.button-primary:focus{background:#A80016;border-color:#A80016}
		.login #backtoblog a,.login #nav a{color:' . esc_attr( $green ) . '}
		.login #backtoblog a:hover,.login #nav a:hover{color:' . esc_attr( $red ) . '}
		.login .message,.login .notice{border-left-color:' . esc_attr( $green ) . ';border-radius:12px}
		.login #login_error{border-left-color:' . esc_attr( $red ) . ';border-radius:12px}
		:focus{outline-color:' . esc_attr( $red ) . '}
	';

	wp_register_style( 'llb-login', false, array(), LLB_VERSION );
	wp_enqueue_style( 'llb-login' );
	wp_add_inline_style( 'llb-login', $css );
}
add_action( 'login_enqueue_scripts', 'llb_login_styles' );

/**
 * Points the login logo at the website instead of wordpress.org.
 *
 * @return string
 */
function llb_login_header_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'llb_login_header_url' );

/**
 * Uses the company name as login logo title.
 *
 * @return string
 */
function llb_login_header_text() {
	$company = trim( (string) llb_get_option( 'llb_company_name' ) );

	return '' !== $company ? $company : get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'llb_login_header_text' );

/**
 * Replaces the dashboard footer text.
 *
 * @param string $text Default footer text.
 * @return string
 */
function llb_admin_footer_text( $text ) {
	$custom = llb_theme_option_text( 'admin_footer_text' );

	return '' !== $custom ? esc_html( $custom ) : $text;
}
add_filter( 'admin_footer_text', 'llb_admin_footer_text' );
