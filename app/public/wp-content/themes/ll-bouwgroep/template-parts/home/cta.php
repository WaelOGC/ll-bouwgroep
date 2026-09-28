<?php
/**
 * Home — CTA (design v2).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();

get_template_part(
	'template-parts/cta-band',
	null,
	array(
		'heading'     => trim( (string) llb_get_meta( $post_id, '_llb_cta_heading' ) ),
		'text'        => (string) llb_get_meta( $post_id, '_llb_cta_text' ),
		'button_text' => trim( (string) llb_get_meta( $post_id, '_llb_cta_btn_text' ) ),
		'button_url'  => llb_get_header_cta_url(),
		'image_id'    => absint( llb_get_meta( $post_id, '_llb_cta_image' ) ),
		'id'          => 'contact',
	)
);
