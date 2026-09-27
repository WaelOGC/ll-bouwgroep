<?php
/**
 * Home — USP strip (why items).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = llb_get_meta( get_the_ID(), '_llb_why_items' );
if ( ! is_array( $items ) ) {
	$items = array();
}

$icons = array( 'team', 'handshake', 'checklist' );
$rows  = array();

foreach ( $items as $index => $item ) {
	if ( ! is_array( $item ) ) {
		continue;
	}
	$title = isset( $item['title'] ) ? trim( (string) $item['title'] ) : '';
	$text  = isset( $item['text'] ) ? trim( (string) $item['text'] ) : '';
	if ( '' === $title && '' === $text ) {
		continue;
	}
	$rows[] = array(
		'title' => $title,
		'text'  => $text,
		'icon'  => isset( $icons[ $index ] ) ? $icons[ $index ] : 'checklist',
	);
}

if ( empty( $rows ) ) {
	return;
}
?>
<section class="llb-home-usp llb-reveal">
	<div class="llb-container">
		<ul class="llb-home-usp__list">
			<?php foreach ( $rows as $row ) : ?>
				<li class="llb-home-usp__item">
					<span class="llb-home-usp__icon" aria-hidden="true">
						<?php echo llb_icon( $row['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
					</span>
					<div class="llb-home-usp__body">
						<?php if ( '' !== $row['title'] ) : ?>
							<h3><?php echo esc_html( $row['title'] ); ?></h3>
						<?php endif; ?>
						<?php if ( '' !== $row['text'] ) : ?>
							<?php echo llb_paragraphs( $row['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
