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
}
add_action( 'wp_enqueue_scripts', 'llb_enqueue_assets' );
