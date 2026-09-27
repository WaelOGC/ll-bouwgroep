<?php
/**
 * USP strip — why items (used on inner pages).
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
<section class="llb-home-usp llb-usp-strip llb-reveal">
	<div class="llb-container">
		<ul class="llb-home-usp__list">
			<?php foreach ( $items as $row ) : ?>
				<li class="llb-home-usp__item">
					<span class="llb-home-usp__icon" aria-hidden="true">
						<?php
						$mdi = function_exists( 'llb_get_mdi_icon_svg' ) ? llb_get_mdi_icon_svg( $row['icon'] ) : '';
						if ( '' !== $mdi ) {
							echo $mdi; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG.
						} else {
							echo llb_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG.
						}
						?>
					</span>
					<div class="llb-home-usp__body">
						<?php if ( '' !== $row['title'] ) : ?>
							<h3><?php echo llb_format_count_title( $row['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?></h3>
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
