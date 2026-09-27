<?php
/**
 * Single service (dienst).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="llb-main llb-single-service">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php
		$post_id  = get_the_ID();
		$title    = trim( (string) llb_get_meta( $post_id, '_llb_hero_title' ) );
		$intro    = (string) llb_get_meta( $post_id, '_llb_hero_intro' );
		$image_id = (int) get_post_thumbnail_id( $post_id );
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

		$sections = llb_get_meta( $post_id, '_llb_sections' );
		if ( ! is_array( $sections ) ) {
			$sections = array();
		}

		$section_index = 0;
		foreach ( $sections as $section ) :
			if ( ! is_array( $section ) ) {
				continue;
			}
			$heading = isset( $section['heading'] ) ? trim( (string) $section['heading'] ) : '';
			$text    = isset( $section['text'] ) ? trim( (string) $section['text'] ) : '';
			$list_raw = isset( $section['list'] ) ? (string) $section['list'] : '';
			$list     = array();
			if ( '' !== trim( $list_raw ) ) {
				$parts = preg_split( '/\r\n|\r|\n/', $list_raw );
				if ( is_array( $parts ) ) {
					foreach ( $parts as $line ) {
						$line = trim( (string) $line );
						if ( '' !== $line ) {
							$list[] = $line;
						}
					}
				}
			}
			if ( '' === $heading && '' === $text && empty( $list ) ) {
				continue;
			}
			$alt_class = ( 0 === $section_index % 2 ) ? 'llb-service-section--light' : 'llb-service-section--white';
			++$section_index;
			?>
			<section class="llb-section llb-service-section <?php echo esc_attr( $alt_class ); ?> llb-reveal">
				<div class="llb-container llb-content-narrow">
					<?php if ( '' !== $heading ) : ?>
						<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
						<h2><?php echo esc_html( $heading ); ?></h2>
					<?php endif; ?>
					<?php if ( '' !== $text ) : ?>
						<div class="llb-service-section__text">
							<?php echo llb_paragraphs( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $list ) ) : ?>
						<ul class="llb-check-list">
							<?php foreach ( $list as $item ) : ?>
								<li>
									<span class="llb-check-list__icon" aria-hidden="true">
										<?php echo llb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
									</span>
									<span><?php echo esc_html( $item ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</section>
		<?php endforeach; ?>

		<?php
		$steps_heading = trim( (string) llb_get_meta( $post_id, '_llb_steps_heading' ) );
		$steps         = llb_get_meta( $post_id, '_llb_steps' );
		if ( ! is_array( $steps ) ) {
			$steps = array();
		}
		$has_steps = ! empty( $steps );
		if ( '' !== $steps_heading || $has_steps ) :
			?>
			<section class="llb-section llb-about-steps llb-reveal">
				<div class="llb-container">
					<?php if ( '' !== $steps_heading ) : ?>
						<div class="llb-about-steps__header">
							<div class="llb-about-steps__heading">
								<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
								<h2><?php echo esc_html( $steps_heading ); ?></h2>
							</div>
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
								if ( '' === $step_title && '' === $step_text ) {
									continue;
								}
								$badge = str_pad( (string) ( (int) $index + 1 ), 2, '0', STR_PAD_LEFT );
								?>
								<li class="llb-about-steps__item">
									<div class="llb-step-card llb-step-card--text">
										<span class="llb-step-card__badge llb-step-card__badge--inline" aria-hidden="true"><?php echo esc_html( $badge ); ?></span>
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
		$cta_heading = trim( (string) llb_get_meta( $post_id, '_llb_cta_heading' ) );
		$cta_text    = (string) llb_get_meta( $post_id, '_llb_cta_text' );
		$cta_button  = trim( (string) llb_get_meta( $post_id, '_llb_cta_button' ) );
		if ( '' === $cta_button ) {
			$cta_button = trim( (string) llb_get_option( 'llb_header_cta_text' ) );
		}

		get_template_part(
			'template-parts/cta-band',
			null,
			array(
				'heading'     => $cta_heading,
				'text'        => $cta_text,
				'button_text' => $cta_button,
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
