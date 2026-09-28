<?php
/**
 * Theme Options (top-level admin menu).
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
 * Every admin page submits one section only; all other keys are preserved on save.
 *
 * @return array<string, array<int, string>>
 */
function llb_theme_options_sections() {
	return array(
		'general'      => array( 'animations', 'projects', 'back_to_top' ),
		'contact'      => array( 'whatsapp_enabled', 'whatsapp_number', 'whatsapp_message', 'mobile_bar_enabled', 'mobile_bar_call_text', 'mobile_bar_quote_text' ),
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
 * Sanitizes Theme Options on save, preserving keys owned by other admin pages.
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

	if ( ! isset( $sections[ $section ] ) ) {
		return $out;
	}

	$types = llb_theme_options_types();

	foreach ( $sections[ $section ] as $key ) {
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

	if ( 'maintenance' === $section && ! empty( $out['maintenance_enabled'] ) && '' === trim( (string) $out['maintenance_preview_token'] ) ) {
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
 * Admin sub-pages under the Theme Options parent menu.
 *
 * @return array<int, array{slug:string, title:string, callback:string}>
 */
function llb_theme_options_pages() {
	return array(
		array(
			'slug'     => 'llb-theme-options',
			'title'    => __( 'General', 'll-bouwgroep' ),
			'callback' => 'llb_render_theme_options_page',
		),
		array(
			'slug'     => 'llb-to-contact',
			'title'    => __( 'Contact buttons', 'll-bouwgroep' ),
			'callback' => 'llb_render_contact_options_page',
		),
		array(
			'slug'     => 'llb-to-seo',
			'title'    => __( 'SEO', 'll-bouwgroep' ),
			'callback' => 'llb_render_seo_options_page',
		),
		array(
			'slug'     => 'llb-to-maintenance',
			'title'    => __( 'Maintenance', 'll-bouwgroep' ),
			'callback' => 'llb_render_maintenance_options_page',
		),
		array(
			'slug'     => 'llb-to-announcement',
			'title'    => __( 'Announcement', 'll-bouwgroep' ),
			'callback' => 'llb_render_announcement_options_page',
		),
		array(
			'slug'     => 'llb-to-tracking',
			'title'    => __( 'Tracking', 'll-bouwgroep' ),
			'callback' => 'llb_render_tracking_options_page',
		),
		array(
			'slug'     => 'llb-to-branding',
			'title'    => __( 'Branding', 'll-bouwgroep' ),
			'callback' => 'llb_render_branding_options_page',
		),
	);
}

/**
 * Registers Theme Options as a top-level admin menu with one sub-page per section.
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

	foreach ( llb_theme_options_pages() as $page ) {
		add_submenu_page(
			'llb-theme-options',
			$page['title'],
			$page['title'],
			'manage_options',
			$page['slug'],
			$page['callback']
		);
	}
}
add_action( 'admin_menu', 'llb_add_theme_options_page' );

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
 * Redirects legacy Appearance URLs to the new Theme Options screens.
 *
 * @return void
 */
function llb_redirect_legacy_theme_option_pages() {
	if ( ! is_admin() || empty( $_GET['page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only redirect.
		return;
	}

	$page = sanitize_key( wp_unslash( $_GET['page'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! llb_is_theme_options_screen( $page ) ) {
		return;
	}

	$target = admin_url( 'admin.php?page=' . $page );

	// Already on the new URL.
	global $pagenow;
	if ( 'admin.php' === $pagenow ) {
		return;
	}

	wp_safe_redirect( $target );
	exit;
}
add_action( 'admin_init', 'llb_redirect_legacy_theme_option_pages', 1 );
add_action( 'admin_page_access_denied', 'llb_redirect_legacy_theme_option_pages' );

/**
 * Enqueues admin CSS for the Theme Options switches.
 *
 * @param string $hook Current admin page hook.
 * @return void
 */
function llb_enqueue_theme_options_assets( $hook ) {
	unset( $hook );

	$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only screen check.
	if ( ! llb_is_theme_options_screen( $page ) ) {
		return;
	}

	$css = '
		.llb-to-wrap{max-width:880px}
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
		.llb-to-intro{margin:8px 0 4px;max-width:70ch;color:#3c434a}
		.llb-to-fields{margin-top:8px}
		.llb-to-fields .form-table th{width:220px;padding-left:0}
		.llb-to-fields .form-table td p.description{max-width:60ch}
		.llb-to-fields input[type=text],.llb-to-fields input[type=url],.llb-to-fields textarea{max-width:520px;width:100%}
		.llb-to-fields input[type=date]{max-width:220px}
		.llb-to-fields textarea.llb-to-code{font-family:Consolas,Monaco,monospace;font-size:12px;line-height:1.5;max-width:640px}
		.llb-to-section{margin-top:28px;padding-top:4px;border-top:1px solid #dcdcde}
		.llb-to-section h2{font-size:15px;margin:20px 0 0}
		.llb-to-preview{background:#fff;border:1px solid #dcdcde;border-radius:4px;padding:14px 16px;margin:16px 0;max-width:700px}
		.llb-to-preview code{display:inline-block;word-break:break-all;padding:2px 6px}
		.llb-to-preview p{margin:0 0 10px}
		.llb-to-preview p:last-child{margin-bottom:0}
	';

	wp_register_style( 'llb-theme-options', false, array(), LLB_VERSION );
	wp_enqueue_style( 'llb-theme-options' );
	wp_add_inline_style( 'llb-theme-options', $css );
}
add_action( 'admin_enqueue_scripts', 'llb_enqueue_theme_options_assets' );

/**
 * Opens a Theme Options form for one section.
 *
 * @param string $section Section key.
 * @return void
 */
function llb_theme_options_form_open( $section ) {
	?>
	<form method="post" action="options.php">
		<?php settings_fields( 'llb_theme_options_group' ); ?>
		<input type="hidden" name="llb_theme_options[_section]" value="<?php echo esc_attr( $section ); ?>" />
	<?php
}

/**
 * Closes a Theme Options form.
 *
 * @return void
 */
function llb_theme_options_form_close() {
	submit_button( __( 'Save Changes', 'll-bouwgroep' ) );
	echo '</form>';
}

/**
 * Opens a form table for text-style fields.
 *
 * @param string $heading Optional heading above the table.
 * @return void
 */
function llb_theme_options_table_open( $heading = '' ) {
	echo '<div class="llb-to-fields">';
	if ( '' !== $heading ) {
		echo '<h2>' . esc_html( $heading ) . '</h2>';
	}
	echo '<table class="form-table" role="presentation"><tbody>';
}

/**
 * Closes a form table.
 *
 * @return void
 */
function llb_theme_options_table_close() {
	echo '</tbody></table></div>';
}

/**
 * Renders one text-style field row inside a form table.
 *
 * @param string               $key  Option key.
 * @param string               $label Field label.
 * @param array<string, mixed> $args  Optional: desc, placeholder, rows, class, options.
 * @return void
 */
function llb_theme_options_render_field( $key, $label, $args = array() ) {
	$types = llb_theme_options_types();
	$type  = isset( $types[ $key ] ) ? $types[ $key ] : 'text';
	$value = (string) llb_theme_option( $key );
	$id    = 'llb_theme_option_' . $key;
	$name  = 'llb_theme_options[' . $key . ']';

	$desc        = isset( $args['desc'] ) ? (string) $args['desc'] : '';
	$placeholder = isset( $args['placeholder'] ) ? (string) $args['placeholder'] : '';
	$rows        = isset( $args['rows'] ) ? (int) $args['rows'] : 4;
	?>
	<tr>
		<th scope="row"><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td>
			<?php if ( 'textarea' === $type || 'code' === $type ) : ?>
				<textarea
					id="<?php echo esc_attr( $id ); ?>"
					name="<?php echo esc_attr( $name ); ?>"
					rows="<?php echo esc_attr( (string) $rows ); ?>"
					class="large-text<?php echo 'code' === $type ? ' llb-to-code' : ''; ?>"
					placeholder="<?php echo esc_attr( $placeholder ); ?>"
				><?php echo esc_textarea( $value ); ?></textarea>
			<?php elseif ( 'consent' === $type ) : ?>
				<select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
					<?php foreach ( llb_theme_options_consent_categories() as $slug => $title ) : ?>
						<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $value, $slug ); ?>><?php echo esc_html( $title ); ?></option>
					<?php endforeach; ?>
				</select>
			<?php else : ?>
				<?php
				$input_type = 'text';
				if ( 'url' === $type ) {
					$input_type = 'url';
				} elseif ( 'date' === $type ) {
					$input_type = 'date';
				} elseif ( 'tel' === $type ) {
					$input_type = 'tel';
				}
				?>
				<input
					type="<?php echo esc_attr( $input_type ); ?>"
					id="<?php echo esc_attr( $id ); ?>"
					name="<?php echo esc_attr( $name ); ?>"
					value="<?php echo esc_attr( $value ); ?>"
					class="regular-text"
					placeholder="<?php echo esc_attr( $placeholder ); ?>"
				/>
			<?php endif; ?>
			<?php if ( '' !== $desc ) : ?>
				<p class="description"><?php echo esc_html( $desc ); ?></p>
			<?php endif; ?>
		</td>
	</tr>
	<?php
}

/**
 * Renders a toggle row.
 *
 * @param string $key   Option key.
 * @param string $label Label.
 * @param string $desc  Description.
 * @return void
 */
function llb_theme_options_render_toggle( $key, $label, $desc ) {
	$checked = llb_theme_option_on( $key );
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
		<h1><?php echo esc_html__( 'Theme Options — General', 'll-bouwgroep' ); ?></h1>

		<?php if ( ! $projects_on ) : ?>
			<div class="notice notice-warning llb-to-notice"><p><?php echo esc_html__( 'Projects are hidden on the website.', 'll-bouwgroep' ); ?></p></div>
		<?php endif; ?>
		<?php if ( ! $animations_on ) : ?>
			<div class="notice notice-info llb-to-notice"><p><?php echo esc_html__( 'Animations are turned off on the website.', 'll-bouwgroep' ); ?></p></div>
		<?php endif; ?>
		<?php if ( $projects_on && $animations_on ) : ?>
			<div class="notice notice-success llb-to-notice"><p><?php echo esc_html__( 'Animations and projects are both enabled on the website.', 'll-bouwgroep' ); ?></p></div>
		<?php endif; ?>

		<?php llb_theme_options_form_open( 'general' ); ?>
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
			llb_theme_options_render_toggle(
				'back_to_top',
				__( 'Back to top button', 'll-bouwgroep' ),
				__( 'Show a round button in the bottom-right corner after the visitor scrolls down, to jump back to the top of the page.', 'll-bouwgroep' )
			);
			?>
		<?php llb_theme_options_form_close(); ?>
	</div>
	<?php
}

/**
 * Renders the Contact buttons admin page.
 *
 * @return void
 */
function llb_render_contact_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$phone = trim( (string) llb_get_option( 'llb_phone' ) );
	?>
	<div class="wrap llb-to-wrap">
		<h1><?php echo esc_html__( 'Theme Options — Contact buttons', 'll-bouwgroep' ); ?></h1>
		<p class="llb-to-intro"><?php echo esc_html__( 'Floating WhatsApp button and the fixed contact bar that only shows on phones.', 'll-bouwgroep' ); ?></p>

		<?php if ( llb_theme_option_on( 'whatsapp_enabled' ) && '' === llb_theme_option_text( 'whatsapp_number' ) ) : ?>
			<div class="notice notice-warning llb-to-notice"><p><?php echo esc_html__( 'WhatsApp is enabled but no number is set, so the button stays hidden.', 'll-bouwgroep' ); ?></p></div>
		<?php endif; ?>
		<?php if ( llb_theme_option_on( 'mobile_bar_enabled' ) && '' === $phone ) : ?>
			<div class="notice notice-warning llb-to-notice"><p><?php echo esc_html__( 'The mobile contact bar uses the phone number from Customizer → L&L Bouwgroep → Company & contact. That field is still empty.', 'll-bouwgroep' ); ?></p></div>
		<?php endif; ?>

		<?php llb_theme_options_form_open( 'contact' ); ?>
			<?php
			llb_theme_options_render_toggle(
				'whatsapp_enabled',
				__( 'WhatsApp button', 'll-bouwgroep' ),
				__( 'Show a round WhatsApp button in the bottom-right corner on every page.', 'll-bouwgroep' )
			);

			llb_theme_options_table_open();
			llb_theme_options_render_field(
				'whatsapp_number',
				__( 'WhatsApp number', 'll-bouwgroep' ),
				array(
					'placeholder' => '+31612345678',
					'desc'        => __( 'International format, for example +31612345678. Leave empty to hide the button.', 'll-bouwgroep' ),
				)
			);
			llb_theme_options_render_field(
				'whatsapp_message',
				__( 'Pre-filled message', 'll-bouwgroep' ),
				array( 'desc' => __( 'Dutch text the visitor sees pre-filled in WhatsApp.', 'll-bouwgroep' ) )
			);
			llb_theme_options_table_close();
			?>

			<div class="llb-to-section">
				<?php
				llb_theme_options_render_toggle(
					'mobile_bar_enabled',
					__( 'Mobile contact bar', 'll-bouwgroep' ),
					__( 'Fixed bar at the bottom of the screen on phones only (under 768px) with a call button and a quote button.', 'll-bouwgroep' )
				);

				llb_theme_options_table_open();
				llb_theme_options_render_field(
					'mobile_bar_call_text',
					__( 'Call button text', 'll-bouwgroep' ),
					array( 'desc' => __( 'Dutch label. Links to the phone number from the Customizer.', 'll-bouwgroep' ) )
				);
				llb_theme_options_render_field(
					'mobile_bar_quote_text',
					__( 'Quote button text', 'll-bouwgroep' ),
					array( 'desc' => __( 'Dutch label. Links to the contact page.', 'll-bouwgroep' ) )
				);
				llb_theme_options_table_close();
				?>
			</div>
		<?php llb_theme_options_form_close(); ?>
	</div>
	<?php
}

/**
 * Renders the SEO admin page.
 *
 * @return void
 */
function llb_render_seo_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$seo_plugin = llb_active_seo_plugin_name();
	?>
	<div class="wrap llb-to-wrap">
		<h1><?php echo esc_html__( 'Theme Options — SEO', 'll-bouwgroep' ); ?></h1>
		<p class="llb-to-intro"><?php echo esc_html__( 'Business data structured for search engines, and breadcrumbs on inner pages.', 'll-bouwgroep' ); ?></p>

		<?php if ( '' !== $seo_plugin ) : ?>
			<div class="notice notice-info llb-to-notice">
				<p>
					<?php
					printf(
						/* translators: %s: SEO plugin name. */
						esc_html__( '%s is active, so it provides the breadcrumb trail and the breadcrumb structured data. The theme only supplies the styling.', 'll-bouwgroep' ),
						esc_html( $seo_plugin )
					);
					?>
				</p>
			</div>
		<?php endif; ?>

		<?php llb_theme_options_form_open( 'seo' ); ?>
			<?php
			llb_theme_options_render_toggle(
				'schema_local_business',
				__( 'Local business structured data', 'll-bouwgroep' ),
				__( 'Output GeneralContractor JSON-LD on every page with the company name, address, phone, opening hours and social profiles from the Customizer.', 'll-bouwgroep' )
			);
			llb_theme_options_render_toggle(
				'breadcrumbs',
				__( 'Breadcrumbs', 'll-bouwgroep' ),
				__( 'Show a breadcrumb trail above the page title on all pages except the homepage.', 'll-bouwgroep' )
			);

			llb_theme_options_table_open();
			llb_theme_options_render_field(
				'schema_area_served',
				__( 'Area served', 'll-bouwgroep' ),
				array( 'desc' => __( 'Region shown in the structured data, in Dutch. For example: Zoetermeer en omgeving.', 'll-bouwgroep' ) )
			);
			llb_theme_options_table_close();
			?>
		<?php llb_theme_options_form_close(); ?>
	</div>
	<?php
}

/**
 * Renders the Maintenance admin page.
 *
 * @return void
 */
function llb_render_maintenance_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$enabled = llb_theme_option_on( 'maintenance_enabled' );
	$token   = llb_theme_option_text( 'maintenance_preview_token' );
	?>
	<div class="wrap llb-to-wrap">
		<h1><?php echo esc_html__( 'Theme Options — Maintenance', 'll-bouwgroep' ); ?></h1>
		<p class="llb-to-intro"><?php echo esc_html__( 'Show a branded holding page to visitors while you keep working on the site. Logged-in administrators always see the normal website.', 'll-bouwgroep' ); ?></p>

		<?php if ( $enabled ) : ?>
			<div class="notice notice-warning llb-to-notice"><p><?php echo esc_html__( 'Maintenance mode is ON. Visitors see the holding page and search engines get a 503 response.', 'll-bouwgroep' ); ?></p></div>
		<?php endif; ?>

		<?php llb_theme_options_form_open( 'maintenance' ); ?>
			<?php
			llb_theme_options_render_toggle(
				'maintenance_enabled',
				__( 'Maintenance mode', 'll-bouwgroep' ),
				__( 'Visitors get the holding page with an HTTP 503 status and a noindex tag. wp-admin, the login page and the REST API stay reachable.', 'll-bouwgroep' )
			);

			llb_theme_options_table_open();
			llb_theme_options_render_field(
				'maintenance_heading',
				__( 'Heading', 'll-bouwgroep' ),
				array( 'desc' => __( 'Dutch heading on the holding page.', 'll-bouwgroep' ) )
			);
			llb_theme_options_render_field(
				'maintenance_text',
				__( 'Text', 'll-bouwgroep' ),
				array(
					'rows' => 3,
					'desc' => __( 'Dutch paragraph under the heading. Phone and e-mail come from the Customizer.', 'll-bouwgroep' ),
				)
			);
			llb_theme_options_table_close();
			?>
		<?php llb_theme_options_form_close(); ?>

		<div class="llb-to-preview">
			<h2><?php echo esc_html__( 'Preview link', 'll-bouwgroep' ); ?></h2>
			<?php if ( '' === $token ) : ?>
				<p><?php echo esc_html__( 'No preview token yet. One is created automatically when you turn maintenance mode on, or generate one now.', 'll-bouwgroep' ); ?></p>
			<?php else : ?>
				<p><?php echo esc_html__( 'Share this link with people who should see the real website while maintenance mode is on. It sets a cookie that lasts 7 days.', 'll-bouwgroep' ); ?></p>
				<p><code><?php echo esc_html( llb_maintenance_preview_url() ); ?></code></p>
			<?php endif; ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="llb_regenerate_maintenance_token" />
				<?php wp_nonce_field( 'llb_regenerate_maintenance_token' ); ?>
				<?php submit_button( __( 'Generate new preview link', 'll-bouwgroep' ), 'secondary', 'submit', false ); ?>
			</form>
		</div>
	</div>
	<?php
}

/**
 * Renders the Announcement admin page.
 *
 * @return void
 */
function llb_render_announcement_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap llb-to-wrap">
		<h1><?php echo esc_html__( 'Theme Options — Announcement', 'll-bouwgroep' ); ?></h1>
		<p class="llb-to-intro"><?php echo esc_html__( 'A thin bar above the header for short messages such as holiday closing days. Visitors can close it; the choice is remembered per message.', 'll-bouwgroep' ); ?></p>

		<?php if ( llb_theme_option_on( 'announcement_enabled' ) && '' === llb_theme_option_text( 'announcement_text' ) ) : ?>
			<div class="notice notice-warning llb-to-notice"><p><?php echo esc_html__( 'The announcement bar is enabled but the text is empty, so nothing is shown.', 'll-bouwgroep' ); ?></p></div>
		<?php endif; ?>

		<?php llb_theme_options_form_open( 'announcement' ); ?>
			<?php
			llb_theme_options_render_toggle(
				'announcement_enabled',
				__( 'Announcement bar', 'll-bouwgroep' ),
				__( 'Show the bar above the header on every page.', 'll-bouwgroep' )
			);

			llb_theme_options_table_open();
			llb_theme_options_render_field(
				'announcement_text',
				__( 'Text', 'll-bouwgroep' ),
				array( 'desc' => __( 'Dutch message. Keep it to one short sentence.', 'll-bouwgroep' ) )
			);
			llb_theme_options_render_field(
				'announcement_link',
				__( 'Link (optional)', 'll-bouwgroep' ),
				array( 'placeholder' => 'https://' )
			);
			llb_theme_options_render_field(
				'announcement_link_text',
				__( 'Link text (optional)', 'll-bouwgroep' ),
				array( 'desc' => __( 'Dutch label for the link. Without it the link is not shown.', 'll-bouwgroep' ) )
			);
			llb_theme_options_render_field(
				'announcement_start',
				__( 'Start date (optional)', 'll-bouwgroep' ),
				array( 'desc' => __( 'The bar stays hidden before this date.', 'll-bouwgroep' ) )
			);
			llb_theme_options_render_field(
				'announcement_end',
				__( 'End date (optional)', 'll-bouwgroep' ),
				array( 'desc' => __( 'The bar disappears after this date.', 'll-bouwgroep' ) )
			);
			llb_theme_options_table_close();
			?>
		<?php llb_theme_options_form_close(); ?>
	</div>
	<?php
}

/**
 * Renders the Tracking admin page.
 *
 * @return void
 */
function llb_render_tracking_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$has_code    = llb_tracking_has_any_code();
	$has_consent = llb_consent_api_available();
	?>
	<div class="wrap llb-to-wrap">
		<h1><?php echo esc_html__( 'Theme Options — Tracking', 'll-bouwgroep' ); ?></h1>
		<p class="llb-to-intro"><?php echo esc_html__( 'Extra third-party snippets. Each snippet is only printed after the visitor consented to the chosen category.', 'll-bouwgroep' ); ?></p>

		<div class="notice notice-info llb-to-notice">
			<p><?php echo esc_html__( 'Google Analytics / Search Console via Site Kit by Google are configured in Site Kit — do not add them here.', 'll-bouwgroep' ); ?></p>
		</div>

		<?php if ( ! $has_consent ) : ?>
			<div class="notice notice-<?php echo $has_code ? 'error' : 'warning'; ?> llb-to-notice">
				<p><?php echo esc_html__( 'No consent plugin found. Install a plugin that supports the WP Consent API (for example Complianz) before adding tracking code. Without it the snippets below are never printed.', 'll-bouwgroep' ); ?></p>
			</div>
		<?php endif; ?>

		<?php if ( ! current_user_can( 'unfiltered_html' ) ) : ?>
			<div class="notice notice-warning llb-to-notice"><p><?php echo esc_html__( 'Your user role may not save raw script tags, so scripts will be stripped on save.', 'll-bouwgroep' ); ?></p></div>
		<?php endif; ?>

		<?php llb_theme_options_form_open( 'tracking' ); ?>
			<?php
			llb_theme_options_table_open();
			llb_theme_options_render_field(
				'tracking_head',
				__( 'Head snippet', 'll-bouwgroep' ),
				array(
					'rows' => 6,
					'desc' => __( 'Printed inside <head>.', 'll-bouwgroep' ),
				)
			);
			llb_theme_options_render_field( 'tracking_head_category', __( 'Head consent category', 'll-bouwgroep' ) );
			llb_theme_options_render_field(
				'tracking_body',
				__( 'Body snippet', 'll-bouwgroep' ),
				array(
					'rows' => 6,
					'desc' => __( 'Printed directly after the opening <body> tag.', 'll-bouwgroep' ),
				)
			);
			llb_theme_options_render_field( 'tracking_body_category', __( 'Body consent category', 'll-bouwgroep' ) );
			llb_theme_options_render_field(
				'tracking_footer',
				__( 'Footer snippet', 'll-bouwgroep' ),
				array(
					'rows' => 6,
					'desc' => __( 'Printed just before the closing </body> tag.', 'll-bouwgroep' ),
				)
			);
			llb_theme_options_render_field( 'tracking_footer_category', __( 'Footer consent category', 'll-bouwgroep' ) );
			llb_theme_options_table_close();
			?>
		<?php llb_theme_options_form_close(); ?>
	</div>
	<?php
}

/**
 * Renders the Branding admin page.
 *
 * @return void
 */
function llb_render_branding_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap llb-to-wrap">
		<h1><?php echo esc_html__( 'Theme Options — Branding', 'll-bouwgroep' ); ?></h1>
		<p class="llb-to-intro"><?php echo esc_html__( 'The login screen always uses the theme logo and brand colors. Only the dashboard footer text is editable.', 'll-bouwgroep' ); ?></p>

		<?php llb_theme_options_form_open( 'branding' ); ?>
			<?php
			llb_theme_options_table_open();
			llb_theme_options_render_field(
				'admin_footer_text',
				__( 'Dashboard footer text', 'll-bouwgroep' ),
				array( 'desc' => __( 'Shown at the bottom left of every dashboard screen. Leave empty for the WordPress default.', 'll-bouwgroep' ) )
			);
			llb_theme_options_table_close();
			?>
		<?php llb_theme_options_form_close(); ?>
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
