<?php
/**
 * Contact Form 7 compatibility.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

/**
 * Enqueues CF7 assets only on pages that need the form.
 *
 * @return void
 */
function llb_enqueue_cf7_assets() {
	if ( ! function_exists( 'wpcf7_enqueue_scripts' ) || ! function_exists( 'wpcf7_enqueue_styles' ) ) {
		return;
	}

	$load = false;

	if ( is_page() && 'page-templates/template-contact.php' === get_page_template_slug() ) {
		$load = true;
	} elseif ( is_singular() ) {
		$post = get_post();
		if ( $post && has_shortcode( $post->post_content, 'contact-form-7' ) ) {
			$load = true;
		}
	}

	if ( ! $load ) {
		return;
	}

	wpcf7_enqueue_scripts();
	wpcf7_enqueue_styles();
}
add_action( 'wp_enqueue_scripts', 'llb_enqueue_cf7_assets', 20 );

/**
 * Returns the Contact Form 7 markup from the Customizer shortcode setting.
 *
 * @return string
 */
function llb_contact_form() {
	if ( ! defined( 'WPCF7_VERSION' ) ) {
		return '';
	}

	$shortcode = trim( (string) llb_get_option( 'llb_cf7_shortcode' ) );
	if ( '' === $shortcode ) {
		return '';
	}

	if ( ! preg_match( '/^\[contact-form-7\b/i', $shortcode ) ) {
		return '';
	}

	return do_shortcode( $shortcode );
}
