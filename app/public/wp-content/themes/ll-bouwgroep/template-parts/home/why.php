<?php
/**
 * Home — why us (design v2).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id  = get_the_ID();
$heading  = trim( (string) llb_get_meta( $post_id, '_llb_why_heading' ) );
$text     = trim( (string) llb_get_meta( $post_id, '_llb_why_text' ) );
$image_id = absint( llb_get_meta( $post_id, '_llb_why_image' ) );
$items    = llb_get_why_items();

if ( '' === $heading && '' === $text && ! $image_id && empty( $items ) ) {
	return;
}

$default_icons = array( 'hard-hat', 'toolbox', 'ruler-square' );
?>
<section class="sec why">
	<div class="wrap">
		<div class="why-grid">
			<?php if ( $image_id ) : ?>
				<div class="why-img rv">
					<?php
					echo wp_get_attachment_image(
						$image_id,
						'llb-card',
						false,
						array(
							'loading'  => 'lazy',
							'decoding' => 'async',
						)
					);
					?>
				</div>
			<?php endif; ?>
			<div class="why-text">
				<?php if ( '' !== $heading ) : ?>
					<div class="rule" aria-hidden="true"></div>
					<h2><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
				<?php if ( '' !== $text ) : ?>
					<div style="margin-top:28px">
						<?php echo llb_paragraphs( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php if ( ! empty( $items ) ) : ?>
			<div class="why-items">
				<?php foreach ( $items as $index => $item ) : ?>
					<?php
					$icon = isset( $item['icon'] ) ? (string) $item['icon'] : '';
					if ( '' === $icon || ! isset( llb_why_icon_options()[ $icon ] ) ) {
						$icon = isset( $default_icons[ $index ] ) ? $default_icons[ $index ] : 'hard-hat';
					}
					?>
					<div class="why-item">
						<?php echo llb_get_mdi_icon_svg( $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
						<?php if ( '' !== $item['title'] ) : ?>
							<h3><?php echo esc_html( $item['title'] ); ?></h3>
						<?php endif; ?>
						<?php if ( '' !== $item['text'] ) : ?>
							<p><?php echo esc_html( $item['text'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
