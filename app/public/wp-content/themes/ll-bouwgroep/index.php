<?php
/**
 * Main index template (fallback).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="llb-main llb-page-default">
	<?php
	get_template_part(
		'template-parts/page-hero',
		null,
		array(
			'title' => get_bloginfo( 'name' ),
		)
	);
	?>
	<div class="llb-container">
		<div class="llb-content-narrow">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<article <?php post_class( 'llb-index-item' ); ?>>
						<h2>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="llb-entry-content">
							<?php the_excerpt(); ?>
						</div>
					</article>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</main>
<?php
get_footer();
