<?php
/**
 * Theme Help admin page (Getting started + Theme Options).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the Help submenu under Theme Options.
 *
 * @return void
 */
function llb_add_help_page() {
	global $llb_help_page_hook;

	$llb_help_page_hook = add_submenu_page(
		'llb-theme-options',
		__( 'Help', 'll-bouwgroep' ),
		__( 'Help', 'll-bouwgroep' ),
		'manage_options',
		'llb-help',
		'llb_render_help_page'
	);
}
add_action( 'admin_menu', 'llb_add_help_page', 20 );

/**
 * Restores "Theme Options" as the first submenu item after the duplicate is removed.
 *
 * @return void
 */
function llb_help_restore_theme_options_submenu() {
	global $submenu;

	if ( ! isset( $submenu['llb-theme-options'] ) || ! is_array( $submenu['llb-theme-options'] ) ) {
		return;
	}

	foreach ( $submenu['llb-theme-options'] as $item ) {
		if ( isset( $item[2] ) && 'llb-theme-options' === $item[2] ) {
			return;
		}
	}

	array_unshift(
		$submenu['llb-theme-options'],
		array(
			__( 'Theme Options', 'll-bouwgroep' ),
			'manage_options',
			'llb-theme-options',
		)
	);
}
add_action( 'admin_menu', 'llb_help_restore_theme_options_submenu', 1000 );

/**
 * Enqueues Help page CSS/JS on that screen only.
 *
 * @param string $hook Current admin page hook suffix.
 * @return void
 */
function llb_enqueue_help_assets( $hook ) {
	global $llb_help_page_hook;

	if ( empty( $llb_help_page_hook ) || $hook !== $llb_help_page_hook ) {
		return;
	}

	$css = LLB_DIR . '/assets/css/admin-help.css';
	$js  = LLB_DIR . '/assets/js/admin-help.js';

	wp_enqueue_style(
		'llb-help',
		llb_asset( 'css/admin-help.css' ),
		array(),
		file_exists( $css ) ? (string) filemtime( $css ) : LLB_VERSION
	);
	wp_enqueue_script(
		'llb-help',
		llb_asset( 'js/admin-help.js' ),
		array(),
		file_exists( $js ) ? (string) filemtime( $js ) : LLB_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'llb_enqueue_help_assets' );

/**
 * Renders the Help admin page.
 *
 * @return void
 */
function llb_render_help_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap llbo-wrap">
		<?php require LLB_DIR . '/template-parts/admin/help.php'; ?>
	</div>
	<?php
}
