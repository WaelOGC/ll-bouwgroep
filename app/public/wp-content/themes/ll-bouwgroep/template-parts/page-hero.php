<?php
/**
 * Page hero (design v2 — .phero).
 *
 * Args: title, intro, image_id, mobile_id, buttons (optional).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title     = isset( $args['title'] ) ? trim( (string) $args['title'] ) : '';
$intro     = isset( $args['intro'] ) ? trim( (string) $args['intro'] ) : '';
$image_id  = isset( $args['image_id'] ) ? absint( $args['image_id'] ) : 0;
$mobile_id = isset( $args['mobile_id'] ) ? absint( $args['mobile_id'] ) : 0;
$buttons    = isset( $args['buttons'] ) && is_array( $args['buttons'] ) ? $args['buttons'] : array();
$label      = isset( $args['label'] ) ? trim( (string) $args['label'] ) : '';
$hero_class = isset( $args['class'] ) ? trim( (string) $args['class'] ) : '';

if ( '' === $title && '' === $intro && ! $image_id && ! $mobile_id ) {
	return;
}

$lines = preg_split( '/\r\n|\r|\n/', $title );
$lines = array_values( array_filter( array_map( 'trim', is_array( $lines ) ? $lines : array() ) ) );
if ( empty( $lines ) && '' !== $title ) {
	$lines = array( $title );
}

$img_attrs = array(
	'loading'       => 'eager',
	'decoding'      => 'async',
	'fetchpriority' => 'high',
);

$section_class = 'phero';
if ( '' !== $hero_class ) {
	$section_class .= ' ' . $hero_class;
}
?>
<section class="<?php echo esc_attr( $section_class ); ?>">
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
					<?php echo wp_get_attachment_image( $image_id, 'full', false, $img_attrs ); ?>
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
		<?php if ( '' !== $label ) : ?>
			<span class="phero-label"><?php echo esc_html( $label ); ?></span>
		<?php endif; ?>
		<?php if ( ! empty( $lines ) ) : ?>
			<h1>
				<?php foreach ( $lines as $line ) : ?>
					<span class="ln"><span><?php echo esc_html( $line ); ?></span></span>
				<?php endforeach; ?>
			</h1>
			<div class="rule" aria-hidden="true"></div>
		<?php endif; ?>
		<?php if ( '' !== $intro ) : ?>
			<p class="phero-intro"><?php echo esc_html( $intro ); ?></p>
		<?php endif; ?>
		<?php if ( ! empty( $buttons ) ) : ?>
			<div class="phero-btns">
				<?php foreach ( $buttons as $button ) : ?>
					<?php
					$btn_text  = isset( $button['text'] ) ? trim( (string) $button['text'] ) : '';
					$btn_url   = isset( $button['url'] ) ? (string) $button['url'] : '';
					$btn_style = isset( $button['style'] ) ? (string) $button['style'] : 'red';
					if ( '' === $btn_text || '' === $btn_url ) {
						continue;
					}
					$btn_class = 'btn';
					if ( 'ghost' === $btn_style || 'outline-light' === $btn_style ) {
						$btn_class .= ' btn-ghost';
					} elseif ( 'line' === $btn_style || 'outline' === $btn_style ) {
						$btn_class .= ' btn-line';
					} else {
						$btn_class .= ' btn-red';
					}
					?>
					<a class="<?php echo esc_attr( $btn_class ); ?>" href="<?php echo esc_url( $btn_url ); ?>">
						<?php echo esc_html( $btn_text ); ?>
						<?php if ( false !== strpos( $btn_class, 'btn-red' ) ) : ?>
							<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
