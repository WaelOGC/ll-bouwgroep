<?php
/**
 * Main index template.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="llb-main">
	<div class="llb-container">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<article <?php post_class(); ?>>
					<?php if ( is_singular() ) : ?>
						<h1><?php the_title(); ?></h1>
					<?php else : ?>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php endif; ?>
					<div class="llb-entry-content">
						<?php the_content(); ?>
					</div>
				</article>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php echo esc_html__( 'Geen berichten gevonden.', 'll-bouwgroep' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
