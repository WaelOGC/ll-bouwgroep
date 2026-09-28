<?php
/**
 * Floating WhatsApp button and the mobile contact bar.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Digits-only WhatsApp number, or an empty string.
 *
 * @return string
 */
function llb_whatsapp_number() {
	$digits = preg_replace( '/\D/', '', llb_theme_option_text( 'whatsapp_number' ) );

	return is_string( $digits ) ? $digits : '';
}

/**
 * Whether the WhatsApp button should be rendered.
 *
 * @return bool
 */
function llb_whatsapp_enabled() {
	return llb_theme_option_on( 'whatsapp_enabled' ) && '' !== llb_whatsapp_number();
}

/**
 * Builds the wa.me link with the pre-filled message.
 *
 * @return string
 */
function llb_whatsapp_url() {
	$number = llb_whatsapp_number();
	if ( '' === $number ) {
		return '';
	}

	$url     = 'https://wa.me/' . $number;
	$message = llb_theme_option_text( 'whatsapp_message' );

	if ( '' !== $message ) {
		$url = add_query_arg( 'text', rawurlencode( $message ), $url );
	}

	return $url;
}

/**
 * Returns the WhatsApp floating button markup.
 *
 * @return string
 */
function llb_whatsapp_button_html() {
	if ( ! llb_whatsapp_enabled() ) {
		return '';
	}

	$svg = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.87 9.87 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm0 18.15h-.01a8.2 8.2 0 0 1-4.18-1.15l-.3-.18-3.11.82.83-3.04-.2-.31a8.17 8.17 0 0 1-1.25-4.38c0-4.54 3.7-8.23 8.23-8.23 2.2 0 4.26.86 5.82 2.41a8.18 8.18 0 0 1 2.41 5.82c0 4.54-3.7 8.24-8.24 8.24zm4.52-6.16c-.25-.13-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.13-.16.24-.64.8-.78.97-.14.16-.29.18-.53.06-.25-.12-1.05-.39-1.99-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.01-.38.11-.5.11-.11.25-.29.37-.43.13-.15.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.23.25-.86.85-.86 2.07s.89 2.4 1.01 2.56c.12.17 1.74 2.66 4.22 3.73.59.25 1.05.4 1.41.52.59.19 1.13.16 1.56.1.47-.07 1.47-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.06-.1-.23-.17-.48-.29z"/></svg>';

	return sprintf(
		'<a class="llb-fab llb-fab--wa" href="%1$s" target="_blank" rel="noopener noreferrer" aria-label="%2$s">%3$s</a>',
		esc_url( llb_whatsapp_url() ),
		esc_attr( 'Stuur ons een WhatsApp-bericht' ),
		$svg
	);
}

/**
 * Whether the mobile contact bar should be rendered.
 *
 * @return bool
 */
function llb_mobile_bar_enabled() {
	if ( ! llb_theme_option_on( 'mobile_bar_enabled' ) ) {
		return false;
	}

	return '' !== llb_mobile_bar_phone() || '' !== llb_mobile_bar_quote_url();
}

/**
 * Returns the tel: number for the mobile bar, or an empty string.
 *
 * @return string
 */
function llb_mobile_bar_phone() {
	$phone = preg_replace( '/[^\d+]/', '', trim( (string) llb_get_option( 'llb_phone' ) ) );

	return is_string( $phone ) ? $phone : '';
}

/**
 * Returns the quote button URL for the mobile bar.
 *
 * @return string
 */
function llb_mobile_bar_quote_url() {
	$cta = trim( (string) llb_get_option( 'llb_header_cta_url' ) );
	if ( '' !== $cta ) {
		return $cta;
	}

	return llb_page_url( 'contact' );
}

/**
 * Prints the fixed mobile contact bar.
 *
 * @return void
 */
function llb_render_mobile_bar() {
	if ( ! llb_mobile_bar_enabled() ) {
		return;
	}

	$phone      = llb_mobile_bar_phone();
	$quote_url  = llb_mobile_bar_quote_url();
	$call_text  = llb_theme_option_text( 'mobile_bar_call_text' );
	$quote_text = llb_theme_option_text( 'mobile_bar_quote_text' );

	if ( '' === $call_text ) {
		$call_text = 'Bel ons';
	}
	if ( '' === $quote_text ) {
		$quote_text = 'Offerte aanvragen';
	}
	?>
	<div class="llb-mobilebar" role="navigation" aria-label="Snel contact">
		<?php if ( '' !== $phone ) : ?>
			<a class="llb-mobilebar__btn llb-mobilebar__btn--call" href="<?php echo esc_url( 'tel:' . $phone ); ?>">
				<?php echo llb_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				<span><?php echo esc_html( $call_text ); ?></span>
			</a>
		<?php endif; ?>
		<?php if ( '' !== $quote_url ) : ?>
			<a class="llb-mobilebar__btn llb-mobilebar__btn--quote" href="<?php echo esc_url( $quote_url ); ?>">
				<span><?php echo esc_html( $quote_text ); ?></span>
			</a>
		<?php endif; ?>
	</div>
	<?php
}
add_action( 'wp_footer', 'llb_render_mobile_bar', 6 );

/**
 * Adds body classes for the floating UI so CSS can reserve space.
 *
 * @param array<int, string> $classes Body classes.
 * @return array<int, string>
 */
function llb_contact_buttons_body_class( $classes ) {
	if ( llb_whatsapp_enabled() ) {
		$classes[] = 'llb-has-whatsapp';
	}

	if ( llb_mobile_bar_enabled() ) {
		$classes[] = 'llb-has-mobile-bar';
	}

	return $classes;
}
add_filter( 'body_class', 'llb_contact_buttons_body_class' );
