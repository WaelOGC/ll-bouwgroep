<?php
/**
 * Template Name: About
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="llb-main llb-page-about">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php
		$post_id  = get_the_ID();
		$title    = trim( (string) llb_get_meta( $post_id, '_llb_hero_title' ) );
		$intro    = (string) llb_get_meta( $post_id, '_llb_hero_intro' );
		$image_id = absint( llb_get_meta( $post_id, '_llb_hero_image' ) );
		if ( '' === $title ) {
			$title = get_the_title();
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

		get_template_part( 'template-parts/usp-strip' );

		$sections = llb_get_meta( $post_id, '_llb_sections' );
		if ( ! is_array( $sections ) ) {
			$sections = array();
		}

		$section_1 = isset( $sections[0] ) && is_array( $sections[0] ) ? $sections[0] : null;
		$section_2 = isset( $sections[1] ) && is_array( $sections[1] ) ? $sections[1] : null;
		$section_3 = isset( $sections[2] ) && is_array( $sections[2] ) ? $sections[2] : null;

		$steps = llb_get_meta( $post_id, '_llb_steps' );
		if ( ! is_array( $steps ) ) {
			$steps = array();
		}
		?>

		<?php if ( $section_1 ) : ?>
			<?php
			$s1_heading = isset( $section_1['heading'] ) ? trim( (string) $section_1['heading'] ) : '';
			$s1_text    = isset( $section_1['text'] ) ? trim( (string) $section_1['text'] ) : '';
			$s1_image   = isset( $section_1['image'] ) ? absint( $section_1['image'] ) : 0;
			if ( '' !== $s1_heading || '' !== $s1_text || $s1_image ) :
				?>
				<section class="llb-section llb-about-split llb-reveal">
					<div class="llb-container llb-about-split__inner">
						<div class="llb-about-split__copy">
							<?php if ( '' !== $s1_heading ) : ?>
								<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
								<h2><?php echo esc_html( $s1_heading ); ?></h2>
							<?php endif; ?>
							<?php if ( '' !== $s1_text ) : ?>
								<div class="llb-about-split__text">
									<?php echo llb_paragraphs( $s1_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="llb-about-split__media">
							<?php if ( $s1_image ) : ?>
								<?php
								echo wp_get_attachment_image(
									$s1_image,
									'large',
									false,
									array(
										'class'    => 'llb-about-split__image',
										'loading'  => 'lazy',
										'decoding' => 'async',
									)
								);
								?>
							<?php else : ?>
								<div class="llb-media-placeholder llb-media-placeholder--tall" aria-hidden="true">
									<span class="llb-accent-line"></span>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</section>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( $section_2 ) : ?>
			<?php
			$s2_heading = isset( $section_2['heading'] ) ? trim( (string) $section_2['heading'] ) : '';
			$s2_text    = isset( $section_2['text'] ) ? trim( (string) $section_2['text'] ) : '';
			$s2_image   = isset( $section_2['image'] ) ? absint( $section_2['image'] ) : 0;
			if ( '' !== $s2_heading || '' !== $s2_text || $s2_image ) :
				?>
				<section class="llb-section llb-about-split llb-about-split--reverse llb-about-split--light llb-reveal">
					<div class="llb-container llb-about-split__inner">
						<div class="llb-about-split__media">
							<?php if ( $s2_image ) : ?>
								<?php
								echo wp_get_attachment_image(
									$s2_image,
									'large',
									false,
									array(
										'class'    => 'llb-about-split__image',
										'loading'  => 'lazy',
										'decoding' => 'async',
									)
								);
								?>
							<?php else : ?>
								<div class="llb-media-placeholder llb-media-placeholder--tall" aria-hidden="true">
									<span class="llb-accent-line"></span>
								</div>
							<?php endif; ?>
						</div>
						<div class="llb-about-split__copy">
							<?php if ( '' !== $s2_heading ) : ?>
								<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
								<h2><?php echo esc_html( $s2_heading ); ?></h2>
							<?php endif; ?>
							<?php if ( '' !== $s2_text ) : ?>
								<div class="llb-about-split__text">
									<?php echo llb_paragraphs( $s2_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</section>
			<?php endif; ?>
		<?php endif; ?>

		<?php
		$s3_heading = $section_3 && isset( $section_3['heading'] ) ? trim( (string) $section_3['heading'] ) : '';
		$s3_text    = $section_3 && isset( $section_3['text'] ) ? trim( (string) $section_3['text'] ) : '';
		$has_steps  = ! empty( $steps );
		if ( '' !== $s3_heading || '' !== $s3_text || $has_steps ) :
			?>
			<section class="llb-section llb-about-steps llb-reveal">
				<div class="llb-container">
					<?php if ( '' !== $s3_heading || '' !== $s3_text ) : ?>
						<div class="llb-about-steps__header">
							<?php if ( '' !== $s3_heading ) : ?>
								<div class="llb-about-steps__heading">
									<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
									<h2><?php echo esc_html( $s3_heading ); ?></h2>
								</div>
							<?php endif; ?>
							<?php if ( '' !== $s3_text ) : ?>
								<div class="llb-about-steps__intro">
									<?php echo llb_paragraphs( $s3_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( $has_steps ) : ?>
						<ul class="llb-about-steps__list">
							<?php foreach ( $steps as $index => $step ) : ?>
								<?php
								if ( ! is_array( $step ) ) {
									continue;
								}
								$step_title = isset( $step['title'] ) ? trim( (string) $step['title'] ) : '';
								$step_text  = isset( $step['text'] ) ? trim( (string) $step['text'] ) : '';
								$step_image = isset( $step['image'] ) ? absint( $step['image'] ) : 0;
								if ( '' === $step_title && '' === $step_text && ! $step_image ) {
									continue;
								}
								$badge = str_pad( (string) ( (int) $index + 1 ), 2, '0', STR_PAD_LEFT );
								?>
								<li class="llb-about-steps__item">
									<div class="llb-step-card">
										<div class="llb-step-card__media">
											<?php if ( $step_image ) : ?>
												<?php
												echo wp_get_attachment_image(
													$step_image,
													'llb-card',
													false,
													array(
														'class'    => 'llb-step-card__image',
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
											<span class="llb-step-card__badge" aria-hidden="true"><?php echo esc_html( $badge ); ?></span>
										</div>
										<div class="llb-step-card__body">
											<?php if ( '' !== $step_title ) : ?>
												<h3><?php echo esc_html( $step_title ); ?></h3>
											<?php endif; ?>
											<?php if ( '' !== $step_text ) : ?>
												<?php echo llb_paragraphs( $step_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
											<?php endif; ?>
										</div>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php
		get_template_part(
			'template-parts/cta-band',
			null,
			array(
				'heading'     => trim( (string) llb_get_meta( $post_id, '_llb_cta_heading' ) ),
				'text'        => (string) llb_get_meta( $post_id, '_llb_cta_text' ),
				'button_text' => trim( (string) llb_get_meta( $post_id, '_llb_cta_btn_text' ) ),
				'button_url'  => llb_get_header_cta_url(),
				'image_id'    => absint( llb_get_meta( $post_id, '_llb_cta_image' ) ),
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
