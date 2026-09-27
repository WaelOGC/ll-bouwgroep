<?php
/**
 * Home — introduction.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();
$heading = trim( (string) llb_get_meta( $post_id, '_llb_intro_heading' ) );
$text    = trim( (string) llb_get_meta( $post_id, '_llb_intro_text' ) );

if ( '' === $heading && '' === $text ) {
	return;
}
?>
<section class="llb-section llb-home-intro">
	<div class="llb-container llb-home-intro__grid">
		<div class="llb-home-intro__heading">
			<?php if ( '' !== $heading ) : ?>
				<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
				<h2><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
		</div>
		<?php if ( '' !== $text ) : ?>
			<div class="llb-home-intro__text">
				<?php echo llb_paragraphs( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
			</div>
		<?php endif; ?>
	</div>
</section>
