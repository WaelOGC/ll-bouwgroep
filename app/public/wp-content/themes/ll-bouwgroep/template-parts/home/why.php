<?php
/**
 * Home — why us.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id  = get_the_ID();
$heading  = trim( (string) llb_get_meta( $post_id, '_llb_why_heading' ) );
$text     = trim( (string) llb_get_meta( $post_id, '_llb_why_text' ) );
$image_id = absint( llb_get_meta( $post_id, '_llb_why_image' ) );

if ( '' === $heading && '' === $text && ! $image_id ) {
	return;
}
?>
<section class="llb-section llb-home-why llb-section--angled llb-reveal">
	<?php
	get_template_part(
		'template-parts/section-decor',
		null,
		array(
			'tool_pattern' => true,
		)
	);
	?>
	<div class="llb-container llb-home-why__grid">
		<div class="llb-home-why__intro">
			<?php if ( '' !== $heading ) : ?>
				<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
				<h2><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<?php if ( '' !== $text ) : ?>
				<div class="llb-home-why__text">
					<?php echo llb_paragraphs( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( $image_id ) : ?>
			<div class="llb-home-why__aside">
				<?php
				echo wp_get_attachment_image(
					$image_id,
					'large',
					false,
					array(
						'class'    => 'llb-home-why__image',
						'loading'  => 'lazy',
						'decoding' => 'async',
					)
				);
				?>
			</div>
		<?php else : ?>
			<div class="llb-home-why__aside" aria-hidden="true">
				<span class="llb-home-why__shape"></span>
			</div>
		<?php endif; ?>
	</div>
</section>
