<?php
/**
 * Home — bathrooms (design v2).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id    = get_the_ID();
$heading    = trim( (string) llb_get_meta( $post_id, '_llb_bath_heading' ) );
$text       = trim( (string) llb_get_meta( $post_id, '_llb_bath_text' ) );
$subheading = trim( (string) llb_get_meta( $post_id, '_llb_bath_subheading' ) );
$btn_text   = trim( (string) llb_get_meta( $post_id, '_llb_bath_btn_text' ) );
$btn_url    = trim( (string) llb_get_meta( $post_id, '_llb_bath_btn_url' ) );
$image_id   = absint( llb_get_meta( $post_id, '_llb_bath_image' ) );

if ( '' === $btn_url ) {
	$btn_url = llb_page_url( 'diensten' );
	$bath    = get_page_by_path( 'badkamers-toiletten', OBJECT, 'dienst' );
	if ( $bath instanceof WP_Post ) {
		$btn_url = get_permalink( $bath );
	}
}

if ( '' === $heading && '' === $text && '' === $subheading && '' === $btn_text && ! $image_id ) {
	return;
}

$sub_parts = preg_split( '/\r\n|\r|\n|\.\s+/', $subheading );
$sub_parts = array_values( array_filter( array_map( 'trim', is_array( $sub_parts ) ? $sub_parts : array() ) ) );
if ( empty( $sub_parts ) && '' !== $subheading ) {
	$sub_parts = array( $subheading );
}
// Match reference three-line subheading when stored as one sentence with periods.
if ( 1 === count( $sub_parts ) && substr_count( $subheading, '.' ) >= 2 ) {
	$sub_parts = array_values(
		array_filter(
			array_map(
				static function ( $p ) {
					$p = trim( $p );
					if ( '' === $p ) {
						return '';
					}
					return ( '.' === substr( $p, -1 ) ) ? $p : $p . '.';
				},
				preg_split( '/(?<=\.)\s+/', $subheading )
			)
		)
	);
}
?>
<section class="sec bath">
	<div class="wrap bath-grid">
		<?php if ( $image_id ) : ?>
			<div class="bath-img rv">
				<?php
				echo wp_get_attachment_image(
					$image_id,
					'llb-card',
					false,
					array(
						'loading'  => 'lazy',
						'decoding' => 'async',
					)
				);
				?>
			</div>
		<?php endif; ?>
		<div>
			<?php if ( '' !== $heading ) : ?>
				<div class="rule" aria-hidden="true"></div>
				<h2><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<?php if ( '' !== $text ) : ?>
				<div style="margin-top:28px">
					<?php echo llb_paragraphs( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $sub_parts ) ) : ?>
				<h3>
					<?php foreach ( $sub_parts as $part ) : ?>
						<span><?php echo esc_html( $part ); ?></span>
					<?php endforeach; ?>
				</h3>
			<?php endif; ?>
			<?php if ( '' !== $btn_text ) : ?>
				<a class="btn btn-red" href="<?php echo esc_url( $btn_url ); ?>">
					<?php echo esc_html( $btn_text ); ?>
					<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
