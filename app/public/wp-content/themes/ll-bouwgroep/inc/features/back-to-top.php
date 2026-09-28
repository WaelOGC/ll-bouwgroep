<?php
/**
 * Back to top button and the shared floating button stack.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the back to top button is enabled.
 *
 * @return bool
 */
function llb_back_to_top_enabled() {
	return llb_theme_option_on( 'back_to_top' );
}

/**
 * Returns the back to top button markup.
 *
 * @return string
 */
function llb_back_to_top_html() {
	if ( ! llb_back_to_top_enabled() ) {
		return '';
	}

	$svg = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5"/><path d="m5 12 7-7 7 7"/></svg>';

	return sprintf(
		'<button type="button" class="llb-fab llb-fab--top" id="llb-back-to-top" aria-label="%1$s" hidden>%2$s</button>',
		esc_attr( 'Terug naar boven' ),
		$svg
	);
}

/**
 * Prints the floating button stack once, in the bottom-right corner.
 *
 * @return void
 */
function llb_render_float_stack() {
	$buttons = array();

	if ( function_exists( 'llb_whatsapp_button_html' ) ) {
		$whatsapp = llb_whatsapp_button_html();
		if ( '' !== $whatsapp ) {
			$buttons[] = $whatsapp;
		}
	}

	$back_to_top = llb_back_to_top_html();
	if ( '' !== $back_to_top ) {
		$buttons[] = $back_to_top;
	}

	if ( empty( $buttons ) ) {
		return;
	}

	echo '<div class="llb-float-stack">' . implode( '', $buttons ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in the builders above.
}
add_action( 'wp_footer', 'llb_render_float_stack', 5 );

/**
 * Adds a body class while the back to top button is enabled.
 *
 * @param array<int, string> $classes Body classes.
 * @return array<int, string>
 */
function llb_back_to_top_body_class( $classes ) {
	if ( llb_back_to_top_enabled() ) {
		$classes[] = 'llb-has-back-to-top';
	}

	return $classes;
}
add_filter( 'body_class', 'llb_back_to_top_body_class' );
