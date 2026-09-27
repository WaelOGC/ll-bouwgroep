<?php
/**
 * Home — projects band (design v2 — text only, no mosaic).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id  = get_the_ID();
$heading  = trim( (string) llb_get_meta( $post_id, '_llb_projects_heading' ) );
$text     = trim( (string) llb_get_meta( $post_id, '_llb_projects_text' ) );
$btn_text = trim( (string) llb_get_meta( $post_id, '_llb_projects_btn_text' ) );
$btn_url  = llb_page_url( 'projecten' );

if ( '' === $heading && '' === $text && '' === $btn_text ) {
	return;
}
?>
<section class="sec proj" id="projecten">
	<div class="wrap proj-grid">
		<div>
			<?php if ( '' !== $heading ) : ?>
				<div class="rule" aria-hidden="true"></div>
				<h2><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
		</div>
		<div class="proj-text">
			<?php if ( '' !== $text ) : ?>
				<?php echo llb_paragraphs( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
			<?php endif; ?>
			<?php if ( '' !== $btn_text ) : ?>
				<a class="btn btn-line" href="<?php echo esc_url( $btn_url ); ?>">
					<?php echo esc_html( $btn_text ); ?>
					<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
