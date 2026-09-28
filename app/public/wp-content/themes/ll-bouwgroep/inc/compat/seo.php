<?php
/**
 * Yoast SEO / Rank Math compatibility.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers SEO plugin theme support.
 *
 * @return void
 */
function llb_seo_theme_support() {
	add_theme_support( 'yoast-seo-breadcrumbs' );
	add_theme_support( 'rank-math-breadcrumbs' );
}
add_action( 'after_setup_theme', 'llb_seo_theme_support' );

/**
 * Uses the theme breadcrumb separator in Yoast / Rank Math output.
 *
 * @return string
 */
function llb_breadcrumb_separator() {
	return '<span class="llb-crumbs__sep" aria-hidden="true">/</span>';
}
add_filter( 'wpseo_breadcrumb_separator', 'llb_breadcrumb_separator' );
add_filter( 'rank_math/frontend/breadcrumb/separator', 'llb_breadcrumb_separator' );

/**
 * Returns the name of the active SEO plugin, or an empty string.
 *
 * @return string
 */
function llb_active_seo_plugin_name() {
	if ( defined( 'WPSEO_VERSION' ) || function_exists( 'yoast_breadcrumb' ) ) {
		return 'Yoast SEO';
	}

	if ( defined( 'RANK_MATH_VERSION' ) || function_exists( 'rank_math_the_breadcrumbs' ) ) {
		return 'Rank Math';
	}

	return '';
}

/**
 * Whether breadcrumbs are switched on in Theme Options.
 *
 * @return bool
 */
function llb_breadcrumbs_enabled() {
	return function_exists( 'llb_theme_option_on' ) && llb_theme_option_on( 'breadcrumbs' );
}

/**
 * Whether breadcrumbs should show on the current view.
 *
 * @return bool
 */
function llb_show_breadcrumbs() {
	if ( ! llb_breadcrumbs_enabled() || is_front_page() || is_home() ) {
		return false;
	}

	return true;
}

/**
 * Returns the ancestor page for a post type, or 0.
 *
 * @param string $slug Page slug.
 * @return int
 */
function llb_breadcrumb_page_id( $slug ) {
	$page = get_page_by_path( $slug, OBJECT, 'page' );

	return $page instanceof WP_Post ? (int) $page->ID : 0;
}

/**
 * Builds the breadcrumb trail for the current view.
 *
 * The last entry is the current page and has no URL.
 *
 * @return array<int, array{name:string, url:string}>
 */
function llb_get_breadcrumb_trail() {
	$trail = array(
		array(
			'name' => 'Home',
			'url'  => home_url( '/' ),
		),
	);

	$add = static function ( $name, $url = '' ) use ( &$trail ) {
		$name = trim( wp_strip_all_tags( (string) $name ) );
		if ( '' !== $name ) {
			$trail[] = array(
				'name' => $name,
				'url'  => (string) $url,
			);
		}
	};

	if ( is_404() ) {
		$add( 'Pagina niet gevonden' );
	} elseif ( is_search() ) {
		$add( 'Zoekresultaten' );
	} elseif ( is_tax( 'project_categorie' ) ) {
		$projects = llb_breadcrumb_page_id( 'projecten' );
		if ( $projects ) {
			$add( get_the_title( $projects ), get_permalink( $projects ) );
		}
		$add( single_term_title( '', false ) );
	} elseif ( is_singular( 'dienst' ) ) {
		$services = llb_breadcrumb_page_id( 'diensten' );
		if ( $services ) {
			$add( get_the_title( $services ), get_permalink( $services ) );
		}
		$add( get_the_title() );
	} elseif ( is_singular( 'project' ) ) {
		$projects = llb_breadcrumb_page_id( 'projecten' );
		if ( $projects ) {
			$add( get_the_title( $projects ), get_permalink( $projects ) );
		}
		$add( get_the_title() );
	} elseif ( is_page() ) {
		foreach ( array_reverse( get_post_ancestors( get_the_ID() ) ) as $ancestor ) {
			$add( get_the_title( $ancestor ), get_permalink( $ancestor ) );
		}
		$add( get_the_title() );
	} elseif ( is_singular() ) {
		$add( get_the_title() );
	} elseif ( is_archive() ) {
		$add( get_the_archive_title() );
	}

	/**
	 * Filters the theme breadcrumb trail.
	 *
	 * @param array<int, array{name:string, url:string}> $trail Breadcrumb entries.
	 */
	return apply_filters( 'llb_breadcrumb_trail', $trail );
}

/**
 * Outputs breadcrumbs from Yoast, Rank Math, or the theme trail.
 *
 * @return void
 */
function llb_breadcrumbs() {
	if ( ! llb_show_breadcrumbs() ) {
		return;
	}

	if ( function_exists( 'yoast_breadcrumb' ) ) {
		echo '<nav class="llb-crumbs" aria-label="' . esc_attr__( 'Kruimelpad', 'll-bouwgroep' ) . '">';
		yoast_breadcrumb();
		echo '</nav>';
		return;
	}

	if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		echo '<nav class="llb-crumbs" aria-label="' . esc_attr__( 'Kruimelpad', 'll-bouwgroep' ) . '">';
		rank_math_the_breadcrumbs();
		echo '</nav>';
		return;
	}

	$trail = llb_get_breadcrumb_trail();
	if ( count( $trail ) < 2 ) {
		return;
	}

	$last = count( $trail ) - 1;
	?>
	<nav class="llb-crumbs" aria-label="Kruimelpad">
		<ol>
			<?php foreach ( $trail as $index => $crumb ) : ?>
				<li>
					<?php if ( $index !== $last && '' !== $crumb['url'] ) : ?>
						<a href="<?php echo esc_url( $crumb['url'] ); ?>"><?php echo esc_html( $crumb['name'] ); ?></a>
					<?php else : ?>
						<span aria-current="page"><?php echo esc_html( $crumb['name'] ); ?></span>
					<?php endif; ?>
					<?php if ( $index !== $last ) : ?>
						<span class="llb-crumbs__sep" aria-hidden="true">/</span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</nav>
	<?php
}

/**
 * Prints BreadcrumbList JSON-LD when no SEO plugin owns breadcrumbs.
 *
 * @return void
 */
function llb_output_breadcrumb_schema() {
	if ( ! llb_show_breadcrumbs() || '' !== llb_active_seo_plugin_name() ) {
		return;
	}

	$trail = llb_get_breadcrumb_trail();
	if ( count( $trail ) < 2 ) {
		return;
	}

	$items = array();
	$last  = count( $trail ) - 1;

	foreach ( $trail as $index => $crumb ) {
		$item = array(
			'@type'    => 'ListItem',
			'position' => $index + 1,
			'name'     => $crumb['name'],
		);

		if ( $index !== $last && '' !== $crumb['url'] ) {
			$item['item'] = $crumb['url'];
		}

		$items[] = $item;
	}

	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'llb_output_breadcrumb_schema', 21 );

/**
 * Prints FAQPage JSON-LD on the FAQ page and single services with related FAQ.
 *
 * @return void
 */
function llb_output_faq_schema() {
	$entities = array();

	if ( is_singular( 'dienst' ) ) {
		$items = function_exists( 'llb_get_related_faq_for_service' ) ? llb_get_related_faq_for_service( get_the_ID(), 3 ) : array();
		foreach ( $items as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}
			$question = isset( $item['question'] ) ? trim( (string) $item['question'] ) : '';
			$answer   = isset( $item['answer'] ) ? trim( (string) $item['answer'] ) : '';
			if ( '' === $question || '' === $answer ) {
				continue;
			}
			$entities[] = array(
				'@type'          => 'Question',
				'name'           => $question,
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_strip_all_tags( $answer ),
				),
			);
		}
	} elseif ( is_page() && 'page-templates/page-faq.php' === get_page_template_slug() ) {
		/**
		 * Filters whether the theme outputs FAQPage JSON-LD on the FAQ page.
		 *
		 * @param bool $output Whether to output FAQ schema. Default true.
		 */
		if ( ! apply_filters( 'llb_output_faq_schema', true ) ) {
			return;
		}

		$items = llb_get_meta( get_the_ID(), '_llb_faq_items' );
		if ( ! is_array( $items ) || empty( $items ) ) {
			return;
		}

		foreach ( $items as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}

			$question = isset( $item['question'] ) ? trim( (string) $item['question'] ) : '';
			$answer   = isset( $item['answer'] ) ? trim( (string) $item['answer'] ) : '';

			if ( '' === $question || '' === $answer ) {
				continue;
			}

			$entities[] = array(
				'@type'          => 'Question',
				'name'           => $question,
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_strip_all_tags( $answer ),
				),
			);
		}
	} else {
		return;
	}

	if ( empty( $entities ) ) {
		return;
	}

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $entities,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'llb_output_faq_schema', 20 );
