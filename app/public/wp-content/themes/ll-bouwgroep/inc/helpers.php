<?php
/**
 * Theme helper functions.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the URL for a file inside the theme assets directory.
 *
 * @param string $path Relative path under assets/ (e.g. 'css/main.css').
 * @return string Asset URL (escape on output with esc_url()).
 */
function llb_asset( $path ) {
	$path = ltrim( (string) $path, '/' );
	return LLB_URI . '/assets/' . $path;
}

/**
 * Returns a theme mod value with the Customizer default as fallback.
 *
 * @param string $key Setting ID (e.g. 'llb_phone').
 * @return mixed
 */
function llb_get_option( $key ) {
	$defaults = llb_customizer_defaults();
	$default  = array_key_exists( $key, $defaults ) ? $defaults[ $key ] : '';

	return get_theme_mod( $key, $default );
}

/**
 * Builds a single address string from Customizer parts.
 *
 * @return string
 */
function llb_get_address() {
	$street   = trim( (string) llb_get_option( 'llb_address_street' ) );
	$postcode = trim( (string) llb_get_option( 'llb_address_postcode' ) );
	$city     = trim( (string) llb_get_option( 'llb_address_city' ) );

	$line2_parts = array_filter( array( $postcode, $city ) );
	$line2       = implode( ' ', $line2_parts );

	$parts = array_filter( array( $street, $line2 ) );

	return implode( ', ', $parts );
}

/**
 * Returns the route URL, or a Google Maps search URL from the address.
 *
 * @return string
 */
function llb_get_map_url() {
	$map_url = trim( (string) llb_get_option( 'llb_map_url' ) );
	if ( '' !== $map_url ) {
		return $map_url;
	}

	$address = llb_get_address();
	if ( '' === $address ) {
		return '';
	}

	return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $address );
}

/**
 * Returns the header CTA URL, falling back to /contact/.
 *
 * @return string
 */
function llb_get_header_cta_url() {
	$url = trim( (string) llb_get_option( 'llb_header_cta_url' ) );
	if ( '' !== $url ) {
		return $url;
	}

	return home_url( '/contact/' );
}

/**
 * Returns opening hours rows with consecutive same-value days grouped.
 *
 * Each row: array( 'label' => string, 'value' => string ). Labels use Dutch day names.
 *
 * @return array<int, array{label: string, value: string}>
 */
function llb_get_opening_hours() {
	$days = array(
		array(
			'key'   => 'llb_hours_monday',
			'name'  => 'Maandag',
			'lower' => 'maandag',
		),
		array(
			'key'   => 'llb_hours_tuesday',
			'name'  => 'Dinsdag',
			'lower' => 'dinsdag',
		),
		array(
			'key'   => 'llb_hours_wednesday',
			'name'  => 'Woensdag',
			'lower' => 'woensdag',
		),
		array(
			'key'   => 'llb_hours_thursday',
			'name'  => 'Donderdag',
			'lower' => 'donderdag',
		),
		array(
			'key'   => 'llb_hours_friday',
			'name'  => 'Vrijdag',
			'lower' => 'vrijdag',
		),
		array(
			'key'   => 'llb_hours_saturday',
			'name'  => 'Zaterdag',
			'lower' => 'zaterdag',
		),
		array(
			'key'   => 'llb_hours_sunday',
			'name'  => 'Zondag',
			'lower' => 'zondag',
		),
	);

	$rows  = array();
	$group = array();

	foreach ( $days as $index => $day ) {
		$value = trim( (string) llb_get_option( $day['key'] ) );
		if ( '' === $value ) {
			if ( ! empty( $group ) ) {
				$rows[] = llb_format_opening_hours_group( $group );
				$group  = array();
			}
			continue;
		}

		$day['value'] = $value;
		$day['index'] = $index;

		if ( empty( $group ) ) {
			$group[] = $day;
			continue;
		}

		$last = $group[ count( $group ) - 1 ];
		if ( $day['value'] === $last['value'] && ( $day['index'] === $last['index'] + 1 ) ) {
			$group[] = $day;
			continue;
		}

		$rows[] = llb_format_opening_hours_group( $group );
		$group  = array( $day );
	}

	if ( ! empty( $group ) ) {
		$rows[] = llb_format_opening_hours_group( $group );
	}

	return $rows;
}

/**
 * Formats a consecutive group of opening-hour days into one display row.
 *
 * @param array<int, array{name: string, lower: string, value: string}> $group Day group.
 * @return array{label: string, value: string}
 */
function llb_format_opening_hours_group( $group ) {
	$count = count( $group );
	$first = $group[0];
	$last  = $group[ $count - 1 ];

	if ( 1 === $count ) {
		$label = $first['name'];
	} elseif ( 2 === $count ) {
		$label = $first['name'] . ' en ' . $last['lower'];
	} else {
		$label = $first['name'] . ' t/m ' . $last['lower'];
	}

	return array(
		'label' => $label,
		'value' => $first['value'],
	);
}

/**
 * Returns the full copyright line for the footer.
 *
 * @return string
 */
function llb_get_copyright() {
	$year    = wp_date( 'Y' );
	$company = trim( (string) llb_get_option( 'llb_company_name' ) );
	$text    = trim( (string) llb_get_option( 'llb_footer_copyright' ) );

	$parts = array_filter(
		array(
			'© ' . $year,
			$company,
			$text,
		)
	);

	return implode( ' ', $parts );
}

/**
 * Returns post meta for a known field key.
 *
 * Gallery and repeater values are always arrays.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key (e.g. '_llb_hero_title').
 * @return mixed
 */
function llb_get_meta( $post_id, $key ) {
	$field = function_exists( 'llb_meta_field_by_key' ) ? llb_meta_field_by_key( $key ) : null;
	$type  = $field && isset( $field['type'] ) ? $field['type'] : '';

	$value = get_post_meta( $post_id, $key, true );

	if ( 'gallery' === $type || 'repeater' === $type ) {
		return is_array( $value ) ? $value : array();
	}

	if ( false === $value || null === $value ) {
		return '';
	}

	return $value;
}

/**
 * Returns non-empty trimmed lines from a lines meta field.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key.
 * @return array<int, string>
 */
function llb_get_lines( $post_id, $key ) {
	$raw   = (string) llb_get_meta( $post_id, $key );
	$lines = preg_split( '/\r\n|\r|\n/', $raw );
	$out   = array();

	if ( ! is_array( $lines ) ) {
		return $out;
	}

	foreach ( $lines as $line ) {
		$line = trim( (string) $line );
		if ( '' !== $line ) {
			$out[] = $line;
		}
	}

	return $out;
}
