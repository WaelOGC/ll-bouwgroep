<?php
/**
 * Project card (image, category, title, link).
 *
 * Args: project (WP_Post), button_text (string).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$project = isset( $args['project'] ) ? $args['project'] : null;
if ( ! ( $project instanceof WP_Post ) ) {
	return;
}

$button_text = isset( $args['button_text'] ) ? trim( (string) $args['button_text'] ) : '';
$thumb_id    = get_post_thumbnail_id( $project );
$terms       = get_the_terms( $project, 'project_categorie' );
$cat         = ( ! is_wp_error( $terms ) && ! empty( $terms[0] ) ) ? $terms[0]->name : '';
?>
<li class="pcard">
	<a href="<?php echo esc_url( get_permalink( $project ) ); ?>">
		<div class="pcard-img">
			<?php if ( $thumb_id ) : ?>
				<?php
				echo wp_get_attachment_image(
					$thumb_id,
					'llb-card',
					false,
					array(
						'loading'  => 'lazy',
						'decoding' => 'async',
					)
				);
				?>
			<?php endif; ?>
			<?php if ( '' !== $cat ) : ?>
				<span class="pcard-cat"><?php echo esc_html( $cat ); ?></span>
			<?php endif; ?>
		</div>
		<h3><?php echo esc_html( get_the_title( $project ) ); ?></h3>
		<?php if ( '' !== $button_text ) : ?>
			<span class="link">
				<?php echo esc_html( $button_text ); ?>
				<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
			</span>
		<?php endif; ?>
	</a>
</li>
