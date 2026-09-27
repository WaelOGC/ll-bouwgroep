<?php
/**
 * Template Name: Contact
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="llb-main llb-page-contact">
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

		$form_heading    = trim( (string) llb_get_meta( $post_id, '_llb_form_heading' ) );
		$form_text       = trim( (string) llb_get_meta( $post_id, '_llb_form_text' ) );
		$form_html       = llb_contact_form();
		$details_heading = trim( (string) llb_get_meta( $post_id, '_llb_details_heading' ) );
		$details_text    = trim( (string) llb_get_meta( $post_id, '_llb_details_text' ) );
		$hours_heading   = trim( (string) llb_get_meta( $post_id, '_llb_hours_heading' ) );
		$map_btn_text    = trim( (string) llb_get_meta( $post_id, '_llb_map_btn_text' ) );
		$faq_link_text   = trim( (string) llb_get_meta( $post_id, '_llb_faq_link_text' ) );
		$faq_items       = llb_get_home_faq_items();
		$faq_page_id     = llb_get_faq_page_id();
		$faq_url         = $faq_page_id ? get_permalink( $faq_page_id ) : llb_page_url( 'veelgestelde-vragen' );

		$phone   = trim( (string) llb_get_option( 'llb_phone' ) );
		$email   = trim( (string) llb_get_option( 'llb_email' ) );
		$address = llb_get_address();
		$map_url = llb_get_map_url();
		$hours   = llb_get_opening_hours();
		$map_id  = absint( llb_get_option( 'llb_map_image' ) );
		?>

		<section class="llb-section llb-contact llb-reveal">
			<div class="llb-container llb-contact__layout">
				<div class="llb-contact__form-col">
					<?php if ( '' !== $form_heading || '' !== $form_text || '' !== $form_html ) : ?>
						<div class="llb-contact__form-block">
							<?php if ( '' !== $form_heading ) : ?>
								<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
								<h2><?php echo esc_html( $form_heading ); ?></h2>
							<?php endif; ?>
							<?php if ( '' !== $form_text ) : ?>
								<div class="llb-contact__lead">
									<?php echo llb_paragraphs( $form_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
								</div>
							<?php endif; ?>
							<?php if ( '' !== $form_html ) : ?>
								<div class="llb-contact__form">
									<?php echo $form_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CF7 markup. ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $faq_items ) || '' !== $faq_link_text ) : ?>
						<div class="llb-contact__faq">
							<?php
							get_template_part(
								'template-parts/faq-accordion',
								null,
								array(
									'items' => $faq_items,
								)
							);
							?>
							<?php if ( '' !== $faq_link_text ) : ?>
								<a class="llb-text-link llb-contact__faq-link" href="<?php echo esc_url( $faq_url ); ?>">
									<span><?php echo esc_html( $faq_link_text ); ?></span>
									<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="llb-contact__details-col">
					<?php if ( '' !== $details_heading || '' !== $details_text ) : ?>
						<div class="llb-contact__details-intro">
							<?php if ( '' !== $details_heading ) : ?>
								<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
								<h2><?php echo esc_html( $details_heading ); ?></h2>
							<?php endif; ?>
							<?php if ( '' !== $details_text ) : ?>
								<div class="llb-contact__lead">
									<?php echo llb_paragraphs( $details_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<ul class="llb-contact-cards">
						<?php if ( '' !== $phone ) : ?>
							<li class="llb-contact-card">
								<span class="llb-contact-card__icon" aria-hidden="true"><?php echo llb_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></span>
								<div class="llb-contact-card__body">
									<strong class="llb-contact-card__label">Telefoon</strong>
									<a href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
								</div>
							</li>
						<?php endif; ?>
						<?php if ( '' !== $email ) : ?>
							<li class="llb-contact-card">
								<span class="llb-contact-card__icon" aria-hidden="true"><?php echo llb_icon( 'email' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></span>
								<div class="llb-contact-card__body">
									<strong class="llb-contact-card__label">E-mail</strong>
									<a href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a>
								</div>
							</li>
						<?php endif; ?>
						<?php if ( '' !== $address ) : ?>
							<li class="llb-contact-card">
								<span class="llb-contact-card__icon" aria-hidden="true"><?php echo llb_icon( 'location' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></span>
								<div class="llb-contact-card__body">
									<strong class="llb-contact-card__label">Adres</strong>
									<span><?php echo esc_html( $address ); ?></span>
									<?php if ( '' !== $map_btn_text && '' !== $map_url ) : ?>
										<a class="llb-text-link" href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener noreferrer">
											<span><?php echo esc_html( $map_btn_text ); ?></span>
											<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
										</a>
									<?php endif; ?>
								</div>
							</li>
						<?php endif; ?>
						<?php if ( '' !== $hours_heading && ! empty( $hours ) ) : ?>
							<li class="llb-contact-card">
								<span class="llb-contact-card__icon" aria-hidden="true"><?php echo llb_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></span>
								<div class="llb-contact-card__body">
									<strong class="llb-contact-card__label"><?php echo esc_html( $hours_heading ); ?></strong>
									<ul class="llb-contact-hours">
										<?php foreach ( $hours as $row ) : ?>
											<li>
												<span class="llb-contact-hours__day"><?php echo esc_html( $row['label'] ); ?></span>
												<span class="llb-contact-hours__value"><?php echo esc_html( $row['value'] ); ?></span>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							</li>
						<?php endif; ?>
					</ul>

					<?php if ( $map_id && '' !== $map_url ) : ?>
						<a class="llb-contact-map" href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener noreferrer">
							<?php
							echo wp_get_attachment_image(
								$map_id,
								'large',
								false,
								array(
									'class'    => 'llb-contact-map__image',
									'loading'  => 'lazy',
									'decoding' => 'async',
								)
							);
							?>
						</a>
					<?php elseif ( $map_id ) : ?>
						<div class="llb-contact-map llb-contact-map--static">
							<?php
							echo wp_get_attachment_image(
								$map_id,
								'large',
								false,
								array(
									'class'    => 'llb-contact-map__image',
									'loading'  => 'lazy',
									'decoding' => 'async',
								)
							);
							?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>

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
