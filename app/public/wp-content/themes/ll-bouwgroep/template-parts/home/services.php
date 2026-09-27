<?php
/**
 * Home — services tile wall (design v2).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id  = get_the_ID();
$heading  = trim( (string) llb_get_meta( $post_id, '_llb_services_heading' ) );
$intro    = trim( (string) llb_get_meta( $post_id, '_llb_services_intro' ) );
$services = llb_get_services();

if ( '' === $heading && '' === $intro && empty( $services ) ) {
	return;
}
?>
<section class="sec" id="diensten">
	<div class="wrap">
		<div class="svc-head">
			<?php if ( '' !== $heading ) : ?>
				<div>
					<div class="rule" aria-hidden="true"></div>
					<h2><?php echo esc_html( $heading ); ?></h2>
				</div>
			<?php endif; ?>
			<?php if ( '' !== $intro ) : ?>
				<?php echo llb_paragraphs( $intro ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
			<?php endif; ?>
		</div>
		<?php if ( ! empty( $services ) ) : ?>
			<div class="tiles">
				<?php foreach ( $services as $service ) : ?>
					<?php
					$excerpt = trim( (string) $service->post_excerpt );
					$icon    = trim( (string) llb_get_meta( $service->ID, '_llb_service_icon' ) );
					if ( '' === $icon || ! isset( llb_service_icon_options()[ $icon ] ) ) {
						$icon = llb_default_service_icon_for_slug( $service->post_name );
					}
					$icon_svg = llb_get_mdi_icon_svg( $icon );
					?>
					<a class="tile" href="<?php echo esc_url( get_permalink( $service ) ); ?>">
						<span class="tile-ic">
							<?php echo $icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
						</span>
						<?php echo llb_tile_go_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
						<h3><?php echo esc_html( get_the_title( $service ) ); ?></h3>
						<?php if ( '' !== $excerpt ) : ?>
							<p><?php echo esc_html( $excerpt ); ?></p>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
