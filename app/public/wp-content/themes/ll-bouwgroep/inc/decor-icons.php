<?php
/**
 * MDI icon helpers for Home tiles / why items (inline SVG, no CDN).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Allowed service tile icons (MDI filenames).
 *
 * @return array<string, string> slug => label
 */
function llb_service_icon_options() {
	return array(
		''                   => __( '— Default by service —', 'll-bouwgroep' ),
		'shower-head'        => 'Shower head',
		'home-edit'          => 'House edit',
		'spirit-level'       => 'Spirit level',
		'view-grid'          => 'Tiles',
		'hand-saw'           => 'Hand saw',
		'format-paint'       => 'Paint roller',
		'countertop'         => 'Kitchen counter',
		'home-plus'          => 'House extension',
		'hammer-screwdriver' => 'Hammer & screwdriver',
	);
}

/**
 * Allowed why-item icons (MDI filenames).
 *
 * @return array<string, string>
 */
function llb_why_icon_options() {
	return array(
		'hard-hat'     => 'Hard hat',
		'toolbox'      => 'Toolbox',
		'ruler-square' => 'Ruler square',
	);
}

/**
 * Default service icon by post slug (real slugs from content-defaults).
 *
 * @param string $slug Service post slug.
 * @return string
 */
function llb_default_service_icon_for_slug( $slug ) {
	$map = array(
		'badkamers-toiletten'               => 'shower-head',
		'renovatie-verbouwing'              => 'home-edit',
		'stucwerk'                          => 'spirit-level',
		'tegelwerk'                         => 'view-grid',
		'timmerwerk'                        => 'hand-saw',
		'schilder-afbouwwerk'               => 'format-paint',
		'keukenverbouwingen'                => 'countertop',
		'aan-uitbouw'                       => 'home-plus',
		'overige-bouwkundige-werkzaamheden' => 'hammer-screwdriver',
	);
	$slug = sanitize_title( (string) $slug );
	return isset( $map[ $slug ] ) ? $map[ $slug ] : 'hammer-screwdriver';
}

/**
 * One-time overwrite of service icons to the v2 map (fixes wrong seeded hammers).
 *
 * @return void
 */
function llb_migrate_service_icons_v2() {
	if ( get_option( 'llb_service_icons_v2' ) ) {
		return;
	}
	if ( ! function_exists( 'llb_get_services' ) || ! function_exists( 'llb_default_service_icon_for_slug' ) ) {
		return;
	}

	foreach ( llb_get_services() as $service ) {
		update_post_meta( $service->ID, '_llb_service_icon', llb_default_service_icon_for_slug( $service->post_name ) );
	}

	update_option( 'llb_service_icons_v2', '1' );
}
add_action( 'admin_init', 'llb_migrate_service_icons_v2' );

/**
 * Returns MDI SVG markup (fill currentColor / inherited fill).
 *
 * @param string $name Icon file name without extension.
 * @return string
 */
function llb_get_mdi_icon_svg( $name ) {
	static $cache = array();

	$name = sanitize_file_name( (string) $name );
	if ( '' === $name ) {
		return '';
	}
	if ( isset( $cache[ $name ] ) ) {
		return $cache[ $name ];
	}

	$path = LLB_DIR . '/assets/icons/mdi/' . $name . '.svg';
	if ( ! file_exists( $path ) || ! is_readable( $path ) ) {
		$cache[ $name ] = '';
		return '';
	}

	$raw = file_get_contents( $path );
	if ( ! is_string( $raw ) || '' === $raw ) {
		$cache[ $name ] = '';
		return '';
	}

	$raw = preg_replace( '/<!--.*?-->/s', '', $raw );
	if ( ! is_string( $raw ) || ! preg_match( '/<svg\b[^>]*>(.*?)<\/svg>/is', $raw, $m ) ) {
		$cache[ $name ] = '';
		return '';
	}

	$inner = trim( $m[1] );
	$svg   = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">' . $inner . '</svg>';
	$cache[ $name ] = $svg;
	return $svg;
}

/**
 * Arrow icon used in reference buttons.
 *
 * @return string
 */
function llb_btn_arrow_svg() {
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
}

/**
 * Tile corner arrow from the reference.
 *
 * @return string
 */
function llb_tile_go_svg() {
	return '<svg class="tile-go" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17L17 7M9 7h8v8"/></svg>';
}
