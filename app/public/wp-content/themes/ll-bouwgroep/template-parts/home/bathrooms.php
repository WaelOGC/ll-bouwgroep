<?php
/**
 * Home — bathrooms highlight.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id    = get_the_ID();
$heading    = trim( (string) llb_get_meta( $post_id, '_llb_bath_heading' ) );
$text       = trim( (string) llb_get_meta( $post_id, '_llb_bath_text' ) );
$subheading = trim( (string) llb_get_meta( $post_id, '_llb_bath_subheading' ) );
$btn_text   = trim( (string) llb_get_meta( $post_id, '_llb_bath_btn_text' ) );
$btn_url    = trim( (string) llb_get_meta( $post_id, '_llb_bath_btn_url' ) );
$image_id   = absint( llb_get_meta( $post_id, '_llb_bath_image' ) );

if ( '' === $btn_url ) {
	$btn_url = llb_get_service_url( 'badkamers-toiletten' );
}

if ( '' === $heading && '' === $text && '' === $subheading && '' === $btn_text && ! $image_id ) {
	return;
}
?>
<section class="llb-section llb-section--light llb-home-bath llb-section--angled llb-reveal">
	<div class="llb-home-bath__deco" aria-hidden="true"></div>
	<div class="llb-container llb-home-bath__grid<?php echo $image_id ? '' : ' llb-home-bath__grid--no-image'; ?>">
		<?php if ( $image_id ) : ?>
			<div class="llb-home-bath__media">
				<?php
				echo wp_get_attachment_image(
					$image_id,
					'large',
					false,
					array(
						'class'    => 'llb-home-bath__image',
						'loading'  => 'lazy',
						'decoding' => 'async',
					)
				);
				?>
			</div>
		<?php else : ?>
			<div class="llb-home-bath__media">
				<div class="llb-media-placeholder llb-media-placeholder--tall" aria-hidden="true">
					<span class="llb-accent-line"></span>
				</div>
			</div>
		<?php endif; ?>
		<div class="llb-home-bath__content">
			<?php if ( '' !== $heading ) : ?>
				<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
				<h2><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<?php if ( '' !== $text ) : ?>
				<div class="llb-home-bath__text">
					<?php echo llb_paragraphs( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
				</div>
			<?php endif; ?>
			<?php if ( '' !== $subheading ) : ?>
				<h3 class="llb-home-bath__subheading"><?php echo esc_html( $subheading ); ?></h3>
			<?php endif; ?>
			<?php if ( '' !== $btn_text ) : ?>
				<a class="llb-btn llb-btn--primary" href="<?php echo esc_url( $btn_url ); ?>">
					<span><?php echo esc_html( $btn_text ); ?></span>
					<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
