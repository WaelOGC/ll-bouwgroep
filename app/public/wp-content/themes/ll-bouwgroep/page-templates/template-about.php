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
<main id="main" class="llb-page-about">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php
		$post_id   = get_the_ID();
		$title     = trim( (string) llb_get_meta( $post_id, '_llb_hero_title' ) );
		$intro     = trim( (string) llb_get_meta( $post_id, '_llb_hero_intro' ) );
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
				<section class="sec">
					<div class="wrap split">
						<div class="split-text">
							<?php if ( '' !== $s1_heading ) : ?>
								<div class="rule" aria-hidden="true"></div>
								<h2><?php echo esc_html( $s1_heading ); ?></h2>
							<?php endif; ?>
							<?php if ( '' !== $s1_text ) : ?>
								<div class="split-body">
									<?php echo llb_paragraphs( $s1_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
								</div>
							<?php endif; ?>
						</div>
						<?php if ( $s1_image ) : ?>
							<div class="split-img rv">
								<?php
								echo wp_get_attachment_image(
									$s1_image,
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
				<section class="sec why">
					<div class="wrap split split--rev">
						<?php if ( $s2_image ) : ?>
							<div class="split-img rv">
								<?php
								echo wp_get_attachment_image(
									$s2_image,
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
						<div class="split-text">
							<?php if ( '' !== $s2_heading ) : ?>
								<div class="rule" aria-hidden="true"></div>
								<h2><?php echo esc_html( $s2_heading ); ?></h2>
							<?php endif; ?>
							<?php if ( '' !== $s2_text ) : ?>
								<div class="split-body">
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
		$has_steps  = false;
		foreach ( $steps as $step_check ) {
			if ( ! is_array( $step_check ) ) {
				continue;
			}
			$st = isset( $step_check['title'] ) ? trim( (string) $step_check['title'] ) : '';
			$sx = isset( $step_check['text'] ) ? trim( (string) $step_check['text'] ) : '';
			$si = isset( $step_check['image'] ) ? absint( $step_check['image'] ) : 0;
			if ( '' !== $st || '' !== $sx || $si ) {
				$has_steps = true;
				break;
			}
		}
		if ( '' !== $s3_heading || '' !== $s3_text || $has_steps ) :
			?>
			<section class="sec">
				<div class="wrap">
					<?php if ( '' !== $s3_heading || '' !== $s3_text ) : ?>
						<div class="svc-head">
							<?php if ( '' !== $s3_heading ) : ?>
								<div>
									<div class="rule" aria-hidden="true"></div>
									<h2><?php echo esc_html( $s3_heading ); ?></h2>
								</div>
							<?php endif; ?>
							<?php if ( '' !== $s3_text ) : ?>
								<div>
									<?php echo llb_paragraphs( $s3_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( $has_steps ) : ?>
						<ol class="steps">
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
								<li class="step">
									<?php if ( $step_image ) : ?>
										<div class="step-img">
											<?php
											echo wp_get_attachment_image(
												$step_image,
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
									<span class="step-no" aria-hidden="true"><?php echo esc_html( $badge ); ?></span>
									<?php if ( '' !== $step_title ) : ?>
										<h3><?php echo esc_html( $step_title ); ?></h3>
									<?php endif; ?>
									<?php if ( '' !== $step_text ) : ?>
										<p><?php echo esc_html( $step_text ); ?></p>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ol>
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
		?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
