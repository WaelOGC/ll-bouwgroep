<?php
/**
 * Default content import tool.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Runs the default content import.
 *
 * @return array{created: array<int, string>, skipped: array<int, string>}
 */
function llb_run_content_import() {
	$defaults = llb_default_content();
	$created  = array();
	$skipped  = array();
	$page_ids = array();

	foreach ( $defaults['pages'] as $page ) {
		$existing = get_page_by_path( $page['slug'], OBJECT, 'page' );
		if ( $existing ) {
			$skipped[]            = 'page:' . $page['slug'];
			$page_ids[ $page['slug'] ] = (int) $existing->ID;
			continue;
		}

		$postarr = array(
			'post_title'   => $page['title'],
			'post_name'    => $page['slug'],
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => isset( $page['content'] ) ? $page['content'] : '',
		);

		$post_id = wp_insert_post( $postarr, true );
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			$skipped[] = 'page:' . $page['slug'] . ' (error)';
			continue;
		}

		if ( ! empty( $page['template'] ) ) {
			update_post_meta( $post_id, '_wp_page_template', $page['template'] );
		}

		if ( ! empty( $page['meta'] ) && is_array( $page['meta'] ) ) {
			foreach ( $page['meta'] as $key => $value ) {
				update_post_meta( $post_id, $key, $value );
			}
		}

		$page_ids[ $page['slug'] ] = (int) $post_id;
		$created[]                   = 'page:' . $page['slug'];
	}

	if ( empty( get_option( 'page_on_front' ) ) && ! empty( $page_ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_ids['home'] );
	}

	if ( empty( get_option( 'wp_page_for_privacy_policy' ) ) && ! empty( $page_ids['privacyverklaring'] ) ) {
		update_option( 'wp_page_for_privacy_policy', $page_ids['privacyverklaring'] );
	}

	foreach ( $defaults['services'] as $service ) {
		$existing = get_page_by_path( $service['slug'], OBJECT, 'dienst' );
		if ( $existing ) {
			$skipped[] = 'dienst:' . $service['slug'];
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_title'   => $service['title'],
				'post_name'    => $service['slug'],
				'post_status'  => 'publish',
				'post_type'    => 'dienst',
				'post_excerpt' => isset( $service['excerpt'] ) ? $service['excerpt'] : '',
				'menu_order'   => isset( $service['menu_order'] ) ? (int) $service['menu_order'] : 0,
			),
			true
		);

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			$skipped[] = 'dienst:' . $service['slug'] . ' (error)';
			continue;
		}

		if ( ! empty( $service['meta'] ) && is_array( $service['meta'] ) ) {
			foreach ( $service['meta'] as $key => $value ) {
				update_post_meta( $post_id, $key, $value );
			}
		}

		$created[] = 'dienst:' . $service['slug'];
	}

	$locations = get_nav_menu_locations();
	if ( ! is_array( $locations ) ) {
		$locations = array();
	}

	foreach ( $defaults['menus'] as $location => $menu_def ) {
		$menu_name = $menu_def['name'];
		$existing  = wp_get_nav_menu_object( $menu_name );

		if ( $existing ) {
			$skipped[] = 'menu:' . $menu_name;
			if ( empty( $locations[ $location ] ) ) {
				$locations[ $location ] = (int) $existing->term_id;
			}
			continue;
		}

		$menu_id = wp_create_nav_menu( $menu_name );
		if ( is_wp_error( $menu_id ) ) {
			$skipped[] = 'menu:' . $menu_name . ' (error)';
			continue;
		}

		$position = 1;
		foreach ( $menu_def['items'] as $slug ) {
			if ( empty( $page_ids[ $slug ] ) ) {
				$page = get_page_by_path( $slug, OBJECT, 'page' );
				if ( ! $page ) {
					continue;
				}
				$page_ids[ $slug ] = (int) $page->ID;
			}

			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'     => get_the_title( $page_ids[ $slug ] ),
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $page_ids[ $slug ],
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
					'menu-item-position'  => $position,
				)
			);
			++$position;
		}

		$locations[ $location ] = (int) $menu_id;
		$created[]              = 'menu:' . $menu_name;
	}

	set_theme_mod( 'nav_menu_locations', $locations );

	if ( function_exists( 'llb_import_demo_images' ) ) {
		llb_import_demo_images();
		update_option( 'llb_demo_images_version', (string) LLB_VERSION );
	}

	if ( function_exists( 'llb_import_demo_projects' ) ) {
		llb_import_demo_projects();
		update_option( 'llb_demo_projects_version', (string) LLB_VERSION );
	}

	return array(
		'created' => $created,
		'skipped' => $skipped,
	);
}
