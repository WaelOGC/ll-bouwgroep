<?php
/**
 * Home — hero.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();
$title   = trim( (string) llb_get_meta( $post_id, '_llb_hero_title' ) );
if ( '' === $title ) {
	$title = get_the_title();
}
$intro    = (string) llb_get_meta( $post_id, '_llb_hero_intro' );
$image_id = absint( llb_get_meta( $post_id, '_llb_hero_image' ) );

$btn1_text = trim( (string) llb_get_meta( $post_id, '_llb_hero_btn1_text' ) );
$btn1_url  = trim( (string) llb_get_meta( $post_id, '_llb_hero_btn1_url' ) );
if ( '' === $btn1_url ) {
	$btn1_url = llb_get_header_cta_url();
}

$btn2_text = trim( (string) llb_get_meta( $post_id, '_llb_hero_btn2_text' ) );
$btn2_url  = trim( (string) llb_get_meta( $post_id, '_llb_hero_btn2_url' ) );
if ( '' === $btn2_url ) {
	$btn2_url = llb_page_url( 'diensten' );
}

$buttons = array();
if ( '' !== $btn1_text ) {
	$buttons[] = array(
		'text'  => $btn1_text,
		'url'   => $btn1_url,
		'style' => 'primary',
	);
}
if ( '' !== $btn2_text ) {
	$buttons[] = array(
		'text'  => $btn2_text,
		'url'   => $btn2_url,
		'style' => 'outline-light',
	);
}

if ( '' === $title && '' === trim( $intro ) && empty( $buttons ) && ! $image_id ) {
	return;
}

get_template_part(
	'template-parts/page-hero',
	null,
	array(
		'title'    => $title,
		'intro'    => $intro,
		'image_id' => $image_id,
		'buttons'  => $buttons,
		'variant'  => 'home',
	)
);
