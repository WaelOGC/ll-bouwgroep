<?php
/**
 * Home — final CTA.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id     = get_the_ID();
$heading     = trim( (string) llb_get_meta( $post_id, '_llb_cta_heading' ) );
$text        = trim( (string) llb_get_meta( $post_id, '_llb_cta_text' ) );
$button_text = trim( (string) llb_get_meta( $post_id, '_llb_cta_btn_text' ) );
$image_id    = absint( llb_get_meta( $post_id, '_llb_cta_image' ) );
$button_url  = llb_get_header_cta_url();

if ( '' === $heading && '' === $text && '' === $button_text ) {
	return;
}

$classes = 'llb-cta-band llb-cta-band--split llb-reveal';
if ( $image_id ) {
	$classes .= ' llb-cta-band--has-image';
} else {
	$classes .= ' llb-cta-band--animated';
}
?>
<section class="<?php echo esc_attr( $classes ); ?>">
	<?php if ( $image_id ) : ?>
		<div class="llb-cta-band__media" aria-hidden="true">
			<?php
			echo wp_get_attachment_image(
				$image_id,
				'full',
				false,
				array(
					'class'    => 'llb-cta-band__image',
					'loading'  => 'lazy',
					'decoding' => 'async',
				)
			);
			?>
			<span class="llb-cta-band__overlay"></span>
		</div>
	<?php endif; ?>
	<div class="llb-container llb-cta-band__inner">
		<div class="llb-cta-band__copy">
			<?php if ( '' !== $heading ) : ?>
				<span class="llb-accent-line" aria-hidden="true"></span>
				<h2><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<?php if ( '' !== trim( $text ) ) : ?>
				<div class="llb-cta-band__text">
					<?php echo llb_paragraphs( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( '' !== $button_text ) : ?>
			<div class="llb-cta-band__action">
				<a class="llb-btn llb-btn--primary" href="<?php echo esc_url( $button_url ); ?>">
					<span><?php echo esc_html( $button_text ); ?></span>
					<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
