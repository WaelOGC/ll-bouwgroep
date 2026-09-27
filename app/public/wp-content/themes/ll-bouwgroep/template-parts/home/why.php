<?php
/**
 * Home — why us.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();
$heading = trim( (string) llb_get_meta( $post_id, '_llb_why_heading' ) );
$text    = trim( (string) llb_get_meta( $post_id, '_llb_why_text' ) );
$items   = llb_get_meta( $post_id, '_llb_why_items' );
if ( ! is_array( $items ) ) {
	$items = array();
}

$icons = array( 'team', 'handshake', 'checklist' );

if ( '' === $heading && '' === $text && empty( $items ) ) {
	return;
}
?>
<section class="llb-section llb-home-why">
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
		<?php if ( ! empty( $items ) ) : ?>
			<ul class="llb-home-why__items">
				<?php foreach ( $items as $index => $item ) : ?>
					<?php
					if ( ! is_array( $item ) ) {
						continue;
					}
					$item_title = isset( $item['title'] ) ? trim( (string) $item['title'] ) : '';
					$item_text  = isset( $item['text'] ) ? trim( (string) $item['text'] ) : '';
					if ( '' === $item_title && '' === $item_text ) {
						continue;
					}
					$icon = isset( $icons[ $index ] ) ? $icons[ $index ] : 'checklist';
					?>
					<li class="llb-home-why__item">
						<span class="llb-home-why__icon" aria-hidden="true">
							<?php echo llb_icon( $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
						</span>
						<div>
							<?php if ( '' !== $item_title ) : ?>
								<h3><?php echo esc_html( $item_title ); ?></h3>
							<?php endif; ?>
							<?php if ( '' !== $item_text ) : ?>
								<?php echo llb_paragraphs( $item_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
							<?php endif; ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
