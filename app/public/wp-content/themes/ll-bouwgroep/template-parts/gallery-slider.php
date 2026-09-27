<?php
/**
 * Image gallery slider.
 *
 * Args: image_ids (int[]), size (optional).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$image_ids = isset( $args['image_ids'] ) && is_array( $args['image_ids'] ) ? array_values( array_filter( array_map( 'absint', $args['image_ids'] ) ) ) : array();
$size      = isset( $args['size'] ) ? (string) $args['size'] : 'large';

if ( empty( $image_ids ) ) {
	return;
}

$multi = count( $image_ids ) > 1;
?>
<div class="llb-gallery<?php echo $multi ? ' llb-gallery--multi' : ''; ?>" data-llb-gallery-slider<?php echo $multi ? '' : ' data-llb-gallery-static'; ?>>
	<div class="llb-gallery__stage">
		<?php foreach ( $image_ids as $index => $attachment_id ) : ?>
			<figure class="llb-gallery__slide<?php echo 0 === $index ? ' is-active' : ''; ?>" data-llb-gallery-slide="<?php echo esc_attr( (string) $index ); ?>"<?php echo 0 === $index ? '' : ' hidden'; ?>>
				<?php
				echo wp_get_attachment_image(
					$attachment_id,
					$size,
					false,
					array(
						'class'    => 'llb-gallery__image',
						'loading'  => 0 === $index ? 'eager' : 'lazy',
						'decoding' => 'async',
					)
				);
				?>
			</figure>
		<?php endforeach; ?>
		<?php if ( $multi ) : ?>
			<button type="button" class="llb-carousel-btn llb-carousel-btn--prev llb-gallery__btn llb-gallery__btn--prev" data-llb-gallery-prev aria-label="Vorige">
				<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
			</button>
			<button type="button" class="llb-carousel-btn llb-carousel-btn--next llb-gallery__btn llb-gallery__btn--next" data-llb-gallery-next aria-label="Volgende">
				<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
			</button>
		<?php endif; ?>
	</div>
	<?php if ( $multi ) : ?>
		<ul class="llb-gallery__thumbs" role="list">
			<?php foreach ( $image_ids as $index => $attachment_id ) : ?>
				<li>
					<button
						type="button"
						class="llb-gallery__thumb<?php echo 0 === $index ? ' is-active' : ''; ?>"
						data-llb-gallery-thumb="<?php echo esc_attr( (string) $index ); ?>"
						aria-label="<?php echo esc_attr( 'Afbeelding ' . ( $index + 1 ) ); ?>"
						aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>"
					>
						<?php
						echo wp_get_attachment_image(
							$attachment_id,
							'thumbnail',
							false,
							array(
								'class'    => 'llb-gallery__thumb-image',
								'loading'  => 'lazy',
								'decoding' => 'async',
								'alt'      => '',
							)
						);
						?>
					</button>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
