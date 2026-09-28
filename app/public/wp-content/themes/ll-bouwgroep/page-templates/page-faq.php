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

		$groups     = llb_get_faq_items_grouped();
		$visible    = array();
		foreach ( $groups as $slug => $group ) {
			if ( empty( $group['items'] ) ) {
				continue;
			}
			$visible[ $slug ] = $group;
		}

		$fnav_label = trim( (string) llb_get_meta( $post_id, '_llb_fnav_label' ) );
		if ( '' === $fnav_label ) {
			$fnav_label = 'Categorieën';
		}

		$cta_heading = trim( (string) llb_get_meta( $post_id, '_llb_cta_heading' ) );
		$cta_btn     = trim( (string) llb_get_meta( $post_id, '_llb_cta_btn_text' ) );
		$cta_image   = absint( llb_get_meta( $post_id, '_llb_cta_image' ) );
		?>

		<?php if ( ! empty( $visible ) ) : ?>
			<section class="sec">
				<div class="wrap fgrid">
					<nav class="fnav" aria-label="<?php echo esc_attr( $fnav_label ); ?>">
						<span class="fnav-t"><?php echo esc_html( $fnav_label ); ?></span>
						<ul>
							<?php $first = true; ?>
							<?php foreach ( $visible as $slug => $group ) : ?>
								<li>
									<a href="#<?php echo esc_attr( $slug ); ?>"<?php echo $first ? ' aria-current="true"' : ''; ?>>
										<?php echo esc_html( $group['label'] ); ?>
									</a>
								</li>
								<?php $first = false; ?>
							<?php endforeach; ?>
						</ul>
					</nav>
					<div>
						<?php foreach ( $visible as $slug => $group ) : ?>
							<section class="fcat" id="<?php echo esc_attr( $slug ); ?>">
								<div class="rule" aria-hidden="true"></div>
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
							</section>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php
		get_template_part(
			'template-parts/cta-band',
			null,
			array(
				'heading'     => $cta_heading,
				'button_text' => $cta_btn,
				'button_url'  => llb_page_url( 'contact' ),
				'image_id'    => $cta_image,
				'class'       => 'cta--short',
			)
		);
		?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
