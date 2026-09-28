<?php
/**
 * Theme Options (Appearance → Theme Options).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default Theme Options values.
 *
 * @return array{animations:int,projects:int}
 */
function llb_theme_options_defaults() {
	return array(
		'animations' => 1,
		'projects'   => 1,
	);
}

/**
 * Returns a Theme Options value or its default.
 *
 * @param string $key Option key (animations|projects).
 * @return int|mixed
 */
function llb_theme_option( $key ) {
	$defaults = llb_theme_options_defaults();
	$key      = (string) $key;

	if ( ! array_key_exists( $key, $defaults ) ) {
		return null;
	}

	$saved = get_option( 'llb_theme_options', array() );
	if ( ! is_array( $saved ) || ! array_key_exists( $key, $saved ) ) {
		return $defaults[ $key ];
	}

	return (int) $saved[ $key ];
}

/**
 * Whether front-end motion effects are enabled.
 *
 * @return bool
 */
function llb_animations_enabled() {
	return 1 === (int) llb_theme_option( 'animations' );
}

/**
 * Whether projects are shown on the front end.
 *
 * @return bool
 */
function llb_projects_enabled() {
	return 1 === (int) llb_theme_option( 'projects' );
}

/**
 * Sanitizes Theme Options on save.
 *
 * @param mixed $input Raw form input.
 * @return array{animations:int,projects:int}
 */
function llb_sanitize_theme_options( $input ) {
	$out = llb_theme_options_defaults();

	if ( ! is_array( $input ) ) {
		$input = array();
	}

	$out['animations'] = ! empty( $input['animations'] ) ? 1 : 0;
	$out['projects']   = ! empty( $input['projects'] ) ? 1 : 0;

	return $out;
}

/**
 * Registers the Theme Options setting.
 *
 * @return void
 */
function llb_register_theme_options() {
	register_setting(
		'llb_theme_options_group',
		'llb_theme_options',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'llb_sanitize_theme_options',
			'default'           => llb_theme_options_defaults(),
		)
	);
}
add_action( 'admin_init', 'llb_register_theme_options' );

/**
 * Adds Appearance → Theme Options.
 *
 * @return void
 */
function llb_add_theme_options_page() {
	add_theme_page(
		__( 'Theme Options', 'll-bouwgroep' ),
		__( 'Theme Options', 'll-bouwgroep' ),
		'manage_options',
		'llb-theme-options',
		'llb_render_theme_options_page'
	);
}
add_action( 'admin_menu', 'llb_add_theme_options_page' );

/**
 * Enqueues admin CSS for the Theme Options switches.
 *
 * @param string $hook Current admin page hook.
 * @return void
 */
function llb_enqueue_theme_options_assets( $hook ) {
	if ( 'appearance_page_llb-theme-options' !== $hook ) {
		return;
	}

	$css = '
		.llb-to-wrap{max-width:720px}
		.llb-to-row{display:flex;gap:20px;align-items:flex-start;padding:20px 0;border-bottom:1px solid #dcdcde}
		.llb-to-row:last-of-type{border-bottom:0}
		.llb-to-copy{flex:1;min-width:0}
		.llb-to-copy h2{margin:0 0 6px;font-size:15px;font-weight:600}
		.llb-to-copy p{margin:0;color:#646970;line-height:1.5}
		.llb-switch{position:relative;display:inline-block;width:44px;height:24px;flex:none;margin-top:2px}
		.llb-switch input{opacity:0;width:0;height:0}
		.llb-switch-slider{position:absolute;cursor:pointer;inset:0;background:#c3c4c7;border-radius:24px;transition:background .2s}
		.llb-switch-slider:before{content:"";position:absolute;height:18px;width:18px;left:3px;top:3px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 2px rgba(0,0,0,.2)}
		.llb-switch input:checked+.llb-switch-slider{background:#2271b1}
		.llb-switch input:checked+.llb-switch-slider:before{transform:translateX(20px)}
		.llb-switch input:focus+.llb-switch-slider{box-shadow:0 0 0 2px #fff,0 0 0 4px #2271b1}
		.llb-to-notice{margin:16px 0 0}
	';

	wp_register_style( 'llb-theme-options', false, array(), LLB_VERSION );
	wp_enqueue_style( 'llb-theme-options' );
	wp_add_inline_style( 'llb-theme-options', $css );
}
add_action( 'admin_enqueue_scripts', 'llb_enqueue_theme_options_assets' );

/**
 * Renders a toggle row.
 *
 * @param string $key   Option key.
 * @param string $label Label.
 * @param string $desc  Description.
 * @return void
 */
function llb_theme_options_render_toggle( $key, $label, $desc ) {
	$opts    = get_option( 'llb_theme_options', llb_theme_options_defaults() );
	$opts    = is_array( $opts ) ? $opts : llb_theme_options_defaults();
	$checked = ! empty( $opts[ $key ] );
	$id      = 'llb_theme_option_' . $key;
	?>
	<div class="llb-to-row">
		<label class="llb-switch" for="<?php echo esc_attr( $id ); ?>">
			<input
				type="checkbox"
				id="<?php echo esc_attr( $id ); ?>"
				name="llb_theme_options[<?php echo esc_attr( $key ); ?>]"
				value="1"
				<?php checked( $checked ); ?>
			/>
			<span class="llb-switch-slider" aria-hidden="true"></span>
		</label>
		<div class="llb-to-copy">
			<h2><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></h2>
			<p><?php echo esc_html( $desc ); ?></p>
		</div>
	</div>
	<?php
}

/**
 * Renders the Theme Options admin page.
 *
 * @return void
 */
function llb_render_theme_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$animations_on = llb_animations_enabled();
	$projects_on   = llb_projects_enabled();
	?>
	<div class="wrap llb-to-wrap">
		<h1><?php echo esc_html__( 'Theme Options', 'll-bouwgroep' ); ?></h1>

		<?php if ( ! $projects_on ) : ?>
			<div class="notice notice-warning llb-to-notice"><p><?php echo esc_html__( 'Projects are hidden on the website.', 'll-bouwgroep' ); ?></p></div>
		<?php endif; ?>
		<?php if ( ! $animations_on ) : ?>
			<div class="notice notice-info llb-to-notice"><p><?php echo esc_html__( 'Animations are turned off on the website.', 'll-bouwgroep' ); ?></p></div>
		<?php endif; ?>
		<?php if ( $projects_on && $animations_on ) : ?>
			<div class="notice notice-success llb-to-notice"><p><?php echo esc_html__( 'Animations and projects are both enabled on the website.', 'll-bouwgroep' ); ?></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'llb_theme_options_group' ); ?>
			<?php
			llb_theme_options_render_toggle(
				'animations',
				__( 'Animations', 'll-bouwgroep' ),
				__( 'Turn all motion effects on or off on the whole website (entrance animations, image reveal, image zoom on hover, hero effects).', 'll-bouwgroep' )
			);
			llb_theme_options_render_toggle(
				'projects',
				__( 'Projects', 'll-bouwgroep' ),
				__( 'Show or hide everything related to projects on the whole website. Nothing is deleted; turning it back on restores everything.', 'll-bouwgroep' )
			);
			submit_button( __( 'Save Changes', 'll-bouwgroep' ) );
			?>
		</form>
	</div>
	<?php
}

/**
 * Purges LiteSpeed Cache after Theme Options are saved.
 *
 * @param mixed $old_value Previous value.
 * @param mixed $value     New value.
 * @return void
 */
function llb_theme_options_purge_litespeed( $old_value, $value ) {
	if ( ! defined( 'LSCWP_V' ) && ! class_exists( 'LiteSpeed\Core', false ) && ! has_action( 'litespeed_purge_all' ) ) {
		return;
	}

	do_action( 'litespeed_purge_all' );
}
add_action( 'update_option_llb_theme_options', 'llb_theme_options_purge_litespeed', 10, 2 );
add_action( 'add_option_llb_theme_options', 'llb_theme_options_purge_litespeed_on_add', 10, 2 );

/**
 * Purges LiteSpeed when the option is first added.
 *
 * @param string $option Option name.
 * @param mixed  $value  Value.
 * @return void
 */
function llb_theme_options_purge_litespeed_on_add( $option, $value ) {
	llb_theme_options_purge_litespeed( null, $value );
}

/* -------------------------------------------------------------------------
 * Projects visibility (front end)
 * ---------------------------------------------------------------------- */

/**
 * Whether the current front request is a projects-related URL.
 *
 * @return bool
 */
function llb_is_projects_front_request() {
	if ( is_singular( 'project' ) || is_post_type_archive( 'project' ) || is_tax( 'project_categorie' ) ) {
		return true;
	}

	$page_id = function_exists( 'llb_get_projects_page_id' ) ? llb_get_projects_page_id() : 0;
	if ( $page_id && is_page( $page_id ) ) {
		return true;
	}

	return false;
}

/**
 * Whether a URL points to the projects page, a project, or a project category.
 *
 * @param string $url URL to check.
 * @return bool
 */
function llb_url_is_projects_related( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url || '#' === $url ) {
		return false;
	}

	$path = wp_parse_url( $url, PHP_URL_PATH );
	if ( ! is_string( $path ) || '' === $path ) {
		return false;
	}

	$path = '/' . trim( $path, '/' ) . '/';

	if ( preg_match( '#/(projecten|projectcategorie)(/|$)#', $path ) ) {
		return true;
	}

	$projects_id = function_exists( 'llb_get_projects_page_id' ) ? llb_get_projects_page_id() : 0;
	if ( $projects_id ) {
		$projects_path = wp_parse_url( get_permalink( $projects_id ), PHP_URL_PATH );
		if ( is_string( $projects_path ) && '' !== $projects_path ) {
			$projects_path = '/' . trim( $projects_path, '/' ) . '/';
			if ( $path === $projects_path || 0 === strpos( $path, $projects_path ) ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Whether a nav menu item points to projects content.
 *
 * @param object $item Menu item.
 * @return bool
 */
function llb_menu_item_is_projects_related( $item ) {
	if ( ! is_object( $item ) ) {
		return false;
	}

	$object = isset( $item->object ) ? (string) $item->object : '';
	if ( 'project' === $object || 'project_categorie' === $object ) {
		return true;
	}

	$projects_id = function_exists( 'llb_get_projects_page_id' ) ? llb_get_projects_page_id() : 0;
	if ( $projects_id && 'page' === $object && (int) $item->object_id === $projects_id ) {
		return true;
	}

	$url = isset( $item->url ) ? (string) $item->url : '';
	return llb_url_is_projects_related( $url );
}

/**
 * Removes project-related items from front-end menus.
 *
 * @param array $items Menu items.
 * @return array
 */
function llb_filter_nav_menu_hide_projects( $items ) {
	if ( is_admin() || llb_projects_enabled() || ! is_array( $items ) ) {
		return $items;
	}

	$remove = array();
	foreach ( $items as $item ) {
		if ( llb_menu_item_is_projects_related( $item ) ) {
			$remove[ (int) $item->ID ] = true;
		}
	}

	if ( empty( $remove ) ) {
		return $items;
	}

	$changed = true;
	while ( $changed ) {
		$changed = false;
		foreach ( $items as $item ) {
			$id     = (int) $item->ID;
			$parent = isset( $item->menu_item_parent ) ? (int) $item->menu_item_parent : 0;
			if ( ! isset( $remove[ $id ] ) && $parent && isset( $remove[ $parent ] ) ) {
				$remove[ $id ] = true;
				$changed       = true;
			}
		}
	}

	$filtered = array();
	foreach ( $items as $item ) {
		if ( ! isset( $remove[ (int) $item->ID ] ) ) {
			$filtered[] = $item;
		}
	}

	return $filtered;
}
add_filter( 'wp_nav_menu_objects', 'llb_filter_nav_menu_hide_projects' );

/**
 * Serves the theme 404 for project URLs when projects are off (visitors only).
 *
 * @return void
 */
function llb_projects_off_template_redirect() {
	if ( llb_projects_enabled() || is_admin() || ! llb_is_projects_front_request() ) {
		return;
	}

	if ( current_user_can( 'manage_options' ) ) {
		return;
	}

	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();

	$template = get_query_template( '404' );
	if ( $template ) {
		include $template;
		exit;
	}
}
add_action( 'template_redirect', 'llb_projects_off_template_redirect', 1 );

/**
 * Admin notice bar on project pages when projects are turned off.
 *
 * @return void
 */
function llb_projects_off_admin_notice_bar() {
	if ( llb_projects_enabled() || ! current_user_can( 'manage_options' ) || ! llb_is_projects_front_request() ) {
		return;
	}
	?>
	<div class="llb-projects-off-bar" role="status">
		<?php echo esc_html__( 'Projects are turned off in Theme Options — only admins can see this page.', 'll-bouwgroep' ); ?>
	</div>
	<style>
		.llb-projects-off-bar{background:#1d2327;color:#fff;text-align:center;padding:10px 16px;font:600 14px/1.4 system-ui,-apple-system,sans-serif;position:relative;z-index:100000}
		body.admin-bar .llb-projects-off-bar{margin-top:0}
	</style>
	<?php
}
add_action( 'wp_body_open', 'llb_projects_off_admin_notice_bar', 5 );

/**
 * Excludes projects from site search when projects are off.
 *
 * @param WP_Query $query Query.
 * @return void
 */
function llb_projects_off_exclude_from_search( $query ) {
	if ( is_admin() || ! $query instanceof WP_Query || ! $query->is_main_query() || ! $query->is_search() || llb_projects_enabled() ) {
		return;
	}

	$post_type = $query->get( 'post_type' );

	if ( empty( $post_type ) || 'any' === $post_type ) {
		$types = get_post_types( array( 'exclude_from_search' => false ), 'names' );
		unset( $types['project'] );
		$query->set( 'post_type', array_values( $types ) );
	} elseif ( is_array( $post_type ) ) {
		$query->set( 'post_type', array_values( array_diff( $post_type, array( 'project' ) ) ) );
	} elseif ( 'project' === $post_type ) {
		$query->set( 'post__in', array( 0 ) );
	}

	$page_id = function_exists( 'llb_get_projects_page_id' ) ? llb_get_projects_page_id() : 0;
	if ( $page_id ) {
		$not_in   = (array) $query->get( 'post__not_in' );
		$not_in[] = $page_id;
		$query->set( 'post__not_in', array_values( array_unique( array_map( 'intval', $not_in ) ) ) );
	}
}
add_action( 'pre_get_posts', 'llb_projects_off_exclude_from_search' );

/**
 * Core sitemaps: remove project post type when projects are off.
 *
 * @param array $post_types Post types.
 * @return array
 */
function llb_projects_off_sitemaps_post_types( $post_types ) {
	if ( ! llb_projects_enabled() ) {
		unset( $post_types['project'] );
	}
	return $post_types;
}
add_filter( 'wp_sitemaps_post_types', 'llb_projects_off_sitemaps_post_types' );

/**
 * Core sitemaps: remove project category taxonomy when projects are off.
 *
 * @param array $taxonomies Taxonomies.
 * @return array
 */
function llb_projects_off_sitemaps_taxonomies( $taxonomies ) {
	if ( ! llb_projects_enabled() ) {
		unset( $taxonomies['project_categorie'] );
	}
	return $taxonomies;
}
add_filter( 'wp_sitemaps_taxonomies', 'llb_projects_off_sitemaps_taxonomies' );

/**
 * Core sitemaps: exclude the Projecten page from the pages sitemap.
 *
 * @param array  $args      Query args.
 * @param string $post_type Post type.
 * @return array
 */
function llb_projects_off_sitemaps_posts_query_args( $args, $post_type ) {
	if ( llb_projects_enabled() || 'page' !== $post_type ) {
		return $args;
	}

	$page_id = function_exists( 'llb_get_projects_page_id' ) ? llb_get_projects_page_id() : 0;
	if ( ! $page_id ) {
		return $args;
	}

	$not_in            = isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array();
	$not_in[]          = $page_id;
	$args['post__not_in'] = array_values( array_unique( array_map( 'intval', $not_in ) ) );

	return $args;
}
add_filter( 'wp_sitemaps_posts_query_args', 'llb_projects_off_sitemaps_posts_query_args', 10, 2 );

/**
 * Yoast: exclude project post type from sitemaps when projects are off.
 *
 * @param bool   $exclude Whether to exclude.
 * @param string $type    Post type.
 * @return bool
 */
function llb_projects_off_yoast_exclude_post_type( $exclude, $type ) {
	if ( ! llb_projects_enabled() && 'project' === $type ) {
		return true;
	}
	return $exclude;
}

/**
 * Yoast: exclude project category taxonomy from sitemaps when projects are off.
 *
 * @param bool   $exclude Whether to exclude.
 * @param string $taxonomy Taxonomy.
 * @return bool
 */
function llb_projects_off_yoast_exclude_taxonomy( $exclude, $taxonomy ) {
	if ( ! llb_projects_enabled() && 'project_categorie' === $taxonomy ) {
		return true;
	}
	return $exclude;
}

/**
 * Yoast: exclude the Projecten page ID from sitemaps.
 *
 * @param int[] $ids Post IDs.
 * @return int[]
 */
function llb_projects_off_yoast_exclude_post_ids( $ids ) {
	if ( llb_projects_enabled() ) {
		return $ids;
	}
	$page_id = function_exists( 'llb_get_projects_page_id' ) ? llb_get_projects_page_id() : 0;
	if ( $page_id ) {
		$ids[] = $page_id;
	}
	return array_values( array_unique( array_map( 'intval', (array) $ids ) ) );
}

/**
 * Rank Math: exclude project post type from sitemaps when projects are off.
 *
 * @param bool   $exclude Whether to exclude.
 * @param string $type    Post type.
 * @return bool
 */
function llb_projects_off_rankmath_exclude_post_type( $exclude, $type ) {
	if ( ! llb_projects_enabled() && 'project' === $type ) {
		return true;
	}
	return $exclude;
}

/**
 * Rank Math: exclude project category taxonomy from sitemaps when projects are off.
 *
 * @param bool   $exclude Whether to exclude.
 * @param string $taxonomy Taxonomy.
 * @return bool
 */
function llb_projects_off_rankmath_exclude_taxonomy( $exclude, $taxonomy ) {
	if ( ! llb_projects_enabled() && 'project_categorie' === $taxonomy ) {
		return true;
	}
	return $exclude;
}

/**
 * Rank Math: exclude the Projecten page from sitemaps.
 *
 * @param int[] $ids Post IDs.
 * @return int[]
 */
function llb_projects_off_rankmath_exclude_post_ids( $ids ) {
	return llb_projects_off_yoast_exclude_post_ids( $ids );
}

/**
 * Registers Yoast / Rank Math sitemap exclude filters when those plugins are active.
 *
 * @return void
 */
function llb_projects_off_register_seo_sitemap_filters() {
	static $done = false;
	if ( $done ) {
		return;
	}

	if ( defined( 'WPSEO_VERSION' ) ) {
		add_filter( 'wpseo_sitemap_exclude_post_type', 'llb_projects_off_yoast_exclude_post_type', 10, 2 );
		add_filter( 'wpseo_sitemap_exclude_taxonomy', 'llb_projects_off_yoast_exclude_taxonomy', 10, 2 );
		add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', 'llb_projects_off_yoast_exclude_post_ids' );
		$done = true;
	}

	if ( defined( 'RANK_MATH_VERSION' ) || class_exists( 'RankMath', false ) ) {
		add_filter( 'rank_math/sitemap/exclude_post_type', 'llb_projects_off_rankmath_exclude_post_type', 10, 2 );
		add_filter( 'rank_math/sitemap/exclude_taxonomy', 'llb_projects_off_rankmath_exclude_taxonomy', 10, 2 );
		add_filter( 'rank_math/sitemap/exclude_post_ids', 'llb_projects_off_rankmath_exclude_post_ids' );
		$done = true;
	}

	// If neither SEO plugin is loaded yet, keep trying on init.
	if ( ! defined( 'WPSEO_VERSION' ) && ! defined( 'RANK_MATH_VERSION' ) && ! class_exists( 'RankMath', false ) ) {
		return;
	}

	$done = true;
}
// Theme loads after plugins_loaded, so register immediately (and on init as a safety net).
llb_projects_off_register_seo_sitemap_filters();
add_action( 'init', 'llb_projects_off_register_seo_sitemap_filters', 5 );
