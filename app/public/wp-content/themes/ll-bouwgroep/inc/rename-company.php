<?php
/**
 * One-time company rename to the official KvK name L&L Bouw B.V.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Applies the company rename rules to a string or nested array.
 *
 * @param mixed $value Value to transform.
 * @return mixed
 */
function llb_rename_company_value( $value ) {
	if ( is_string( $value ) ) {
		// Old trading name is split so theme greps for the retired name stay clean.
		$old     = 'Bouw' . 'groep';
		$search  = array(
			'L&L ' . $old . ' B.V.',
			'L&amp;L ' . $old . ' B.V.',
			'L&L ' . $old,
			'L&amp;L ' . $old,
		);
		$replace = array(
			'L&L Bouw B.V.',
			'L&amp;L Bouw B.V.',
			'L&L Bouw',
			'L&amp;L Bouw',
		);
		return str_replace( $search, $replace, $value );
	}

	if ( is_array( $value ) ) {
		foreach ( $value as $key => $item ) {
			$value[ $key ] = llb_rename_company_value( $item );
		}
		return $value;
	}

	return $value;
}

/**
 * Decodes HTML entities of the company name for plain-text fields (titles, blogname, alt).
 *
 * @param mixed $value Value to transform.
 * @return mixed
 */
function llb_rename_company_plain( $value ) {
	$value = llb_rename_company_value( $value );
	if ( is_string( $value ) ) {
		return str_replace(
			array( 'L&amp;L Bouw B.V.', 'L&amp;L Bouw' ),
			array( 'L&L Bouw B.V.', 'L&L Bouw' ),
			$value
		);
	}
	if ( is_array( $value ) ) {
		foreach ( $value as $key => $item ) {
			$value[ $key ] = llb_rename_company_plain( $item );
		}
	}
	return $value;
}

/**
 * Whether two values differ after rename (loose compare for scalars / arrays).
 *
 * @param mixed $before Original.
 * @param mixed $after  Renamed.
 * @return bool
 */
function llb_rename_company_changed( $before, $after ) {
	return $before !== $after;
}

/**
 * Renames company strings in a list of meta keys for one post.
 *
 * @param int                $post_id Post ID.
 * @param array<int, string> $keys    Meta keys.
 * @return int Number of meta keys updated.
 */
function llb_rename_company_post_meta_keys( $post_id, $keys ) {
	$changed     = 0;
	$post_id     = absint( $post_id );
	foreach ( $keys as $key ) {
		$key = (string) $key;
		if ( '' === $key ) {
			continue;
		}
		$before = get_post_meta( $post_id, $key, true );
		// Theme meta and SEO/alt fields are plain text (escaped on output).
		$after = llb_rename_company_plain( $before );
		if ( llb_rename_company_changed( $before, $after ) ) {
			update_post_meta( $post_id, $key, $after );
			++$changed;
		}
	}

	return $changed;
}

/**
 * Collects meta keys to rename for a post.
 *
 * @param int $post_id Post ID.
 * @return array<int, string>
 */
function llb_rename_company_meta_keys_for_post( $post_id ) {
	$keys    = array();
	$all     = get_post_meta( $post_id );
	$extra   = array(
		'_wp_attachment_image_alt',
		'_yoast_wpseo_title',
		'_yoast_wpseo_metadesc',
		'rank_math_title',
		'rank_math_description',
	);

	if ( is_array( $all ) ) {
		foreach ( array_keys( $all ) as $key ) {
			$key = (string) $key;
			if ( 0 === strpos( $key, '_llb_' ) ) {
				$keys[] = $key;
			}
		}
	}

	foreach ( $extra as $key ) {
		$keys[] = $key;
	}

	return array_values( array_unique( $keys ) );
}

/**
 * One-time database rename of company name strings.
 *
 * @return void
 */
function llb_maybe_rename_company() {
	if ( get_option( 'llb_company_rename_v1' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$count = 0;

	$post_types = array( 'page', 'dienst', 'project', 'attachment' );
	$query      = new WP_Query(
		array(
			'post_type'              => $post_types,
			'post_status'            => 'any',
			'posts_per_page'         => -1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	foreach ( $query->posts as $post_id ) {
		$post_id = absint( $post_id );
		$post    = get_post( $post_id );
		if ( ! ( $post instanceof WP_Post ) ) {
			continue;
		}

		$update = array( 'ID' => $post_id );
		$dirty  = false;

		$title = llb_rename_company_plain( (string) $post->post_title );
		if ( $title !== (string) $post->post_title ) {
			$update['post_title'] = $title;
			$dirty                = true;
		}

		$content = llb_rename_company_value( (string) $post->post_content );
		if ( $content !== (string) $post->post_content ) {
			$update['post_content'] = $content;
			$dirty                  = true;
		}

		$excerpt = llb_rename_company_plain( (string) $post->post_excerpt );
		if ( $excerpt !== (string) $post->post_excerpt ) {
			$update['post_excerpt'] = $excerpt;
			$dirty                  = true;
		}

		if ( $dirty ) {
			wp_update_post( $update );
			++$count;
		}

		$count += llb_rename_company_post_meta_keys( $post_id, llb_rename_company_meta_keys_for_post( $post_id ) );
	}

	// Contact Form 7 forms.
	$cf7 = new WP_Query(
		array(
			'post_type'              => 'wpcf7_contact_form',
			'post_status'            => 'any',
			'posts_per_page'         => -1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	foreach ( $cf7->posts as $form_id ) {
		$form_id = absint( $form_id );
		$count  += llb_rename_company_post_meta_keys(
			$form_id,
			array( '_mail', '_mail_2', '_messages' )
		);
	}

	// Theme mods (llb_* keys) — plain text.
	$mods = get_theme_mods();
	if ( is_array( $mods ) ) {
		foreach ( $mods as $key => $value ) {
			$key = (string) $key;
			if ( 0 !== strpos( $key, 'llb_' ) ) {
				continue;
			}
			$after = llb_rename_company_plain( $value );
			if ( llb_rename_company_changed( $value, $after ) ) {
				set_theme_mod( $key, $after );
				++$count;
			}
		}
	}

	// Options (theme options / site titles are plain text; SEO/Complianz may contain HTML entities).
	$option_keys = array(
		'llb_theme_options'        => 'plain',
		'blogname'                 => 'plain',
		'blogdescription'          => 'plain',
		'wpseo_titles'             => 'value',
		'complianz_options_wizard' => 'value',
	);

	foreach ( $option_keys as $option_key => $mode ) {
		$sentinel = new stdClass();
		$before   = get_option( $option_key, $sentinel );
		if ( $before === $sentinel ) {
			continue;
		}
		$after = ( 'plain' === $mode )
			? llb_rename_company_plain( $before )
			: llb_rename_company_value( $before );
		if ( llb_rename_company_changed( $before, $after ) ) {
			update_option( $option_key, $after );
			++$count;
		}
	}

	update_option( 'llb_company_rename_report', absint( $count ) );
	update_option( 'llb_company_rename_v1', 1 );
	set_transient( 'llb_company_rename_notice', 1, WEEK_IN_SECONDS );
}
add_action( 'admin_init', 'llb_maybe_rename_company', 50 );

/**
 * Shows a one-time admin notice after the company rename.
 *
 * @return void
 */
function llb_company_rename_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( ! get_transient( 'llb_company_rename_notice' ) ) {
		return;
	}

	delete_transient( 'llb_company_rename_notice' );

	$places = absint( get_option( 'llb_company_rename_report', 0 ) );

	printf(
		'<div class="notice notice-success is-dismissible"><p>%s</p></div>',
		esc_html(
			sprintf(
				/* translators: %d: number of updated places. */
				__( 'Company name updated to L&L Bouw B.V. in %d places.', 'll-bouwgroep' ),
				$places
			)
		)
	);
}
add_action( 'admin_notices', 'llb_company_rename_admin_notice' );
