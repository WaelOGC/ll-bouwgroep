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

/**
 * Escapes text and converts blank-line-separated paragraphs to HTML paragraphs.
 *
 * @param string $text Raw text.
 * @return string
 */
function llb_paragraphs( $text ) {
	$text = trim( (string) $text );
	if ( '' === $text ) {
		return '';
	}

	return wpautop( esc_html( $text ) );
}

/**
 * Returns an inline SVG icon by name.
 *
 * @param string $name Icon name.
 * @return string
 */
function llb_icon( $name ) {
	$icons = array(
		'arrow'     => '<svg class="llb-icon llb-icon--arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>',
		'phone'     => '<svg class="llb-icon llb-icon--phone" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.72 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.59 2.81.72A2 2 0 0 1 22 16.92z"/></svg>',
		'email'     => '<svg class="llb-icon llb-icon--email" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>',
		'location'  => '<svg class="llb-icon llb-icon--location" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>',
		'facebook'  => '<svg class="llb-icon llb-icon--facebook" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
		'instagram' => '<svg class="llb-icon llb-icon--instagram" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>',
		'linkedin'  => '<svg class="llb-icon llb-icon--linkedin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>',
		'menu'      => '<svg class="llb-icon llb-icon--menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>',
		'close'     => '<svg class="llb-icon llb-icon--close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>',
		'team'      => '<svg class="llb-icon llb-icon--team" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
		'handshake' => '<svg class="llb-icon llb-icon--handshake" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m11 17 2 2a1 1 0 1 0 3-3"/><path d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 6"/><path d="m21 3 1 11h-2"/><path d="M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3"/><path d="M3 4h8"/></svg>',
		'checklist' => '<svg class="llb-icon llb-icon--checklist" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>',
		'plus'      => '<svg class="llb-icon llb-icon--plus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M12 5v14"/><path d="M5 12h14"/></svg>',
	);

	$name = (string) $name;
	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * Returns the permalink for a page by slug, with a path fallback.
 *
 * @param string $slug Page slug.
 * @return string
 */
function llb_page_url( $slug ) {
	$slug = sanitize_title( (string) $slug );
	if ( '' === $slug ) {
		return home_url( '/' );
	}

	$page = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $page instanceof WP_Post ) {
		return get_permalink( $page );
	}

	return home_url( '/' . $slug . '/' );
}
