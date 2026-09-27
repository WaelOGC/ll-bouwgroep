<?php
/**
 * Template Name: Home
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="llb-main llb-home">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php get_template_part( 'template-parts/home/hero' ); ?>
		<?php get_template_part( 'template-parts/home/intro' ); ?>
		<?php get_template_part( 'template-parts/home/bathrooms' ); ?>
		<?php get_template_part( 'template-parts/home/services' ); ?>
		<?php get_template_part( 'template-parts/home/why' ); ?>
		<?php get_template_part( 'template-parts/home/projects' ); ?>
		<?php get_template_part( 'template-parts/home/faq' ); ?>
		<?php get_template_part( 'template-parts/home/cta' ); ?>
		<?php
		$raw_content = get_post_field( 'post_content', get_the_ID() );
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
