<?php
/**
 * Home — services grid.
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
?>
<section class="llb-section llb-home-services">
	<div class="llb-container">
		<?php
		get_template_part(
			'template-parts/section-heading',
			null,
			array(
				'heading' => $heading,
				'level'   => 'h2',
				'text'    => $intro,
			)
		);
		?>
		<?php if ( ! empty( $services ) ) : ?>
			<ul class="llb-card-grid llb-card-grid--services">
				<?php foreach ( $services as $service ) : ?>
					<?php
					$thumb_id = get_post_thumbnail_id( $service );
					$excerpt  = trim( (string) $service->post_excerpt );
					?>
					<li>
						<a class="llb-card" href="<?php echo esc_url( get_permalink( $service ) ); ?>">
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
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
