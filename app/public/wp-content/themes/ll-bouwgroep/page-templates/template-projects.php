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
?>
<main id="main" class="llb-page-projects">
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

		$intro_heading = trim( (string) llb_get_meta( $post_id, '_llb_intro_heading' ) );
		$intro_text    = trim( (string) llb_get_meta( $post_id, '_llb_intro_text' ) );
		$all_label     = trim( (string) llb_get_meta( $post_id, '_llb_filter_all_label' ) );
		$card_btn      = trim( (string) llb_get_meta( $post_id, '_llb_card_btn_text' ) );

		$projects_q = $has_projects ? llb_query_projects( $filter_slug, $page_number, 9 ) : null;
		$featured   = $has_projects ? llb_get_featured_project() : null;
		?>

		<?php if ( '' !== $intro_heading || '' !== $intro_text || $featured instanceof WP_Post || $has_projects ) : ?>
			<section class="sec">
				<div class="wrap">
					<?php if ( '' !== $intro_heading || '' !== $intro_text ) : ?>
						<div class="svc-head">
							<?php if ( '' !== $intro_heading ) : ?>
								<div>
									<div class="rule" aria-hidden="true"></div>
									<h2><?php echo esc_html( $intro_heading ); ?></h2>
								</div>
							<?php endif; ?>
							<?php if ( '' !== $intro_text ) : ?>
								<p><?php echo esc_html( $intro_text ); ?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( $featured instanceof WP_Post ) : ?>
						<?php
						$feat_terms = get_the_terms( $featured, 'project_categorie' );
						$feat_cat   = ( ! is_wp_error( $feat_terms ) && ! empty( $feat_terms[0] ) ) ? $feat_terms[0]->name : '';
						$feat_desc  = trim( (string) llb_get_meta( $featured->ID, '_llb_project_description' ) );
						$feat_thumb = get_post_thumbnail_id( $featured );
						?>
						<a class="pfeat" href="<?php echo esc_url( get_permalink( $featured ) ); ?>">
							<div class="pfeat-img">
								<?php if ( $feat_thumb ) : ?>
									<?php
									echo wp_get_attachment_image(
										$feat_thumb,
										'large',
										false,
										array(
											'loading'  => 'lazy',
											'decoding' => 'async',
										)
									);
									?>
								<?php endif; ?>
							</div>
							<div class="pfeat-body">
								<?php if ( '' !== $feat_cat ) : ?>
									<span class="pfeat-label"><?php echo esc_html( $feat_cat ); ?></span>
								<?php endif; ?>
								<h2><?php echo esc_html( get_the_title( $featured ) ); ?></h2>
								<?php if ( '' !== $feat_desc ) : ?>
									<p><?php echo esc_html( $feat_desc ); ?></p>
								<?php endif; ?>
								<?php if ( '' !== $card_btn ) : ?>
									<span class="btn btn-red">
										<?php echo esc_html( $card_btn ); ?>
										<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
									</span>
								<?php endif; ?>
							</div>
						</a>
					<?php endif; ?>

					<?php if ( $has_projects && ( '' !== $all_label || ! empty( $filter_terms ) ) ) : ?>
						<nav class="pfilter"<?php echo '' !== $all_label ? ' aria-label="' . esc_attr( $all_label ) . '"' : ''; ?>>
							<?php if ( '' !== $all_label ) : ?>
								<a
									href="<?php echo esc_url( llb_get_projects_page_url() ); ?>"
									<?php echo '' === $filter_slug ? ' aria-current="page"' : ''; ?>
								><?php echo esc_html( $all_label ); ?></a>
							<?php endif; ?>
							<?php foreach ( $filter_terms as $term ) : ?>
								<a
									href="<?php echo esc_url( llb_get_projects_page_url( array( 'categorie' => $term->slug ) ) ); ?>"
									<?php echo $filter_slug === $term->slug ? ' aria-current="page"' : ''; ?>
								><?php echo esc_html( $term->name ); ?></a>
							<?php endforeach; ?>
						</nav>
					<?php endif; ?>

					<?php if ( $projects_q instanceof WP_Query && $projects_q->have_posts() ) : ?>
						<ul class="pgrid">
							<?php
							while ( $projects_q->have_posts() ) :
								$projects_q->the_post();
								get_template_part(
									'template-parts/project-card',
									null,
									array(
										'project'     => get_post(),
										'button_text' => $card_btn,
									)
								);
							endwhile;
							?>
						</ul>
						<?php
						$total_pages = (int) $projects_q->max_num_pages;
						if ( $total_pages > 1 ) :
							?>
							<nav class="pager">
								<?php for ( $i = 1; $i <= $total_pages; $i++ ) : ?>
									<?php if ( $i === $page_number ) : ?>
										<span aria-current="page"><?php echo esc_html( (string) $i ); ?></span>
									<?php else : ?>
										<a href="<?php echo esc_url( llb_get_projects_page_url( array( 'categorie' => $filter_slug, 'pagina' => $i ) ) ); ?>"><?php echo esc_html( (string) $i ); ?></a>
									<?php endif; ?>
								<?php endfor; ?>
							</nav>
						<?php endif; ?>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
