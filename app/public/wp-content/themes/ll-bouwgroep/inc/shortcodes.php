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

	$parts = array();

	if ( '' !== $company ) {
		$parts[] = '<strong>' . esc_html( $company ) . '</strong>';
	}

	if ( '' !== $address ) {
		$parts[] = '<span>' . esc_html( $address ) . '</span>';
	}

	if ( '' !== $email ) {
		$parts[] = '<a href="' . esc_url( 'mailto:' . antispambot( $email ) ) . '">' . esc_html( antispambot( $email ) ) . '</a>';
	}

	if ( '' !== $phone ) {
		$tel = preg_replace( '/[^\d+]/', '', $phone );
		if ( '' !== $tel ) {
			$parts[] = '<a href="' . esc_url( 'tel:' . $tel ) . '">' . esc_html( $phone ) . '</a>';
		} else {
			$parts[] = '<span>' . esc_html( $phone ) . '</span>';
		}
	}

	if ( empty( $parts ) ) {
		return '';
	}

	return '<div class="company-card">' . implode( '', $parts ) . '</div>';
}
add_shortcode( 'llb_company_details', 'llb_shortcode_company_details' );
