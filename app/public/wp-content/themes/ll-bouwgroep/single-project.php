<?php
/**
 * Single project (design v2).
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
		$gallery_ids = llb_get_project_gallery_ids_excluding_featured( $post_id );
		$about_h     = trim( (string) llb_get_projects_page_meta( '_llb_single_about_heading' ) );
		$work_h      = trim( (string) llb_get_projects_page_meta( '_llb_single_work_heading' ) );
		$result_h    = trim( (string) llb_get_projects_page_meta( '_llb_single_result_heading' ) );
		$desc        = trim( (string) llb_get_meta( $post_id, '_llb_project_description' ) );
		$work_lines  = llb_get_lines( $post_id, '_llb_project_work' );
		$result      = trim( (string) llb_get_meta( $post_id, '_llb_project_result' ) );
		$cta_heading = trim( (string) llb_get_projects_page_meta( '_llb_single_cta_heading' ) );
		$cta_text    = trim( (string) llb_get_projects_page_meta( '_llb_single_cta_text' ) );
		$cta_btn     = trim( (string) llb_get_projects_page_meta( '_llb_single_cta_btn_text' ) );

		$terms = get_the_terms( $post_id, 'project_categorie' );
		$label = ( ! is_wp_error( $terms ) && ! empty( $terms[0] ) ) ? $terms[0]->name : '';

		get_template_part(
			'template-parts/page-hero',
			null,
			array(
				'title'    => $title,
				'intro'    => $intro,
				'image_id' => $image_id,
				'label'    => $label,
				'class'    => 'sv-hero',
			)
		);

		$has_about  = '' !== $desc;
		$has_result = '' !== $result;
		$has_work   = ! empty( $work_lines );
		$has_text   = $has_about || $has_result;
		$has_body   = $has_text || $has_work;
		$multi      = count( $gallery_ids ) > 1;

		if ( ! empty( $gallery_ids ) || $has_body ) :
			?>
			<section class="sec">
				<div class="wrap">
					<?php if ( ! empty( $gallery_ids ) ) : ?>
						<?php
						$srcs = array();
						foreach ( $gallery_ids as $gid ) {
							$url = wp_get_attachment_image_url( $gid, 'large' );
							if ( $url ) {
								$srcs[] = $url;
							}
						}
						$first_id  = (int) $gallery_ids[0];
						$first_alt = trim( (string) get_post_meta( $first_id, '_wp_attachment_image_alt', true ) );
						if ( '' === $first_alt ) {
							$first_alt = $title;
						}
						?>
						<div class="gallery"<?php echo $multi ? ' data-srcs="' . esc_attr( wp_json_encode( $srcs ) ) . '"' : ''; ?>>
							<div class="gal-main">
								<?php
								echo wp_get_attachment_image(
									$first_id,
									'large',
									false,
									array(
										'id'       => $multi ? 'galImg' : '',
										'loading'  => 'eager',
										'decoding' => 'async',
										'sizes'    => llb_image_sizes_attr( 'gallery' ),
										'alt'      => $first_alt,
									)
								);
								?>
								<?php if ( $multi ) : ?>
									<div class="gal-nav">
										<button class="gal-btn" type="button" data-dir="-1" aria-label="Vorige foto">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M19 12H5M11 6l-6 6 6 6"/></svg>
										</button>
										<span class="gal-count"><span id="galN">1</span>&nbsp;/&nbsp;<?php echo esc_html( (string) count( $gallery_ids ) ); ?></span>
										<button class="gal-btn" type="button" data-dir="1" aria-label="Volgende foto">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
										</button>
									</div>
								<?php endif; ?>
							</div>
							<?php if ( $multi ) : ?>
								<ul class="gal-thumbs">
									<?php foreach ( $gallery_ids as $index => $gid ) : ?>
										<li>
											<button type="button" data-i="<?php echo esc_attr( (string) $index ); ?>"<?php echo 0 === $index ? ' aria-current="true"' : ''; ?> aria-label="<?php echo esc_attr( sprintf( 'Foto %d', $index + 1 ) ); ?>">
												<?php
												echo wp_get_attachment_image(
													$gid,
													'medium',
													false,
													llb_lazy_img_attrs(
														'thumb',
														array(
															'alt' => '',
														)
													)
												);
												?>
											</button>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( $has_body ) : ?>
						<div class="pj-grid"<?php echo ! empty( $gallery_ids ) ? ' style="margin-top:clamp(56px,7vw,96px)"' : ''; ?>>
							<?php if ( $has_text ) : ?>
								<div class="pj-text">
									<?php if ( $has_about ) : ?>
										<div class="pj-block">
											<div class="rule" aria-hidden="true"></div>
											<?php if ( '' !== $about_h ) : ?>
												<h2><?php echo esc_html( $about_h ); ?></h2>
											<?php endif; ?>
											<?php echo llb_paragraphs( $desc ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
										</div>
									<?php endif; ?>
									<?php if ( $has_result ) : ?>
										<div class="pj-block">
											<div class="rule" aria-hidden="true"></div>
											<?php if ( '' !== $result_h ) : ?>
												<h2><?php echo esc_html( $result_h ); ?></h2>
											<?php endif; ?>
											<?php echo llb_paragraphs( $result ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							<?php if ( $has_work ) : ?>
								<aside class="pj-side">
									<?php if ( '' !== $work_h ) : ?>
										<h2><?php echo esc_html( $work_h ); ?></h2>
									<?php endif; ?>
									<ul class="checks">
										<?php foreach ( $work_lines as $line ) : ?>
											<li><?php echo esc_html( $line ); ?></li>
										<?php endforeach; ?>
									</ul>
								</aside>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$related          = llb_projects_enabled() ? llb_get_related_projects_for_project( $post_id, 2 ) : array();
		$projects_heading = trim( (string) llb_get_option( 'llb_service_projects_heading' ) );
		$projects_btn     = trim( (string) llb_get_option( 'llb_service_projects_btn' ) );
		$card_btn         = trim( (string) llb_get_projects_page_meta( '_llb_card_btn_text' ) );

		if ( llb_projects_enabled() && ! empty( $related ) && ( '' !== $projects_heading || '' !== $projects_btn ) ) :
			?>
			<section class="sec" style="padding-top:0">
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
						<?php foreach ( $related as $project ) : ?>
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
		$contact_url = llb_page_url( 'contact' );
		if ( '' === $contact_url ) {
			$contact_url = llb_get_header_cta_url();
		}

		get_template_part(
			'template-parts/cta-band',
			null,
			array(
				'heading'     => $cta_heading,
				'text'        => $cta_text,
				'button_text' => $cta_btn,
				'button_url'  => $contact_url,
				'image_id'    => llb_get_home_cta_image_id(),
			)
		);
		?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
