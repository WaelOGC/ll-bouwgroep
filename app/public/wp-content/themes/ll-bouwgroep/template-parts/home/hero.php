<?php
/**
 * Home — hero (design v2).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();
$title   = trim( (string) llb_get_meta( $post_id, '_llb_hero_title' ) );
if ( '' === $title ) {
	$title = get_the_title();
}
$intro      = (string) llb_get_meta( $post_id, '_llb_hero_intro' );
$image_id   = absint( llb_get_meta( $post_id, '_llb_hero_image' ) );
$mobile_id  = absint( llb_get_meta( $post_id, '_llb_hero_image_mobile' ) );

$btn1_text = trim( (string) llb_get_meta( $post_id, '_llb_hero_btn1_text' ) );
$btn1_url  = trim( (string) llb_get_meta( $post_id, '_llb_hero_btn1_url' ) );
if ( '' === $btn1_url ) {
	$btn1_url = llb_get_header_cta_url();
}

$btn2_text = trim( (string) llb_get_meta( $post_id, '_llb_hero_btn2_text' ) );
$btn2_url  = trim( (string) llb_get_meta( $post_id, '_llb_hero_btn2_url' ) );
if ( '' === $btn2_url ) {
	$btn2_url = llb_page_url( 'diensten' );
}

if ( '' === $title && '' === trim( $intro ) && '' === $btn1_text && '' === $btn2_text && ! $image_id && ! $mobile_id ) {
	return;
}

$lines = preg_split( '/\r\n|\r|\n/', $title );
$lines = array_values( array_filter( array_map( 'trim', is_array( $lines ) ? $lines : array() ) ) );
if ( empty( $lines ) && '' !== $title ) {
	$lines = array( $title );
}
// Fallback split for the known single-line default.
if ( 1 === count( $lines ) && false !== stripos( $lines[0], 'badkamer' ) && false !== stripos( $lines[0], 'verbouwing' ) ) {
	$lines = array( 'Van complete', 'badkamer tot', 'volledige verbouwing' );
}

$img_attrs = array(
	'loading'       => 'eager',
	'decoding'      => 'async',
	'fetchpriority' => 'high',
);
?>
<section class="hero">
	<?php if ( $image_id || $mobile_id ) : ?>
		<div class="hero-img">
			<?php if ( $image_id && $mobile_id ) : ?>
				<picture>
					<?php
					$mobile_srcset = wp_get_attachment_image_srcset( $mobile_id, 'full' );
					$mobile_sizes  = wp_get_attachment_image_sizes( $mobile_id, 'full' );
					$mobile_src    = wp_get_attachment_image_url( $mobile_id, 'full' );
					$srcset_attr   = $mobile_srcset ? $mobile_srcset : $mobile_src;
					?>
					<?php if ( $srcset_attr ) : ?>
						<source
							media="(max-width: 1023px) and (orientation: portrait)"
							srcset="<?php echo esc_attr( $srcset_attr ); ?>"
							<?php if ( $mobile_srcset && $mobile_sizes ) : ?>
								sizes="<?php echo esc_attr( $mobile_sizes ); ?>"
							<?php endif; ?>
						>
					<?php endif; ?>
					<?php
					echo wp_get_attachment_image( $image_id, 'full', false, $img_attrs );
					?>
				</picture>
			<?php elseif ( $image_id ) : ?>
				<?php echo wp_get_attachment_image( $image_id, 'full', false, $img_attrs ); ?>
			<?php else : ?>
				<?php echo wp_get_attachment_image( $mobile_id, 'full', false, $img_attrs ); ?>
			<?php endif; ?>
		</div>
	<?php else : ?>
		<div class="hero-img" aria-hidden="true"></div>
	<?php endif; ?>
	<div class="wrap hero-in">
		<?php if ( ! empty( $lines ) ) : ?>
			<h1>
				<?php foreach ( $lines as $line ) : ?>
					<span class="ln"><span><?php echo esc_html( $line ); ?></span></span>
				<?php endforeach; ?>
			</h1>
			<div class="rule" aria-hidden="true"></div>
		<?php endif; ?>
		<div class="hero-foot">
			<?php if ( '' !== trim( $intro ) ) : ?>
				<?php echo llb_paragraphs( $intro ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
			<?php endif; ?>
			<?php if ( '' !== $btn1_text || '' !== $btn2_text ) : ?>
				<div class="hero-btns">
					<?php if ( '' !== $btn1_text ) : ?>
						<a class="btn btn-red" href="<?php echo esc_url( $btn1_url ); ?>">
							<?php echo esc_html( $btn1_text ); ?>
							<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
						</a>
					<?php endif; ?>
					<?php if ( '' !== $btn2_text ) : ?>
						<a class="btn btn-ghost" href="<?php echo esc_url( $btn2_url ); ?>"><?php echo esc_html( $btn2_text ); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
