<?php
/**
 * Page hero template part.
 *
 * Args: title, intro, image_id, buttons (text, url, style).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title     = isset( $args['title'] ) ? (string) $args['title'] : '';
$intro     = isset( $args['intro'] ) ? (string) $args['intro'] : '';
$image_id  = isset( $args['image_id'] ) ? absint( $args['image_id'] ) : 0;
$buttons   = isset( $args['buttons'] ) && is_array( $args['buttons'] ) ? $args['buttons'] : array();
$has_image = $image_id > 0;

if ( '' === $title ) {
	return;
}

$classes = 'llb-page-hero';
if ( $has_image ) {
	$classes .= ' llb-page-hero--has-image';
}
?>
<section class="<?php echo esc_attr( $classes ); ?>">
	<?php if ( $has_image ) : ?>
		<div class="llb-page-hero__media" aria-hidden="true">
			<?php
			echo wp_get_attachment_image(
				$image_id,
				'full',
				false,
				array(
					'class'    => 'llb-page-hero__image',
					'loading'  => 'eager',
					'decoding' => 'async',
				)
			);
			?>
			<div class="llb-page-hero__overlay"></div>
		</div>
	<?php endif; ?>
	<div class="llb-container">
		<div class="llb-page-hero__inner">
			<span class="llb-accent-line" aria-hidden="true"></span>
			<h1><?php echo esc_html( $title ); ?></h1>
			<?php if ( '' !== trim( $intro ) ) : ?>
				<div class="llb-page-hero__intro">
					<?php echo llb_paragraphs( $intro ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $buttons ) ) : ?>
				<div class="llb-btn-group">
					<?php foreach ( $buttons as $button ) : ?>
						<?php
						$btn_text  = isset( $button['text'] ) ? trim( (string) $button['text'] ) : '';
						$btn_url   = isset( $button['url'] ) ? (string) $button['url'] : '';
						$btn_style = isset( $button['style'] ) ? (string) $button['style'] : 'primary';
						if ( '' === $btn_text || '' === $btn_url ) {
							continue;
						}
						$btn_class = 'llb-btn';
						if ( 'outline-light' === $btn_style ) {
							$btn_class .= ' llb-btn--outline-light';
						} elseif ( 'outline' === $btn_style ) {
							$btn_class .= ' llb-btn--outline';
						} else {
							$btn_class .= ' llb-btn--primary';
						}
						?>
						<a class="<?php echo esc_attr( $btn_class ); ?>" href="<?php echo esc_url( $btn_url ); ?>">
							<span><?php echo esc_html( $btn_text ); ?></span>
							<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
