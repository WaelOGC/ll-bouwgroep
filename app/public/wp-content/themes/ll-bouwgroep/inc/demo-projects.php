<?php
/**
 * Demo projects (theme assets → Media Library → project posts).
 *
 * Creates each project only if the slug does not exist. Never overwrites.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Demo project definitions.
 *
 * @return array<int, array<string, mixed>>
 */
function llb_demo_projects() {
	return array(
		array(
			'title'       => 'Aanbouw met lichtstraat',
			'slug'        => 'aanbouw-met-lichtstraat',
			'category'    => 'Aan- en uitbouw',
			'featured'    => true,
			'image'       => 'project-rear-extension.webp',
			'gallery'     => array( 'project-rear-extension.webp', 'projects-hero.webp', 'about-approach.webp' ),
			'description' => 'Een ruime aanbouw aan de achterzijde van een tussenwoning, met een grote glazen schuifpui en een lichtstraat voor extra daglicht.',
			'work'        => "Fundering en ruwbouw\nPlaatsen van de schuifpui en lichtstraat\nStucwerk en schilderwerk\nTegelvloer en afwerking",
			'result'      => 'Een lichte leefruimte met een directe verbinding met de tuin.',
		),
		array(
			'title'       => 'Familiebadkamer met inloopdouche',
			'slug'        => 'familiebadkamer-met-inloopdouche',
			'category'    => 'Badkamers & toiletten',
			'featured'    => false,
			'image'       => 'project-family-bathroom.webp',
			'gallery'     => array( 'project-family-bathroom.webp', 'home-bathroom.webp', 'about-step-3-finish.webp' ),
			'description' => 'Een complete renovatie van een familiebadkamer, van sloopwerk tot de laatste afwerking.',
			'work'        => "Sloopwerkzaamheden\nLeidingwerk en elektra\nTegelwerk\nMontage van sanitair\nAfwerking",
			'result'      => 'Een frisse badkamer met een ruime inloopdouche en een dubbel wastafelmeubel.',
		),
		array(
			'title'       => 'Toiletrenovatie in antraciet',
			'slug'        => 'toiletrenovatie-in-antraciet',
			'category'    => 'Badkamers & toiletten',
			'featured'    => false,
			'image'       => 'project-guest-toilet.webp',
			'gallery'     => array( 'project-guest-toilet.webp', 'home-bathroom.webp' ),
			'description' => 'Een compact toilet volledig vernieuwd met donkere wandtegels en een houten wastafelblad.',
			'work'        => "Sloopwerkzaamheden\nLeidingwerk\nTegelwerk\nMontage van sanitair",
			'result'      => 'Een sfeervol en onderhoudsvriendelijk toilet.',
		),
		array(
			'title'       => 'Woonkamerrenovatie in een jaren-30 woning',
			'slug'        => 'woonkamerrenovatie-jaren-30-woning',
			'category'    => 'Renovatie & verbouwing',
			'featured'    => false,
			'image'       => 'project-living-room.webp',
			'gallery'     => array( 'project-living-room.webp', 'about-hero.webp', 'about-craftsmen.webp' ),
			'description' => 'Een woonkamer in een jaren-30 woning gerenoveerd met respect voor de oorspronkelijke details.',
			'work'        => "Stucwerk van wanden en plafonds\nVisgraat parketvloer\nPlaatsen van stalen deuren\nSchilderwerk",
			'result'      => 'Een lichte woonkamer waarin karakter en comfort samenkomen.',
		),
		array(
			'title'       => 'Zolderverbouwing tot slaapkamer',
			'slug'        => 'zolderverbouwing-tot-slaapkamer',
			'category'    => 'Renovatie & verbouwing',
			'featured'    => false,
			'image'       => 'project-attic.webp',
			'gallery'     => array( 'project-attic.webp', 'about-step-2-execution.webp' ),
			'description' => 'Een onbenutte zolder omgebouwd tot een lichte slaapkamer met extra daglicht.',
			'work'        => "Timmerwerk en isolatie\nPlaatsen van dakramen\nStucwerk\nInbouwkasten",
			'result'      => 'Een volwaardige extra slaapkamer onder het dak.',
		),
		array(
			'title'       => 'Lichte keuken met kookeiland',
			'slug'        => 'lichte-keuken-met-kookeiland',
			'category'    => 'Keukens',
			'featured'    => false,
			'image'       => 'project-kitchen.webp',
			'gallery'     => array( 'project-kitchen.webp', 'services-hero.webp' ),
			'description' => 'Een keukenverbouwing met een kookeiland, lichte fronten en een getegelde achterwand.',
			'work'        => "Sloopwerkzaamheden\nLeidingwerk en elektra\nTegelwerk\nMontage en afwerking",
			'result'      => 'Een warme, lichte keuken die volledig aansluit op de woonruimte.',
		),
	);
}

/**
 * Ensures a demo image attachment exists (reuse or sideload).
 *
 * @param string $filename Filename under assets/images/.
 * @param string $title    Attachment title.
 * @return int Attachment ID or 0.
 */
function llb_ensure_demo_attachment( $filename, $title = '' ) {
	$filename = basename( (string) $filename );
	if ( '' === $filename ) {
		return 0;
	}

	$existing = llb_find_demo_attachment( $filename );
	if ( $existing ) {
		return $existing;
	}

	return llb_sideload_demo_image( $filename, $title );
}

/**
 * Returns a project_categorie term ID by name, creating it if needed.
 *
 * @param string $name Term name.
 * @return int Term ID or 0.
 */
function llb_ensure_project_category( $name ) {
	$name = trim( (string) $name );
	if ( '' === $name ) {
		return 0;
	}

	$existing = term_exists( $name, 'project_categorie' );
	if ( is_array( $existing ) && ! empty( $existing['term_id'] ) ) {
		return (int) $existing['term_id'];
	}

	$inserted = wp_insert_term( $name, 'project_categorie' );
	if ( is_wp_error( $inserted ) || empty( $inserted['term_id'] ) ) {
		return 0;
	}

	return (int) $inserted['term_id'];
}

/**
 * Finds a project by slug.
 *
 * @param string $slug Project slug.
 * @return WP_Post|null
 */
function llb_find_project_by_slug( $slug ) {
	$slug = sanitize_title( (string) $slug );
	if ( '' === $slug ) {
		return null;
	}

	$posts = get_posts(
		array(
			'name'             => $slug,
			'post_type'        => 'project',
			'post_status'      => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page'   => 1,
			'suppress_filters' => true,
		)
	);

	if ( empty( $posts[0] ) || ! ( $posts[0] instanceof WP_Post ) ) {
		return null;
	}

	return $posts[0];
}

/**
 * Creates demo projects that do not exist yet.
 *
 * @return void
 */
function llb_import_demo_projects() {
	if ( ! post_type_exists( 'project' ) || ! taxonomy_exists( 'project_categorie' ) ) {
		return;
	}

	if ( function_exists( 'llb_seed_project_categories' ) ) {
		llb_seed_project_categories();
	}

	foreach ( llb_demo_projects() as $item ) {
		$slug = isset( $item['slug'] ) ? sanitize_title( (string) $item['slug'] ) : '';
		if ( '' === $slug || llb_find_project_by_slug( $slug ) ) {
			continue;
		}

		$title = isset( $item['title'] ) ? (string) $item['title'] : $slug;
		$post_id = wp_insert_post(
			array(
				'post_type'   => 'project',
				'post_status' => 'publish',
				'post_title'  => $title,
				'post_name'   => $slug,
				'post_content'=> '',
			),
			true
		);

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		$category = isset( $item['category'] ) ? (string) $item['category'] : '';
		$term_id  = llb_ensure_project_category( $category );
		if ( $term_id ) {
			wp_set_object_terms( (int) $post_id, array( $term_id ), 'project_categorie', false );
		}

		$image_file = isset( $item['image'] ) ? (string) $item['image'] : '';
		$thumb_id   = llb_ensure_demo_attachment( $image_file, $title );
		if ( $thumb_id ) {
			set_post_thumbnail( (int) $post_id, $thumb_id );
		}

		$gallery_files = isset( $item['gallery'] ) && is_array( $item['gallery'] ) ? $item['gallery'] : array();
		$gallery_ids   = array();
		foreach ( $gallery_files as $file ) {
			$aid = llb_ensure_demo_attachment( (string) $file, $title );
			if ( $aid ) {
				$gallery_ids[] = $aid;
			}
		}
		$gallery_ids = array_values( array_unique( array_map( 'absint', $gallery_ids ) ) );
		if ( ! empty( $gallery_ids ) ) {
			update_post_meta( (int) $post_id, '_llb_project_gallery', $gallery_ids );
		}

		if ( ! empty( $item['featured'] ) ) {
			update_post_meta( (int) $post_id, '_llb_project_featured', '1' );
		}

		if ( isset( $item['description'] ) ) {
			update_post_meta( (int) $post_id, '_llb_project_description', (string) $item['description'] );
		}
		if ( isset( $item['work'] ) ) {
			update_post_meta( (int) $post_id, '_llb_project_work', (string) $item['work'] );
		}
		if ( isset( $item['result'] ) ) {
			update_post_meta( (int) $post_id, '_llb_project_result', (string) $item['result'] );
		}
	}
}

/**
 * Runs demo project import once per theme version (admin).
 *
 * @return void
 */
function llb_maybe_import_demo_projects() {
	$stored = (string) get_option( 'llb_demo_projects_version', '' );
	if ( $stored === (string) LLB_VERSION ) {
		return;
	}

	llb_import_demo_projects();
	update_option( 'llb_demo_projects_version', (string) LLB_VERSION );
}
add_action( 'admin_init', 'llb_maybe_import_demo_projects', 20 );
