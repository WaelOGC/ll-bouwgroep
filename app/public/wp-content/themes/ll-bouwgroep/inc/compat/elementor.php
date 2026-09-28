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

/**
 * Whether Elementor is active on this site.
 *
 * @return bool
 */
function llb_elementor_active() {
	return defined( 'ELEMENTOR_VERSION' ) || did_action( 'elementor/loaded' );
}

/**
 * Whether a post is built with the Elementor editor.
 *
 * @param int $post_id Post ID. Defaults to the current post.
 * @return bool
 */
function llb_is_elementor_builder_page( $post_id = 0 ) {
	if ( ! llb_elementor_active() ) {
		return false;
	}

	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();
	if ( ! $post_id ) {
		return false;
	}

	return 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true );
}

/**
 * Whether Elementor owns the page template (Canvas / Full Width).
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function llb_has_elementor_page_template( $post_id ) {
	$template = (string) get_post_meta( (int) $post_id, '_wp_page_template', true );

	return 0 === strpos( $template, 'elementor_' );
}

/**
 * Renders Elementor builder pages without the theme hero, TOC and prose wrapper.
 *
 * Elementor Canvas and Full Width keep their own templates.
 *
 * @param string $template Template path.
 * @return string
 */
function llb_elementor_template_include( $template ) {
	if ( is_admin() || ! is_singular() ) {
		return $template;
	}

	$post_id = (int) get_queried_object_id();
	if ( ! $post_id || ! llb_is_elementor_builder_page( $post_id ) || llb_has_elementor_page_template( $post_id ) ) {
		return $template;
	}

	$elementor_template = LLB_DIR . '/page-templates/template-elementor.php';

	return file_exists( $elementor_template ) ? $elementor_template : $template;
}
add_filter( 'template_include', 'llb_elementor_template_include', 9 );
