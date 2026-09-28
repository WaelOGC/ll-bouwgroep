<?php
/**
 * Contact Form 7 compatibility.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Enqueues CF7 assets only on pages that need the form.
 *
 * @return void
 */
function llb_enqueue_cf7_assets() {
	if ( ! function_exists( 'wpcf7_enqueue_scripts' ) || ! function_exists( 'wpcf7_enqueue_styles' ) ) {
		return;
	}

	$load = false;

	if ( is_page() && 'page-templates/template-contact.php' === get_page_template_slug() ) {
		$load = true;
	} elseif ( is_singular() ) {
		$post = get_post();
		if ( $post && has_shortcode( $post->post_content, 'contact-form-7' ) ) {
			$load = true;
		}
	}

	if ( ! $load ) {
		return;
	}

	wpcf7_enqueue_scripts();
}
add_action( 'wp_enqueue_scripts', 'llb_enqueue_cf7_assets', 20 );

/**
 * Returns the Privacyverklaring page URL.
 *
 * @return string
 */
function llb_get_privacy_page_url() {
	$url = function_exists( 'get_privacy_policy_url' ) ? (string) get_privacy_policy_url() : '';
	if ( '' !== $url ) {
		return $url;
	}

	$page = get_page_by_path( 'privacyverklaring' );
	if ( $page instanceof WP_Post ) {
		$permalink = get_permalink( $page );
		return is_string( $permalink ) ? $permalink : '';
	}

	return home_url( '/privacyverklaring/' );
}

/**
 * Returns the default CF7 form template markup.
 *
 * @return string
 */
function llb_cf7_default_form_template() {
	$privacy_url = esc_url( llb_get_privacy_page_url() );

	return '<div class="llb-form">
  <div class="llb-form__grid">
    <label class="llb-field"><span class="llb-field__label">Naam *</span>[text* your-name autocomplete:name]</label>
    <label class="llb-field"><span class="llb-field__label">E-mailadres *</span>[email* your-email autocomplete:email]</label>
    <label class="llb-field"><span class="llb-field__label">Telefoonnummer</span>[tel your-phone autocomplete:tel]</label>
    <label class="llb-field"><span class="llb-field__label">Type werkzaamheden *</span>[select* your-service include_blank "Badkamers & toiletten" "Renovatie en verbouwing" "Stucwerk" "Tegelwerk" "Timmerwerk" "Schilder- en afbouwwerk" "Keukenverbouwingen" "Aan- en uitbouw" "Overige bouwkundige werkzaamheden"]</label>
    <label class="llb-field llb-field--full"><span class="llb-field__label">Bericht *</span>[textarea* your-message x5]</label>
  </div>
  <div class="llb-form__consent">[acceptance privacy-consent] Door dit formulier te versturen, gaat u akkoord met de verwerking van uw gegevens zoals beschreven in onze <a href="' . $privacy_url . '">Privacyverklaring</a>. [/acceptance]</div>
  [submit class:btn class:btn-red "Verstuur aanvraag"]
</div>';
}

/**
 * Returns the default CF7 mail property array.
 *
 * @return array<string, mixed>
 */
function llb_cf7_default_mail() {
	return array(
		'active'             => true,
		'subject'            => 'Nieuwe aanvraag: [your-service] — [your-name]',
		'sender'             => '[_site_title] <wordpress@[_site_domain]>',
		'recipient'          => '[_site_admin_email]',
		'body'               => "Naam: [your-name]\nE-mailadres: [your-email]\nTelefoonnummer: [your-phone]\nType werkzaamheden: [your-service]\n\nBericht:\n[your-message]\n\n--\nVerstuurd via het contactformulier op [_site_url]",
		'additional_headers' => 'Reply-To: [your-name] <[your-email]>',
		'attachments'        => '',
		'use_html'           => 0,
		'exclude_blank'      => 0,
	);
}

/**
 * Finds the theme-created default CF7 form post ID.
 *
 * @return int
 */
function llb_find_default_cf7_form_id() {
	$query = new WP_Query(
		array(
			'post_type'              => 'wpcf7_contact_form',
			'post_status'            => 'any',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_key'               => '_llb_default_form',
			'meta_value'             => '1',
		)
	);

	if ( empty( $query->posts[0] ) ) {
		return 0;
	}

	return (int) $query->posts[0];
}

/**
 * Builds a CF7 shortcode for a form ID.
 *
 * @param int $form_id Form post ID.
 * @return string
 */
function llb_cf7_shortcode_for_id( $form_id ) {
	$form_id = absint( $form_id );
	if ( ! $form_id ) {
		return '';
	}

	return sprintf(
		'[contact-form-7 id="%d" title="%s"]',
		$form_id,
		'Contactformulier L&L'
	);
}

/**
 * Creates the default Contact Form 7 form when missing.
 *
 * @return int Form ID or 0.
 */
function llb_create_default_cf7_form() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return 0;
	}

	$existing = llb_find_default_cf7_form_id();
	if ( $existing ) {
		return $existing;
	}

	$contact_form = WPCF7_ContactForm::get_template(
		array(
			'title' => 'Contactformulier L&L',
		)
	);

	$properties         = $contact_form->get_properties();
	$properties['form'] = llb_cf7_default_form_template();
	$properties['mail'] = array_merge(
		isset( $properties['mail'] ) && is_array( $properties['mail'] ) ? $properties['mail'] : array(),
		llb_cf7_default_mail()
	);

	$contact_form->set_properties( $properties );
	$form_id = (int) $contact_form->save();

	if ( ! $form_id ) {
		return 0;
	}

	update_post_meta( $form_id, '_llb_default_form', '1' );

	return $form_id;
}

/**
 * Ensures the default CF7 form exists once per theme version.
 *
 * @return void
 */
function llb_maybe_create_default_cf7_form() {
	if ( ! defined( 'WPCF7_VERSION' ) || ! class_exists( 'WPCF7_ContactForm' ) ) {
		return;
	}

	$stored = (string) get_option( 'llb_cf7_form_version', '' );
	if ( $stored === (string) LLB_VERSION ) {
		return;
	}

	$form_id = llb_create_default_cf7_form();
	if ( $form_id ) {
		$current = trim( (string) get_theme_mod( 'llb_cf7_shortcode', '' ) );
		if ( '' === $current ) {
			set_theme_mod( 'llb_cf7_shortcode', llb_cf7_shortcode_for_id( $form_id ) );
		}
	}

	update_option( 'llb_cf7_form_version', (string) LLB_VERSION );
}
add_action( 'admin_init', 'llb_maybe_create_default_cf7_form', 30 );

/**
 * Returns the Contact Form 7 markup from the Customizer shortcode setting.
 *
 * @return string
 */
function llb_contact_form() {
	if ( ! defined( 'WPCF7_VERSION' ) ) {
		return '';
	}

	$shortcode = trim( (string) llb_get_option( 'llb_cf7_shortcode' ) );
	if ( '' === $shortcode ) {
		return '';
	}

	if ( ! preg_match( '/^\[contact-form-7\b/i', $shortcode ) ) {
		return '';
	}

	return do_shortcode( $shortcode );
}
