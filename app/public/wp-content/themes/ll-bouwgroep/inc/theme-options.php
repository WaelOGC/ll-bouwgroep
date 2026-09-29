<?php
/**
 * Theme Options (top-level admin menu — single-page UI).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default Theme Options values.
 *
 * Front-end visitor strings are Dutch on purpose; the admin UI around them is English.
 *
 * @return array<string, int|string>
 */
function llb_theme_options_defaults() {
	return array(
		// General.
		'animations'                => 1,
		'projects'                  => 1,
		'back_to_top'               => 1,
		// Contact buttons.
		'whatsapp_enabled'          => 0,
		'whatsapp_number'           => '',
		'whatsapp_message'          => 'Hallo, ik heb een vraag.',
		'mobile_bar_enabled'        => 0,
		'mobile_bar_call_text'      => 'Bel ons',
		'mobile_bar_quote_text'     => 'Offerte aanvragen',
		// Social media.
		'social_instagram'          => '',
		'social_facebook'           => '',
		'social_linkedin'           => '',
		'social_youtube'            => '',
		'social_google'             => '',
		'social_show_footer'        => 1,
		'social_show_contact'       => 1,
		'social_show_menu'          => 0,
		// SEO.
		'schema_local_business'     => 1,
		'breadcrumbs'               => 1,
		'schema_area_served'        => 'Zoetermeer en omgeving',
		// Maintenance.
		'maintenance_enabled'       => 0,
		'maintenance_heading'       => 'Onze website wordt vernieuwd',
		'maintenance_text'          => 'Binnenkort vindt u hier de nieuwe website van L&L Bouwgroep B.V.',
		'maintenance_preview_token' => '',
		// Announcement.
		'announcement_enabled'      => 0,
		'announcement_text'         => '',
		'announcement_link'         => '',
		'announcement_link_text'    => '',
		'announcement_start'        => '',
		'announcement_end'          => '',
		// Tracking.
		'tracking_head'             => '',
		'tracking_body'             => '',
		'tracking_footer'           => '',
		'tracking_head_category'    => 'statistics',
		'tracking_body_category'    => 'statistics',
		'tracking_footer_category'  => 'marketing',
		// Branding.
		'admin_footer_text'         => 'L&L Bouwgroep B.V.',
	);
}

/**
 * Value type per Theme Options key.
 *
 * Types: bool (0/1), text, textarea, url, date (Y-m-d), tel, code, consent.
 *
 * @return array<string, string>
 */
function llb_theme_options_types() {
	return array(
		'animations'                => 'bool',
		'projects'                  => 'bool',
		'back_to_top'               => 'bool',
		'whatsapp_enabled'          => 'bool',
		'whatsapp_number'           => 'tel',
		'whatsapp_message'          => 'text',
		'mobile_bar_enabled'        => 'bool',
		'mobile_bar_call_text'      => 'text',
		'mobile_bar_quote_text'     => 'text',
		'social_instagram'          => 'url',
		'social_facebook'           => 'url',
		'social_linkedin'           => 'url',
		'social_youtube'            => 'url',
		'social_google'             => 'url',
		'social_show_footer'        => 'bool',
		'social_show_contact'       => 'bool',
		'social_show_menu'          => 'bool',
		'schema_local_business'     => 'bool',
		'breadcrumbs'               => 'bool',
		'schema_area_served'        => 'text',
		'maintenance_enabled'       => 'bool',
		'maintenance_heading'       => 'text',
		'maintenance_text'          => 'textarea',
		'maintenance_preview_token' => 'text',
		'announcement_enabled'      => 'bool',
		'announcement_text'         => 'text',
		'announcement_link'         => 'url',
		'announcement_link_text'    => 'text',
		'announcement_start'        => 'date',
		'announcement_end'          => 'date',
		'tracking_head'             => 'code',
		'tracking_body'             => 'code',
		'tracking_footer'           => 'code',
		'tracking_head_category'    => 'consent',
		'tracking_body_category'    => 'consent',
		'tracking_footer_category'  => 'consent',
		'admin_footer_text'         => 'text',
	);
}

/**
 * Consent categories available for tracking snippets (WP Consent API names).
 *
 * @return array<string, string>
 */
function llb_theme_options_consent_categories() {
	return array(
		'functional'  => __( 'Functional', 'll-bouwgroep' ),
		'preferences' => __( 'Preferences', 'll-bouwgroep' ),
		'statistics'  => __( 'Statistics', 'll-bouwgroep' ),
		'marketing'   => __( 'Marketing', 'll-bouwgroep' ),
	);
}

/**
 * Returns a Theme Options value or its default, cast to the key type.
 *
 * Toggles return int; every other key returns a string.
 *
 * @param string $key Option key.
 * @return int|string|null
 */
function llb_theme_option( $key ) {
	$defaults = llb_theme_options_defaults();
	$key      = (string) $key;

	if ( ! array_key_exists( $key, $defaults ) ) {
		return null;
	}

	$types = llb_theme_options_types();
	$type  = isset( $types[ $key ] ) ? $types[ $key ] : 'text';

	$saved = get_option( 'llb_theme_options', array() );
	if ( ! is_array( $saved ) || ! array_key_exists( $key, $saved ) ) {
		return $defaults[ $key ];
	}

	$value = $saved[ $key ];

	if ( 'bool' === $type ) {
		return empty( $value ) ? 0 : 1;
	}

	if ( is_scalar( $value ) ) {
		return (string) $value;
	}

	return $defaults[ $key ];
}

/**
 * Returns a trimmed Theme Options string value.
 *
 * @param string $key Option key.
 * @return string
 */
function llb_theme_option_text( $key ) {
	return trim( (string) llb_theme_option( $key ) );
}

/**
 * Whether a Theme Options toggle is on.
 *
 * @param string $key Option key.
 * @return bool
 */
function llb_theme_option_on( $key ) {
	return 1 === (int) llb_theme_option( $key );
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
 * Keys owned by each admin section.
 *
 * @return array<string, array<int, string>>
 */
function llb_theme_options_sections() {
	return array(
		'general'      => array( 'animations', 'projects', 'back_to_top' ),
		'contact'      => array( 'whatsapp_enabled', 'whatsapp_number', 'whatsapp_message', 'mobile_bar_enabled', 'mobile_bar_call_text', 'mobile_bar_quote_text' ),
		'social'       => array( 'social_instagram', 'social_facebook', 'social_linkedin', 'social_youtube', 'social_google', 'social_show_footer', 'social_show_contact', 'social_show_menu' ),
		'seo'          => array( 'schema_local_business', 'breadcrumbs', 'schema_area_served' ),
		'maintenance'  => array( 'maintenance_enabled', 'maintenance_heading', 'maintenance_text' ),
		'announcement' => array( 'announcement_enabled', 'announcement_text', 'announcement_link', 'announcement_link_text', 'announcement_start', 'announcement_end' ),
		'tracking'     => array( 'tracking_head', 'tracking_head_category', 'tracking_body', 'tracking_body_category', 'tracking_footer', 'tracking_footer_category' ),
		'branding'     => array( 'admin_footer_text' ),
	);
}

/**
 * Returns the currently stored options merged over the defaults.
 *
 * @return array<string, int|string>
 */
function llb_get_theme_options() {
	$defaults = llb_theme_options_defaults();
	$saved    = get_option( 'llb_theme_options', array() );

	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	return array_merge( $defaults, array_intersect_key( $saved, $defaults ) );
}

/**
 * Generates a maintenance preview token.
 *
 * @return string
 */
function llb_generate_maintenance_token() {
	return wp_generate_password( 20, false, false );
}

/**
 * Returns non-empty social profile links in display order.
 *
 * @return array<int, array{key:string, url:string, label:string}>
 */
function llb_get_social_links() {
	$profiles = array(
		'instagram' => array(
			'option' => 'social_instagram',
			'label'  => __( 'L&L Bouwgroep op Instagram', 'll-bouwgroep' ),
		),
		'facebook'  => array(
			'option' => 'social_facebook',
			'label'  => __( 'L&L Bouwgroep op Facebook', 'll-bouwgroep' ),
		),
		'linkedin'  => array(
			'option' => 'social_linkedin',
			'label'  => __( 'L&L Bouwgroep op LinkedIn', 'll-bouwgroep' ),
		),
		'youtube'   => array(
			'option' => 'social_youtube',
			'label'  => __( 'L&L Bouwgroep op YouTube', 'll-bouwgroep' ),
		),
		'google'    => array(
			'option' => 'social_google',
			'label'  => __( 'L&L Bouwgroep op Google', 'll-bouwgroep' ),
		),
	);

	$links = array();
	foreach ( $profiles as $key => $meta ) {
		$url = llb_theme_option_text( $meta['option'] );
		if ( '' === $url ) {
			continue;
		}
		$links[] = array(
			'key'   => $key,
			'url'   => $url,
			'label' => $meta['label'],
		);
	}

	return $links;
}

/**
 * One-time migration of Customizer social URLs into Theme Options.
 *
 * @return void
 */
function llb_migrate_social_from_customizer() {
	if ( get_option( 'llb_social_migrated' ) ) {
		return;
	}

	$options = llb_get_theme_options();
	$map     = array(
		'llb_social_instagram' => 'social_instagram',
		'llb_social_facebook'  => 'social_facebook',
		'llb_social_linkedin'  => 'social_linkedin',
	);
	$changed = false;

	foreach ( $map as $theme_mod => $option_key ) {
		if ( '' === trim( (string) $options[ $option_key ] ) ) {
			$mod = trim( (string) get_theme_mod( $theme_mod, '' ) );
			if ( '' !== $mod ) {
				$options[ $option_key ] = esc_url_raw( $mod );
				$changed                = true;
			}
		}
		remove_theme_mod( $theme_mod );
	}

	if ( $changed ) {
		$options['_section'] = 'all';
		update_option( 'llb_theme_options', $options );
	}

	update_option( 'llb_social_migrated', 1 );
}
add_action( 'admin_init', 'llb_migrate_social_from_customizer' );

/**
 * Seeds demo social profile URLs when empty (once per theme version).
 *
 * @return void
 */
function llb_seed_demo_social_options() {
	$options = llb_get_theme_options();
	$demos   = array(
		'social_instagram' => 'https://www.instagram.com/llbouwgroep',
		'social_facebook'  => 'https://www.facebook.com/llbouwgroep',
		'social_linkedin'  => 'https://www.linkedin.com/company/llbouwgroep',
		'social_google'    => 'https://g.page/llbouwgroep',
	);
	$changed = false;

	foreach ( $demos as $key => $url ) {
		if ( '' === trim( (string) ( isset( $options[ $key ] ) ? $options[ $key ] : '' ) ) ) {
			$options[ $key ] = $url;
			$changed         = true;
		}
	}

	if ( $changed ) {
		// Ensure sanitize treats this as a full write (register_setting filters update_option).
		$options['_section'] = 'all';
		update_option( 'llb_theme_options', $options );
	}
}

/**
 * Runs social demo seed once per theme version (admin).
 *
 * @return void
 */
function llb_maybe_seed_demo_social_options() {
	// One-time: earlier 0.26.0 seed attempts were stripped by sanitize (no _section).
	if ( ! get_option( 'llb_social_demo_v026b_fixed' ) ) {
		delete_option( 'llb_social_demo_version' );
		delete_option( 'llb_social_demo_seeded' );
		delete_option( 'llb_social_demo_v026_fixed' );
		update_option( 'llb_social_demo_v026b_fixed', 1 );
	}

	$stored = (string) get_option( 'llb_social_demo_version', '' );
	if ( $stored === (string) LLB_VERSION ) {
		return;
	}

	llb_seed_demo_social_options();
	update_option( 'llb_social_demo_version', (string) LLB_VERSION );
}
add_action( 'admin_init', 'llb_maybe_seed_demo_social_options', 11 );

/**
 * Sanitizes a single Theme Options value by key type.
 *
 * @param string $key   Option key.
 * @param mixed  $value Raw value.
 * @return int|string
 */
function llb_sanitize_theme_option_value( $key, $value ) {
	$types = llb_theme_options_types();
	$type  = isset( $types[ $key ] ) ? $types[ $key ] : 'text';

	switch ( $type ) {
		case 'bool':
			return empty( $value ) ? 0 : 1;

		case 'url':
			return esc_url_raw( trim( (string) $value ) );

		case 'tel':
			$tel = preg_replace( '/[^0-9+]/', '', (string) $value );
			return is_string( $tel ) ? $tel : '';

		case 'date':
			$date = trim( (string) $value );
			if ( '' === $date ) {
				return '';
			}
			$parsed = date_create_from_format( 'Y-m-d', $date );
			return ( $parsed && $parsed->format( 'Y-m-d' ) === $date ) ? $date : '';

		case 'consent':
			$categories = llb_theme_options_consent_categories();
			$value      = sanitize_key( (string) $value );
			return isset( $categories[ $value ] ) ? $value : 'statistics';

		case 'code':
			// Raw scripts are only kept for users who may post unfiltered HTML.
			if ( current_user_can( 'unfiltered_html' ) ) {
				return trim( (string) $value );
			}
			return trim( wp_kses_post( (string) $value ) );

		case 'textarea':
			return sanitize_textarea_field( (string) $value );

		default:
			return sanitize_text_field( (string) $value );
	}
}

/**
 * Applies sanitized values for a list of option keys.
 *
 * @param array<string, int|string> $out  Current options.
 * @param array<string, mixed>      $input Raw form input.
 * @param array<int, string>        $keys Keys to sanitize.
 * @return array<string, int|string>
 */
function llb_sanitize_theme_options_keys( $out, $input, $keys ) {
	$types = llb_theme_options_types();

	foreach ( $keys as $key ) {
		$type = isset( $types[ $key ] ) ? $types[ $key ] : 'text';

		// Unchecked checkboxes are not posted at all, so they are explicitly set to 0.
		if ( 'bool' === $type ) {
			$out[ $key ] = empty( $input[ $key ] ) ? 0 : 1;
			continue;
		}

		if ( ! array_key_exists( $key, $input ) ) {
			continue;
		}

		$out[ $key ] = llb_sanitize_theme_option_value( $key, $input[ $key ] );
	}

	return $out;
}

/**
 * Sanitizes Theme Options on save.
 *
 * When `_section` is `all`, every section key is sanitized (bools default to 0).
 * Known section keys keep the old per-section behaviour.
 *
 * @param mixed $input Raw form input.
 * @return array<string, int|string>
 */
function llb_sanitize_theme_options( $input ) {
	$out = llb_get_theme_options();

	if ( ! is_array( $input ) ) {
		return $out;
	}

	$sections = llb_theme_options_sections();
	$section  = isset( $input['_section'] ) ? sanitize_key( $input['_section'] ) : '';

	// `all` = Theme Options form. Empty section = programmatic update (seed/migration).
	if ( 'all' === $section || '' === $section ) {
		foreach ( $sections as $keys ) {
			$out = llb_sanitize_theme_options_keys( $out, $input, $keys );
		}
	} elseif ( isset( $sections[ $section ] ) ) {
		$out = llb_sanitize_theme_options_keys( $out, $input, $sections[ $section ] );
	} else {
		return $out;
	}

	if ( ! empty( $out['maintenance_enabled'] ) && '' === trim( (string) $out['maintenance_preview_token'] ) ) {
		$out['maintenance_preview_token'] = llb_generate_maintenance_token();
	}

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
 * Legacy page slug → tab map (for redirects).
 *
 * @return array<string, string>
 */
function llb_theme_options_legacy_tabs() {
	return array(
		'llb-to-contact'      => 'contact',
		'llb-to-seo'          => 'seo',
		'llb-to-maintenance'  => 'maint',
		'llb-to-announcement' => 'ann',
		'llb-to-tracking'     => 'track',
		'llb-to-branding'     => 'brand',
		'llb-import-content'  => 'import',
	);
}

/**
 * Registers Theme Options as a single top-level admin menu.
 *
 * @return void
 */
function llb_add_theme_options_page() {
	add_menu_page(
		__( 'Theme Options', 'll-bouwgroep' ),
		__( 'Theme Options', 'll-bouwgroep' ),
		'manage_options',
		'llb-theme-options',
		'llb_render_theme_options_page',
		'dashicons-admin-generic',
		61
	);
}
add_action( 'admin_menu', 'llb_add_theme_options_page' );

/**
 * Hides the auto-added duplicate Theme Options submenu entry.
 *
 * @return void
 */
function llb_theme_options_hide_duplicate_submenu() {
	remove_submenu_page( 'llb-theme-options', 'llb-theme-options' );
}
add_action( 'admin_menu', 'llb_theme_options_hide_duplicate_submenu', 999 );

/**
 * Whether an admin page slug belongs to the Theme Options screens.
 *
 * @param string $page Page slug.
 * @return bool
 */
function llb_is_theme_options_screen( $page ) {
	$page = (string) $page;

	if ( in_array( $page, array( 'llb-theme-options', 'llb-import-content' ), true ) ) {
		return true;
	}

	return 0 === strpos( $page, 'llb-to-' );
}

/**
 * Redirects legacy Theme Options URLs to the single-page UI.
 *
 * @return void
 */
function llb_redirect_legacy_theme_option_pages() {
	if ( ! is_admin() || empty( $_GET['page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only redirect.
		return;
	}

	$page = sanitize_key( wp_unslash( $_GET['page'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$tabs = llb_theme_options_legacy_tabs();

	if ( isset( $tabs[ $page ] ) ) {
		$args = array();
		foreach ( wp_unslash( $_GET ) as $key => $value ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( ! is_scalar( $value ) ) {
				continue;
			}
			$key = sanitize_key( (string) $key );
			if ( '' === $key || 'page' === $key ) {
				continue;
			}
			$args[ $key ] = sanitize_text_field( (string) $value );
		}
		$args['page'] = 'llb-theme-options';
		$args['tab']  = $tabs[ $page ];
		wp_safe_redirect( add_query_arg( $args, admin_url( 'admin.php' ) ) );
		exit;
	}

	if ( ! llb_is_theme_options_screen( $page ) ) {
		return;
	}

	// Already on the new URL.
	global $pagenow;
	if ( 'admin.php' === $pagenow ) {
		return;
	}

	// Legacy Appearance → Themes URL.
	$args = array();
	foreach ( wp_unslash( $_GET ) as $key => $value ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! is_scalar( $value ) ) {
			continue;
		}
		$key = sanitize_key( (string) $key );
		if ( '' === $key ) {
			continue;
		}
		$args[ $key ] = sanitize_text_field( (string) $value );
	}
	wp_safe_redirect( add_query_arg( $args, admin_url( 'admin.php' ) ) );
	exit;
}
add_action( 'admin_init', 'llb_redirect_legacy_theme_option_pages', 1 );
add_action( 'admin_page_access_denied', 'llb_redirect_legacy_theme_option_pages' );

/**
 * Enqueues Theme Options admin CSS and JS.
 *
 * @param string $hook Current admin page hook.
 * @return void
 */
function llb_enqueue_theme_options_assets( $hook ) {
	unset( $hook );

	$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only screen check.
	if ( 'llb-theme-options' !== $page ) {
		return;
	}

	wp_enqueue_style(
		'llb-theme-options',
		llb_asset( 'css/admin-theme-options.css' ),
		array(),
		LLB_VERSION
	);
	wp_enqueue_script(
		'llb-theme-options',
		llb_asset( 'js/admin-theme-options.js' ),
		array(),
		LLB_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'llb_enqueue_theme_options_assets' );

/**
 * Renders an On/Off badge for a feature toggle.
 *
 * @param string $key Option key.
 * @return void
 */
function llb_theme_options_badge( $key ) {
	$on = llb_theme_option_on( $key );
	printf(
		'<span class="llbo-badge%s">%s</span>',
		$on ? '' : ' off',
		esc_html( $on ? __( 'On', 'll-bouwgroep' ) : __( 'Off', 'll-bouwgroep' ) )
	);
}

/**
 * Renders a feature toggle switch input.
 *
 * @param string $key   Option key.
 * @param string $label Accessible label.
 * @return void
 */
function llb_theme_options_switch( $key, $label ) {
	?>
	<label class="llbo-sw">
		<input
			type="checkbox"
			name="llb_theme_options[<?php echo esc_attr( $key ); ?>]"
			value="1"
			data-key="<?php echo esc_attr( $key ); ?>"
			aria-label="<?php echo esc_attr( $label ); ?>"
			<?php checked( llb_theme_option_on( $key ) ); ?>
		/>
		<span></span>
	</label>
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

	$saved         = isset( $_GET['settings-updated'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only UI flag.
	$theme         = wp_get_theme();
	$theme_version = $theme->get( 'Version' );
	$seo_plugin    = function_exists( 'llb_active_seo_plugin_name' ) ? llb_active_seo_plugin_name() : '';
	$has_consent   = function_exists( 'llb_consent_api_available' ) ? llb_consent_api_available() : false;
	$has_tracking  = function_exists( 'llb_tracking_has_any_code' ) ? llb_tracking_has_any_code() : false;
	$preview_url   = function_exists( 'llb_maintenance_preview_url' ) ? llb_maintenance_preview_url() : '';
	$import_result = null;

	if ( isset( $_POST['llb_import_content'] ) ) {
		check_admin_referer( 'llb_import_content' );
		if ( function_exists( 'llb_run_content_import' ) ) {
			$import_result = llb_run_content_import();
		}
	}

	$ext_svg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/></svg>';
	?>
	<div class="wrap llbo-wrap">
	<div class="llbo" data-saved="<?php echo $saved ? '1' : '0'; ?>">
		<header class="llbo-head">
			<img src="<?php echo esc_url( llb_asset( 'images/logo-header.webp' ) ); ?>" alt="<?php echo esc_attr__( 'L&L Bouwgroep', 'll-bouwgroep' ); ?>">
			<div class="llbo-grow">
				<span class="llbo-rule"></span>
				<h1><?php echo esc_html__( 'Theme Options', 'll-bouwgroep' ); ?></h1>
				<p><?php echo esc_html__( 'Control website features. Changes go live after saving (cache is cleared automatically).', 'll-bouwgroep' ); ?></p>
			</div>
			<a class="llbo-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener">
				<?php echo esc_html__( 'View website', 'll-bouwgroep' ); ?>
				<?php echo $ext_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
			</a>
		</header>

		<div class="llbo-body">
			<nav class="llbo-nav" aria-label="<?php echo esc_attr__( 'Theme Options sections', 'll-bouwgroep' ); ?>">
				<ul role="tablist">
					<li><button type="button" role="tab" aria-selected="true" data-tab="overview"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg><?php echo esc_html__( 'Overview', 'll-bouwgroep' ); ?></button></li>
					<li class="llbo-sep" aria-hidden="true"></li>
					<li><button type="button" role="tab" aria-selected="false" data-tab="general"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 6h10M18 6h2M4 12h4M12 12h8M4 18h12M20 18h0"/><circle cx="16" cy="6" r="2"/><circle cx="10" cy="12" r="2"/><circle cx="18" cy="18" r="2"/></svg><?php echo esc_html__( 'General', 'll-bouwgroep' ); ?><i class="llbo-dot on" data-for="general"></i></button></li>
					<li><button type="button" role="tab" aria-selected="false" data-tab="contact"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20l1-4.6A8 8 0 1 1 21 12z"/></svg><?php echo esc_html__( 'Contact buttons', 'll-bouwgroep' ); ?><i class="llbo-dot" data-for="contact"></i></button></li>
					<li><button type="button" role="tab" aria-selected="false" data-tab="social"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="M8.6 13.5l6.8 4M15.4 6.5l-6.8 4"/></svg><?php echo esc_html__( 'Social media', 'll-bouwgroep' ); ?><i class="llbo-dot on" data-for="social"></i></button></li>
					<li><button type="button" role="tab" aria-selected="false" data-tab="seo"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg><?php echo esc_html__( 'SEO', 'll-bouwgroep' ); ?><i class="llbo-dot on" data-for="seo"></i></button></li>
					<li><button type="button" role="tab" aria-selected="false" data-tab="maint"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18v3h3l6.3-6.3a4 4 0 0 0 5.4-5.4l-2.5 2.5-2.4-.6-.6-2.4z"/></svg><?php echo esc_html__( 'Maintenance', 'll-bouwgroep' ); ?><i class="llbo-dot" data-for="maint"></i></button></li>
					<li><button type="button" role="tab" aria-selected="false" data-tab="ann"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11v2a1 1 0 0 0 1 1h2l5 4V6L6 10H4a1 1 0 0 0-1 1zM15 9a3 3 0 0 1 0 6M18 6a7 7 0 0 1 0 12"/></svg><?php echo esc_html__( 'Announcement', 'll-bouwgroep' ); ?><i class="llbo-dot" data-for="ann"></i></button></li>
					<li><button type="button" role="tab" aria-selected="false" data-tab="track"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/></svg><?php echo esc_html__( 'Tracking', 'll-bouwgroep' ); ?></button></li>
					<li><button type="button" role="tab" aria-selected="false" data-tab="brand"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 3l3 3-9 9-3-3zM9 12l-4 4a2.8 2.8 0 0 0 0 4c-1.5 0-3 .5-3 .5S2.5 17 4 16"/></svg><?php echo esc_html__( 'Branding', 'll-bouwgroep' ); ?></button></li>
					<li class="llbo-sep" aria-hidden="true"></li>
					<li><button type="button" role="tab" aria-selected="false" data-tab="import"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12M7 10l5 5 5-5M4 21h16"/></svg><?php echo esc_html__( 'Import content', 'll-bouwgroep' ); ?></button></li>
				</ul>
			</nav>

			<div class="llbo-main">
			<form id="llbo-form" method="post" action="options.php">
				<?php settings_fields( 'llb_theme_options_group' ); ?>
				<input type="hidden" name="llb_theme_options[_section]" value="all" />

				<section class="llbo-panel active" id="p-overview" role="tabpanel">
					<h2 class="llbo-ptitle"><?php echo esc_html__( 'Overview', 'll-bouwgroep' ); ?></h2>
					<p class="llbo-pdesc"><?php echo esc_html__( 'The status of every feature at a glance. Switch a feature on or off here, or open its section for the settings.', 'll-bouwgroep' ); ?></p>
					<div class="llbo-ov-llbo-stat">
						<div class="llbo-stat"><b data-count-on>0</b><span><?php echo esc_html__( 'features active', 'll-bouwgroep' ); ?></span></div>
						<div class="llbo-stat"><b><?php echo esc_html__( 'Live', 'll-bouwgroep' ); ?></b><span><?php echo esc_html__( 'website visible to visitors', 'll-bouwgroep' ); ?></span></div>
						<div class="llbo-stat"><b><?php echo esc_html( (string) $theme_version ); ?></b><span><?php echo esc_html__( 'theme version', 'll-bouwgroep' ); ?></span></div>
					</div>
					<div class="llbo-ov-grid" id="ov-grid"></div>
				</section>

				<section class="llbo-panel" id="p-general" role="tabpanel">
					<h2 class="llbo-ptitle"><?php echo esc_html__( 'General', 'll-bouwgroep' ); ?></h2>
					<p class="llbo-pdesc"><?php echo esc_html__( 'Effects and sections on the whole website.', 'll-bouwgroep' ); ?></p>

					<div class="llbo-card">
						<div class="llbo-card-h">
							<div class="llbo-card-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8zM19 16l.8 2.2L22 19l-2.2.8L19 22l-.8-2.2L16 19l2.2-.8z"/></svg></div>
							<div class="llbo-card-t">
								<h3><?php echo esc_html__( 'Animations', 'll-bouwgroep' ); ?> <?php llb_theme_options_badge( 'animations' ); ?></h3>
								<p><?php echo esc_html__( 'Motion effects on the whole website: entrance animations, image reveal, zoom on hover.', 'll-bouwgroep' ); ?></p>
							</div>
							<?php llb_theme_options_switch( 'animations', __( 'Animations', 'll-bouwgroep' ) ); ?>
						</div>
					</div>

					<div class="llbo-card">
						<div class="llbo-card-h">
							<div class="llbo-card-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div>
							<div class="llbo-card-t">
								<h3><?php echo esc_html__( 'Projects', 'll-bouwgroep' ); ?> <?php llb_theme_options_badge( 'projects' ); ?></h3>
								<p><?php echo esc_html__( 'Show everything related to projects. Turning it off hides the Projecten page, project sections and menu links. Nothing is deleted.', 'll-bouwgroep' ); ?></p>
							</div>
							<?php llb_theme_options_switch( 'projects', __( 'Projects', 'll-bouwgroep' ) ); ?>
						</div>
					</div>

					<div class="llbo-card">
						<div class="llbo-card-h">
							<div class="llbo-card-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7"/></svg></div>
							<div class="llbo-card-t">
								<h3><?php echo esc_html__( 'Back to top button', 'll-bouwgroep' ); ?> <?php llb_theme_options_badge( 'back_to_top' ); ?></h3>
								<p><?php echo esc_html__( 'A round button in the bottom-right corner after scrolling down.', 'll-bouwgroep' ); ?></p>
							</div>
							<?php llb_theme_options_switch( 'back_to_top', __( 'Back to top button', 'll-bouwgroep' ) ); ?>
						</div>
					</div>
				</section>

				<section class="llbo-panel" id="p-contact" role="tabpanel">
					<h2 class="llbo-ptitle"><?php echo esc_html__( 'Contact buttons', 'll-bouwgroep' ); ?></h2>
					<p class="llbo-pdesc"><?php echo esc_html__( 'Quick ways for visitors to reach the company.', 'll-bouwgroep' ); ?></p>

					<div class="llbo-card">
						<div class="llbo-card-h">
							<div class="llbo-card-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 21l1.6-4.6A8.5 8.5 0 1 1 7.7 19.4z"/><path d="M9 9.5c.3 2 2.5 4.2 4.5 4.5l1-1 2 1v1a1.5 1.5 0 0 1-1.5 1.5A7 7 0 0 1 8 9.5 1.5 1.5 0 0 1 9.5 8h1l1 2z"/></svg></div>
							<div class="llbo-card-t">
								<h3><?php echo esc_html__( 'WhatsApp button', 'll-bouwgroep' ); ?> <?php llb_theme_options_badge( 'whatsapp_enabled' ); ?></h3>
								<p><?php echo esc_html__( 'A round WhatsApp button in the bottom-right corner on every page.', 'll-bouwgroep' ); ?></p>
							</div>
							<?php llb_theme_options_switch( 'whatsapp_enabled', __( 'WhatsApp button', 'll-bouwgroep' ) ); ?>
						</div>
						<div class="llbo-card-b"<?php echo llb_theme_option_on( 'whatsapp_enabled' ) ? '' : ' hidden'; ?>>
							<div class="llbo-f">
								<label for="llbo-wa-n"><?php echo esc_html__( 'WhatsApp number', 'll-bouwgroep' ); ?></label>
								<div>
									<input id="llbo-wa-n" type="tel" name="llb_theme_options[whatsapp_number]" value="<?php echo esc_attr( llb_theme_option_text( 'whatsapp_number' ) ); ?>" placeholder="+31612345678">
									<small><?php echo esc_html__( 'International format. The button is hidden when this is empty.', 'll-bouwgroep' ); ?></small>
								</div>
							</div>
							<div class="llbo-f">
								<label for="llbo-wa-m"><?php echo esc_html__( 'Pre-filled message', 'll-bouwgroep' ); ?></label>
								<div>
									<input id="llbo-wa-m" type="text" name="llb_theme_options[whatsapp_message]" value="<?php echo esc_attr( (string) llb_theme_option( 'whatsapp_message' ) ); ?>">
									<small><?php echo esc_html__( 'Dutch text the visitor sees in WhatsApp.', 'll-bouwgroep' ); ?></small>
								</div>
							</div>
						</div>
					</div>

					<div class="llbo-card">
						<div class="llbo-card-h">
							<div class="llbo-card-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="6" y="2" width="12" height="20" rx="2.5"/><path d="M11 18h2"/></svg></div>
							<div class="llbo-card-t">
								<h3><?php echo esc_html__( 'Mobile contact bar', 'll-bouwgroep' ); ?> <?php llb_theme_options_badge( 'mobile_bar_enabled' ); ?></h3>
								<p><?php echo esc_html__( 'A fixed bar at the bottom of the screen on phones only, with a call button and a quote button.', 'll-bouwgroep' ); ?></p>
							</div>
							<?php llb_theme_options_switch( 'mobile_bar_enabled', __( 'Mobile contact bar', 'll-bouwgroep' ) ); ?>
						</div>
						<div class="llbo-card-b"<?php echo llb_theme_option_on( 'mobile_bar_enabled' ) ? '' : ' hidden'; ?>>
							<div class="llbo-f">
								<label><?php echo esc_html__( 'Button texts', 'll-bouwgroep' ); ?></label>
								<div class="llbo-row2">
									<input type="text" name="llb_theme_options[mobile_bar_call_text]" value="<?php echo esc_attr( (string) llb_theme_option( 'mobile_bar_call_text' ) ); ?>" aria-label="<?php echo esc_attr__( 'Call button text', 'll-bouwgroep' ); ?>">
									<input type="text" name="llb_theme_options[mobile_bar_quote_text]" value="<?php echo esc_attr( (string) llb_theme_option( 'mobile_bar_quote_text' ) ); ?>" aria-label="<?php echo esc_attr__( 'Quote button text', 'll-bouwgroep' ); ?>">
								</div>
							</div>
							<div class="llbo-f">
								<label></label>
								<small><?php echo esc_html__( 'The call button uses the phone number from Appearance → Customize → Company details.', 'll-bouwgroep' ); ?></small>
							</div>
						</div>
					</div>
				</section>

				<section class="llbo-panel" id="p-social" role="tabpanel">
					<h2 class="llbo-ptitle"><?php echo esc_html__( 'Social media', 'll-bouwgroep' ); ?></h2>
					<p class="llbo-pdesc"><?php echo esc_html__( 'Add the company profiles. Only filled-in links are shown on the website. Best practice: 3 to 5 active profiles.', 'll-bouwgroep' ); ?></p>

					<div class="llbo-card">
						<div class="llbo-card-h">
							<div class="llbo-card-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/></svg></div>
							<div class="llbo-card-t">
								<h3><?php echo esc_html__( 'Profiles', 'll-bouwgroep' ); ?></h3>
								<p><?php echo esc_html__( 'Paste the full link to each profile. Leave empty to hide that icon.', 'll-bouwgroep' ); ?></p>
							</div>
						</div>
						<div class="llbo-card-b">
							<div class="llbo-soc-list">
								<div class="llbo-soc"><span class="llbo-si"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 8.2A3.2 3.2 0 1 1 12 8.8a3.2 3.2 0 0 1 0 6.4zM17.3 5.5a1.2 1.2 0 1 0 0 2.4 1.2 1.2 0 0 0 0-2.4zM12 2c-2.7 0-3 0-4.1.1C4.3 2.2 2.2 4.3 2.1 7.9 2 9 2 9.3 2 12s0 3 .1 4.1c.1 3.6 2.2 5.7 5.8 5.8 1.1.1 1.4.1 4.1.1s3 0 4.1-.1c3.6-.1 5.7-2.2 5.8-5.8.1-1.1.1-1.4.1-4.1s0-3-.1-4.1c-.1-3.6-2.2-5.7-5.8-5.8C15 2 14.7 2 12 2zm0 1.8c2.7 0 3 0 4 .1 2.6.1 3.9 1.4 4 4 .1 1 .1 1.3.1 4s0 3-.1 4c-.1 2.6-1.4 3.9-4 4-1 .1-1.3.1-4 .1s-3 0-4-.1c-2.6-.1-3.9-1.4-4-4-.1-1-.1-1.3-.1-4s0-3 .1-4c.1-2.6 1.4-3.9 4-4 1-.1 1.3-.1 4-.1z"/></svg></span><input type="url" name="llb_theme_options[social_instagram]" placeholder="https://www.instagram.com/…" value="<?php echo esc_attr( llb_theme_option_text( 'social_instagram' ) ); ?>" aria-label="<?php echo esc_attr__( 'Instagram link', 'll-bouwgroep' ); ?>" data-soc="ig"></div>
								<div class="llbo-soc"><span class="llbo-si"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 22v-8.2h2.8l.4-3.2h-3.2V8.6c0-.9.3-1.6 1.6-1.6h1.7V4.1c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2.3H7.3v3.2h2.8V22z"/></svg></span><input type="url" name="llb_theme_options[social_facebook]" placeholder="https://www.facebook.com/…" value="<?php echo esc_attr( llb_theme_option_text( 'social_facebook' ) ); ?>" aria-label="<?php echo esc_attr__( 'Facebook link', 'll-bouwgroep' ); ?>" data-soc="fb"></div>
								<div class="llbo-soc"><span class="llbo-si"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9.8h4V21H3zM9.5 9.8h3.8v1.5h.1c.5-1 1.8-1.9 3.7-1.9 4 0 4.7 2.6 4.7 6V21h-4v-5c0-1.2 0-2.8-1.7-2.8s-2 1.3-2 2.7V21h-4z"/></svg></span><input type="url" name="llb_theme_options[social_linkedin]" placeholder="https://www.linkedin.com/company/…" value="<?php echo esc_attr( llb_theme_option_text( 'social_linkedin' ) ); ?>" aria-label="<?php echo esc_attr__( 'LinkedIn link', 'll-bouwgroep' ); ?>" data-soc="li"></div>
								<div class="llbo-soc"><span class="llbo-si"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M23 7.2a3 3 0 0 0-2.1-2.1C19 4.6 12 4.6 12 4.6s-7 0-8.9.5A3 3 0 0 0 1 7.2 31 31 0 0 0 .5 12 31 31 0 0 0 1 16.8a3 3 0 0 0 2.1 2.1c1.9.5 8.9.5 8.9.5s7 0 8.9-.5a3 3 0 0 0 2.1-2.1 31 31 0 0 0 .5-4.8 31 31 0 0 0-.5-4.8zM9.8 15V9l5.8 3z"/></svg></span><input type="url" name="llb_theme_options[social_youtube]" placeholder="https://www.youtube.com/@…" value="<?php echo esc_attr( llb_theme_option_text( 'social_youtube' ) ); ?>" aria-label="<?php echo esc_attr__( 'YouTube link', 'll-bouwgroep' ); ?>" data-soc="yt"></div>
								<div class="llbo-soc"><span class="llbo-si"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.6 10.2H12v3.9h5.5c-.5 2.5-2.7 4.1-5.5 4.1a6.2 6.2 0 1 1 4-10.9l2.9-2.9A10.2 10.2 0 1 0 12 22.2c5.9 0 9.8-4.1 9.8-9.9 0-.7-.1-1.4-.2-2.1z"/></svg></span><input type="url" name="llb_theme_options[social_google]" placeholder="<?php echo esc_attr__( 'Google Business profile link', 'll-bouwgroep' ); ?>" value="<?php echo esc_attr( llb_theme_option_text( 'social_google' ) ); ?>" aria-label="<?php echo esc_attr__( 'Google Business link', 'll-bouwgroep' ); ?>" data-soc="g"></div>
							</div>
						</div>
					</div>

					<div class="llbo-card">
						<div class="llbo-card-h">
							<div class="llbo-card-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg></div>
							<div class="llbo-card-t">
								<h3><?php echo esc_html__( 'Where to show the icons', 'll-bouwgroep' ); ?></h3>
								<p><?php echo esc_html__( 'The footer is the standard place. The contact page and the phone menu are optional.', 'll-bouwgroep' ); ?></p>
							</div>
						</div>
						<div class="llbo-card-b">
							<div class="llbo-chips">
								<label class="llbo-chip"><input type="checkbox" name="llb_theme_options[social_show_footer]" value="1" <?php checked( llb_theme_option_on( 'social_show_footer' ) ); ?>><span><?php echo esc_html__( 'Footer', 'll-bouwgroep' ); ?></span></label>
								<label class="llbo-chip"><input type="checkbox" name="llb_theme_options[social_show_contact]" value="1" <?php checked( llb_theme_option_on( 'social_show_contact' ) ); ?>><span><?php echo esc_html__( 'Contact page', 'll-bouwgroep' ); ?></span></label>
								<label class="llbo-chip"><input type="checkbox" name="llb_theme_options[social_show_menu]" value="1" <?php checked( llb_theme_option_on( 'social_show_menu' ) ); ?>><span><?php echo esc_html__( 'Phone menu', 'll-bouwgroep' ); ?></span></label>
							</div>
							<div>
								<div class="llbo-prev" id="soc-prev"></div>
								<small style="color:var(--muted);font-size:12.5px"><?php echo esc_html__( 'Preview — how the icons look in the footer.', 'll-bouwgroep' ); ?></small>
							</div>
						</div>
					</div>
				</section>

				<section class="llbo-panel" id="p-seo" role="tabpanel">
					<h2 class="llbo-ptitle"><?php echo esc_html__( 'SEO', 'll-bouwgroep' ); ?></h2>
					<p class="llbo-pdesc"><?php echo esc_html__( 'Help Google understand the company and the page structure.', 'll-bouwgroep' ); ?></p>

					<?php if ( '' !== $seo_plugin ) : ?>
						<div class="llbo-note llbo-note--info"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h0"/></svg><span>
							<?php
							printf(
								/* translators: %s: SEO plugin name. */
								esc_html__( '%s is active: it provides the breadcrumb trail and its structured data. The theme only adds the styling.', 'll-bouwgroep' ),
								esc_html( $seo_plugin )
							);
							?>
						</span></div>
					<?php endif; ?>

					<div class="llbo-card">
						<div class="llbo-card-h">
							<div class="llbo-card-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-6h6v6"/></svg></div>
							<div class="llbo-card-t">
								<h3><?php echo esc_html__( 'Local business data', 'll-bouwgroep' ); ?> <?php llb_theme_options_badge( 'schema_local_business' ); ?></h3>
								<p><?php echo esc_html__( 'Tells Google the company name, address, phone, opening hours and social profiles (GeneralContractor). Important for local search.', 'll-bouwgroep' ); ?></p>
							</div>
							<?php llb_theme_options_switch( 'schema_local_business', __( 'Local business data', 'll-bouwgroep' ) ); ?>
						</div>
						<div class="llbo-card-b"<?php echo llb_theme_option_on( 'schema_local_business' ) ? '' : ' hidden'; ?>>
							<div class="llbo-f">
								<label for="llbo-area"><?php echo esc_html__( 'Area served', 'll-bouwgroep' ); ?></label>
								<div>
									<input id="llbo-area" type="text" name="llb_theme_options[schema_area_served]" value="<?php echo esc_attr( (string) llb_theme_option( 'schema_area_served' ) ); ?>">
									<small><?php echo esc_html__( 'Dutch. Company details come from Appearance → Customize.', 'll-bouwgroep' ); ?></small>
								</div>
							</div>
						</div>
					</div>

					<div class="llbo-card">
						<div class="llbo-card-h">
							<div class="llbo-card-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12h4M10 12h4M17 12h4M6 9l3 3-3 3M13 9l3 3-3 3"/></svg></div>
							<div class="llbo-card-t">
								<h3><?php echo esc_html__( 'Breadcrumbs', 'll-bouwgroep' ); ?> <?php llb_theme_options_badge( 'breadcrumbs' ); ?></h3>
								<p><?php echo esc_html__( 'A small trail above the page title (Home / Diensten / Stucwerk) on every page except the homepage.', 'll-bouwgroep' ); ?></p>
							</div>
							<?php llb_theme_options_switch( 'breadcrumbs', __( 'Breadcrumbs', 'll-bouwgroep' ) ); ?>
						</div>
					</div>
				</section>

				<section class="llbo-panel" id="p-maint" role="tabpanel">
					<h2 class="llbo-ptitle"><?php echo esc_html__( 'Maintenance', 'll-bouwgroep' ); ?></h2>
					<p class="llbo-pdesc"><?php echo esc_html__( 'Show a holding page to visitors while you work on the website. Logged-in administrators always see the normal website.', 'll-bouwgroep' ); ?></p>

					<div class="llbo-card">
						<div class="llbo-card-h">
							<div class="llbo-card-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18v3h3l6.3-6.3a4 4 0 0 0 5.4-5.4l-2.5 2.5-2.4-.6-.6-2.4z"/></svg></div>
							<div class="llbo-card-t">
								<h3><?php echo esc_html__( 'Maintenance mode', 'll-bouwgroep' ); ?> <?php llb_theme_options_badge( 'maintenance_enabled' ); ?></h3>
								<p><?php echo esc_html__( 'Visitors see the holding page. Google is told the site is temporarily unavailable, so rankings are not harmed.', 'll-bouwgroep' ); ?></p>
							</div>
							<?php llb_theme_options_switch( 'maintenance_enabled', __( 'Maintenance mode', 'll-bouwgroep' ) ); ?>
						</div>
						<div class="llbo-card-b"<?php echo llb_theme_option_on( 'maintenance_enabled' ) ? '' : ' hidden'; ?>>
							<div class="llbo-f">
								<label for="llbo-m-h"><?php echo esc_html__( 'Heading', 'll-bouwgroep' ); ?></label>
								<input id="llbo-m-h" type="text" name="llb_theme_options[maintenance_heading]" value="<?php echo esc_attr( (string) llb_theme_option( 'maintenance_heading' ) ); ?>">
							</div>
							<div class="llbo-f">
								<label for="llbo-m-t"><?php echo esc_html__( 'Text', 'll-bouwgroep' ); ?></label>
								<div>
									<input id="llbo-m-t" type="text" name="llb_theme_options[maintenance_text]" value="<?php echo esc_attr( (string) llb_theme_option( 'maintenance_text' ) ); ?>">
									<small><?php echo esc_html__( 'Logo, phone and e-mail are added automatically.', 'll-bouwgroep' ); ?></small>
								</div>
							</div>
							<div class="llbo-f">
								<label><?php echo esc_html__( 'Client preview link', 'll-bouwgroep' ); ?></label>
								<div>
									<?php if ( '' !== $preview_url ) : ?>
										<div class="llbo-copy">
											<code><?php echo esc_html( $preview_url ); ?></code>
											<button type="button" class="llbo-btn" data-copy><?php echo esc_html__( 'Copy', 'll-bouwgroep' ); ?></button>
											<button type="submit" class="llbo-btn" form="llbo-regen-token"><?php echo esc_html__( 'New link', 'll-bouwgroep' ); ?></button>
										</div>
									<?php else : ?>
										<p><small><?php echo esc_html__( 'No preview token yet. One is created automatically when you turn maintenance mode on.', 'll-bouwgroep' ); ?></small></p>
										<button type="submit" class="llbo-btn" form="llbo-regen-token"><?php echo esc_html__( 'New link', 'll-bouwgroep' ); ?></button>
									<?php endif; ?>
									<small><?php echo esc_html__( 'Anyone with this link can see the real website for 7 days, without an account.', 'll-bouwgroep' ); ?></small>
								</div>
							</div>
						</div>
					</div>
				</section>

				<section class="llbo-panel" id="p-ann" role="tabpanel">
					<h2 class="llbo-ptitle"><?php echo esc_html__( 'Announcement', 'll-bouwgroep' ); ?></h2>
					<p class="llbo-pdesc"><?php echo esc_html__( 'A thin bar above the header for short news, like holiday closing days.', 'll-bouwgroep' ); ?></p>

					<div class="llbo-card">
						<div class="llbo-card-h">
							<div class="llbo-card-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11v2a1 1 0 0 0 1 1h2l5 4V6L6 10H4a1 1 0 0 0-1 1zM15 9a3 3 0 0 1 0 6M18 6a7 7 0 0 1 0 12"/></svg></div>
							<div class="llbo-card-t">
								<h3><?php echo esc_html__( 'Announcement bar', 'll-bouwgroep' ); ?> <?php llb_theme_options_badge( 'announcement_enabled' ); ?></h3>
								<p><?php echo esc_html__( 'Visitors can close it; the choice is remembered for that message.', 'll-bouwgroep' ); ?></p>
							</div>
							<?php llb_theme_options_switch( 'announcement_enabled', __( 'Announcement bar', 'll-bouwgroep' ) ); ?>
						</div>
						<div class="llbo-card-b"<?php echo llb_theme_option_on( 'announcement_enabled' ) ? '' : ' hidden'; ?>>
							<div class="llbo-f">
								<label for="llbo-a-t"><?php echo esc_html__( 'Text', 'll-bouwgroep' ); ?></label>
								<input id="llbo-a-t" type="text" name="llb_theme_options[announcement_text]" value="<?php echo esc_attr( (string) llb_theme_option( 'announcement_text' ) ); ?>" placeholder="<?php echo esc_attr__( 'Wij zijn gesloten van 24 t/m 26 december.', 'll-bouwgroep' ); ?>">
							</div>
							<div class="llbo-f">
								<label><?php echo esc_html__( 'Link (optional)', 'll-bouwgroep' ); ?></label>
								<div class="llbo-row2">
									<input type="url" name="llb_theme_options[announcement_link]" value="<?php echo esc_attr( llb_theme_option_text( 'announcement_link' ) ); ?>" placeholder="https://" aria-label="<?php echo esc_attr__( 'Link', 'll-bouwgroep' ); ?>">
									<input type="text" name="llb_theme_options[announcement_link_text]" value="<?php echo esc_attr( (string) llb_theme_option( 'announcement_link_text' ) ); ?>" placeholder="<?php echo esc_attr__( 'Lees meer', 'll-bouwgroep' ); ?>" aria-label="<?php echo esc_attr__( 'Link text', 'll-bouwgroep' ); ?>">
								</div>
							</div>
							<div class="llbo-f">
								<label><?php echo esc_html__( 'Show between (optional)', 'll-bouwgroep' ); ?></label>
								<div class="llbo-row2">
									<input type="date" name="llb_theme_options[announcement_start]" value="<?php echo esc_attr( llb_theme_option_text( 'announcement_start' ) ); ?>" aria-label="<?php echo esc_attr__( 'Start date', 'll-bouwgroep' ); ?>">
									<input type="date" name="llb_theme_options[announcement_end]" value="<?php echo esc_attr( llb_theme_option_text( 'announcement_end' ) ); ?>" aria-label="<?php echo esc_attr__( 'End date', 'll-bouwgroep' ); ?>">
								</div>
							</div>
						</div>
					</div>
				</section>

				<section class="llbo-panel" id="p-track" role="tabpanel">
					<h2 class="llbo-ptitle"><?php echo esc_html__( 'Tracking', 'll-bouwgroep' ); ?></h2>
					<p class="llbo-pdesc"><?php echo esc_html__( 'Extra third-party code. Each snippet only runs after the visitor accepted cookies for its category.', 'll-bouwgroep' ); ?></p>

					<div class="llbo-note llbo-note--info"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h0"/></svg><span><?php
						echo wp_kses(
							__( 'Google Analytics and Search Console are managed in <b>Site Kit by Google</b> — do not add them here.', 'll-bouwgroep' ),
							array( 'b' => array() )
						);
					?></span></div>

					<?php if ( ! $has_consent ) : ?>
						<div class="llbo-note llbo-note--warn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l10 18H2zM12 10v4M12 17h0"/></svg><span><?php
							echo esc_html(
								$has_tracking
									? __( 'No cookie consent plugin found. Install Complianz first; until then these snippets are never printed.', 'll-bouwgroep' )
									: __( 'No cookie consent plugin found. Install Complianz first; until then these snippets are never printed.', 'll-bouwgroep' )
							);
						?></span></div>
					<?php endif; ?>

					<div class="llbo-card">
						<div class="llbo-card-b" style="border-top:0">
							<div class="llbo-f">
								<label for="llbo-t-h"><?php echo esc_html__( 'In <head>', 'll-bouwgroep' ); ?></label>
								<div>
									<textarea id="llbo-t-h" name="llb_theme_options[tracking_head]" placeholder="<script>…</script>"><?php echo esc_textarea( (string) llb_theme_option( 'tracking_head' ) ); ?></textarea>
									<div class="llbo-row2" style="margin-top:8px">
										<select name="llb_theme_options[tracking_head_category]" aria-label="<?php echo esc_attr__( 'Consent category', 'll-bouwgroep' ); ?>">
											<?php foreach ( llb_theme_options_consent_categories() as $slug => $title ) : ?>
												<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( (string) llb_theme_option( 'tracking_head_category' ), $slug ); ?>><?php echo esc_html( $title ); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="llbo-f">
								<label for="llbo-t-b"><?php echo esc_html__( 'After <body>', 'll-bouwgroep' ); ?></label>
								<div>
									<textarea id="llbo-t-b" name="llb_theme_options[tracking_body]"><?php echo esc_textarea( (string) llb_theme_option( 'tracking_body' ) ); ?></textarea>
									<div class="llbo-row2" style="margin-top:8px">
										<select name="llb_theme_options[tracking_body_category]" aria-label="<?php echo esc_attr__( 'Consent category', 'll-bouwgroep' ); ?>">
											<?php foreach ( llb_theme_options_consent_categories() as $slug => $title ) : ?>
												<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( (string) llb_theme_option( 'tracking_body_category' ), $slug ); ?>><?php echo esc_html( $title ); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="llbo-f">
								<label for="llbo-t-f"><?php echo esc_html__( 'Before </body>', 'll-bouwgroep' ); ?></label>
								<div>
									<textarea id="llbo-t-f" name="llb_theme_options[tracking_footer]"><?php echo esc_textarea( (string) llb_theme_option( 'tracking_footer' ) ); ?></textarea>
									<div class="llbo-row2" style="margin-top:8px">
										<select name="llb_theme_options[tracking_footer_category]" aria-label="<?php echo esc_attr__( 'Consent category', 'll-bouwgroep' ); ?>">
											<?php foreach ( llb_theme_options_consent_categories() as $slug => $title ) : ?>
												<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( (string) llb_theme_option( 'tracking_footer_category' ), $slug ); ?>><?php echo esc_html( $title ); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<section class="llbo-panel" id="p-brand" role="tabpanel">
					<h2 class="llbo-ptitle"><?php echo esc_html__( 'Branding', 'll-bouwgroep' ); ?></h2>
					<p class="llbo-pdesc"><?php echo esc_html__( 'The login screen always uses the company logo and colors.', 'll-bouwgroep' ); ?></p>

					<div class="llbo-card">
						<div class="llbo-card-b" style="border-top:0">
							<div class="llbo-f">
								<label for="llbo-b-f"><?php echo esc_html__( 'Dashboard footer text', 'll-bouwgroep' ); ?></label>
								<div>
									<input id="llbo-b-f" type="text" name="llb_theme_options[admin_footer_text]" value="<?php echo esc_attr( (string) llb_theme_option( 'admin_footer_text' ) ); ?>">
									<small><?php echo esc_html__( 'Shown at the bottom of every dashboard screen.', 'll-bouwgroep' ); ?></small>
								</div>
							</div>
							<div class="llbo-f">
								<label><?php echo esc_html__( 'Login screen', 'll-bouwgroep' ); ?></label>
								<div>
									<a class="llbo-btn" href="<?php echo esc_url( wp_login_url() ); ?>" target="_blank" rel="noopener">
										<?php echo esc_html__( 'Preview login screen', 'll-bouwgroep' ); ?>
										<?php echo $ext_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
									</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</form>

			<form id="llbo-regen-token" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" hidden>
				<input type="hidden" name="action" value="llb_regenerate_maintenance_token" />
				<?php wp_nonce_field( 'llb_regenerate_maintenance_token' ); ?>
			</form>

			<section class="llbo-panel" id="p-import" role="tabpanel">
				<h2 class="llbo-ptitle"><?php echo esc_html__( 'Import content', 'll-bouwgroep' ); ?></h2>
				<p class="llbo-pdesc"><?php echo esc_html__( 'Creates the pages, services, FAQ and menus with the default Dutch content. Items that already exist are skipped — nothing is overwritten.', 'll-bouwgroep' ); ?></p>

				<?php if ( is_array( $import_result ) ) : ?>
					<div class="llbo-card">
						<div class="llbo-card-b" style="border-top:0">
							<p><strong><?php echo esc_html__( 'Import finished.', 'll-bouwgroep' ); ?></strong></p>
							<ul>
								<?php foreach ( $import_result['created'] as $item ) : ?>
									<li><?php echo esc_html( sprintf( /* translators: %s: item label */ __( 'Created: %s', 'll-bouwgroep' ), $item ) ); ?></li>
								<?php endforeach; ?>
								<?php foreach ( $import_result['skipped'] as $item ) : ?>
									<li><?php echo esc_html( sprintf( /* translators: %s: item label */ __( 'Skipped: %s', 'll-bouwgroep' ), $item ) ); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				<?php endif; ?>

				<div class="llbo-card">
					<div class="llbo-card-h">
						<div class="llbo-card-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12M7 10l5 5 5-5M4 21h16"/></svg></div>
						<div class="llbo-card-t">
							<h3><?php echo esc_html__( 'Default content', 'll-bouwgroep' ); ?></h3>
							<p><?php echo esc_html__( 'Safe to run again at any time.', 'll-bouwgroep' ); ?></p>
						</div>
						<form method="post">
							<?php wp_nonce_field( 'llb_import_content' ); ?>
							<button class="llbo-btn llbo-btn--red" type="submit" name="llb_import_content" value="1"><?php echo esc_html__( 'Import default content', 'll-bouwgroep' ); ?></button>
						</form>
					</div>
				</div>
			</section>
			</div><!-- .llbo-main -->
		</div>

		<footer class="llbo-credit">
			<img src="<?php echo esc_url( llb_asset( 'images/ogc-newfinity-logo.webp' ) ); ?>" alt="OGC NewFinity">
			<span><?php
				echo wp_kses(
					sprintf(
						/* translators: %s: agency website URL. */
						__( 'Theme designed & developed by <b>OGC NewFinity</b> · <a href="%s" target="_blank" rel="noopener">ogcnewfinity.com</a>', 'll-bouwgroep' ),
						esc_url( 'https://ogcnewfinity.com/' )
					),
					array(
						'b' => array(),
						'a' => array(
							'href'   => array(),
							'target' => array(),
							'rel'    => array(),
						),
					)
				);
			?></span>
			<span class="llbo-v"><?php echo esc_html( sprintf( /* translators: %s: theme version */ __( 'Version %s', 'll-bouwgroep' ), LLB_VERSION ) ); ?></span>
		</footer>
	</div>

	<div class="llbo-savebar" id="savebar">
		<p><?php echo esc_html__( 'You have unsaved changes', 'll-bouwgroep' ); ?></p>
		<button class="llbo-btn" type="button" id="discard"><?php echo esc_html__( 'Discard', 'll-bouwgroep' ); ?></button>
		<button class="llbo-btn llbo-btn--red" type="button" id="save"><?php echo esc_html__( 'Save changes', 'll-bouwgroep' ); ?></button>
	</div>
	<div class="llbo-toast" id="toast"><?php echo esc_html__( 'Settings saved', 'll-bouwgroep' ); ?></div>
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

	$not_in               = isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array();
	$not_in[]             = $page_id;
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
