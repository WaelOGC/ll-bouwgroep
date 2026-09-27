<?php
/**
 * Home — FAQ accordion.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id  = get_the_ID();
$heading  = trim( (string) llb_get_meta( $post_id, '_llb_faq_heading' ) );
$btn_text = trim( (string) llb_get_meta( $post_id, '_llb_faq_btn_text' ) );
$items    = llb_get_home_faq_items();

if ( empty( $items ) ) {
	return;
}

$faq_page_id = llb_get_faq_page_id();
$faq_url     = $faq_page_id ? get_permalink( $faq_page_id ) : llb_page_url( 'veelgestelde-vragen' );
?>
<section class="llb-section llb-home-faq llb-section--angled llb-reveal">
	<?php
	get_template_part(
		'template-parts/section-decor',
		null,
		array(
			'blueprint'      => true,
			'stripes_corner' => true,
		)
	);
	?>
	<div class="llb-container llb-home-faq__layout">
		<div class="llb-home-faq__intro">
			<?php if ( '' !== $heading ) : ?>
				<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
				<h2><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<?php if ( '' !== $btn_text ) : ?>
				<a class="llb-btn llb-btn--outline" href="<?php echo esc_url( $faq_url ); ?>">
					<span><?php echo esc_html( $btn_text ); ?></span>
					<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</a>
			<?php endif; ?>
		</div>
		<div class="llb-home-faq__list">
			<?php foreach ( $items as $item ) : ?>
				<?php
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
	</div>
</section>
