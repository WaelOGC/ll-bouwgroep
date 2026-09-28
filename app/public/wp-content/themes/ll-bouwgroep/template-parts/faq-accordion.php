<?php
/**
 * FAQ accordion list (.qa — design v2).
 *
 * Args: items (array of question/answer).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = isset( $args['items'] ) && is_array( $args['items'] ) ? $args['items'] : array();

if ( empty( $items ) ) {
	return;
}

foreach ( $items as $item ) :
	if ( ! is_array( $item ) ) {
		continue;
	}
	$question = isset( $item['question'] ) ? trim( (string) $item['question'] ) : '';
	$answer   = isset( $item['answer'] ) ? trim( (string) $item['answer'] ) : '';
	if ( '' === $question || '' === $answer ) {
		continue;
	}
	?>
	<div class="qa">
		<button type="button" aria-expanded="false">
			<?php echo esc_html( $question ); ?>
			<span class="qa-x" aria-hidden="true">
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
			</span>
		</button>
		<div class="qa-a">
			<div>
				<?php echo llb_paragraphs( $answer ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
			</div>
		</div>
	</div>
	<?php
endforeach;
