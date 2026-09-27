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
<main id="main" class="llb-home">
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
	<?php endwhile; ?>
</main>
<?php
get_footer();
