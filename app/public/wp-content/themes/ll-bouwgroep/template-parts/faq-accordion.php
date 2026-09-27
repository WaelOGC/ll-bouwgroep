<?php
/**
 * FAQ accordion list.
 *
 * Args: items (array of question/answer), class (optional).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = isset( $args['items'] ) && is_array( $args['items'] ) ? $args['items'] : array();
$class = isset( $args['class'] ) ? trim( (string) $args['class'] ) : '';

if ( empty( $items ) ) {
	return;
}

$list_class = 'llb-faq-accordion';
if ( '' !== $class ) {
	$list_class .= ' ' . $class;
}
?>
<div class="<?php echo esc_attr( $list_class ); ?>">
	<?php foreach ( $items as $item ) : ?>
		<?php
		if ( ! is_array( $item ) ) {
			continue;
		}
		$question = isset( $item['question'] ) ? trim( (string) $item['question'] ) : '';
		$answer   = isset( $item['answer'] ) ? trim( (string) $item['answer'] ) : '';
		if ( '' === $question || '' === $answer ) {
			continue;
		}
		?>
		<details class="llb-accordion">
			<summary class="llb-accordion__summary">
				<span class="llb-accordion__question"><?php echo esc_html( $question ); ?></span>
				<span class="llb-accordion__icon" aria-hidden="true">
					<?php echo llb_icon( 'plus' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</span>
			</summary>
			<div class="llb-accordion__answer">
				<div class="llb-accordion__answer-inner">
					<?php echo llb_paragraphs( $answer ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
				</div>
			</div>
		</details>
	<?php endforeach; ?>
</div>
