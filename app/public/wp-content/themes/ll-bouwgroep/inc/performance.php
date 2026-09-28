<?php
/**
 * Front-end performance helpers (preload, head cleanup, image attrs).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Removes unused WordPress head output on the front end.
 *
 * @return void
 */
function llb_performance_head_cleanup() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
	remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
}
add_action( 'after_setup_theme', 'llb_performance_head_cleanup' );

/**
 * Disables emoji DNS prefetch.
 *
 * @param array<int, string> $urls          URLs.
 * @param string             $relation_type Relation.
 * @return array<int, string>
 */
function llb_disable_emoji_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' !== $relation_type ) {
		return $urls;
	}
	return array_values(
		array_filter(
			$urls,
			static function ( $url ) {
				return false === strpos( (string) $url, 'https://s.w.org/images/core/emoji' );
			}
		)
	);
}
add_filter( 'wp_resource_hints', 'llb_disable_emoji_dns_prefetch', 10, 2 );

/**
 * Preloads critical fonts (Barlow 700, Inter 400).
 *
 * @return void
 */
function llb_preload_fonts() {
	$fonts = array(
		'fonts/barlow-latin-700-normal.woff2',
		'fonts/inter-latin-400-normal.woff2',
	);

	foreach ( $fonts as $relative ) {
		$path = LLB_DIR . '/assets/' . $relative;
		if ( ! file_exists( $path ) ) {
			continue;
		}
		$url = LLB_URI . '/assets/' . $relative;
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( $url )
		);
	}
}
add_action( 'wp_head', 'llb_preload_fonts', 1 );

/**
 * Returns hero image IDs for the current front request.
 *
 * @return array{desktop:int,mobile:int}
 */
function llb_get_current_hero_image_ids() {
	$desktop = 0;
	$mobile  = 0;
	$post_id = 0;

	if ( is_front_page() ) {
		$post_id = (int) get_queried_object_id();
		if ( ! $post_id ) {
			$post_id = (int) get_option( 'page_on_front' );
		}
	} elseif ( is_singular() ) {
		$post_id = (int) get_queried_object_id();
	}

	if ( $post_id ) {
		$desktop = absint( get_post_meta( $post_id, '_llb_hero_image', true ) );
		$mobile  = absint( get_post_meta( $post_id, '_llb_hero_image_mobile', true ) );
	}

	return array(
		'desktop' => $desktop,
		'mobile'  => $mobile,
	);
}

/**
 * Prints a preload link for an attachment (optionally with media query).
 *
 * @param int    $attachment_id Attachment ID.
 * @param string $media         Optional media attribute.
 * @return void
 */
function llb_print_image_preload( $attachment_id, $media = '' ) {
	$attachment_id = absint( $attachment_id );
	if ( ! $attachment_id ) {
		return;
	}

	$src = wp_get_attachment_image_url( $attachment_id, 'full' );
	if ( ! $src ) {
		return;
	}

	$srcset = wp_get_attachment_image_srcset( $attachment_id, 'full' );
	$sizes  = wp_get_attachment_image_sizes( $attachment_id, 'full' );
	if ( ! $sizes ) {
		$sizes = '100vw';
	}

	$attrs = array(
		'rel="preload"',
		'as="image"',
		'href="' . esc_url( $src ) . '"',
	);

	if ( $srcset ) {
		$attrs[] = 'imagesrcset="' . esc_attr( $srcset ) . '"';
		$attrs[] = 'imagesizes="' . esc_attr( $sizes ) . '"';
	}

	if ( '' !== $media ) {
		$attrs[] = 'media="' . esc_attr( $media ) . '"';
	}

	echo '<link ' . implode( ' ', $attrs ) . '>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- attrs escaped above.
}

/**
 * Preloads the LCP hero image (desktop + mobile picture sources).
 *
 * @return void
 */
function llb_preload_hero_lcp() {
	$ids = llb_get_current_hero_image_ids();
	if ( ! $ids['desktop'] && ! $ids['mobile'] ) {
		return;
	}

	if ( $ids['desktop'] && $ids['mobile'] ) {
		llb_print_image_preload( $ids['mobile'], '(max-width: 1023px) and (orientation: portrait)' );
		llb_print_image_preload( $ids['desktop'], '(min-width: 1024px), (max-width: 1023px) and (orientation: landscape)' );
		return;
	}

	llb_print_image_preload( $ids['desktop'] ? $ids['desktop'] : $ids['mobile'] );
}
add_action( 'wp_head', 'llb_preload_hero_lcp', 2 );

/**
 * Default sizes attribute for common image contexts.
 *
 * @param string $context Context key.
 * @return string
 */
function llb_image_sizes_attr( $context ) {
	switch ( $context ) {
		case 'card':
			return '(max-width: 599px) 100vw, (max-width: 1023px) 50vw, 400px';
		case 'split':
			return '(max-width: 767px) 100vw, 50vw';
		case 'featured':
			return '(max-width: 1023px) 100vw, 58vw';
		case 'cta':
			return '100vw';
		case 'gallery':
			return '(max-width: 1023px) 100vw, 58vw';
		case 'thumb':
			return '160px';
		case 'hero':
			return '100vw';
		default:
			return '(max-width: 1023px) 100vw, 1200px';
	}
}

/**
 * Common lazy image attributes for a context.
 *
 * @param string               $context Context.
 * @param array<string, mixed> $extra   Extra attributes.
 * @return array<string, mixed>
 */
function llb_lazy_img_attrs( $context, $extra = array() ) {
	$attrs = array(
		'loading'  => 'lazy',
		'decoding' => 'async',
		'sizes'    => llb_image_sizes_attr( $context ),
	);
	return array_merge( $attrs, is_array( $extra ) ? $extra : array() );
}
