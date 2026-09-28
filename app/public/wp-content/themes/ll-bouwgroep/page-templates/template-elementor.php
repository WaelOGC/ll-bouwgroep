<?php
/**
 * Elementor builder pages: header, Elementor content, footer.
 *
 * Applied automatically by inc/compat/elementor.php — no Template Name on purpose,
 * so it never shows up in the page template dropdown.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="llb-main llb-main--elementor">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
