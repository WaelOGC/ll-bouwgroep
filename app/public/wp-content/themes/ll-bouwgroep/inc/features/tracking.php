<?php
/**
 * Consent-gated tracking snippets.
 *
 * Google Analytics and Search Console are handled by Site Kit by Google, not here.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether a consent plugin the theme can read is available.
 *
 * @return bool
 */
function llb_consent_api_available() {
	if ( function_exists( 'wp_has_consent' ) ) {
		return true;
	}

	return function_exists( 'cmplz_has_consent' );
}

/**
 * Whether the visitor consented to a category.
 *
 * Without a consent plugin nothing is ever printed.
 *
 * @param string $category Consent category (statistics|marketing|functional|preferences).
 * @return bool
 */
function llb_has_consent( $category ) {
	$category = sanitize_key( (string) $category );

	if ( function_exists( 'wp_has_consent' ) ) {
		return (bool) wp_has_consent( $category );
	}

	if ( function_exists( 'cmplz_has_consent' ) ) {
		return (bool) cmplz_has_consent( $category );
	}

	return false;
}

/**
 * Whether any tracking snippet is filled in.
 *
 * @return bool
 */
function llb_tracking_has_any_code() {
	foreach ( array( 'tracking_head', 'tracking_body', 'tracking_footer' ) as $key ) {
		if ( '' !== llb_theme_option_text( $key ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Whether tracking output is allowed for the current request.
 *
 * @return bool
 */
function llb_tracking_allowed() {
	if ( is_admin() || is_preview() || is_customize_preview() ) {
		return false;
	}

	return ! ( function_exists( 'llb_maintenance_should_block' ) && llb_maintenance_should_block() );
}

/**
 * Prints one snippet when its consent category is granted.
 *
 * @param string $key          Code option key.
 * @param string $category_key Consent category option key.
 * @return void
 */
function llb_print_tracking_snippet( $key, $category_key ) {
	if ( ! llb_tracking_allowed() ) {
		return;
	}

	$code = trim( (string) llb_theme_option( $key ) );
	if ( '' === $code ) {
		return;
	}

	if ( ! llb_has_consent( (string) llb_theme_option( $category_key ) ) ) {
		return;
	}

	echo "\n" . $code . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- admin-provided snippet, saved with the unfiltered_html capability.
}

/**
 * Head snippet.
 *
 * @return void
 */
function llb_tracking_head() {
	llb_print_tracking_snippet( 'tracking_head', 'tracking_head_category' );
}
add_action( 'wp_head', 'llb_tracking_head', 99 );

/**
 * Body-start snippet.
 *
 * @return void
 */
function llb_tracking_body() {
	llb_print_tracking_snippet( 'tracking_body', 'tracking_body_category' );
}
add_action( 'wp_body_open', 'llb_tracking_body', 2 );

/**
 * Footer snippet.
 *
 * @return void
 */
function llb_tracking_footer() {
	llb_print_tracking_snippet( 'tracking_footer', 'tracking_footer_category' );
}
add_action( 'wp_footer', 'llb_tracking_footer', 99 );

/**
 * Warns in the dashboard when tracking code is saved without a consent plugin.
 *
 * @return void
 */
function llb_tracking_consent_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( llb_consent_api_available() || ! llb_tracking_has_any_code() ) {
		return;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( $screen && 'dashboard' !== $screen->base && ! llb_is_theme_options_screen( isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '' ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only screen check.
		return;
	}

	echo '<div class="notice notice-error"><p>' . esc_html__( 'L&L Bouwgroep: tracking code is saved but no consent plugin (WP Consent API / Complianz) is active, so the code is never printed on the website.', 'll-bouwgroep' ) . '</p></div>';
}
add_action( 'admin_notices', 'llb_tracking_consent_admin_notice' );
