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
<main id="main" class="llb-page-contact">
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

		$form_heading    = trim( (string) llb_get_meta( $post_id, '_llb_form_heading' ) );
		$form_text       = trim( (string) llb_get_meta( $post_id, '_llb_form_text' ) );
		$form_html       = llb_contact_form();
		$details_heading = trim( (string) llb_get_meta( $post_id, '_llb_details_heading' ) );
		$details_text    = trim( (string) llb_get_meta( $post_id, '_llb_details_text' ) );
		$hours_heading   = trim( (string) llb_get_meta( $post_id, '_llb_hours_heading' ) );
		$map_btn_text    = trim( (string) llb_get_meta( $post_id, '_llb_map_btn_text' ) );
		$faq_link_text   = trim( (string) llb_get_meta( $post_id, '_llb_faq_link_text' ) );
		$faq_page_id     = llb_get_faq_page_id();
		$faq_url         = $faq_page_id ? get_permalink( $faq_page_id ) : llb_page_url( 'veelgestelde-vragen' );

		$phone     = trim( (string) llb_get_option( 'llb_phone' ) );
		$phone_tel = preg_replace( '/[^\d+]/', '', $phone );
		$email     = trim( (string) llb_get_option( 'llb_email' ) );
		$address   = llb_get_address();
		$map_url   = llb_get_map_url();
		$hours     = llb_get_opening_hours();
		$map_id    = absint( llb_get_option( 'llb_map_image' ) );
		$cf7_active = defined( 'WPCF7_VERSION' );
		?>

		<section class="sec">
			<div class="wrap cgrid">
				<aside class="cinfo">
					<?php if ( '' !== $details_heading ) : ?>
						<div class="rule" aria-hidden="true"></div>
						<h2><?php echo esc_html( $details_heading ); ?></h2>
					<?php endif; ?>
					<?php if ( '' !== $details_text ) : ?>
						<p class="lead"><?php echo esc_html( $details_text ); ?></p>
					<?php endif; ?>

					<ul class="cinfo-list">
						<?php if ( '' !== $phone && '' !== $phone_tel ) : ?>
							<li>
								<span class="cinfo-ic" aria-hidden="true">
									<svg viewBox="0 0 24 24"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
								</span>
								<div>
									<span class="cinfo-k">Telefoon</span>
									<a class="cinfo-v" href="<?php echo esc_url( 'tel:' . $phone_tel ); ?>"><?php echo esc_html( $phone ); ?></a>
								</div>
							</li>
						<?php endif; ?>
						<?php if ( '' !== $email ) : ?>
							<li>
								<span class="cinfo-ic" aria-hidden="true">
									<svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
								</span>
								<div>
									<span class="cinfo-k">E-mail</span>
									<a class="cinfo-v" href="<?php echo esc_url( 'mailto:' . antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a>
								</div>
							</li>
						<?php endif; ?>
						<?php if ( '' !== $address ) : ?>
							<li>
								<span class="cinfo-ic" aria-hidden="true">
									<svg viewBox="0 0 24 24"><path d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zm0 9.5c-1.4 0-2.5-1.1-2.5-2.5S10.6 6.5 12 6.5s2.5 1.1 2.5 2.5-1.1 2.5-2.5 2.5z"/></svg>
								</span>
								<div>
									<span class="cinfo-k">Adres</span>
									<span class="cinfo-v"><?php echo esc_html( $address ); ?></span>
									<?php if ( '' !== $map_btn_text && '' !== $map_url ) : ?>
										<br>
										<a class="link" href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener noreferrer">
											<?php echo esc_html( $map_btn_text ); ?>
											<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
										</a>
									<?php endif; ?>
								</div>
							</li>
						<?php endif; ?>
						<?php
						ob_start();
						get_template_part( 'template-parts/social-icons', null, array( 'variant' => 'contact' ) );
						$llb_contact_social = trim( (string) ob_get_clean() );
						if ( '' !== $llb_contact_social ) :
							?>
							<li class="cinfo-social-only"><?php echo $llb_contact_social; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- template part escapes its own output. ?></li>
						<?php endif; ?>
						<?php if ( '' !== $hours_heading && ! empty( $hours ) ) : ?>
							<li>
								<span class="cinfo-ic" aria-hidden="true">
									<svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 18a8 8 0 110-16 8 8 0 010 16zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z"/></svg>
								</span>
								<div>
									<span class="cinfo-k"><?php echo esc_html( $hours_heading ); ?></span>
									<dl class="chours">
										<?php foreach ( $hours as $row ) : ?>
											<dt><?php echo esc_html( $row['label'] ); ?></dt>
											<dd><?php echo esc_html( $row['value'] ); ?></dd>
										<?php endforeach; ?>
									</dl>
								</div>
							</li>
						<?php endif; ?>
					</ul>

					<?php if ( $map_id ) : ?>
						<?php if ( '' !== $map_url ) : ?>
							<a class="cinfo-map" href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener noreferrer">
								<?php
								echo wp_get_attachment_image(
									$map_id,
									'large',
									false,
llb_lazy_img_attrs( 'cta' )
								);
								?>
							</a>
						<?php else : ?>
							<div class="cinfo-map">
								<?php
								echo wp_get_attachment_image(
									$map_id,
									'large',
									false,
llb_lazy_img_attrs( 'cta' )
								);
								?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</aside>

				<div class="cform-col">
					<?php if ( '' !== $form_heading ) : ?>
						<div class="rule" aria-hidden="true"></div>
						<h2><?php echo esc_html( $form_heading ); ?></h2>
					<?php endif; ?>
					<?php if ( '' !== $form_text ) : ?>
						<p class="lead"><?php echo esc_html( $form_text ); ?></p>
					<?php endif; ?>

					<?php if ( '' !== $form_html ) : ?>
						<?php echo $form_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CF7 markup. ?>
					<?php elseif ( ! $cf7_active && current_user_can( 'manage_options' ) ) : ?>
						<p class="lead"><?php echo esc_html( 'Activeer Contact Form 7 om het contactformulier te tonen.' ); ?></p>
					<?php endif; ?>

					<?php if ( '' !== $faq_link_text && $faq_url ) : ?>
						<p class="cfaq">
							<a class="link" href="<?php echo esc_url( $faq_url ); ?>">
								<?php echo esc_html( $faq_link_text ); ?>
								<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
							</a>
						</p>
					<?php endif; ?>
				</div>
			</div>
		</section>
	<?php endwhile; ?>
</main>
<?php
get_footer();
