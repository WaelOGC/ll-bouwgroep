<?php
/**
 * Single service (dienst) — design v2.
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
		$post_id     = get_the_ID();
		$title       = trim( (string) llb_get_meta( $post_id, '_llb_hero_title' ) );
		$intro       = trim( (string) llb_get_meta( $post_id, '_llb_hero_intro' ) );
		$hero_image  = absint( llb_get_meta( $post_id, '_llb_hero_image' ) );
		$cta_button  = trim( (string) llb_get_meta( $post_id, '_llb_cta_button' ) );
		$contact_url = llb_page_url( 'contact' );
		if ( '' === $title ) {
			$title = get_the_title();
		}

		$hero_buttons = array();
		if ( '' !== $cta_button && '' !== $contact_url ) {
			$hero_buttons[] = array(
				'text'  => $cta_button,
				'url'   => $contact_url,
				'style' => 'red',
			);
		}

		get_template_part(
			'template-parts/page-hero',
			null,
			array(
				'title'    => $title,
				'intro'    => $intro,
				'image_id' => $hero_image,
				'buttons'  => $hero_buttons,
				'class'    => 'sv-hero',
			)
		);

		$sections = llb_get_meta( $post_id, '_llb_sections' );
		if ( ! is_array( $sections ) ) {
			$sections = array();
		}

		$normalized = array();
		foreach ( $sections as $section ) {
			if ( ! is_array( $section ) ) {
				continue;
			}
			$heading = isset( $section['heading'] ) ? trim( (string) $section['heading'] ) : '';
			$text    = isset( $section['text'] ) ? trim( (string) $section['text'] ) : '';
			$list    = llb_parse_section_list( isset( $section['list'] ) ? $section['list'] : '' );
			$image   = isset( $section['image'] ) ? absint( $section['image'] ) : 0;
			if ( '' === $heading && '' === $text && empty( $list ) && ! $image ) {
				continue;
			}
			$normalized[] = array(
				'heading' => $heading,
				'text'    => $text,
				'list'    => $list,
				'image'   => $image,
			);
		}

		$intro_section = ! empty( $normalized[0] ) ? $normalized[0] : null;
		$rest_sections = array_slice( $normalized, 1 );

		if ( $intro_section && ( '' !== $intro_section['heading'] || '' !== $intro_section['text'] || $intro_section['image'] || get_post_thumbnail_id( $post_id ) ) ) :
			$intro_img = $intro_section['image'] ? $intro_section['image'] : (int) get_post_thumbnail_id( $post_id );
			?>
			<section class="sec sv-intro">
				<div class="wrap split">
					<div class="split-text">
						<?php if ( '' !== $intro_section['heading'] || '' !== $intro_section['text'] ) : ?>
							<div class="rule" aria-hidden="true"></div>
						<?php endif; ?>
						<?php if ( '' !== $intro_section['heading'] ) : ?>
							<h2><?php echo esc_html( $intro_section['heading'] ); ?></h2>
						<?php endif; ?>
						<?php if ( '' !== $intro_section['text'] ) : ?>
							<div class="split-body">
								<?php echo llb_paragraphs( $intro_section['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
							</div>
						<?php endif; ?>
					</div>
					<?php if ( $intro_img ) : ?>
						<div class="split-img rv">
							<?php
							echo wp_get_attachment_image(
								$intro_img,
								'large',
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

		<?php foreach ( $rest_sections as $section ) : ?>
			<?php
			$has_list = ! empty( $section['list'] );
			$has_text = '' !== $section['text'];
			$has_head = '' !== $section['heading'];
			if ( ! $has_list && ! $has_text && ! $has_head ) {
				continue;
			}
			$sec_class = $has_list ? 'sec sv-work' : 'sec';
			?>
			<section class="<?php echo esc_attr( $sec_class ); ?>">
				<div class="wrap sv-work-grid">
					<div>
						<?php if ( $has_head ) : ?>
							<div class="rule" aria-hidden="true"></div>
							<h2><?php echo esc_html( $section['heading'] ); ?></h2>
						<?php endif; ?>
					</div>
					<?php if ( $has_list ) : ?>
						<ul class="checks">
							<?php foreach ( $section['list'] as $item ) : ?>
								<li><?php echo esc_html( $item ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php elseif ( $has_text ) : ?>
						<div>
							<?php echo llb_paragraphs( $section['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endforeach; ?>

		<?php
		$steps_heading = trim( (string) llb_get_meta( $post_id, '_llb_steps_heading' ) );
		$steps_raw     = llb_get_meta( $post_id, '_llb_steps' );
		$steps         = array();
		if ( is_array( $steps_raw ) ) {
			foreach ( $steps_raw as $step ) {
				if ( ! is_array( $step ) ) {
					continue;
				}
				$step_title = isset( $step['title'] ) ? llb_strip_step_number_prefix( (string) $step['title'] ) : '';
				$step_text  = isset( $step['text'] ) ? trim( (string) $step['text'] ) : '';
				if ( '' === $step_title && '' === $step_text ) {
					continue;
				}
				$steps[] = array(
					'title' => $step_title,
					'text'  => $step_text,
				);
			}
		}

		if ( ! empty( $steps ) ) :
			?>
			<section class="sec why">
				<div class="wrap">
					<?php if ( '' !== $steps_heading ) : ?>
						<div class="rule" aria-hidden="true"></div>
						<h2 style="max-width:18ch"><?php echo esc_html( $steps_heading ); ?></h2>
					<?php endif; ?>
					<ol class="sv-steps">
						<?php foreach ( $steps as $index => $step ) : ?>
							<li>
								<span class="step-no"><?php echo esc_html( str_pad( (string) ( (int) $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
								<?php if ( '' !== $step['title'] ) : ?>
									<h3><?php echo esc_html( $step['title'] ); ?></h3>
								<?php endif; ?>
								<?php if ( '' !== $step['text'] ) : ?>
									<p><?php echo esc_html( $step['text'] ); ?></p>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ol>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$related_projects = llb_projects_enabled() ? llb_get_related_projects_for_service( $post_id, 2 ) : array();
		$projects_heading = trim( (string) llb_get_option( 'llb_service_projects_heading' ) );
		$projects_btn     = trim( (string) llb_get_option( 'llb_service_projects_btn' ) );
		$card_btn         = trim( (string) llb_get_projects_page_meta( '_llb_card_btn_text' ) );
		if ( '' === $card_btn ) {
			$card_btn = 'Bekijk project';
		}

		if ( llb_projects_enabled() && ! empty( $related_projects ) && ( '' !== $projects_heading || '' !== $projects_btn ) ) :
			?>
			<section class="sec">
				<div class="wrap">
					<div class="sec-head">
						<div>
							<?php if ( '' !== $projects_heading ) : ?>
								<div class="rule" aria-hidden="true"></div>
								<h2><?php echo esc_html( $projects_heading ); ?></h2>
							<?php endif; ?>
						</div>
						<?php if ( '' !== $projects_btn ) : ?>
							<a class="btn btn-line" href="<?php echo esc_url( llb_get_projects_page_url() ); ?>">
								<?php echo esc_html( $projects_btn ); ?>
								<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
							</a>
						<?php endif; ?>
					</div>
					<ul class="pgrid pgrid--2">
						<?php foreach ( $related_projects as $project ) : ?>
							<?php
							get_template_part(
								'template-parts/project-card',
								null,
								array(
									'project'     => $project,
									'button_text' => $card_btn,
								)
							);
							?>
						<?php endforeach; ?>
					</ul>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$related_faq  = llb_get_related_faq_for_service( $post_id, 3 );
		$faq_heading  = trim( (string) llb_get_option( 'llb_service_faq_heading' ) );
		$faq_btn      = trim( (string) llb_get_option( 'llb_service_faq_btn' ) );
		$faq_page_url = llb_page_url( 'veelgestelde-vragen' );

		if ( ! empty( $related_faq ) && ( '' !== $faq_heading || '' !== $faq_btn ) ) :
			?>
			<section class="sec faq">
				<div class="wrap faq-grid">
					<div class="faq-side">
						<?php if ( '' !== $faq_heading ) : ?>
							<div class="rule" aria-hidden="true"></div>
							<h2><?php echo esc_html( $faq_heading ); ?></h2>
						<?php endif; ?>
						<?php if ( '' !== $faq_btn && $faq_page_url ) : ?>
							<a class="btn btn-line" href="<?php echo esc_url( $faq_page_url ); ?>">
								<?php echo esc_html( $faq_btn ); ?>
								<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
							</a>
						<?php endif; ?>
					</div>
					<div>
						<?php
						get_template_part(
							'template-parts/faq-accordion',
							null,
							array(
								'items' => $related_faq,
							)
						);
						?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$others_heading = trim( (string) llb_get_option( 'llb_service_others_heading' ) );
		$other_services = array();
		foreach ( llb_get_services() as $service ) {
			if ( (int) $service->ID === (int) $post_id ) {
				continue;
			}
			$other_services[] = $service;
		}

		if ( ! empty( $other_services ) && '' !== $others_heading ) :
			?>
			<section class="sec">
				<div class="wrap">
					<div class="sec-head">
						<div>
							<div class="rule" aria-hidden="true"></div>
							<h2><?php echo esc_html( $others_heading ); ?></h2>
						</div>
					</div>
					<ul class="others">
						<?php foreach ( $other_services as $service ) : ?>
							<?php
							$icon = trim( (string) llb_get_meta( $service->ID, '_llb_service_icon' ) );
							if ( '' === $icon || ! isset( llb_service_icon_options()[ $icon ] ) ) {
								$icon = llb_default_service_icon_for_slug( $service->post_name );
							}
							?>
							<li>
								<a href="<?php echo esc_url( get_permalink( $service ) ); ?>">
									<span class="o-ic" aria-hidden="true">
										<?php echo llb_get_mdi_icon_svg( $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
									</span>
									<?php echo esc_html( get_the_title( $service ) ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$cta_heading = trim( (string) llb_get_meta( $post_id, '_llb_cta_heading' ) );
		$cta_text    = (string) llb_get_meta( $post_id, '_llb_cta_text' );
		$cta_btn     = $cta_button;
		$cta_image   = llb_get_home_cta_image_id();

		get_template_part(
			'template-parts/cta-band',
			null,
			array(
				'heading'     => $cta_heading,
				'text'        => $cta_text,
				'button_text' => $cta_btn,
				'button_url'  => $contact_url,
				'image_id'    => $cta_image,
			)
		);
		?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
