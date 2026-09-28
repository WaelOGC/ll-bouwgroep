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
 * Returns the Home why items (_llb_why_items from the front page).
 *
 * Each item: title, text, icon (MDI slug).
 *
 * @return array<int, array{title: string, text: string, icon: string}>
 */
function llb_get_why_items() {
	$front_id = (int) get_option( 'page_on_front' );

	if ( ! $front_id ) {
		$pages = get_posts(
			array(
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'meta_key'       => '_wp_page_template',
				'meta_value'     => 'page-templates/template-home.php',
				'fields'         => 'ids',
			)
		);
		$front_id = ( ! empty( $pages[0] ) ) ? (int) $pages[0] : 0;
	}

	if ( ! $front_id ) {
		return array();
	}

	$items = llb_get_meta( $front_id, '_llb_why_items' );
	if ( ! is_array( $items ) ) {
		return array();
	}

	$defaults = array( 'hard-hat', 'toolbox', 'ruler-square' );
	$allowed  = llb_why_icon_options();
	$out      = array();

	foreach ( $items as $index => $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$title = isset( $item['title'] ) ? trim( (string) $item['title'] ) : '';
		$text  = isset( $item['text'] ) ? trim( (string) $item['text'] ) : '';
		$icon  = isset( $item['icon'] ) ? sanitize_file_name( (string) $item['icon'] ) : '';
		if ( '' === $title && '' === $text ) {
			continue;
		}
		if ( '' === $icon || ! isset( $allowed[ $icon ] ) ) {
			$icon = isset( $defaults[ $index ] ) ? $defaults[ $index ] : 'hard-hat';
		}
		$out[] = array(
			'title' => $title,
			'text'  => $text,
			'icon'  => $icon,
		);
	}

	return $out;
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

/**
 * Returns the Projects overview page ID, or 0.
 *
 * @return int
 */
function llb_get_projects_page_id() {
	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-templates/template-projects.php',
			'fields'         => 'ids',
		)
	);

	if ( empty( $pages ) || ! is_array( $pages ) ) {
		return 0;
	}

	return (int) $pages[0];
}

/**
 * Reads a meta value from the Projects overview page.
 *
 * @param string $key Meta key.
 * @return mixed
 */
function llb_get_projects_page_meta( $key ) {
	$page_id = llb_get_projects_page_id();
	if ( ! $page_id ) {
		return '';
	}

	return llb_get_meta( $page_id, $key );
}

/**
 * Builds a Projects overview URL with optional categorie and pagina query args.
 *
 * @param array<string, mixed> $args Optional. categorie, pagina.
 * @return string
 */
function llb_get_projects_page_url( $args = array() ) {
	$url = llb_page_url( 'projecten' );
	$page_id = llb_get_projects_page_id();
	if ( $page_id ) {
		$url = get_permalink( $page_id );
	}

	$query = array();
	if ( ! empty( $args['categorie'] ) ) {
		$query['categorie'] = sanitize_title( (string) $args['categorie'] );
	}
	if ( ! empty( $args['pagina'] ) && (int) $args['pagina'] > 1 ) {
		$query['pagina'] = (int) $args['pagina'];
	}

	if ( empty( $query ) ) {
		return $url;
	}

	return add_query_arg( $query, $url );
}

/**
 * Returns project_categorie terms that have at least one published project.
 *
 * Order matches the approved Projecten filter (docs + design reference).
 *
 * @return array<int, WP_Term>
 */
function llb_get_project_filter_terms() {
	$preferred_slugs = array(
		'badkamers-toiletten',
		'renovatie-verbouwing',
		'keukens',
		'aan-en-uitbouw',
	);

	$terms = get_terms(
		array(
			'taxonomy'   => 'project_categorie',
			'hide_empty' => true,
		)
	);

	if ( is_wp_error( $terms ) || ! is_array( $terms ) ) {
		return array();
	}

	$by_slug = array();
	foreach ( $terms as $term ) {
		if ( $term instanceof WP_Term ) {
			$by_slug[ $term->slug ] = $term;
		}
	}

	$ordered = array();
	foreach ( $preferred_slugs as $slug ) {
		if ( isset( $by_slug[ $slug ] ) ) {
			$ordered[] = $by_slug[ $slug ];
			unset( $by_slug[ $slug ] );
		}
	}

	foreach ( $by_slug as $term ) {
		$ordered[] = $term;
	}

	return $ordered;
}

/**
 * Returns the current Projects filter slug from the query string.
 *
 * @return string
 */
function llb_get_projects_filter_slug() {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- public filter query arg.
	if ( empty( $_GET['categorie'] ) ) {
		return '';
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	return sanitize_title( wp_unslash( (string) $_GET['categorie'] ) );
}

/**
 * Returns the current Projects page number from ?pagina=.
 *
 * @return int
 */
function llb_get_projects_page_number() {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- public pagination query arg.
	if ( empty( $_GET['pagina'] ) ) {
		return 1;
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	return max( 1, absint( wp_unslash( $_GET['pagina'] ) ) );
}

/**
 * Queries published projects for the overview (filter + pagination).
 *
 * @param string $category_slug Optional category slug.
 * @param int    $paged         Page number (1-based).
 * @param int    $per_page      Posts per page.
 * @return WP_Query
 */
function llb_query_projects( $category_slug = '', $paged = 1, $per_page = 9 ) {
	$args = array(
		'post_type'      => 'project',
		'post_status'    => 'publish',
		'posts_per_page' => max( 1, absint( $per_page ) ),
		'paged'          => max( 1, absint( $paged ) ),
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$category_slug = sanitize_title( (string) $category_slug );
	if ( '' !== $category_slug ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'project_categorie',
				'field'    => 'slug',
				'terms'    => $category_slug,
			),
		);
	}

	return new WP_Query( $args );
}

/**
 * Returns the first published featured project, or null.
 *
 * @return WP_Post|null
 */
function llb_get_featured_project() {
	$posts = get_posts(
		array(
			'post_type'      => 'project',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => '_llb_project_featured',
			'meta_value'     => '1',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	if ( empty( $posts[0] ) || ! ( $posts[0] instanceof WP_Post ) ) {
		return null;
	}

	return $posts[0];
}

/**
 * Returns whether any published projects exist.
 *
 * @return bool
 */
function llb_has_projects() {
	$posts = get_posts(
		array(
			'post_type'      => 'project',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	return ! empty( $posts );
}

/**
 * Returns gallery attachment IDs for a project (gallery, fallback featured image).
 *
 * @param int $post_id Project ID.
 * @return array<int, int>
 */
function llb_get_project_gallery_ids( $post_id ) {
	$post_id = absint( $post_id );
	$ids     = llb_get_meta( $post_id, '_llb_project_gallery' );
	if ( ! is_array( $ids ) ) {
		$ids = array();
	}

	$ids = array_values( array_filter( array_map( 'absint', $ids ) ) );
	if ( ! empty( $ids ) ) {
		return $ids;
	}

	$thumb = (int) get_post_thumbnail_id( $post_id );
	return $thumb ? array( $thumb ) : array();
}

/**
 * FAQ category labels in display order.
 *
 * @return array<string, string>
 */
function llb_get_faq_category_labels() {
	return array(
		'algemeen' => 'Algemeen',
		'badkamer' => 'Badkamer & toilet',
		'kosten'   => 'Kosten & btw',
		'aanbouw'  => 'Aan- en uitbouw',
	);
}

/**
 * Returns FAQ items with answers, grouped by category order.
 *
 * @return array<string, array{label: string, items: array<int, array<string, mixed>>}>
 */
function llb_get_faq_items_grouped() {
	$page_id = llb_get_faq_page_id();
	$labels  = llb_get_faq_category_labels();
	$groups  = array();

	foreach ( $labels as $key => $label ) {
		$groups[ $key ] = array(
			'label' => $label,
			'items' => array(),
		);
	}

	if ( ! $page_id ) {
		return $groups;
	}

	$items = llb_get_meta( $page_id, '_llb_faq_items' );
	if ( ! is_array( $items ) ) {
		return $groups;
	}

	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$question = isset( $item['question'] ) ? trim( (string) $item['question'] ) : '';
		$answer   = isset( $item['answer'] ) ? trim( (string) $item['answer'] ) : '';
		$category = isset( $item['category'] ) ? (string) $item['category'] : 'algemeen';

		if ( '' === $question || '' === $answer ) {
			continue;
		}

		if ( ! isset( $groups[ $category ] ) ) {
			$category = 'algemeen';
		}

		$groups[ $category ]['items'][] = $item;
	}

	return $groups;
}

/**
 * Parses list lines from a service section list field.
 *
 * @param mixed $list_raw Raw list value.
 * @return array<int, string>
 */
function llb_parse_section_list( $list_raw ) {
	$list = array();
	if ( '' === trim( (string) $list_raw ) ) {
		return $list;
	}

	$parts = preg_split( '/\r\n|\r|\n/', (string) $list_raw );
	if ( ! is_array( $parts ) ) {
		return $list;
	}

	foreach ( $parts as $line ) {
		$line = trim( (string) $line );
		if ( '' !== $line ) {
			$list[] = $line;
		}
	}

	return $list;
}

/**
 * Strips a leading "1. " style prefix from a step title.
 *
 * @param string $title Step title.
 * @return string
 */
function llb_strip_step_number_prefix( $title ) {
	$title = trim( (string) $title );
	return (string) preg_replace( '/^\d+\.\s*/u', '', $title );
}

/**
 * Project category select options for service related content.
 *
 * @return array<string, string>
 */
function llb_service_project_category_options() {
	$options = array(
		'' => __( '— None —', 'll-bouwgroep' ),
	);

	if ( ! taxonomy_exists( 'project_categorie' ) ) {
		return $options;
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'project_categorie',
			'hide_empty' => false,
		)
	);

	if ( is_wp_error( $terms ) || ! is_array( $terms ) ) {
		return $options;
	}

	foreach ( $terms as $term ) {
		if ( $term instanceof WP_Term ) {
			$options[ $term->slug ] = $term->name;
		}
	}

	return $options;
}

/**
 * FAQ category select options for service related content.
 *
 * @return array<string, string>
 */
function llb_service_faq_category_options() {
	$options = array(
		'' => __( '— None —', 'll-bouwgroep' ),
	);

	foreach ( llb_get_faq_category_labels() as $slug => $label ) {
		$options[ $slug ] = $label;
	}

	return $options;
}

/**
 * Default related-content map by service slug (seeder only).
 *
 * @return array<string, array{project_name: string, faq: string}>
 */
function llb_default_service_related_map() {
	return array(
		'badkamers-toiletten'               => array(
			'project_name' => 'Badkamers & toiletten',
			'faq'          => 'badkamer',
		),
		'renovatie-verbouwing'              => array(
			'project_name' => 'Renovatie & verbouwing',
			'faq'          => 'algemeen',
		),
		'keukenverbouwingen'                => array(
			'project_name' => 'Keukens',
			'faq'          => 'algemeen',
		),
		'aan-uitbouw'                       => array(
			'project_name' => 'Aan- en uitbouw',
			'faq'          => 'aanbouw',
		),
		'stucwerk'                          => array(
			'project_name' => '',
			'faq'          => 'algemeen',
		),
		'tegelwerk'                         => array(
			'project_name' => '',
			'faq'          => 'algemeen',
		),
		'timmerwerk'                        => array(
			'project_name' => '',
			'faq'          => 'algemeen',
		),
		'schilder-afbouwwerk'               => array(
			'project_name' => '',
			'faq'          => 'algemeen',
		),
		'overige-bouwkundige-werkzaamheden' => array(
			'project_name' => '',
			'faq'          => 'algemeen',
		),
	);
}

/**
 * Returns related projects for a service (category first, then newest fill).
 *
 * @param int $service_id Service post ID.
 * @param int $limit      Number of projects.
 * @return array<int, WP_Post>
 */
function llb_get_related_projects_for_service( $service_id, $limit = 2 ) {
	$limit      = max( 1, absint( $limit ) );
	$service_id = absint( $service_id );
	$out        = array();
	$exclude    = array();

	$cat_slug = $service_id ? trim( (string) llb_get_meta( $service_id, '_llb_related_project_cat' ) ) : '';
	if ( '' !== $cat_slug && taxonomy_exists( 'project_categorie' ) ) {
		$term = get_term_by( 'slug', $cat_slug, 'project_categorie' );
		if ( $term instanceof WP_Term ) {
			$from_cat = get_posts(
				array(
					'post_type'      => 'project',
					'post_status'    => 'publish',
					'posts_per_page' => $limit,
					'orderby'        => 'date',
					'order'          => 'DESC',
					'tax_query'      => array(
						array(
							'taxonomy' => 'project_categorie',
							'field'    => 'term_id',
							'terms'    => array( (int) $term->term_id ),
						),
					),
				)
			);
			if ( is_array( $from_cat ) ) {
				foreach ( $from_cat as $post ) {
					if ( $post instanceof WP_Post ) {
						$out[]     = $post;
						$exclude[] = (int) $post->ID;
					}
				}
			}
		}
	}

	$needed = $limit - count( $out );
	if ( $needed > 0 ) {
		$rest = get_posts(
			array(
				'post_type'      => 'project',
				'post_status'    => 'publish',
				'posts_per_page' => $needed,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'post__not_in'   => $exclude,
			)
		);
		if ( is_array( $rest ) ) {
			foreach ( $rest as $post ) {
				if ( $post instanceof WP_Post ) {
					$out[] = $post;
				}
			}
		}
	}

	return array_slice( $out, 0, $limit );
}

/**
 * Returns related FAQ items for a service (answered only).
 *
 * @param int $service_id Service post ID.
 * @param int $limit      Max items.
 * @return array<int, array<string, mixed>>
 */
function llb_get_related_faq_for_service( $service_id, $limit = 3 ) {
	$limit      = max( 1, absint( $limit ) );
	$service_id = absint( $service_id );
	$cat        = $service_id ? trim( (string) llb_get_meta( $service_id, '_llb_related_faq_cat' ) ) : '';
	$labels     = llb_get_faq_category_labels();

	if ( '' === $cat || ! isset( $labels[ $cat ] ) ) {
		return array();
	}

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
		$category = isset( $item['category'] ) ? (string) $item['category'] : '';
		if ( '' === $question || '' === $answer || $category !== $cat ) {
			continue;
		}
		$out[] = $item;
		if ( count( $out ) >= $limit ) {
			break;
		}
	}

	return $out;
}

/**
 * Returns the home CTA background attachment ID (demo home-cta or Home meta).
 *
 * @return int
 */
function llb_get_home_cta_image_id() {
	if ( function_exists( 'llb_find_demo_attachment' ) ) {
		$demo = llb_find_demo_attachment( 'home-cta.png' );
		if ( $demo ) {
			return $demo;
		}
	}

	$home_id = function_exists( 'llb_get_demo_page_id_by_slug' ) ? llb_get_demo_page_id_by_slug( 'home' ) : 0;
	if ( ! $home_id ) {
		$front = (int) get_option( 'page_on_front' );
		$home_id = $front ? $front : 0;
	}

	return $home_id ? absint( get_post_meta( $home_id, '_llb_cta_image', true ) ) : 0;
}

/**
 * Redirects project category archives to the Projects page filter URL.
 *
 * @return void
 */
function llb_redirect_project_category_archive() {
	if ( ! is_tax( 'project_categorie' ) ) {
		return;
	}

	$term = get_queried_object();
	if ( ! ( $term instanceof WP_Term ) ) {
		return;
	}

	$url = llb_get_projects_page_url( array( 'categorie' => $term->slug ) );
	wp_safe_redirect( $url, 301 );
	exit;
}
add_action( 'template_redirect', 'llb_redirect_project_category_archive' );
