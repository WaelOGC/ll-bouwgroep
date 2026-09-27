<?php
/**
 * Template Name: Projects overview
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$has_projects = llb_has_projects();
$filter_slug  = llb_get_projects_filter_slug();
$page_number  = llb_get_projects_page_number();
$filter_terms = $has_projects ? llb_get_project_filter_terms() : array();
$all_label    = '';
$card_btn     = '';
$projects_q   = null;
$featured     = null;

?>
<main id="main" class="llb-main llb-page-projects">
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

		$intro_heading = trim( (string) llb_get_meta( $post_id, '_llb_intro_heading' ) );
		$intro_text    = trim( (string) llb_get_meta( $post_id, '_llb_intro_text' ) );
		$all_label     = trim( (string) llb_get_meta( $post_id, '_llb_filter_all_label' ) );
		$card_btn      = trim( (string) llb_get_meta( $post_id, '_llb_card_btn_text' ) );
		?>

		<?php if ( '' !== $intro_heading || '' !== $intro_text ) : ?>
			<section class="llb-section llb-projects-intro llb-reveal">
				<div class="llb-container">
					<div class="llb-projects-intro__header">
						<?php if ( '' !== $intro_heading ) : ?>
							<div class="llb-projects-intro__heading">
								<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
								<h2><?php echo esc_html( $intro_heading ); ?></h2>
							</div>
						<?php endif; ?>
						<?php if ( '' !== $intro_text ) : ?>
							<div class="llb-projects-intro__text">
								<?php echo llb_paragraphs( $intro_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $has_projects ) : ?>
			<?php
			$projects_q = llb_query_projects( $filter_slug, $page_number, 9 );
			$featured   = llb_get_featured_project();
			?>

			<section class="llb-section llb-projects-listing llb-reveal">
				<div class="llb-container">
					<?php if ( '' !== $all_label || ! empty( $filter_terms ) ) : ?>
						<nav class="llb-project-filter" aria-label="<?php echo esc_attr( $all_label ? $all_label : 'Filter' ); ?>">
							<ul class="llb-project-filter__pills">
								<?php if ( '' !== $all_label ) : ?>
									<li>
										<a
											class="llb-project-filter__pill<?php echo '' === $filter_slug ? ' is-active' : ''; ?>"
											href="<?php echo esc_url( llb_get_projects_page_url() ); ?>"
											<?php echo '' === $filter_slug ? ' aria-current="page"' : ''; ?>
										><?php echo esc_html( $all_label ); ?></a>
									</li>
								<?php endif; ?>
								<?php foreach ( $filter_terms as $term ) : ?>
									<li class="llb-project-filter__pill-item--desktop">
										<a
											class="llb-project-filter__pill<?php echo $filter_slug === $term->slug ? ' is-active' : ''; ?>"
											href="<?php echo esc_url( llb_get_projects_page_url( array( 'categorie' => $term->slug ) ) ); ?>"
											<?php echo $filter_slug === $term->slug ? ' aria-current="page"' : ''; ?>
										><?php echo esc_html( $term->name ); ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
							<?php if ( ! empty( $filter_terms ) ) : ?>
								<form class="llb-project-filter__select-form" method="get" action="<?php echo esc_url( llb_get_projects_page_url() ); ?>">
									<label class="screen-reader-text" for="llb-project-filter-select"><?php echo esc_html( $all_label ? $all_label : 'Filter' ); ?></label>
									<select id="llb-project-filter-select" class="llb-project-filter__select" name="categorie">
										<option value=""<?php selected( $filter_slug, '' ); ?>><?php echo esc_html( $all_label ? $all_label : '—' ); ?></option>
										<?php foreach ( $filter_terms as $term ) : ?>
											<option value="<?php echo esc_attr( $term->slug ); ?>"<?php selected( $filter_slug, $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
										<?php endforeach; ?>
									</select>
								</form>
							<?php endif; ?>
						</nav>
					<?php endif; ?>

					<?php if ( $projects_q instanceof WP_Query && $projects_q->have_posts() ) : ?>
						<ul class="llb-projects-grid">
							<?php
							while ( $projects_q->have_posts() ) :
								$projects_q->the_post();
								?>
								<li class="llb-projects-grid__item">
									<?php
									get_template_part(
										'template-parts/project-card',
										null,
										array(
											'project' => get_post(),
										)
									);
									?>
								</li>
							<?php endwhile; ?>
						</ul>
						<?php
						$total_pages = (int) $projects_q->max_num_pages;
						if ( $total_pages > 1 ) :
							?>
							<nav class="llb-pagination" aria-label="Paginering">
								<ul class="llb-pagination__list">
									<?php for ( $i = 1; $i <= $total_pages; $i++ ) : ?>
										<li>
											<?php if ( $i === $page_number ) : ?>
												<span class="llb-pagination__item is-current" aria-current="page"><?php echo esc_html( (string) $i ); ?></span>
											<?php else : ?>
												<a class="llb-pagination__item" href="<?php echo esc_url( llb_get_projects_page_url( array( 'categorie' => $filter_slug, 'pagina' => $i ) ) ); ?>"><?php echo esc_html( (string) $i ); ?></a>
											<?php endif; ?>
										</li>
									<?php endfor; ?>
								</ul>
							</nav>
						<?php endif; ?>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>
				</div>
			</section>

			<?php if ( $featured instanceof WP_Post ) : ?>
				<?php
				$gallery_ids = llb_get_project_gallery_ids( $featured->ID );
				$desc        = trim( (string) llb_get_meta( $featured->ID, '_llb_project_description' ) );
				$work_lines  = llb_get_lines( $featured->ID, '_llb_project_work' );
				?>
				<section class="llb-section llb-section--light llb-featured-project llb-reveal">
					<div class="llb-container llb-featured-project__inner">
						<div class="llb-featured-project__media">
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
						<div class="llb-featured-project__copy">
							<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
							<h2><?php echo esc_html( get_the_title( $featured ) ); ?></h2>
							<?php if ( '' !== $desc ) : ?>
								<div class="llb-featured-project__text">
									<?php echo llb_paragraphs( $desc ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
								</div>
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
							<?php if ( '' !== $card_btn ) : ?>
								<a class="llb-btn llb-btn--primary" href="<?php echo esc_url( get_permalink( $featured ) ); ?>">
									<span><?php echo esc_html( $card_btn ); ?></span>
									<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</section>
			<?php endif; ?>
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
