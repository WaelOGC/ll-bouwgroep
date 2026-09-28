<?php
/**
 * Announcement bar above the header.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the announcement bar is active today.
 *
 * @return bool
 */
function llb_announcement_enabled() {
	if ( ! llb_theme_option_on( 'announcement_enabled' ) ) {
		return false;
	}

	if ( '' === llb_theme_option_text( 'announcement_text' ) ) {
		return false;
	}

	$today = current_time( 'Y-m-d' );
	$start = llb_theme_option_text( 'announcement_start' );
	$end   = llb_theme_option_text( 'announcement_end' );

	if ( '' !== $start && $today < $start ) {
		return false;
	}

	if ( '' !== $end && $today > $end ) {
		return false;
	}

	return true;
}

/**
 * Returns the storage key for the current message, so a new message shows again.
 *
 * @return string
 */
function llb_announcement_key() {
	$parts = array(
		llb_theme_option_text( 'announcement_text' ),
		llb_theme_option_text( 'announcement_link' ),
		llb_theme_option_text( 'announcement_link_text' ),
	);

	return 'llb-announce-' . substr( md5( implode( '|', $parts ) ), 0, 12 );
}

/**
 * Prints the announcement bar directly after the opening body tag.
 *
 * @return void
 */
function llb_render_announcement() {
	if ( ! llb_announcement_enabled() ) {
		return;
	}

	$text      = llb_theme_option_text( 'announcement_text' );
	$link      = llb_theme_option_text( 'announcement_link' );
	$link_text = llb_theme_option_text( 'announcement_link_text' );
	$key       = llb_announcement_key();
	?>
	<div class="llb-announce" id="llb-announce" data-llb-announce="<?php echo esc_attr( $key ); ?>" role="region" aria-label="Mededeling">
		<div class="llb-announce__in">
			<p class="llb-announce__text"><?php echo esc_html( $text ); ?></p>
			<?php if ( '' !== $link && '' !== $link_text ) : ?>
				<a class="llb-announce__link" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $link_text ); ?></a>
			<?php endif; ?>
		</div>
		<button type="button" class="llb-announce__close" data-llb-announce-close aria-label="Mededeling sluiten">
			<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M18 6 6 18M6 6l12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
		</button>
	</div>
	<script>
		(function () {
			var bar = document.getElementById('llb-announce');
			try {
				if (bar && window.localStorage.getItem(bar.getAttribute('data-llb-announce')) === '1') {
					bar.hidden = true;
				}
			} catch (e) {}
		})();
	</script>
	<?php
}
add_action( 'wp_body_open', 'llb_render_announcement', 3 );

/**
 * Adds a body class while the announcement bar is active.
 *
 * @param array<int, string> $classes Body classes.
 * @return array<int, string>
 */
function llb_announcement_body_class( $classes ) {
	if ( llb_announcement_enabled() ) {
		$classes[] = 'llb-has-announce';
	}

	return $classes;
}
add_filter( 'body_class', 'llb_announcement_body_class' );
