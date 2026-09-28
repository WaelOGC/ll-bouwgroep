<?php
/**
 * CTA band (design v2 — same as Home).
 *
 * Args: heading, text, button_text, button_url, image_id, id (optional).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading     = isset( $args['heading'] ) ? trim( (string) $args['heading'] ) : '';
$text        = isset( $args['text'] ) ? trim( (string) $args['text'] ) : '';
$button_text = isset( $args['button_text'] ) ? trim( (string) $args['button_text'] ) : '';
$button_url  = isset( $args['button_url'] ) ? (string) $args['button_url'] : '';
$image_id    = isset( $args['image_id'] ) ? absint( $args['image_id'] ) : 0;
$section_id  = isset( $args['id'] ) ? trim( (string) $args['id'] ) : '';
$extra_class = isset( $args['class'] ) ? trim( (string) $args['class'] ) : '';

if ( '' === $heading && '' === $text && '' === $button_text && ! $image_id ) {
	return;
}

$id_attr      = '' !== $section_id ? ' id="' . esc_attr( $section_id ) . '"' : '';
$section_class = 'sec cta';
if ( '' !== $extra_class ) {
	$section_class .= ' ' . $extra_class;
}
?>
<section class="<?php echo esc_attr( $section_class ); ?>"<?php echo $id_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>>
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
		<?php if ( '' !== $button_text && '' !== $button_url ) : ?>
			<a class="btn btn-red" href="<?php echo esc_url( $button_url ); ?>">
				<?php echo esc_html( $button_text ); ?>
				<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
			</a>
		<?php endif; ?>
	</div>
</section>
