<?php
/**
 * CTA band template part.
 *
 * Args: heading, text, button_text, button_url.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading     = isset( $args['heading'] ) ? trim( (string) $args['heading'] ) : '';
$text        = isset( $args['text'] ) ? (string) $args['text'] : '';
$button_text = isset( $args['button_text'] ) ? trim( (string) $args['button_text'] ) : '';
$button_url  = isset( $args['button_url'] ) ? (string) $args['button_url'] : '';

if ( '' === $heading ) {
	return;
}
?>
<section class="llb-cta-band">
	<div class="llb-container">
		<h2><?php echo esc_html( $heading ); ?></h2>
		<?php if ( '' !== trim( $text ) ) : ?>
			<div class="llb-cta-band__text">
				<?php echo llb_paragraphs( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
			</div>
		<?php endif; ?>
		<?php if ( '' !== $button_text && '' !== $button_url ) : ?>
			<a class="llb-btn llb-btn--primary" href="<?php echo esc_url( $button_url ); ?>">
				<span><?php echo esc_html( $button_text ); ?></span>
				<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
			</a>
		<?php endif; ?>
	</div>
</section>
