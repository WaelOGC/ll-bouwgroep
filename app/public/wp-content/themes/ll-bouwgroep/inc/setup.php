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
