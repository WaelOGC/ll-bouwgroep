<?php
/**
 * Home — projects.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id  = get_the_ID();
$heading  = trim( (string) llb_get_meta( $post_id, '_llb_projects_heading' ) );
$text     = trim( (string) llb_get_meta( $post_id, '_llb_projects_text' ) );
$btn_text = trim( (string) llb_get_meta( $post_id, '_llb_projects_btn_text' ) );
$btn_url  = llb_page_url( 'projecten' );
$projects = llb_get_home_projects( 3 );

if ( '' === $heading && '' === $text && '' === $btn_text ) {
	return;
}
?>
<section class="llb-section llb-section--light llb-home-projects">
	<div class="llb-container">
		<div class="llb-home-projects__header">
			<div class="llb-home-projects__intro">
				<?php if ( '' !== $heading ) : ?>
					<span class="llb-accent-line llb-accent-line--red" aria-hidden="true"></span>
					<h2><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
				<?php if ( '' !== $text ) : ?>
					<div class="llb-home-projects__text">
						<?php echo llb_paragraphs( $text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( '' !== $btn_text ) : ?>
				<a class="llb-btn llb-btn--outline" href="<?php echo esc_url( $btn_url ); ?>">
					<span><?php echo esc_html( $btn_text ); ?></span>
					<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</a>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $projects ) ) : ?>
			<ul class="llb-card-grid llb-card-grid--projects">
				<?php foreach ( $projects as $project ) : ?>
					<?php
					$thumb_id = get_post_thumbnail_id( $project );
					$terms    = get_the_terms( $project, 'project_categorie' );
					$cat      = ( ! is_wp_error( $terms ) && ! empty( $terms[0] ) ) ? $terms[0]->name : '';
					?>
					<li>
						<a class="llb-card" href="<?php echo esc_url( get_permalink( $project ) ); ?>">
							<div class="llb-card__media">
								<?php if ( $thumb_id ) : ?>
									<?php
									echo wp_get_attachment_image(
										$thumb_id,
										'llb-card',
										false,
										array(
											'class'    => 'llb-card__image',
											'loading'  => 'lazy',
											'decoding' => 'async',
										)
									);
									?>
								<?php else : ?>
									<div class="llb-media-placeholder" aria-hidden="true">
										<span class="llb-accent-line"></span>
									</div>
								<?php endif; ?>
							</div>
							<div class="llb-card__body">
								<?php if ( '' !== $cat ) : ?>
									<span class="llb-card__meta"><?php echo esc_html( $cat ); ?></span>
								<?php endif; ?>
								<h3 class="llb-card__title"><?php echo esc_html( get_the_title( $project ) ); ?></h3>
								<span class="llb-card__arrow" aria-hidden="true">
									<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
								</span>
							</div>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
