<?php
/**
 * Front-end content queries.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns published services ordered by menu_order, then title.
 *
 * @return array<int, WP_Post>
 */
function llb_get_services() {
	$posts = get_posts(
		array(
			'post_type'      => 'dienst',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
		)
	);

	return is_array( $posts ) ? $posts : array();
}

/**
 * Returns published projects for the homepage (featured first, then newest).
 *
 * @param int $limit Max number of projects.
 * @return array<int, WP_Post>
 */
function llb_get_home_projects( $limit = 3 ) {
	$limit = max( 1, absint( $limit ) );

	$featured = get_posts(
		array(
			'post_type'      => 'project',
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'meta_key'       => '_llb_project_featured',
			'meta_value'     => '1',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	if ( ! is_array( $featured ) ) {
		$featured = array();
	}

	$needed = $limit - count( $featured );
	if ( $needed <= 0 ) {
		return array_slice( $featured, 0, $limit );
	}

	$exclude = wp_list_pluck( $featured, 'ID' );
	$rest    = get_posts(
		array(
			'post_type'      => 'project',
			'post_status'    => 'publish',
			'posts_per_page' => $needed,
			'post__not_in'   => $exclude,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	if ( ! is_array( $rest ) ) {
		$rest = array();
	}

	return array_merge( $featured, $rest );
}

/**
 * Returns the ID of the first published FAQ page template, or 0.
 *
 * @return int
 */
function llb_get_faq_page_id() {
	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-templates/page-faq.php',
			'fields'         => 'ids',
		)
	);

	if ( empty( $pages ) || ! is_array( $pages ) ) {
		return 0;
	}

	return (int) $pages[0];
}

/**
 * Returns FAQ items marked for the homepage with a non-empty answer.
 *
 * @return array<int, array<string, mixed>>
 */
function llb_get_home_faq_items() {
	$page_id = llb_get_faq_page_id();
	if ( ! $page_id ) {
		return array();
	}

	$items = llb_get_meta( $page_id, '_llb_faq_items' );
	if ( ! is_array( $items ) ) {
		return array();
	}

	$out = array();
	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$question = isset( $item['question'] ) ? trim( (string) $item['question'] ) : '';
		$answer   = isset( $item['answer'] ) ? trim( (string) $item['answer'] ) : '';
		$show     = isset( $item['show_on_home'] ) ? (string) $item['show_on_home'] : '';

		if ( '1' !== $show || '' === $question || '' === $answer ) {
			continue;
		}

		$out[] = $item;
	}

	return $out;
}

/**
 * Returns the permalink for a service by slug, or the Services page URL.
 *
 * @param string $slug Service post slug.
 * @return string
 */
function llb_get_service_url( $slug ) {
	$slug = sanitize_title( (string) $slug );
	if ( '' === $slug ) {
		return llb_page_url( 'diensten' );
	}

	$posts = get_posts(
		array(
			'name'           => $slug,
			'post_type'      => 'dienst',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
		)
	);

	if ( ! empty( $posts[0] ) && $posts[0] instanceof WP_Post ) {
		return get_permalink( $posts[0] );
	}

	return llb_page_url( 'diensten' );
}
