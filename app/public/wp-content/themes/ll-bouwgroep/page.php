<?php
/**
 * Default page template (Privacyverklaring and normal pages).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Elementor builder pages render their own layout (no hero, TOC or prose wrapper).
if ( function_exists( 'llb_is_elementor_builder_page' ) && llb_is_elementor_builder_page( get_queried_object_id() ) ) {
	require LLB_DIR . '/page-templates/template-elementor.php';
	return;
}

get_header();
?>
<main id="main" class="llb-main llb-page-default">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php
		$post_id   = get_the_ID();
		$title     = trim( (string) llb_get_meta( $post_id, '_llb_hero_title' ) );
		$intro     = trim( (string) llb_get_meta( $post_id, '_llb_hero_intro' ) );
		$image_id  = absint( llb_get_meta( $post_id, '_llb_hero_image' ) );
		$mobile_id = absint( llb_get_meta( $post_id, '_llb_hero_image_mobile' ) );

		if ( '' === $title ) {
			$title = get_the_title();
		}

		if ( $image_id || $mobile_id ) {
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
		} else {
			?>
			<section class="thero">
				<div class="wrap">
					<?php
					if ( function_exists( 'llb_breadcrumbs' ) ) {
						llb_breadcrumbs();
					}
					?>
					<?php if ( '' !== $title ) : ?>
						<h1><?php echo esc_html( $title ); ?></h1>
						<div class="rule" aria-hidden="true"></div>
					<?php endif; ?>
					<?php if ( '' !== $intro ) : ?>
						<p><?php echo esc_html( $intro ); ?></p>
					<?php endif; ?>
				</div>
			</section>
			<?php
		}

		$content  = apply_filters( 'the_content', get_the_content() );
		$prepared = llb_prose_prepare( $content );
		$toc      = $prepared['toc'];
		$has_toc  = count( $toc ) >= 2;
		?>
		<section class="sec">
			<div class="wrap<?php echo $has_toc ? ' tgrid' : ''; ?>">
				<?php if ( $has_toc ) : ?>
					<nav class="toc" aria-label="Inhoud">
						<span class="fnav-t">Inhoud</span>
						<ul>
							<?php foreach ( $toc as $index => $item ) : ?>
								<li>
									<a href="#<?php echo esc_attr( $item['id'] ); ?>"<?php echo 0 === $index ? ' aria-current="true"' : ''; ?>>
										<?php echo esc_html( $item['title'] ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</nav>
				<?php endif; ?>
				<article <?php post_class( 'prose' ); ?>>
					<?php echo $prepared['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- filtered post content + ids. ?>
				</article>
			</div>
		</section>
	<?php endwhile; ?>
</main>
<?php
get_footer();
