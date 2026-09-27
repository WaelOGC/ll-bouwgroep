<?php
/**
 * Home — FAQ accordion (design v2).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id  = get_the_ID();
$heading  = trim( (string) llb_get_meta( $post_id, '_llb_faq_heading' ) );
$btn_text = trim( (string) llb_get_meta( $post_id, '_llb_faq_btn_text' ) );
$btn_url  = llb_page_url( 'veelgestelde-vragen' );
$items    = llb_get_home_faq_items();

if ( '' === $heading && '' === $btn_text && empty( $items ) ) {
	return;
}
?>
<section class="sec faq">
	<div class="wrap faq-grid">
		<div class="faq-side">
			<?php if ( '' !== $heading ) : ?>
				<div class="rule" aria-hidden="true"></div>
				<h2><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<?php if ( '' !== $btn_text ) : ?>
				<a class="btn btn-line" href="<?php echo esc_url( $btn_url ); ?>">
					<?php echo esc_html( $btn_text ); ?>
					<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</a>
			<?php endif; ?>
		</div>
		<div>
			<?php foreach ( $items as $item ) : ?>
				<div class="qa">
					<button type="button" aria-expanded="false">
						<?php echo esc_html( $item['question'] ); ?>
						<span class="qa-x" aria-hidden="true">
							<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
						</span>
					</button>
					<div class="qa-a">
						<div>
							<p><?php echo esc_html( $item['answer'] ); ?></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
