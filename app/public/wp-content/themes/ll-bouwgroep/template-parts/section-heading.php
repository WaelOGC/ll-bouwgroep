<?php
/**
 * Section heading template part.
 *
 * Args: heading, level (h2/h3), text.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = isset( $args['heading'] ) ? trim( (string) $args['heading'] ) : '';
$level   = isset( $args['level'] ) ? (string) $args['level'] : 'h2';
$text    = isset( $args['text'] ) ? (string) $args['text'] : '';

if ( '' === $heading ) {
	return;
}

if ( ! in_array( $level, array( 'h2', 'h3' ), true ) ) {
	$level = 'h2';
}
?>
<div class="llb-section-heading">
	<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
	<?php
	printf(
		'<%1$s>%2$s</%1$s>',
		tag_escape( $level ),
		esc_html( $heading )
	);
	?>
	<?php if ( '' !== trim( $text ) ) : ?>
		<div class="llb-section-heading__text">
			<?php echo llb_paragraphs( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
		</div>
	<?php endif; ?>
</div>
