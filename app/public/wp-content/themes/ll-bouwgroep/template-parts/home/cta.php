<?php
/**
 * Home — final CTA.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id     = get_the_ID();
$heading     = trim( (string) llb_get_meta( $post_id, '_llb_cta_heading' ) );
$text        = trim( (string) llb_get_meta( $post_id, '_llb_cta_text' ) );
$button_text = trim( (string) llb_get_meta( $post_id, '_llb_cta_btn_text' ) );

if ( '' === $heading && '' === $text && '' === $button_text ) {
	return;
}

get_template_part(
	'template-parts/cta-band',
	null,
	array(
		'heading'     => $heading,
		'text'        => $text,
		'button_text' => $button_text,
		'button_url'  => llb_get_header_cta_url(),
	)
);
