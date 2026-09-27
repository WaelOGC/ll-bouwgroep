<?php
/**
 * Tabler Icons helpers for section decorations (inline SVG, no CDN).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icon names used in the construction tool pattern (Tabler Icons outline).
 *
 * Workers' tools / building site icons that exist in Tabler.
 *
 * @return array<int, string>
 */
function llb_decor_tool_icon_names() {
	return array(
		'hammer',
		'tool',
		'tools',
		'ruler-measure',
		'ruler-2',
		'ruler',
		'paint',
		'brush',
		'bucket',
		'bucket-droplet',
		'ladder',
		'helmet',
		'shovel',
		'wall',
		'trowel',
		'axe',
		'cut',
		'pick',
		'dimensions',
		'traffic-cone',
		'crane',
		'backhoe',
		'bulldozer',
		'forklift',
		'bolt',
		'building',
		'fence',
		'wood',
		'chisel',
		'spray',
		'door',
		'window',
	);
}

/**
 * Returns wallpaper placements (icon, position %, size px, rotation deg).
 *
 * @return array<int, array{icon: string, x: float, y: float, s: int, r: int}>
 */
function llb_decor_tool_pattern_placements() {
	$icons  = llb_decor_tool_icon_names();
	$layout = array(
		array( 4, 6, 52, -18 ),
		array( 18, 4, 40, 12 ),
		array( 32, 10, 56, -8 ),
		array( 48, 5, 36, 22 ),
		array( 64, 9, 48, -14 ),
		array( 80, 4, 44, 8 ),
		array( 92, 12, 38, -22 ),
		array( 8, 28, 46, 16 ),
		array( 22, 24, 58, -10 ),
		array( 38, 30, 42, 6 ),
		array( 54, 22, 50, -20 ),
		array( 70, 28, 36, 14 ),
		array( 86, 26, 54, -6 ),
		array( 3, 48, 40, 10 ),
		array( 16, 52, 48, -16 ),
		array( 30, 46, 34, 24 ),
		array( 46, 54, 56, -4 ),
		array( 60, 48, 42, 18 ),
		array( 76, 52, 46, -12 ),
		array( 90, 46, 38, 8 ),
		array( 10, 72, 50, -8 ),
		array( 26, 76, 36, 20 ),
		array( 42, 70, 52, -18 ),
		array( 58, 78, 40, 6 ),
		array( 74, 72, 48, -14 ),
		array( 88, 76, 34, 12 ),
		array( 6, 90, 44, -6 ),
		array( 50, 88, 38, 16 ),
	);

	$out = array();
	foreach ( $layout as $index => $row ) {
		$out[] = array(
			'icon' => $icons[ $index % count( $icons ) ],
			'x'    => (float) $row[0],
			'y'    => (float) $row[1],
			's'    => (int) $row[2],
			'r'    => (int) $row[3],
		);
	}

	return $out;
}

/**
 * Loads a Tabler outline SVG and returns markup suitable for inline use.
 *
 * Brand gradient is embedded per SVG so stroke urls stay same-document.
 *
 * @param string $name Icon file name without extension.
 * @param string $uid  Unique id prefix for the gradient (per instance).
 * @return string
 */
function llb_get_tabler_icon_svg( $name, $uid = '' ) {
	static $file_cache = array();

	$name = sanitize_file_name( (string) $name );
	if ( '' === $name ) {
		return '';
	}

	if ( ! isset( $file_cache[ $name ] ) ) {
		$path = LLB_DIR . '/assets/icons/tabler/' . $name . '.svg';
		if ( ! file_exists( $path ) || ! is_readable( $path ) ) {
			$file_cache[ $name ] = '';
			return '';
		}

		$raw = file_get_contents( $path );
		if ( ! is_string( $raw ) || '' === $raw ) {
			$file_cache[ $name ] = '';
			return '';
		}

		$raw = preg_replace( '/<!--.*?-->/s', '', $raw );
		if ( ! is_string( $raw ) || ! preg_match( '/<svg\b[^>]*>(.*?)<\/svg>/is', $raw, $m ) ) {
			$file_cache[ $name ] = '';
			return '';
		}

		$file_cache[ $name ] = trim( $m[1] );
	}

	$inner = $file_cache[ $name ];
	if ( '' === $inner ) {
		return '';
	}

	$gid = '' !== $uid ? sanitize_html_class( $uid ) : 'llb-tg';
	$defs = '<defs><linearGradient id="' . esc_attr( $gid ) . '" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#D0021B"/><stop offset="100%" stop-color="#0B6B3A"/></linearGradient></defs>';

	return '<svg class="llb-tool-pattern__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="url(#' . esc_attr( $gid ) . ')" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $defs . $inner . '</svg>';
}
