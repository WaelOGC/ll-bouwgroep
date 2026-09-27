<?php
/**
 * USP strip — Home why items (docs § 1).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = function_exists( 'llb_get_why_items' ) ? llb_get_why_items() : array();
if ( empty( $items ) ) {
	return;
}
?>
<section class="llb-home-usp llb-reveal">
	<div class="llb-container">
		<ul class="llb-home-usp__list">
			<?php foreach ( $items as $row ) : ?>
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
