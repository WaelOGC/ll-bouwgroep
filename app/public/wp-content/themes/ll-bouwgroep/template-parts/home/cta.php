<?php
/**
 * Home — CTA (design v2).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id  = get_the_ID();
$heading  = trim( (string) llb_get_meta( $post_id, '_llb_cta_heading' ) );
$text     = trim( (string) llb_get_meta( $post_id, '_llb_cta_text' ) );
$btn_text = trim( (string) llb_get_meta( $post_id, '_llb_cta_btn_text' ) );
$btn_url  = llb_get_header_cta_url();
$image_id = absint( llb_get_meta( $post_id, '_llb_cta_image' ) );

if ( '' === $heading && '' === $text && '' === $btn_text && ! $image_id ) {
	return;
}
?>
<section class="sec cta" id="contact">
	<?php if ( $image_id ) : ?>
		<div class="cta-img">
			<?php
			echo wp_get_attachment_image(
				$image_id,
				'full',
				false,
				array(
					'loading'  => 'lazy',
					'decoding' => 'async',
					'alt'      => '',
				)
			);
			?>
		</div>
	<?php else : ?>
		<div class="cta-img" aria-hidden="true"></div>
	<?php endif; ?>
	<div class="wrap">
		<?php if ( '' !== $heading ) : ?>
			<div class="rule" aria-hidden="true"></div>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<?php if ( '' !== $text ) : ?>
			<div style="margin-top:24px">
				<?php echo llb_paragraphs( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
			</div>
		<?php endif; ?>
		<?php if ( '' !== $btn_text ) : ?>
			<a class="btn btn-red" href="<?php echo esc_url( $btn_url ); ?>">
				<?php echo esc_html( $btn_text ); ?>
				<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
			</a>
		<?php endif; ?>
	</div>
</section>
