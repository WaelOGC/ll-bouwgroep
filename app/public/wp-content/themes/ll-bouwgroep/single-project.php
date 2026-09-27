<?php
/**
 * Single project.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="llb-main llb-single-project">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php
		$post_id     = get_the_ID();
		$title       = get_the_title();
		$intro       = trim( (string) llb_get_projects_page_meta( '_llb_single_intro' ) );
		$image_id    = (int) get_post_thumbnail_id( $post_id );
		$gallery_ids = llb_get_project_gallery_ids( $post_id );
		$about_h     = trim( (string) llb_get_projects_page_meta( '_llb_single_about_heading' ) );
		$work_h      = trim( (string) llb_get_projects_page_meta( '_llb_single_work_heading' ) );
		$result_h    = trim( (string) llb_get_projects_page_meta( '_llb_single_result_heading' ) );
		$desc        = trim( (string) llb_get_meta( $post_id, '_llb_project_description' ) );
		$work_lines  = llb_get_lines( $post_id, '_llb_project_work' );
		$result      = trim( (string) llb_get_meta( $post_id, '_llb_project_result' ) );
		$cta_heading = trim( (string) llb_get_projects_page_meta( '_llb_single_cta_heading' ) );
		$cta_text    = trim( (string) llb_get_projects_page_meta( '_llb_single_cta_text' ) );
		$cta_btn     = trim( (string) llb_get_projects_page_meta( '_llb_single_cta_btn_text' ) );
		if ( '' === $cta_btn ) {
			$cta_btn = trim( (string) llb_get_option( 'llb_header_cta_text' ) );
		}

		get_template_part(
			'template-parts/page-hero',
			null,
			array(
				'title'    => $title,
				'intro'    => $intro,
				'image_id' => $image_id,
			)
		);
		?>

		<?php if ( ! empty( $gallery_ids ) ) : ?>
			<section class="llb-section llb-single-project__gallery llb-reveal">
				<div class="llb-container llb-content-narrow">
					<?php
					get_template_part(
						'template-parts/gallery-slider',
						null,
						array(
							'image_ids' => $gallery_ids,
							'size'      => 'large',
						)
					);
					?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( '' !== $about_h || '' !== $desc ) : ?>
			<section class="llb-section llb-service-section llb-service-section--light llb-reveal">
				<div class="llb-container llb-content-narrow">
					<?php if ( '' !== $about_h ) : ?>
						<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
						<h2><?php echo esc_html( $about_h ); ?></h2>
					<?php endif; ?>
					<?php if ( '' !== $desc ) : ?>
						<div class="llb-service-section__text">
							<?php echo llb_paragraphs( $desc ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( '' !== $work_h || ! empty( $work_lines ) ) : ?>
			<section class="llb-section llb-service-section llb-service-section--white llb-reveal">
				<div class="llb-container llb-content-narrow">
					<?php if ( '' !== $work_h ) : ?>
						<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
						<h2><?php echo esc_html( $work_h ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $work_lines ) ) : ?>
						<ul class="llb-check-list">
							<?php foreach ( $work_lines as $line ) : ?>
								<li>
									<span class="llb-check-list__icon" aria-hidden="true">
										<?php echo llb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
									</span>
									<span><?php echo esc_html( $line ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( '' !== $result_h || '' !== $result ) : ?>
			<section class="llb-section llb-service-section llb-service-section--light llb-reveal">
				<div class="llb-container llb-content-narrow">
					<?php if ( '' !== $result_h ) : ?>
						<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
						<h2><?php echo esc_html( $result_h ); ?></h2>
					<?php endif; ?>
					<?php if ( '' !== $result ) : ?>
						<div class="llb-service-section__text">
							<?php echo llb_paragraphs( $result ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php
		get_template_part(
			'template-parts/cta-band',
			null,
			array(
				'heading'     => $cta_heading,
				'text'        => $cta_text,
				'button_text' => $cta_btn,
				'button_url'  => llb_get_header_cta_url(),
			)
		);

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
