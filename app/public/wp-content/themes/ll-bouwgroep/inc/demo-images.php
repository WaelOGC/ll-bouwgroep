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
 * Demo image definitions.
 *
 * Keys:
 * - file: filename under assets/images/ (sideload if missing)
 * - reuse: existing demo filename to reuse without re-import
 * - field: meta key
 * - page: page slug (default: front page / Home template)
 * - index + subkey: nested repeater field (e.g. sections[0].image)
 * - title: attachment title
 *
 * @return array<int, array<string, mixed>>
 */
function llb_demo_images() {
	return array(
		array(
			'file'  => 'home-hero.webp',
			'field' => '_llb_hero_image',
			'page'  => 'home',
			'title' => 'Home hero',
		),
		array(
			'file'  => 'home-hero-mobile.webp',
			'field' => '_llb_hero_image_mobile',
			'page'  => 'home',
			'title' => 'Home hero mobile',
		),
		array(
			'file'  => 'home-bathroom.webp',
			'field' => '_llb_bath_image',
			'page'  => 'home',
			'title' => 'Home bathrooms',
		),
		array(
			'file'  => 'home-craftsmen.webp',
			'field' => '_llb_why_image',
			'page'  => 'home',
			'title' => 'Home why us',
		),
		array(
			'file'  => 'home-cta.webp',
			'field' => '_llb_cta_image',
			'page'  => 'home',
			'title' => 'Home CTA',
		),
		array(
			'file'  => 'about-hero.webp',
			'field' => '_llb_hero_image',
			'page'  => 'over-ons',
			'title' => 'About hero',
		),
		array(
			'file'  => 'about-hero-mobile.webp',
			'field' => '_llb_hero_image_mobile',
			'page'  => 'over-ons',
			'title' => 'About hero mobile',
		),
		array(
			'file'   => 'about-approach.webp',
			'field'  => '_llb_sections',
			'page'   => 'over-ons',
			'index'  => 0,
			'subkey' => 'image',
			'title'  => 'About approach',
		),
		array(
			'file'   => 'about-craftsmen.webp',
			'field'  => '_llb_sections',
			'page'   => 'over-ons',
			'index'  => 1,
			'subkey' => 'image',
			'title'  => 'About craftsmen',
		),
		array(
			'file'   => 'about-step-1-plans.webp',
			'field'  => '_llb_steps',
			'page'   => 'over-ons',
			'index'  => 0,
			'subkey' => 'image',
			'title'  => 'About step plans',
		),
		array(
			'file'   => 'about-step-2-execution.webp',
			'field'  => '_llb_steps',
			'page'   => 'over-ons',
			'index'  => 1,
			'subkey' => 'image',
			'title'  => 'About step execution',
		),
		array(
			'file'   => 'about-step-3-finish.webp',
			'field'  => '_llb_steps',
			'page'   => 'over-ons',
			'index'  => 2,
			'subkey' => 'image',
			'title'  => 'About step finish',
		),
		array(
			'reuse' => 'home-cta.webp',
			'field' => '_llb_cta_image',
			'page'  => 'over-ons',
			'title' => 'Home CTA',
		),
		array(
			'file'  => 'services-hero.webp',
			'field' => '_llb_hero_image',
			'page'  => 'diensten',
			'title' => 'Services hero',
		),
		array(
			'file'  => 'services-hero-mobile.webp',
			'field' => '_llb_hero_image_mobile',
			'page'  => 'diensten',
			'title' => 'Services hero mobile',
		),
		array(
			'file'  => 'projects-hero.webp',
			'field' => '_llb_hero_image',
			'page'  => 'projecten',
			'title' => 'Projects hero',
		),
		array(
			'file'  => 'projects-hero-mobile.webp',
			'field' => '_llb_hero_image_mobile',
			'page'  => 'projecten',
			'title' => 'Projects hero mobile',
		),
		array(
			'file'  => 'contact-hero.webp',
			'field' => '_llb_hero_image',
			'page'  => 'contact',
			'title' => 'Contact hero',
		),
		array(
			'file'  => 'contact-hero-mobile.webp',
			'field' => '_llb_hero_image_mobile',
			'page'  => 'contact',
			'title' => 'Contact hero mobile',
		),
		array(
			'file'  => 'faq-hero.webp',
			'field' => '_llb_hero_image',
			'page'  => 'veelgestelde-vragen',
			'title' => 'FAQ hero',
		),
		array(
			'file'  => 'faq-hero-mobile.webp',
			'field' => '_llb_hero_image_mobile',
			'page'  => 'veelgestelde-vragen',
			'title' => 'FAQ hero mobile',
		),
		array(
			'reuse' => 'home-cta.webp',
			'field' => '_llb_cta_image',
			'page'  => 'veelgestelde-vragen',
			'title' => 'Home CTA',
		),
		array(
			'file'  => 'privacy-hero.webp',
			'field' => '_llb_hero_image',
			'page'  => 'privacyverklaring',
			'title' => 'Privacy hero',
		),
		array(
			'file'  => 'privacy-hero-mobile.webp',
			'field' => '_llb_hero_image_mobile',
			'page'  => 'privacyverklaring',
			'title' => 'Privacy hero mobile',
		),
		array(
			'file'      => 'service-badkamers-toiletten-hero.webp',
			'field'     => '_llb_hero_image',
			'post_type' => 'dienst',
			'page'      => 'badkamers-toiletten',
			'title'     => 'Service bathrooms hero',
		),
		array(
			'file'      => 'service-badkamers-toiletten.webp',
			'field'     => '_thumbnail_id',
			'post_type' => 'dienst',
			'page'      => 'badkamers-toiletten',
			'title'     => 'Service bathrooms',
		),
		array(
			'file'      => 'service-renovatie-verbouwing-hero.webp',
			'field'     => '_llb_hero_image',
			'post_type' => 'dienst',
			'page'      => 'renovatie-verbouwing',
			'title'     => 'Service renovation hero',
		),
		array(
			'file'      => 'service-renovatie-verbouwing.webp',
			'field'     => '_thumbnail_id',
			'post_type' => 'dienst',
			'page'      => 'renovatie-verbouwing',
			'title'     => 'Service renovation',
		),
		array(
			'file'      => 'service-stucwerk-hero.webp',
			'field'     => '_llb_hero_image',
			'post_type' => 'dienst',
			'page'      => 'stucwerk',
			'title'     => 'Service plastering hero',
		),
		array(
			'file'      => 'service-stucwerk.webp',
			'field'     => '_thumbnail_id',
			'post_type' => 'dienst',
			'page'      => 'stucwerk',
			'title'     => 'Service plastering',
		),
		array(
			'file'      => 'service-tegelwerk-hero.webp',
			'field'     => '_llb_hero_image',
			'post_type' => 'dienst',
			'page'      => 'tegelwerk',
			'title'     => 'Service tiling hero',
		),
		array(
			'file'      => 'service-tegelwerk.webp',
			'field'     => '_thumbnail_id',
			'post_type' => 'dienst',
			'page'      => 'tegelwerk',
			'title'     => 'Service tiling',
		),
		array(
			'file'      => 'service-timmerwerk-hero.webp',
			'field'     => '_llb_hero_image',
			'post_type' => 'dienst',
			'page'      => 'timmerwerk',
			'title'     => 'Service carpentry hero',
		),
		array(
			'file'      => 'service-timmerwerk.webp',
			'field'     => '_thumbnail_id',
			'post_type' => 'dienst',
			'page'      => 'timmerwerk',
			'title'     => 'Service carpentry',
		),
		array(
			'file'      => 'service-schilder-afbouwwerk-hero.webp',
			'field'     => '_llb_hero_image',
			'post_type' => 'dienst',
			'page'      => 'schilder-afbouwwerk',
			'title'     => 'Service painting hero',
		),
		array(
			'file'      => 'service-schilder-afbouwwerk.webp',
			'field'     => '_thumbnail_id',
			'post_type' => 'dienst',
			'page'      => 'schilder-afbouwwerk',
			'title'     => 'Service painting',
		),
		array(
			'file'      => 'service-keukenverbouwingen-hero.webp',
			'field'     => '_llb_hero_image',
			'post_type' => 'dienst',
			'page'      => 'keukenverbouwingen',
			'title'     => 'Service kitchen hero',
		),
		array(
			'file'      => 'service-keukenverbouwingen.webp',
			'field'     => '_thumbnail_id',
			'post_type' => 'dienst',
			'page'      => 'keukenverbouwingen',
			'title'     => 'Service kitchen',
		),
		array(
			'file'      => 'service-aan-uitbouw-hero.webp',
			'field'     => '_llb_hero_image',
			'post_type' => 'dienst',
			'page'      => 'aan-uitbouw',
			'title'     => 'Service extension hero',
		),
		array(
			'file'      => 'service-aan-uitbouw.webp',
			'field'     => '_thumbnail_id',
			'post_type' => 'dienst',
			'page'      => 'aan-uitbouw',
			'title'     => 'Service extension',
		),
		array(
			'file'      => 'service-overige-bouwkundige-werkzaamheden-hero.webp',
			'field'     => '_llb_hero_image',
			'post_type' => 'dienst',
			'page'      => 'overige-bouwkundige-werkzaamheden',
			'title'     => 'Service other hero',
		),
		array(
			'file'      => 'service-overige-bouwkundige-werkzaamheden.webp',
			'field'     => '_thumbnail_id',
			'post_type' => 'dienst',
			'page'      => 'overige-bouwkundige-werkzaamheden',
			'title'     => 'Service other',
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
 * Returns a page ID by slug, or 0.
 *
 * @param string $slug Page slug.
 * @return int
 */
function llb_get_demo_page_id_by_slug( $slug ) {
	$slug = sanitize_title( (string) $slug );
	if ( '' === $slug ) {
		return 0;
	}

	if ( 'home' === $slug ) {
		$front = (int) get_option( 'page_on_front' );
		if ( $front ) {
			return $front;
		}
	}

	$page = get_page_by_path( $slug, OBJECT, 'page' );
	return ( $page instanceof WP_Post ) ? (int) $page->ID : 0;
}

/**
 * Returns a post ID by slug and post type, or 0.
 *
 * @param string $slug      Post slug.
 * @param string $post_type Post type.
 * @return int
 */
function llb_get_demo_post_id_by_slug( $slug, $post_type = 'page' ) {
	$slug      = sanitize_title( (string) $slug );
	$post_type = sanitize_key( (string) $post_type );
	if ( '' === $slug || '' === $post_type ) {
		return 0;
	}

	if ( 'page' === $post_type ) {
		return llb_get_demo_page_id_by_slug( $slug );
	}

	$posts = get_posts(
		array(
			'name'           => $slug,
			'post_type'      => $post_type,
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	return ! empty( $posts[0] ) ? (int) $posts[0] : 0;
}

/**
 * Returns the front page ID used for Home demo image fields.
 *
 * @return int
 */
function llb_get_demo_images_page_id() {
	return llb_get_demo_page_id_by_slug( 'home' );
}

/**
 * Assigns an attachment to a page meta field (flat or nested), only if empty.
 *
 * @param int                  $page_id       Page ID.
 * @param array<string, mixed> $item          Demo item config.
 * @param int                  $attachment_id Attachment ID.
 * @return void
 */
function llb_assign_demo_image_field( $page_id, $item, $attachment_id ) {
	$page_id       = absint( $page_id );
	$attachment_id = absint( $attachment_id );
	$field         = isset( $item['field'] ) ? (string) $item['field'] : '';

	if ( ! $page_id || ! $attachment_id || '' === $field ) {
		return;
	}

	if ( '_thumbnail_id' === $field ) {
		if ( get_post_thumbnail_id( $page_id ) ) {
			return;
		}
		set_post_thumbnail( $page_id, $attachment_id );
		return;
	}

	if ( isset( $item['index'] ) && isset( $item['subkey'] ) ) {
		$index  = absint( $item['index'] );
		$subkey = sanitize_key( (string) $item['subkey'] );
		$rows   = get_post_meta( $page_id, $field, true );
		if ( ! is_array( $rows ) ) {
			$rows = array();
		}
		if ( ! isset( $rows[ $index ] ) || ! is_array( $rows[ $index ] ) ) {
			$rows[ $index ] = array();
		}
		$current = isset( $rows[ $index ][ $subkey ] ) ? absint( $rows[ $index ][ $subkey ] ) : 0;
		if ( $current ) {
			return;
		}
		$rows[ $index ][ $subkey ] = $attachment_id;
		update_post_meta( $page_id, $field, $rows );
		return;
	}

	$current = absint( get_post_meta( $page_id, $field, true ) );
	if ( $current ) {
		return;
	}

	update_post_meta( $page_id, $field, $attachment_id );
}

/**
 * Imports demo images into the Media Library and assigns empty fields.
 *
 * @return void
 */
function llb_import_demo_images() {
	foreach ( llb_demo_images() as $item ) {
		$file  = isset( $item['file'] ) ? (string) $item['file'] : '';
		$reuse = isset( $item['reuse'] ) ? (string) $item['reuse'] : '';
		$title = isset( $item['title'] ) ? (string) $item['title'] : '';
		$page      = isset( $item['page'] ) ? (string) $item['page'] : 'home';
		$post_type = isset( $item['post_type'] ) ? (string) $item['post_type'] : 'page';

		$attachment_id = 0;
		if ( '' !== $reuse ) {
			$attachment_id = llb_find_demo_attachment( $reuse );
		} elseif ( '' !== $file ) {
			$attachment_id = llb_find_demo_attachment( $file );
			if ( ! $attachment_id ) {
				$attachment_id = llb_sideload_demo_image( $file, $title );
			}
		}

		if ( ! $attachment_id ) {
			continue;
		}

		$page_id = llb_get_demo_post_id_by_slug( $page, $post_type );
		if ( ! $page_id ) {
			continue;
		}

		llb_assign_demo_image_field( $page_id, $item, $attachment_id );
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
 * Recursively replaces attachment IDs in a meta value using a map.
 *
 * @param mixed             $value Value.
 * @param array<int, int>   $map   Old ID => new ID.
 * @param int               $count Replacements made (by reference).
 * @return mixed
 */
function llb_replace_attachment_ids_deep( $value, $map, &$count ) {
	if ( is_array( $value ) ) {
		foreach ( $value as $key => $item ) {
			$value[ $key ] = llb_replace_attachment_ids_deep( $item, $map, $count );
		}
		return $value;
	}

	if ( is_int( $value ) || ( is_string( $value ) && ctype_digit( $value ) ) ) {
		$id = (int) $value;
		if ( isset( $map[ $id ] ) ) {
			++$count;
			return is_string( $value ) ? (string) $map[ $id ] : $map[ $id ];
		}
		return $value;
	}

	if ( is_string( $value ) && preg_match( '/^\d+(?:\s*,\s*\d+)+$/', $value ) ) {
		$parts   = array_map( 'trim', explode( ',', $value ) );
		$changed = false;
		foreach ( $parts as $i => $part ) {
			$id = (int) $part;
			if ( isset( $map[ $id ] ) ) {
				$parts[ $i ] = (string) $map[ $id ];
				++$count;
				$changed = true;
			}
		}
		return $changed ? implode( ',', $parts ) : $value;
	}

	return $value;
}

/**
 * One-time migration: replace PNG demo attachments with WebP (option llb_images_webp_v1).
 *
 * @return array<string, mixed>|null Report when migration runs, null when skipped.
 */
function llb_migrate_demo_images_to_webp() {
	if ( get_option( 'llb_images_webp_v1' ) ) {
		return null;
	}

	$uploads_before = 0;
	$upload_dir     = wp_upload_dir();
	if ( empty( $upload_dir['error'] ) && ! empty( $upload_dir['basedir'] ) && is_dir( $upload_dir['basedir'] ) ) {
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator( $upload_dir['basedir'], FilesystemIterator::SKIP_DOTS )
		);
		foreach ( $iterator as $file ) {
			if ( $file->isFile() ) {
				$uploads_before += (int) $file->getSize();
			}
		}
	}

	$query = new WP_Query(
		array(
			'post_type'              => 'attachment',
			'post_status'            => 'inherit',
			'posts_per_page'         => -1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_query'             => array(
				array(
					'key'     => '_llb_demo_image',
					'value'   => '.png',
					'compare' => 'LIKE',
				),
			),
		)
	);

	$map           = array();
	$replaced      = 0;
	$fields_updated = 0;

	foreach ( $query->posts as $old_id ) {
		$old_id   = (int) $old_id;
		$png_name = (string) get_post_meta( $old_id, '_llb_demo_image', true );
		if ( ! preg_match( '/\.png$/i', $png_name ) ) {
			continue;
		}

		$webp_name = preg_replace( '/\.png$/i', '.webp', $png_name );
		$title     = get_the_title( $old_id );
		$new_id    = llb_find_demo_attachment( $webp_name );
		if ( ! $new_id ) {
			$new_id = llb_sideload_demo_image( $webp_name, $title );
		}
		if ( ! $new_id || $new_id === $old_id ) {
			continue;
		}

		$map[ $old_id ] = $new_id;
		++$replaced;
	}

	if ( ! empty( $map ) ) {
		$post_types = array( 'page', 'dienst', 'project', 'post' );
		$posts      = get_posts(
			array(
				'post_type'      => $post_types,
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);

		foreach ( $posts as $post_id ) {
			$post_id = (int) $post_id;
			$allmeta = get_post_meta( $post_id );
			if ( ! is_array( $allmeta ) ) {
				continue;
			}

			foreach ( $allmeta as $meta_key => $values ) {
				if ( ! is_array( $values ) ) {
					continue;
				}
				foreach ( $values as $raw ) {
					$value = maybe_unserialize( $raw );
					$count = 0;
					$new   = llb_replace_attachment_ids_deep( $value, $map, $count );
					if ( $count > 0 ) {
						update_post_meta( $post_id, $meta_key, $new );
						$fields_updated += $count;
					}
				}
			}
		}

		// Customizer / theme mods that store attachment IDs.
		$mods = get_theme_mods();
		if ( is_array( $mods ) ) {
			$mods_changed = false;
			$count        = 0;
			$new_mods     = llb_replace_attachment_ids_deep( $mods, $map, $count );
			if ( $count > 0 && is_array( $new_mods ) ) {
				foreach ( $new_mods as $mod_key => $mod_value ) {
					if ( ! array_key_exists( $mod_key, $mods ) || $mods[ $mod_key ] !== $mod_value ) {
						set_theme_mod( $mod_key, $mod_value );
						$mods_changed = true;
					}
				}
				if ( $mods_changed ) {
					$fields_updated += $count;
				}
			}
		}

		// Standalone options that may store image IDs (map image etc. via get_option when not theme_mod).
		$option_keys = array( 'llb_map_image' );
		foreach ( $option_keys as $option_key ) {
			$opt = get_option( $option_key, null );
			if ( null === $opt ) {
				continue;
			}
			$count = 0;
			$new   = llb_replace_attachment_ids_deep( $opt, $map, $count );
			if ( $count > 0 ) {
				update_option( $option_key, $new );
				$fields_updated += $count;
			}
		}

		foreach ( array_keys( $map ) as $old_id ) {
			wp_delete_attachment( (int) $old_id, true );
		}
	}

	$uploads_after = 0;
	if ( empty( $upload_dir['error'] ) && ! empty( $upload_dir['basedir'] ) && is_dir( $upload_dir['basedir'] ) ) {
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator( $upload_dir['basedir'], FilesystemIterator::SKIP_DOTS )
		);
		foreach ( $iterator as $file ) {
			if ( $file->isFile() ) {
				$uploads_after += (int) $file->getSize();
			}
		}
	}

	$report = array(
		'replaced'         => $replaced,
		'fields_updated'   => $fields_updated,
		'uploads_before'   => $uploads_before,
		'uploads_after'    => $uploads_after,
		'webp_supported'   => (bool) wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ),
		'completed_at'     => gmdate( 'c' ),
	);

	update_option( 'llb_images_webp_v1', $report, false );
	return $report;
}

/**
 * Runs the WebP demo-image migration once (admin).
 *
 * @return void
 */
function llb_maybe_migrate_demo_images_to_webp() {
	if ( get_option( 'llb_images_webp_v1' ) ) {
		return;
	}
	llb_migrate_demo_images_to_webp();
}
add_action( 'admin_init', 'llb_maybe_migrate_demo_images_to_webp', 20 );

/**
 * Shows a one-time admin notice with the WebP migration report.
 *
 * @return void
 */
function llb_webp_migration_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$report = get_option( 'llb_images_webp_v1' );
	if ( ! is_array( $report ) || ! empty( $report['notice_shown'] ) ) {
		return;
	}
	$replaced = isset( $report['replaced'] ) ? (int) $report['replaced'] : 0;
	$fields   = isset( $report['fields_updated'] ) ? (int) $report['fields_updated'] : 0;
	$before   = isset( $report['uploads_before'] ) ? round( ( (int) $report['uploads_before'] ) / 1048576, 2 ) : 0;
	$after    = isset( $report['uploads_after'] ) ? round( ( (int) $report['uploads_after'] ) / 1048576, 2 ) : 0;
	$webp     = ! empty( $report['webp_supported'] ) ? 'yes' : 'no';
	echo '<div class="notice notice-success is-dismissible"><p>';
	echo esc_html(
		sprintf(
			'WebP migration done: %1$d attachments replaced, %2$d field values updated, uploads %3$s MB → %4$s MB, WebP sub-sizes supported: %5$s.',
			$replaced,
			$fields,
			(string) $before,
			(string) $after,
			$webp
		)
	);
	echo '</p></div>';
	$report['notice_shown'] = 1;
	update_option( 'llb_images_webp_v1', $report, false );
}
add_action( 'admin_notices', 'llb_webp_migration_admin_notice' );

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
 * Seeds default related project/FAQ categories on services when empty.
 *
 * @return void
 */
function llb_seed_demo_service_related() {
	if ( ! function_exists( 'llb_get_services' ) || ! function_exists( 'llb_default_service_related_map' ) ) {
		return;
	}

	$map = llb_default_service_related_map();

	foreach ( llb_get_services() as $service ) {
		$defaults = isset( $map[ $service->post_name ] ) ? $map[ $service->post_name ] : null;
		if ( ! $defaults ) {
			continue;
		}

		$faq_current = get_post_meta( $service->ID, '_llb_related_faq_cat', true );
		if ( '' === (string) $faq_current && '' !== $defaults['faq'] ) {
			update_post_meta( $service->ID, '_llb_related_faq_cat', $defaults['faq'] );
		}

		$proj_current = get_post_meta( $service->ID, '_llb_related_project_cat', true );
		if ( '' === (string) $proj_current && '' !== $defaults['project_name'] && taxonomy_exists( 'project_categorie' ) ) {
			$term = get_term_by( 'name', $defaults['project_name'], 'project_categorie' );
			if ( $term instanceof WP_Term ) {
				update_post_meta( $service->ID, '_llb_related_project_cat', $term->slug );
			}
		}
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
	llb_seed_demo_service_related();
	update_option( 'llb_demo_data_version', (string) LLB_VERSION );
}
add_action( 'admin_init', 'llb_maybe_seed_demo_data' );
