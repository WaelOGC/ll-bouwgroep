<?php
/**
 * Tool-pattern icon helpers (MDI + Lucide, inline SVG, no CDN).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icons used in the construction tool pattern.
 *
 * @return array<int, array{set: string, name: string}>
 */
function llb_decor_tool_icon_list() {
	return array(
		array( 'set' => 'mdi', 'name' => 'hammer' ),
		array( 'set' => 'mdi', 'name' => 'screwdriver' ),
		array( 'set' => 'mdi', 'name' => 'wrench' ),
		array( 'set' => 'mdi', 'name' => 'hand-saw' ),
		array( 'set' => 'mdi', 'name' => 'circular-saw' ),
		array( 'set' => 'mdi', 'name' => 'saw-blade' ),
		array( 'set' => 'mdi', 'name' => 'pliers' ),
		array( 'set' => 'mdi', 'name' => 'spirit-level' ),
		array( 'set' => 'mdi', 'name' => 'tape-measure' ),
		array( 'set' => 'mdi', 'name' => 'format-paint' ),
		array( 'set' => 'mdi', 'name' => 'pail' ),
		array( 'set' => 'mdi', 'name' => 'ladder' ),
		array( 'set' => 'mdi', 'name' => 'hard-hat' ),
		array( 'set' => 'mdi', 'name' => 'toolbox' ),
		array( 'set' => 'mdi', 'name' => 'wall' ),
		array( 'set' => 'mdi', 'name' => 'shovel' ),
		array( 'set' => 'mdi', 'name' => 'bucket' ),
		array( 'set' => 'mdi', 'name' => 'pipe-wrench' ),
		array( 'set' => 'mdi', 'name' => 'ruler-square' ),
		array( 'set' => 'mdi', 'name' => 'hammer-wrench' ),
		array( 'set' => 'lucide', 'name' => 'drill' ),
	);
}

/**
 * Wallpaper placements: icon + position + size + float motion params.
 *
 * @return array<int, array<string, mixed>>
 */
function llb_decor_tool_pattern_placements() {
	$icons  = llb_decor_tool_icon_list();
	// 18 icons, even spacing, sizes 28–56, no overlap.
	$layout = array(
		// x%, y%, size, base_rot, dur_s, delay_s, fx, fy, frot, fscale
		array( 6, 8, 48, -16, 22, 0, 22, -16, 6, 1.04 ),
		array( 22, 5, 34, 12, 18, -3, -14, 24, -5, 0.96 ),
		array( 40, 10, 52, -8, 26, -6, 28, 12, 7, 1.03 ),
		array( 58, 6, 30, 20, 16, -1, -18, -14, -8, 0.97 ),
		array( 76, 9, 44, -14, 24, -8, 16, 22, 5, 1.05 ),
		array( 90, 14, 36, 8, 20, -4, -26, 12, -6, 0.95 ),
		array( 10, 32, 40, 14, 28, -2, 12, -28, 8, 1.02 ),
		array( 28, 28, 56, -10, 19, -7, -16, 20, -4, 0.98 ),
		array( 48, 34, 32, 6, 15, -5, 30, -12, 7, 1.04 ),
		array( 66, 30, 46, -18, 25, -9, -12, 26, -7, 0.96 ),
		array( 84, 36, 38, 10, 21, -3, 18, -20, 5, 1.03 ),
		array( 5, 54, 42, -6, 17, -6, -22, 14, -8, 0.97 ),
		array( 24, 58, 50, 16, 27, -1, 14, -24, 6, 1.05 ),
		array( 44, 52, 28, -20, 14, -8, -28, 16, -5, 0.95 ),
		array( 62, 56, 48, 4, 23, -4, 24, -10, 8, 1.02 ),
		array( 80, 50, 36, -12, 29, -10, -10, 28, -6, 0.98 ),
		array( 14, 78, 44, 18, 18, -2, 18, -22, 4, 1.04 ),
		array( 52, 76, 40, -8, 22, -7, -20, 12, -7, 0.96 ),
	);

	$out = array();
	foreach ( $layout as $index => $row ) {
		$icon = $icons[ $index % count( $icons ) ];
		$out[] = array(
			'set'    => $icon['set'],
			'icon'   => $icon['name'],
			'x'      => (float) $row[0],
			'y'      => (float) $row[1],
			's'      => (int) $row[2],
			'r'      => (int) $row[3],
			'dur'    => (int) $row[4],
			'delay'  => (float) $row[5],
			'fx'     => (int) $row[6],
			'fy'     => (int) $row[7],
			'frot'   => (int) $row[8],
			'fscale' => (float) $row[9],
		);
	}

	return $out;
}

/**
 * Loads an MDI or Lucide SVG with brand-gradient paint.
 *
 * @param string $set  'mdi' or 'lucide'.
 * @param string $name Icon file name without extension.
 * @param string $uid  Unique id for the gradient.
 * @return string
 */
function llb_get_decor_icon_svg( $set, $name, $uid = '' ) {
	static $file_cache = array();

	$set  = sanitize_key( (string) $set );
	$name = sanitize_file_name( (string) $name );
	if ( ! in_array( $set, array( 'mdi', 'lucide' ), true ) || '' === $name ) {
		return '';
	}

	$cache_key = $set . '/' . $name;
	if ( ! isset( $file_cache[ $cache_key ] ) ) {
		$path = LLB_DIR . '/assets/icons/' . $set . '/' . $name . '.svg';
		if ( ! file_exists( $path ) || ! is_readable( $path ) ) {
			$file_cache[ $cache_key ] = '';
			return '';
		}

		$raw = file_get_contents( $path );
		if ( ! is_string( $raw ) || '' === $raw ) {
			$file_cache[ $cache_key ] = '';
			return '';
		}

		$raw = preg_replace( '/<!--.*?-->/s', '', $raw );
		if ( ! is_string( $raw ) || ! preg_match( '/<svg\b[^>]*>(.*?)<\/svg>/is', $raw, $m ) ) {
			$file_cache[ $cache_key ] = '';
			return '';
		}

		$file_cache[ $cache_key ] = trim( $m[1] );
	}

	$inner = $file_cache[ $cache_key ];
	if ( '' === $inner ) {
		return '';
	}

	$gid  = '' !== $uid ? sanitize_html_class( $uid ) : 'llb-tg';
	$defs = '<defs><linearGradient id="' . esc_attr( $gid ) . '" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#D0021B"/><stop offset="100%" stop-color="#0B6B3A"/></linearGradient></defs>';

	if ( 'lucide' === $set ) {
		return '<svg class="llb-tool-pattern__svg llb-tool-pattern__svg--stroke" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="url(#' . esc_attr( $gid ) . ')" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $defs . $inner . '</svg>';
	}

	return '<svg class="llb-tool-pattern__svg llb-tool-pattern__svg--fill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="url(#' . esc_attr( $gid ) . ')" aria-hidden="true" focusable="false">' . $defs . $inner . '</svg>';
}
