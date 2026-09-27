<?php
/**
 * Project card (image, category, title, arrow).
 *
 * Args: project (WP_Post).
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

$thumb_id = get_post_thumbnail_id( $project );
$terms    = get_the_terms( $project, 'project_categorie' );
$cat      = ( ! is_wp_error( $terms ) && ! empty( $terms[0] ) ) ? $terms[0]->name : '';
?>
<a class="llb-project-card" href="<?php echo esc_url( get_permalink( $project ) ); ?>">
	<div class="llb-project-card__media">
		<?php if ( $thumb_id ) : ?>
			<?php
			echo wp_get_attachment_image(
				$thumb_id,
				'llb-card',
				false,
				array(
					'class'    => 'llb-project-card__image',
					'loading'  => 'lazy',
					'decoding' => 'async',
				)
			);
			?>
		<?php else : ?>
			<div class="llb-media-placeholder llb-media-placeholder--dark" aria-hidden="true">
				<span class="llb-accent-line"></span>
			</div>
		<?php endif; ?>
		<span class="llb-project-card__overlay" aria-hidden="true"></span>
	</div>
	<?php if ( '' !== $cat ) : ?>
		<span class="llb-project-card__cat"><?php echo esc_html( $cat ); ?></span>
	<?php endif; ?>
	<div class="llb-project-card__footer">
		<h3 class="llb-project-card__title"><?php echo esc_html( get_the_title( $project ) ); ?></h3>
		<span class="llb-project-card__arrow" aria-hidden="true">
			<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
		</span>
	</div>
</a>
