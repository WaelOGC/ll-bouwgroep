<?php
/**
 * Yoast SEO / Rank Math compatibility.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers SEO plugin theme support.
 *
 * @return void
 */
function llb_seo_theme_support() {
	add_theme_support( 'yoast-seo-breadcrumbs' );
	add_theme_support( 'rank-math-breadcrumbs' );
}
add_action( 'after_setup_theme', 'llb_seo_theme_support' );

/**
 * Outputs breadcrumbs from Yoast or Rank Math, or nothing.
 *
 * @return void
 */
function llb_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		echo '<nav class="llb-breadcrumbs" aria-label="' . esc_attr__( 'Kruimelpad', 'll-bouwgroep' ) . '">';
		yoast_breadcrumb();
		echo '</nav>';
		return;
	}

	if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		echo '<nav class="llb-breadcrumbs" aria-label="' . esc_attr__( 'Kruimelpad', 'll-bouwgroep' ) . '">';
		rank_math_the_breadcrumbs();
		echo '</nav>';
	}
}

/**
 * Prints FAQPage JSON-LD on the FAQ page and single services with related FAQ.
 *
 * @return void
 */
function llb_output_faq_schema() {
	$entities = array();

	if ( is_singular( 'dienst' ) ) {
		$items = function_exists( 'llb_get_related_faq_for_service' ) ? llb_get_related_faq_for_service( get_the_ID(), 3 ) : array();
		foreach ( $items as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}
			$question = isset( $item['question'] ) ? trim( (string) $item['question'] ) : '';
			$answer   = isset( $item['answer'] ) ? trim( (string) $item['answer'] ) : '';
			if ( '' === $question || '' === $answer ) {
				continue;
			}
			$entities[] = array(
				'@type'          => 'Question',
				'name'           => $question,
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_strip_all_tags( $answer ),
				),
			);
		}
	} elseif ( is_page() && 'page-templates/page-faq.php' === get_page_template_slug() ) {
		/**
		 * Filters whether the theme outputs FAQPage JSON-LD on the FAQ page.
		 *
		 * @param bool $output Whether to output FAQ schema. Default true.
		 */
		if ( ! apply_filters( 'llb_output_faq_schema', true ) ) {
			return;
		}

		$items = llb_get_meta( get_the_ID(), '_llb_faq_items' );
		if ( ! is_array( $items ) || empty( $items ) ) {
			return;
		}

		foreach ( $items as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}

			$question = isset( $item['question'] ) ? trim( (string) $item['question'] ) : '';
			$answer   = isset( $item['answer'] ) ? trim( (string) $item['answer'] ) : '';

			if ( '' === $question || '' === $answer ) {
				continue;
			}

			$entities[] = array(
				'@type'          => 'Question',
				'name'           => $question,
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_strip_all_tags( $answer ),
				),
			);
		}
	} else {
		return;
	}

	if ( empty( $entities ) ) {
		return;
	}

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $entities,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'llb_output_faq_schema', 20 );
