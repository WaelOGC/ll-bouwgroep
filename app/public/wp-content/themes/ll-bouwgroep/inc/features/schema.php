<?php
/**
 * LocalBusiness (GeneralContractor) structured data.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the local business schema should be printed.
 *
 * @return bool
 */
function llb_schema_local_business_enabled() {
	return llb_theme_option_on( 'schema_local_business' );
}

/**
 * Returns the canonical @id for the business entity.
 *
 * @return string
 */
function llb_schema_business_id() {
	return home_url( '/#business' );
}

/**
 * Returns the logo URL used in structured data and on the maintenance page.
 *
 * @return string
 */
function llb_schema_logo_url() {
	$custom_logo_id = (int) get_theme_mod( 'custom_logo' );
	if ( $custom_logo_id ) {
		$url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	return llb_asset( 'images/ll-logo.webp' );
}

/**
 * Parses an opening hours string such as "08:00 – 17:00" into opens/closes.
 *
 * Returns an empty array for "Gesloten" or anything without two times.
 *
 * @param string $value Raw Customizer value.
 * @return array{opens:string, closes:string}|array{}
 */
function llb_schema_parse_hours( $value ) {
	$value = trim( (string) $value );
	if ( '' === $value ) {
		return array();
	}

	if ( ! preg_match_all( '/(\d{1,2})[:.](\d{2})/', $value, $matches, PREG_SET_ORDER ) ) {
		return array();
	}

	if ( count( $matches ) < 2 ) {
		return array();
	}

	return array(
		'opens'  => sprintf( '%02d:%02d', (int) $matches[0][1], (int) $matches[0][2] ),
		'closes' => sprintf( '%02d:%02d', (int) $matches[1][1], (int) $matches[1][2] ),
	);
}

/**
 * Builds openingHoursSpecification entries, grouping days with identical hours.
 *
 * @return array<int, array<string, mixed>>
 */
function llb_schema_opening_hours() {
	$days = array(
		'llb_hours_monday'    => 'Monday',
		'llb_hours_tuesday'   => 'Tuesday',
		'llb_hours_wednesday' => 'Wednesday',
		'llb_hours_thursday'  => 'Thursday',
		'llb_hours_friday'    => 'Friday',
		'llb_hours_saturday'  => 'Saturday',
		'llb_hours_sunday'    => 'Sunday',
	);

	$grouped = array();

	foreach ( $days as $key => $day ) {
		$hours = llb_schema_parse_hours( llb_get_option( $key ) );
		if ( empty( $hours ) ) {
			continue;
		}

		$slot = $hours['opens'] . '-' . $hours['closes'];

		if ( ! isset( $grouped[ $slot ] ) ) {
			$grouped[ $slot ] = array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array(),
				'opens'     => $hours['opens'],
				'closes'    => $hours['closes'],
			);
		}

		$grouped[ $slot ]['dayOfWeek'][] = $day;
	}

	return array_values( $grouped );
}

/**
 * Returns the non-empty social profile URLs for schema sameAs.
 *
 * Order: Instagram, Facebook, LinkedIn, YouTube, Google.
 *
 * @return array<int, string>
 */
function llb_schema_same_as() {
	$urls = array();

	if ( ! function_exists( 'llb_get_social_links' ) ) {
		return $urls;
	}

	foreach ( llb_get_social_links() as $link ) {
		if ( ! empty( $link['url'] ) ) {
			$urls[] = $link['url'];
		}
	}

	return $urls;
}

/**
 * Builds the GeneralContractor schema array, skipping empty values.
 *
 * @return array<string, mixed>
 */
function llb_schema_local_business_data() {
	$company = trim( (string) llb_get_option( 'llb_company_name' ) );
	if ( '' === $company ) {
		$company = get_bloginfo( 'name' );
	}

	$logo = llb_schema_logo_url();

	$data = array(
		'@context' => 'https://schema.org',
		'@type'    => 'GeneralContractor',
		'@id'      => llb_schema_business_id(),
		'name'     => $company,
		'url'      => home_url( '/' ),
	);

	if ( '' !== $logo ) {
		$data['logo']  = $logo;
		$data['image'] = $logo;
	}

	$phone = trim( (string) llb_get_option( 'llb_phone' ) );
	if ( '' !== $phone ) {
		$data['telephone'] = $phone;
	}

	$email = trim( (string) llb_get_option( 'llb_email' ) );
	if ( '' !== $email ) {
		$data['email'] = $email;
	}

	$street   = trim( (string) llb_get_option( 'llb_address_street' ) );
	$postcode = trim( (string) llb_get_option( 'llb_address_postcode' ) );
	$city     = trim( (string) llb_get_option( 'llb_address_city' ) );

	$address = array_filter(
		array(
			'streetAddress'   => $street,
			'postalCode'      => $postcode,
			'addressLocality' => $city,
		)
	);

	if ( ! empty( $address ) ) {
		$data['address'] = array_merge(
			array(
				'@type'          => 'PostalAddress',
				'addressCountry' => 'NL',
			),
			$address
		);
	}

	$hours = llb_schema_opening_hours();
	if ( ! empty( $hours ) ) {
		$data['openingHoursSpecification'] = $hours;
	}

	$area = llb_theme_option_text( 'schema_area_served' );
	if ( '' !== $area ) {
		$data['areaServed'] = $area;
	}

	$same_as = llb_schema_same_as();
	if ( ! empty( $same_as ) ) {
		$data['sameAs'] = $same_as;
	}

	/**
	 * Filters the GeneralContractor structured data before output.
	 *
	 * @param array<string, mixed> $data Schema data.
	 */
	return apply_filters( 'llb_schema_local_business_data', $data );
}

/**
 * Prints the GeneralContractor JSON-LD once per request.
 *
 * @return void
 */
function llb_output_local_business_schema() {
	static $printed = false;

	if ( $printed || ! llb_schema_local_business_enabled() ) {
		return;
	}

	$printed = true;

	echo '<script type="application/ld+json">' . wp_json_encode( llb_schema_local_business_data(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'llb_output_local_business_schema', 19 );
