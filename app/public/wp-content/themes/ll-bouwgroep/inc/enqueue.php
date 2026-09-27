<?php
/**
 * Enqueue scripts and styles.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues front-end styles and scripts.
 *
 * @return void
 */
function llb_enqueue_assets() {
	$fonts_path = LLB_DIR . '/assets/css/fonts.css';
	$main_css   = LLB_DIR . '/assets/css/main.css';
	$v2_css     = LLB_DIR . '/assets/css/design-v2.css';
	$main_js    = LLB_DIR . '/assets/js/main.js';

	wp_enqueue_style(
		'llb-fonts',
		LLB_URI . '/assets/css/fonts.css',
		array(),
		file_exists( $fonts_path ) ? (string) filemtime( $fonts_path ) : LLB_VERSION
	);

	wp_enqueue_style(
		'llb-main',
		LLB_URI . '/assets/css/main.css',
		array( 'llb-fonts' ),
		file_exists( $main_css ) ? (string) filemtime( $main_css ) : LLB_VERSION
	);

	wp_enqueue_style(
		'llb-design-v2',
		LLB_URI . '/assets/css/design-v2.css',
		array( 'llb-main' ),
		file_exists( $v2_css ) ? (string) filemtime( $v2_css ) : LLB_VERSION
	);

	wp_enqueue_script(
		'llb-main',
		LLB_URI . '/assets/js/main.js',
		array(),
		file_exists( $main_js ) ? (string) filemtime( $main_js ) : LLB_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	llb_enqueue_brand_color_overrides();
}
add_action( 'wp_enqueue_scripts', 'llb_enqueue_assets' );

/**
 * Prints CSS custom property overrides when brand colors differ from defaults.
 *
 * @return void
 */
function llb_enqueue_brand_color_overrides() {
	$defaults = llb_customizer_defaults();
	$red      = (string) llb_get_option( 'llb_color_red' );
	$green    = (string) llb_get_option( 'llb_color_green' );

	$rules = array();

	if ( strtolower( $red ) !== strtolower( $defaults['llb_color_red'] ) && '' !== $red ) {
		$rules[] = '--llb-red: ' . esc_attr( $red ) . ';';
	}

	if ( strtolower( $green ) !== strtolower( $defaults['llb_color_green'] ) && '' !== $green ) {
		$rules[] = '--llb-green: ' . esc_attr( $green ) . ';';
	}

	if ( empty( $rules ) ) {
		return;
	}

	$css = ':root { ' . implode( ' ', $rules ) . ' }';
	wp_add_inline_style( 'llb-design-v2', $css );
}
