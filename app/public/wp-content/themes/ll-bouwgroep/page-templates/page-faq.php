<?php
/**
 * Template Name: FAQ
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="llb-main llb-page-faq">
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

		$groups      = llb_get_faq_items_grouped();
		$cta_heading = trim( (string) llb_get_meta( $post_id, '_llb_cta_heading' ) );
		$cta_btn     = trim( (string) llb_get_meta( $post_id, '_llb_cta_btn_text' ) );
		?>

		<?php foreach ( $groups as $group ) : ?>
			<?php if ( empty( $group['items'] ) ) : ?>
				<?php continue; ?>
			<?php endif; ?>
			<section class="llb-section llb-faq-group llb-reveal">
				<div class="llb-container llb-content-narrow">
					<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
					<h2><?php echo esc_html( $group['label'] ); ?></h2>
					<?php
					get_template_part(
						'template-parts/faq-accordion',
						null,
						array(
							'items' => $group['items'],
						)
					);
					?>
				</div>
			</section>
		<?php endforeach; ?>

		<?php
		get_template_part(
			'template-parts/cta-band',
			null,
			array(
				'heading'     => $cta_heading,
				'button_text' => $cta_btn,
				'button_url'  => llb_page_url( 'contact' ),
			)
		);

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
