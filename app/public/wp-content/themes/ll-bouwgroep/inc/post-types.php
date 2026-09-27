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
		'name'                  => __( 'Diensten', 'll-bouwgroep' ),
		'singular_name'         => __( 'Dienst', 'll-bouwgroep' ),
		'menu_name'             => __( 'Diensten', 'll-bouwgroep' ),
		'name_admin_bar'        => __( 'Dienst', 'll-bouwgroep' ),
		'add_new'               => __( 'Nieuwe toevoegen', 'll-bouwgroep' ),
		'add_new_item'          => __( 'Nieuwe dienst toevoegen', 'll-bouwgroep' ),
		'new_item'              => __( 'Nieuwe dienst', 'll-bouwgroep' ),
		'edit_item'             => __( 'Dienst bewerken', 'll-bouwgroep' ),
		'view_item'             => __( 'Dienst bekijken', 'll-bouwgroep' ),
		'view_items'            => __( 'Diensten bekijken', 'll-bouwgroep' ),
		'all_items'             => __( 'Alle diensten', 'll-bouwgroep' ),
		'search_items'          => __( 'Diensten zoeken', 'll-bouwgroep' ),
		'parent_item_colon'     => __( 'Hoofddienst:', 'll-bouwgroep' ),
		'not_found'             => __( 'Geen diensten gevonden.', 'll-bouwgroep' ),
		'not_found_in_trash'    => __( 'Geen diensten gevonden in de prullenbak.', 'll-bouwgroep' ),
		'featured_image'        => __( 'Uitgelichte afbeelding', 'll-bouwgroep' ),
		'set_featured_image'    => __( 'Uitgelichte afbeelding instellen', 'll-bouwgroep' ),
		'remove_featured_image' => __( 'Uitgelichte afbeelding verwijderen', 'll-bouwgroep' ),
		'use_featured_image'    => __( 'Als uitgelichte afbeelding gebruiken', 'll-bouwgroep' ),
		'archives'              => __( 'Dienstenarchief', 'll-bouwgroep' ),
		'insert_into_item'      => __( 'In dienst invoegen', 'll-bouwgroep' ),
		'uploaded_to_this_item' => __( 'Geüpload naar deze dienst', 'll-bouwgroep' ),
		'filter_items_list'     => __( 'Dienstenlijst filteren', 'll-bouwgroep' ),
		'items_list_navigation' => __( 'Navigatie dienstenlijst', 'll-bouwgroep' ),
		'items_list'            => __( 'Dienstenlijst', 'll-bouwgroep' ),
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
		'name'                  => __( 'Projecten', 'll-bouwgroep' ),
		'singular_name'         => __( 'Project', 'll-bouwgroep' ),
		'menu_name'             => __( 'Projecten', 'll-bouwgroep' ),
		'name_admin_bar'        => __( 'Project', 'll-bouwgroep' ),
		'add_new'               => __( 'Nieuw toevoegen', 'll-bouwgroep' ),
		'add_new_item'          => __( 'Nieuw project toevoegen', 'll-bouwgroep' ),
		'new_item'              => __( 'Nieuw project', 'll-bouwgroep' ),
		'edit_item'             => __( 'Project bewerken', 'll-bouwgroep' ),
		'view_item'             => __( 'Project bekijken', 'll-bouwgroep' ),
		'view_items'            => __( 'Projecten bekijken', 'll-bouwgroep' ),
		'all_items'             => __( 'Alle projecten', 'll-bouwgroep' ),
		'search_items'          => __( 'Projecten zoeken', 'll-bouwgroep' ),
		'parent_item_colon'     => __( 'Hoofdproject:', 'll-bouwgroep' ),
		'not_found'             => __( 'Geen projecten gevonden.', 'll-bouwgroep' ),
		'not_found_in_trash'    => __( 'Geen projecten gevonden in de prullenbak.', 'll-bouwgroep' ),
		'featured_image'        => __( 'Uitgelichte afbeelding', 'll-bouwgroep' ),
		'set_featured_image'    => __( 'Uitgelichte afbeelding instellen', 'll-bouwgroep' ),
		'remove_featured_image' => __( 'Uitgelichte afbeelding verwijderen', 'll-bouwgroep' ),
		'use_featured_image'    => __( 'Als uitgelichte afbeelding gebruiken', 'll-bouwgroep' ),
		'archives'              => __( 'Projectenarchief', 'll-bouwgroep' ),
		'insert_into_item'      => __( 'In project invoegen', 'll-bouwgroep' ),
		'uploaded_to_this_item' => __( 'Geüpload naar dit project', 'll-bouwgroep' ),
		'filter_items_list'     => __( 'Projectenlijst filteren', 'll-bouwgroep' ),
		'items_list_navigation' => __( 'Navigatie projectenlijst', 'll-bouwgroep' ),
		'items_list'            => __( 'Projectenlijst', 'll-bouwgroep' ),
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
		'name'                       => __( 'Projectcategorieën', 'll-bouwgroep' ),
		'singular_name'              => __( 'Projectcategorie', 'll-bouwgroep' ),
		'menu_name'                  => __( 'Projectcategorieën', 'll-bouwgroep' ),
		'all_items'                  => __( 'Alle projectcategorieën', 'll-bouwgroep' ),
		'edit_item'                  => __( 'Projectcategorie bewerken', 'll-bouwgroep' ),
		'view_item'                  => __( 'Projectcategorie bekijken', 'll-bouwgroep' ),
		'update_item'                => __( 'Projectcategorie bijwerken', 'll-bouwgroep' ),
		'add_new_item'               => __( 'Nieuwe projectcategorie toevoegen', 'll-bouwgroep' ),
		'new_item_name'              => __( 'Nieuwe projectcategorienaam', 'll-bouwgroep' ),
		'parent_item'                => __( 'Hoofdprojectcategorie', 'll-bouwgroep' ),
		'parent_item_colon'          => __( 'Hoofdprojectcategorie:', 'll-bouwgroep' ),
		'search_items'               => __( 'Projectcategorieën zoeken', 'll-bouwgroep' ),
		'popular_items'              => __( 'Populaire projectcategorieën', 'll-bouwgroep' ),
		'separate_items_with_commas' => __( 'Scheid projectcategorieën met komma’s', 'll-bouwgroep' ),
		'add_or_remove_items'        => __( 'Projectcategorieën toevoegen of verwijderen', 'll-bouwgroep' ),
		'choose_from_most_used'      => __( 'Kies uit de meest gebruikte projectcategorieën', 'll-bouwgroep' ),
		'not_found'                  => __( 'Geen projectcategorieën gevonden.', 'll-bouwgroep' ),
		'no_terms'                   => __( 'Geen projectcategorieën', 'll-bouwgroep' ),
		'items_list_navigation'      => __( 'Navigatie projectcategorieënlijst', 'll-bouwgroep' ),
		'items_list'                 => __( 'Projectcategorieënlijst', 'll-bouwgroep' ),
		'back_to_items'              => __( '← Terug naar projectcategorieën', 'll-bouwgroep' ),
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
