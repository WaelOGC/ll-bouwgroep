<?php
/**
 * Home — services carousel.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id  = get_the_ID();
$heading  = trim( (string) llb_get_meta( $post_id, '_llb_services_heading' ) );
$intro    = trim( (string) llb_get_meta( $post_id, '_llb_services_intro' ) );
$services = llb_get_services();

if ( '' === $heading && '' === $intro && empty( $services ) ) {
	return;
}

/**
 * Renders one service card.
 *
 * @param WP_Post $service Service post.
 * @param bool    $clone   Whether this is a carousel duplicate.
 * @return void
 */
$llb_render_service_card = static function ( $service, $clone = false ) {
	$thumb_id = get_post_thumbnail_id( $service );
	$excerpt  = trim( (string) $service->post_excerpt );
	$attrs    = $clone ? ' aria-hidden="true" tabindex="-1"' : '';
	?>
	<li class="llb-services-carousel__item"<?php echo $attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static attributes. ?>>
		<a class="llb-card llb-card--service" href="<?php echo esc_url( get_permalink( $service ) ); ?>"<?php echo $clone ? ' tabindex="-1"' : ''; ?>>
			<div class="llb-card__media">
				<?php if ( $thumb_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$thumb_id,
						'llb-card',
						false,
						array(
							'class'    => 'llb-card__image',
							'loading'  => 'lazy',
							'decoding' => 'async',
						)
					);
					?>
				<?php else : ?>
					<div class="llb-media-placeholder" aria-hidden="true">
						<span class="llb-accent-line"></span>
					</div>
				<?php endif; ?>
			</div>
			<div class="llb-card__body">
				<h3 class="llb-card__title"><?php echo esc_html( get_the_title( $service ) ); ?></h3>
				<?php if ( '' !== $excerpt ) : ?>
					<p class="llb-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
				<?php endif; ?>
				<span class="llb-card__arrow" aria-hidden="true">
					<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</span>
			</div>
		</a>
	</li>
	<?php
};
?>
<section class="llb-section llb-home-services llb-reveal">
	<div class="llb-container">
		<div class="llb-home-services__header">
			<?php if ( '' !== $heading ) : ?>
				<div class="llb-home-services__heading">
					<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
					<h2><?php echo esc_html( $heading ); ?></h2>
				</div>
			<?php endif; ?>
			<?php if ( '' !== $intro ) : ?>
				<div class="llb-home-services__intro">
					<?php echo llb_paragraphs( $intro ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php if ( ! empty( $services ) ) : ?>
		<div class="llb-services-carousel" data-llb-services-carousel>
			<div class="llb-services-carousel__track" data-llb-carousel-track>
				<ul class="llb-services-carousel__list">
					<?php foreach ( $services as $service ) : ?>
						<?php $llb_render_service_card( $service, false ); ?>
					<?php endforeach; ?>
					<?php foreach ( $services as $service ) : ?>
						<?php $llb_render_service_card( $service, true ); ?>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	<?php endif; ?>
</section>
