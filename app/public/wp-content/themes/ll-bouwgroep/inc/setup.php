<?php
/**
 * Theme setup.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up theme defaults and registers support for WordPress features.
 *
 * @return void
 */
function llb_setup() {
	load_theme_textdomain( 'll-bouwgroep', LLB_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary menu', 'll-bouwgroep' ),
			'footer'  => __( 'Footer menu', 'll-bouwgroep' ),
		)
	);

	add_image_size( 'llb-card', 720, 480, true );

	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 1200;
	}
}
add_action( 'after_setup_theme', 'llb_setup' );

/**
 * Clears menu item IDs for the mobile primary menu to avoid duplicates.
 *
 * @param string  $id    Menu item ID attribute.
 * @param WP_Post $item  Menu item.
 * @param object  $args  Menu args.
 * @param int     $depth Depth.
 * @return string
 */
function llb_nav_menu_item_id( $id, $item, $args, $depth ) {
	unset( $item, $depth );
	if ( is_object( $args ) && isset( $args->menu_id ) && 'llb-menu-mobile' === $args->menu_id ) {
		return '';
	}
	return $id;
}
add_filter( 'nav_menu_item_id', 'llb_nav_menu_item_id', 10, 4 );

/**
 * Injects service children under the Diensten menu item when it has none.
 *
 * @param array<int, object> $items Menu items.
 * @param object             $args  Menu args.
 * @return array<int, object>
 */
function llb_nav_menu_services_dropdown( $items, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $items;
	}

	$diensten = get_page_by_path( 'diensten', OBJECT, 'page' );
	if ( ! $diensten ) {
		return $items;
	}

	$services = llb_get_services();
	if ( empty( $services ) ) {
		return $items;
	}

	$has_children = array();
	$parent_item  = null;

	foreach ( $items as $item ) {
		$parent = isset( $item->menu_item_parent ) ? (int) $item->menu_item_parent : 0;
		if ( $parent > 0 ) {
			$has_children[ $parent ] = true;
		}
		if ( 'page' === $item->object && (int) $item->object_id === (int) $diensten->ID ) {
			$parent_item = $item;
		}
	}

	if ( ! $parent_item || ! empty( $has_children[ (int) $parent_item->ID ] ) ) {
		return $items;
	}

	$parent_item->classes   = array_unique( array_merge( (array) $parent_item->classes, array( 'menu-item-has-children', 'llb-menu-item--services' ) ) );
	$parent_db_id           = (int) $parent_item->ID;
	$out                    = array();
	$fake_id                = 900000;

	foreach ( $items as $item ) {
		$out[] = $item;
		if ( (int) $item->ID !== $parent_db_id ) {
			continue;
		}
		foreach ( $services as $service ) {
			++$fake_id;
			$child                   = new stdClass();
			$child->ID               = $fake_id;
			$child->db_id            = $fake_id;
			$child->menu_item_parent = $parent_db_id;
			$child->object_id        = (int) $service->ID;
			$child->post_parent      = $parent_db_id;
			$child->type             = 'post_type';
			$child->object           = 'dienst';
			$child->type_label       = __( 'Service', 'll-bouwgroep' );
			$child->title            = get_the_title( $service );
			$child->url              = get_permalink( $service );
			$child->target           = '';
			$child->attr_title       = '';
			$child->description      = '';
			$child->classes          = array( 'menu-item', 'menu-item-type-post_type', 'menu-item-object-dienst' );
			$child->xfn              = '';
			$child->current          = false;
			$child->current_item_ancestor = false;
			$child->current_item_parent   = false;
			$out[] = $child;
		}
	}

	return $out;
}
add_filter( 'wp_nav_menu_objects', 'llb_nav_menu_services_dropdown', 10, 2 );

/**
 * Appends a chevron icon to top-level parent menu titles.
 *
 * @param string   $title Item title.
 * @param WP_Post  $item  Menu item.
 * @param stdClass $args  Menu args.
 * @param int      $depth Depth.
 * @return string
 */
function llb_nav_menu_chevron( $title, $item, $args, $depth ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $title;
	}
	if ( 0 !== (int) $depth ) {
		return $title;
	}
	if ( ! in_array( 'menu-item-has-children', (array) $item->classes, true ) ) {
		return $title;
	}

	return $title . '<span class="llb-nav-chevron">' . llb_icon( 'chevron' ) . '</span>';
}
add_filter( 'nav_menu_item_title', 'llb_nav_menu_chevron', 10, 4 );
