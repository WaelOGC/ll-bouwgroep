<?php
/**
 * Elementor compatibility.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers Elementor theme locations (header / footer).
 *
 * @param object $elementor_theme_manager Elementor theme location manager.
 * @return void
 */
function llb_register_elementor_locations( $elementor_theme_manager ) {
	if ( ! is_object( $elementor_theme_manager ) || ! method_exists( $elementor_theme_manager, 'register_location' ) ) {
		return;
	}

	$elementor_theme_manager->register_location( 'header' );
	$elementor_theme_manager->register_location( 'footer' );
}
add_action( 'elementor_theme_register_locations', 'llb_register_elementor_locations' );

// AVG: Elementor must not load Google Fonts (theme uses self-hosted fonts).
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
