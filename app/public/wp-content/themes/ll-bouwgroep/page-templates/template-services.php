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
<main id="main" class="llb-page-services">
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

		$services = llb_get_services();
		?>
		<?php if ( ! empty( $services ) ) : ?>
			<section class="sec">
				<div class="wrap">
					<ul class="scards">
						<?php foreach ( $services as $service ) : ?>
							<?php
							$thumb_id    = get_post_thumbnail_id( $service );
							$overview    = trim( (string) llb_get_meta( $service->ID, '_llb_overview_text' ) );
							$button_text = trim( (string) llb_get_meta( $service->ID, '_llb_overview_button' ) );
							$service_url = get_permalink( $service );
							$icon        = trim( (string) llb_get_meta( $service->ID, '_llb_service_icon' ) );
							if ( '' === $icon || ! isset( llb_service_icon_options()[ $icon ] ) ) {
								$icon = llb_default_service_icon_for_slug( $service->post_name );
							}
							$icon_svg = llb_get_mdi_icon_svg( $icon );
							$media_class = $thumb_id ? 'scard-media' : 'scard-media scard-media--empty';
							?>
							<li class="scard">
								<a class="<?php echo esc_attr( $media_class ); ?>" href="<?php echo esc_url( $service_url ); ?>" tabindex="-1" aria-hidden="true">
									<?php if ( $thumb_id ) : ?>
										<?php
										echo wp_get_attachment_image(
											$thumb_id,
											'llb-card',
											false,
											array(
												'loading'  => 'lazy',
												'decoding' => 'async',
											)
										);
										?>
									<?php else : ?>
										<?php echo $icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
									<?php endif; ?>
									<?php if ( $icon_svg ) : ?>
										<span class="scard-ic">
											<?php echo $icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
										</span>
									<?php endif; ?>
								</a>
								<h2>
									<a href="<?php echo esc_url( $service_url ); ?>"><?php echo esc_html( get_the_title( $service ) ); ?></a>
								</h2>
								<?php if ( '' !== $overview ) : ?>
									<?php echo llb_paragraphs( $overview ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
								<?php endif; ?>
								<?php if ( '' !== $button_text ) : ?>
									<a class="link" href="<?php echo esc_url( $service_url ); ?>">
										<?php echo esc_html( $button_text ); ?>
										<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
									</a>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</section>
		<?php endif; ?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
