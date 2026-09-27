<?php
/**
 * Home — why us (text + decoration only).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();
$heading = trim( (string) llb_get_meta( $post_id, '_llb_why_heading' ) );
$text    = trim( (string) llb_get_meta( $post_id, '_llb_why_text' ) );

if ( '' === $heading && '' === $text ) {
	return;
}
?>
<section class="llb-section llb-home-why llb-reveal">
	<div class="llb-home-why__deco" aria-hidden="true"></div>
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
		<div class="llb-home-why__aside" aria-hidden="true">
			<span class="llb-home-why__shape"></span>
		</div>
	</div>
</section>
