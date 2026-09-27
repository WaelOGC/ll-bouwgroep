<?php
/**
 * Home — hero (angled panel layout).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();
$title   = trim( (string) llb_get_meta( $post_id, '_llb_hero_title' ) );
if ( '' === $title ) {
	$title = get_the_title();
}
$intro    = (string) llb_get_meta( $post_id, '_llb_hero_intro' );
$image_id = absint( llb_get_meta( $post_id, '_llb_hero_image' ) );

$btn1_text = trim( (string) llb_get_meta( $post_id, '_llb_hero_btn1_text' ) );
$btn1_url  = trim( (string) llb_get_meta( $post_id, '_llb_hero_btn1_url' ) );
if ( '' === $btn1_url ) {
	$btn1_url = llb_get_header_cta_url();
}

$btn2_text = trim( (string) llb_get_meta( $post_id, '_llb_hero_btn2_text' ) );
$btn2_url  = trim( (string) llb_get_meta( $post_id, '_llb_hero_btn2_url' ) );
if ( '' === $btn2_url ) {
	$btn2_url = llb_page_url( 'diensten' );
}

if ( '' === $title && '' === trim( $intro ) && '' === $btn1_text && '' === $btn2_text && ! $image_id ) {
	return;
}

$classes = 'llb-home-hero llb-reveal';
if ( $image_id ) {
	$classes .= ' llb-home-hero--has-image';
} else {
	$classes .= ' llb-home-hero--no-image';
}
?>
<section class="<?php echo esc_attr( $classes ); ?>">
	<div class="llb-home-hero__bg" aria-hidden="true">
		<?php if ( $image_id ) : ?>
			<?php
			echo wp_get_attachment_image(
				$image_id,
				'full',
				false,
				array(
					'class'    => 'llb-home-hero__image',
					'loading'  => 'eager',
					'decoding' => 'async',
				)
			);
			?>
		<?php endif; ?>
		<span class="llb-home-hero__shade"></span>
	</div>
	<div class="llb-home-hero__panel">
		<div class="llb-home-hero__content">
			<?php if ( '' !== $title ) : ?>
				<h1><?php echo esc_html( $title ); ?></h1>
				<span class="llb-accent-line" aria-hidden="true"></span>
			<?php endif; ?>
			<?php if ( '' !== trim( $intro ) ) : ?>
				<div class="llb-home-hero__intro">
					<?php echo llb_paragraphs( $intro ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
				</div>
			<?php endif; ?>
			<?php if ( '' !== $btn1_text || '' !== $btn2_text ) : ?>
				<div class="llb-btn-group">
					<?php if ( '' !== $btn1_text ) : ?>
						<a class="llb-btn llb-btn--primary" href="<?php echo esc_url( $btn1_url ); ?>">
							<span><?php echo esc_html( $btn1_text ); ?></span>
							<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
						</a>
					<?php endif; ?>
					<?php if ( '' !== $btn2_text ) : ?>
						<a class="llb-btn llb-btn--outline-light llb-btn--no-icon" href="<?php echo esc_url( $btn2_url ); ?>">
							<span><?php echo esc_html( $btn2_text ); ?></span>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
