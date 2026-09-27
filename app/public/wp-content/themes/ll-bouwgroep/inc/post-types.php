<?php
/**
 * Custom post types and taxonomies.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers custom post types and taxonomies.
 *
 * @return void
 */
function llb_register_post_types() {
	llb_register_cpt_dienst();
	llb_register_cpt_project();
	llb_register_taxonomy_project_categorie();
}
add_action( 'init', 'llb_register_post_types' );

/**
 * Registers the dienst post type.
 *
 * @return void
 */
function llb_register_cpt_dienst() {
	$labels = array(
		'name'                  => __( 'Services', 'll-bouwgroep' ),
		'singular_name'         => __( 'Service', 'll-bouwgroep' ),
		'menu_name'             => __( 'Services', 'll-bouwgroep' ),
		'name_admin_bar'        => __( 'Service', 'll-bouwgroep' ),
		'add_new'               => __( 'Add New', 'll-bouwgroep' ),
		'add_new_item'          => __( 'Add New Service', 'll-bouwgroep' ),
		'new_item'              => __( 'New Service', 'll-bouwgroep' ),
		'edit_item'             => __( 'Edit Service', 'll-bouwgroep' ),
		'view_item'             => __( 'View Service', 'll-bouwgroep' ),
		'view_items'            => __( 'View Services', 'll-bouwgroep' ),
		'all_items'             => __( 'All Services', 'll-bouwgroep' ),
		'search_items'          => __( 'Search Services', 'll-bouwgroep' ),
		'parent_item_colon'     => __( 'Parent Service:', 'll-bouwgroep' ),
		'not_found'             => __( 'No services found.', 'll-bouwgroep' ),
		'not_found_in_trash'    => __( 'No services found in Trash.', 'll-bouwgroep' ),
		'featured_image'        => __( 'Featured image', 'll-bouwgroep' ),
		'set_featured_image'    => __( 'Set featured image', 'll-bouwgroep' ),
		'remove_featured_image' => __( 'Remove featured image', 'll-bouwgroep' ),
		'use_featured_image'    => __( 'Use as featured image', 'll-bouwgroep' ),
		'archives'              => __( 'Service archives', 'll-bouwgroep' ),
		'insert_into_item'      => __( 'Insert into service', 'll-bouwgroep' ),
		'uploaded_to_this_item' => __( 'Uploaded to this service', 'll-bouwgroep' ),
		'filter_items_list'     => __( 'Filter services list', 'll-bouwgroep' ),
		'items_list_navigation' => __( 'Services list navigation', 'll-bouwgroep' ),
		'items_list'            => __( 'Services list', 'll-bouwgroep' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'show_in_rest'       => true,
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_icon'          => 'dashicons-hammer',
		'menu_position'      => 20,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'revisions' ),
		'rewrite'            => array(
			'slug'       => 'diensten',
			'with_front' => false,
		),
	);

	register_post_type( 'dienst', $args );
}

/**
 * Registers the project post type.
 *
 * @return void
 */
function llb_register_cpt_project() {
	$labels = array(
		'name'                  => __( 'Projects', 'll-bouwgroep' ),
		'singular_name'         => __( 'Project', 'll-bouwgroep' ),
		'menu_name'             => __( 'Projects', 'll-bouwgroep' ),
		'name_admin_bar'        => __( 'Project', 'll-bouwgroep' ),
		'add_new'               => __( 'Add New', 'll-bouwgroep' ),
		'add_new_item'          => __( 'Add New Project', 'll-bouwgroep' ),
		'new_item'              => __( 'New Project', 'll-bouwgroep' ),
		'edit_item'             => __( 'Edit Project', 'll-bouwgroep' ),
		'view_item'             => __( 'View Project', 'll-bouwgroep' ),
		'view_items'            => __( 'View Projects', 'll-bouwgroep' ),
		'all_items'             => __( 'All Projects', 'll-bouwgroep' ),
		'search_items'          => __( 'Search Projects', 'll-bouwgroep' ),
		'parent_item_colon'     => __( 'Parent Project:', 'll-bouwgroep' ),
		'not_found'             => __( 'No projects found.', 'll-bouwgroep' ),
		'not_found_in_trash'    => __( 'No projects found in Trash.', 'll-bouwgroep' ),
		'featured_image'        => __( 'Featured image', 'll-bouwgroep' ),
		'set_featured_image'    => __( 'Set featured image', 'll-bouwgroep' ),
		'remove_featured_image' => __( 'Remove featured image', 'll-bouwgroep' ),
		'use_featured_image'    => __( 'Use as featured image', 'll-bouwgroep' ),
		'archives'              => __( 'Project archives', 'll-bouwgroep' ),
		'insert_into_item'      => __( 'Insert into project', 'll-bouwgroep' ),
		'uploaded_to_this_item' => __( 'Uploaded to this project', 'll-bouwgroep' ),
		'filter_items_list'     => __( 'Filter projects list', 'll-bouwgroep' ),
		'items_list_navigation' => __( 'Projects list navigation', 'll-bouwgroep' ),
		'items_list'            => __( 'Projects list', 'll-bouwgroep' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'show_in_rest'       => true,
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_icon'          => 'dashicons-portfolio',
		'menu_position'      => 21,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
		'rewrite'            => array(
			'slug'       => 'projecten',
			'with_front' => false,
		),
	);

	register_post_type( 'project', $args );
}

/**
 * Registers the project_categorie taxonomy.
 *
 * @return void
 */
function llb_register_taxonomy_project_categorie() {
	$labels = array(
		'name'                       => __( 'Project categories', 'll-bouwgroep' ),
		'singular_name'              => __( 'Project category', 'll-bouwgroep' ),
		'menu_name'                  => __( 'Project categories', 'll-bouwgroep' ),
		'all_items'                  => __( 'All Project categories', 'll-bouwgroep' ),
		'edit_item'                  => __( 'Edit Project category', 'll-bouwgroep' ),
		'view_item'                  => __( 'View Project category', 'll-bouwgroep' ),
		'update_item'                => __( 'Update Project category', 'll-bouwgroep' ),
		'add_new_item'               => __( 'Add New Project category', 'll-bouwgroep' ),
		'new_item_name'              => __( 'New Project category name', 'll-bouwgroep' ),
		'parent_item'                => __( 'Parent Project category', 'll-bouwgroep' ),
		'parent_item_colon'          => __( 'Parent Project category:', 'll-bouwgroep' ),
		'search_items'               => __( 'Search Project categories', 'll-bouwgroep' ),
		'popular_items'              => __( 'Popular Project categories', 'll-bouwgroep' ),
		'separate_items_with_commas' => __( 'Separate project categories with commas', 'll-bouwgroep' ),
		'add_or_remove_items'        => __( 'Add or remove project categories', 'll-bouwgroep' ),
		'choose_from_most_used'      => __( 'Choose from the most used project categories', 'll-bouwgroep' ),
		'not_found'                  => __( 'No project categories found.', 'll-bouwgroep' ),
		'no_terms'                   => __( 'No project categories', 'll-bouwgroep' ),
		'items_list_navigation'      => __( 'Project categories list navigation', 'll-bouwgroep' ),
		'items_list'                 => __( 'Project categories list', 'll-bouwgroep' ),
		'back_to_items'              => __( '← Back to Project categories', 'll-bouwgroep' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array(
			'slug'       => 'projectcategorie',
			'with_front' => false,
		),
	);

	register_taxonomy( 'project_categorie', array( 'project' ), $args );
}

/**
 * Flushes rewrite rules and seeds default project categories on theme activation.
 *
 * @return void
 */
function llb_theme_activation() {
	llb_register_post_types();
	llb_seed_project_categories();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'llb_theme_activation' );

/**
 * Creates default project_categorie terms if they do not exist yet.
 *
 * @return void
 */
function llb_seed_project_categories() {
	$terms = array(
		'Badkamers & toiletten',
		'Renovatie & verbouwing',
		'Keukens',
		'Aan- en uitbouw',
	);

	foreach ( $terms as $term_name ) {
		if ( ! term_exists( $term_name, 'project_categorie' ) ) {
			wp_insert_term( $term_name, 'project_categorie' );
		}
	}
}
