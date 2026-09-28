<?php
/**
 * Template Name: Services overview
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="llb-main llb-page-services">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php
		$post_id   = get_the_ID();
		$title     = trim( (string) llb_get_meta( $post_id, '_llb_hero_title' ) );
		$intro     = (string) llb_get_meta( $post_id, '_llb_hero_intro' );
		$image_id  = absint( llb_get_meta( $post_id, '_llb_hero_image' ) );
		$mobile_id = absint( llb_get_meta( $post_id, '_llb_hero_image_mobile' ) );
		if ( '' === $title ) {
			$title = get_the_title();
		}

		get_template_part(
			'template-parts/page-hero',
			null,
			array(
				'title'     => $title,
				'intro'     => $intro,
				'image_id'  => $image_id,
				'mobile_id' => $mobile_id,
			)
		);

		get_template_part( 'template-parts/usp-strip' );

		$services = llb_get_services();
		?>
		<?php if ( ! empty( $services ) ) : ?>
			<section class="llb-section llb-services-grid llb-reveal">
				<div class="llb-container">
					<ul class="llb-services-grid__list">
						<?php foreach ( $services as $service ) : ?>
							<?php
							$thumb_id     = get_post_thumbnail_id( $service );
							$overview     = trim( (string) llb_get_meta( $service->ID, '_llb_overview_text' ) );
							$button_text  = trim( (string) llb_get_meta( $service->ID, '_llb_overview_button' ) );
							$service_url  = get_permalink( $service );
							?>
							<li class="llb-services-grid__item">
								<article class="llb-card llb-card--service">
									<a class="llb-card__media-link" href="<?php echo esc_url( $service_url ); ?>">
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
									</a>
									<div class="llb-card__body">
										<h2 class="llb-card__title">
											<a href="<?php echo esc_url( $service_url ); ?>"><?php echo esc_html( get_the_title( $service ) ); ?></a>
										</h2>
										<?php if ( '' !== $overview ) : ?>
											<div class="llb-card__excerpt">
												<?php echo llb_paragraphs( $overview ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
											</div>
										<?php endif; ?>
										<?php if ( '' !== $button_text ) : ?>
											<a class="llb-text-link" href="<?php echo esc_url( $service_url ); ?>">
												<span><?php echo esc_html( $button_text ); ?></span>
												<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
											</a>
										<?php endif; ?>
									</div>
								</article>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</section>
		<?php endif; ?>
		<?php
		$raw_content = get_post_field( 'post_content', $post_id );
		if ( is_string( $raw_content ) && '' !== trim( $raw_content ) ) :
			?>
			<div class="llb-container">
				<div class="llb-entry-content">
					<?php the_content(); ?>
				</div>
			</div>
		<?php endif; ?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
