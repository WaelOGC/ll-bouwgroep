<?php
/**
 * Default page template.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="llb-main llb-page-default">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php
		get_template_part(
			'template-parts/page-hero',
			null,
			array(
				'title' => get_the_title(),
			)
		);
		?>
		<div class="llb-container">
			<article <?php post_class( 'llb-content-narrow' ); ?>>
				<div class="llb-entry-content">
					<?php the_content(); ?>
				</div>
			</article>
		</div>
	<?php endwhile; ?>
</main>
<?php
get_footer();
