<?php
/**
 * Demo image import (theme assets → Media Library → empty page fields).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Demo image definitions (filename → front-page meta field).
 *
 * Extend this array for later pages.
 *
 * @return array<int, array{file: string, field: string, title: string}>
 */
function llb_demo_images() {
	return array(
		array(
			'file'  => 'home-hero.png',
			'field' => '_llb_hero_image',
			'title' => 'Home hero',
		),
		array(
			'file'  => 'home-hero-mobile.png',
			'field' => '_llb_hero_image_mobile',
			'title' => 'Home hero mobile',
		),
		array(
			'file'  => 'home-bathroom.png',
			'field' => '_llb_bath_image',
			'title' => 'Home bathrooms',
		),
		array(
			'file'  => 'home-craftsmen.png',
			'field' => '_llb_why_image',
			'title' => 'Home why us',
		),
		array(
			'file'  => 'home-cta.png',
			'field' => '_llb_cta_image',
			'title' => 'Home CTA',
		),
	);
}

/**
 * Finds an existing demo attachment by filename meta.
 *
 * @param string $filename Demo filename.
 * @return int Attachment ID or 0.
 */
function llb_find_demo_attachment( $filename ) {
	$filename = (string) $filename;
	if ( '' === $filename ) {
		return 0;
	}

	$query = new WP_Query(
		array(
			'post_type'              => 'attachment',
			'post_status'            => 'inherit',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_key'               => '_llb_demo_image',
			'meta_value'             => $filename,
		)
	);

	if ( empty( $query->posts[0] ) ) {
		return 0;
	}

	return (int) $query->posts[0];
}

/**
 * Copies a theme demo file into uploads and creates an attachment.
 *
 * @param string $filename Filename under assets/images/.
 * @param string $title    Attachment title.
 * @return int Attachment ID or 0.
 */
function llb_sideload_demo_image( $filename, $title = '' ) {
	$filename = basename( (string) $filename );
	$source   = LLB_DIR . '/assets/images/' . $filename;

	if ( ! file_exists( $source ) || ! is_readable( $source ) ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$upload_dir = wp_upload_dir();
	if ( ! empty( $upload_dir['error'] ) ) {
		return 0;
	}

	$dest_name = wp_unique_filename( $upload_dir['path'], $filename );
	$dest_path = trailingslashit( $upload_dir['path'] ) . $dest_name;

	if ( ! copy( $source, $dest_path ) ) {
		return 0;
	}

	$filetype = wp_check_filetype( $dest_name, null );
	if ( empty( $filetype['type'] ) ) {
		wp_delete_file( $dest_path );
		return 0;
	}

	if ( '' === $title ) {
		$title = preg_replace( '/\.[^.]+$/', '', $filename );
	}

	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => $filetype['type'],
			'post_title'     => sanitize_text_field( (string) $title ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$dest_path
	);

	if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
		wp_delete_file( $dest_path );
		return 0;
	}

	$metadata = wp_generate_attachment_metadata( (int) $attachment_id, $dest_path );
	if ( is_array( $metadata ) ) {
		wp_update_attachment_metadata( (int) $attachment_id, $metadata );
	}

	update_post_meta( (int) $attachment_id, '_llb_demo_image', $filename );
	update_post_meta( (int) $attachment_id, '_wp_attachment_image_alt', sanitize_text_field( (string) $title ) );

	return (int) $attachment_id;
}

/**
 * Returns the front page ID used for Home demo image fields.
 *
 * @return int
 */
function llb_get_demo_images_page_id() {
	$front_id = (int) get_option( 'page_on_front' );
	if ( $front_id ) {
		return $front_id;
	}

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

	return ( ! empty( $pages[0] ) ) ? (int) $pages[0] : 0;
}

/**
 * Imports demo images into the Media Library and assigns empty Home fields.
 *
 * @return void
 */
function llb_import_demo_images() {
	$page_id = llb_get_demo_images_page_id();

	foreach ( llb_demo_images() as $item ) {
		$file  = isset( $item['file'] ) ? (string) $item['file'] : '';
		$field = isset( $item['field'] ) ? (string) $item['field'] : '';
		$title = isset( $item['title'] ) ? (string) $item['title'] : '';

		if ( '' === $file || '' === $field ) {
			continue;
		}

		$attachment_id = llb_find_demo_attachment( $file );
		if ( ! $attachment_id ) {
			$attachment_id = llb_sideload_demo_image( $file, $title );
		}

		if ( ! $attachment_id || ! $page_id ) {
			continue;
		}

		$current = absint( get_post_meta( $page_id, $field, true ) );
		if ( $current ) {
			continue;
		}

		update_post_meta( $page_id, $field, $attachment_id );
	}
}

/**
 * Runs demo image import once per theme version (admin).
 *
 * @return void
 */
function llb_maybe_import_demo_images() {
	$stored = (string) get_option( 'llb_demo_images_version', '' );
	if ( $stored === (string) LLB_VERSION ) {
		return;
	}

	llb_import_demo_images();
	update_option( 'llb_demo_images_version', (string) LLB_VERSION );
}
add_action( 'admin_init', 'llb_maybe_import_demo_images' );

/**
 * Seeds demo Customizer company data only when empty (once per theme version).
 *
 * @return void
 */
function llb_seed_demo_company_options() {
	$seeds = array(
		'llb_phone'            => '079 123 45 67',
		'llb_email'            => 'info@llbouwgroep.nl',
		'llb_address_street'   => 'Voorbeeldstraat 1',
		'llb_address_postcode' => '2711 AA',
		'llb_address_city'     => 'Zoetermeer',
		'llb_kvk'              => '00000000',
		'llb_btw'              => 'NL000000000B01',
	);

	foreach ( $seeds as $key => $value ) {
		$current = trim( (string) get_theme_mod( $key, '' ) );
		if ( '' === $current ) {
			set_theme_mod( $key, $value );
		}
	}
}

/**
 * Seeds default service icons when empty.
 *
 * @return void
 */
function llb_seed_demo_service_icons() {
	if ( ! function_exists( 'llb_get_services' ) || ! function_exists( 'llb_default_service_icon_for_slug' ) ) {
		return;
	}

	foreach ( llb_get_services() as $service ) {
		$current = trim( (string) get_post_meta( $service->ID, '_llb_service_icon', true ) );
		if ( '' !== $current ) {
			continue;
		}
		update_post_meta( $service->ID, '_llb_service_icon', llb_default_service_icon_for_slug( $service->post_name ) );
	}
}

/**
 * Runs demo seeds once per theme version (admin).
 *
 * @return void
 */
function llb_maybe_seed_demo_data() {
	$stored = (string) get_option( 'llb_demo_data_version', '' );
	if ( $stored === (string) LLB_VERSION ) {
		return;
	}

	llb_seed_demo_company_options();
	llb_seed_demo_service_icons();
	update_option( 'llb_demo_data_version', (string) LLB_VERSION );
}
add_action( 'admin_init', 'llb_maybe_seed_demo_data' );
