<?php
/**
 * Home — intro (design v2).
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
<section class="sec intro">
	<div class="wrap intro-grid">
		<div>
			<?php if ( '' !== $heading ) : ?>
				<div class="rule" aria-hidden="true"></div>
				<h2><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
		</div>
		<?php if ( '' !== $text ) : ?>
			<div class="intro-text">
				<?php echo llb_paragraphs( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
			</div>
		<?php endif; ?>
	</div>
</section>
