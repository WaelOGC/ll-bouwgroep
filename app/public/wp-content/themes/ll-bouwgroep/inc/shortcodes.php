<?php
/**
 * Theme shortcodes.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcode [llb_company_details]: company name, address, email, phone from Customizer.
 *
 * @return string
 */
function llb_shortcode_company_details() {
	$company = trim( (string) llb_get_option( 'llb_company_name' ) );
	$address = trim( (string) llb_get_address() );
	$email   = trim( (string) llb_get_option( 'llb_email' ) );
	$phone   = trim( (string) llb_get_option( 'llb_phone' ) );

	$lines = array();

	if ( '' !== $company ) {
		$lines[] = esc_html( $company );
	}

	if ( '' !== $address ) {
		$lines[] = esc_html( $address );
	}

	if ( '' !== $email ) {
		$lines[] = '<a href="' . esc_url( 'mailto:' . antispambot( $email ) ) . '">' . esc_html( antispambot( $email ) ) . '</a>';
	}

	if ( '' !== $phone ) {
		$tel = preg_replace( '/[^\d+]/', '', $phone );
		if ( '' !== $tel ) {
			$lines[] = '<a href="' . esc_url( 'tel:' . $tel ) . '">' . esc_html( $phone ) . '</a>';
		} else {
			$lines[] = esc_html( $phone );
		}
	}

	if ( empty( $lines ) ) {
		return '';
	}

	return '<p class="llb-company-details">' . implode( '<br>', $lines ) . '</p>';
}
add_shortcode( 'llb_company_details', 'llb_shortcode_company_details' );
