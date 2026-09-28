<?php
/**
 * 404 template (design v2).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title     = trim( (string) llb_get_option( 'llb_404_title' ) );
$lead      = trim( (string) llb_get_option( 'llb_404_lead' ) );
$sub_title = trim( (string) llb_get_option( 'llb_404_sub_title' ) );
$sub_text  = trim( (string) llb_get_option( 'llb_404_sub_text' ) );
$btn_home  = trim( (string) llb_get_option( 'llb_404_btn_home' ) );
$btn_svc   = trim( (string) llb_get_option( 'llb_404_btn_services' ) );
$services  = llb_page_url( 'diensten' );

get_header();
?>
<main id="main" class="llb-main llb-page-404">
	<section class="e404">
		<span class="e404-num" aria-hidden="true">404</span>
		<div class="wrap">
			<div class="rule" aria-hidden="true"></div>
			<?php if ( '' !== $title ) : ?>
				<h1><?php echo esc_html( $title ); ?></h1>
			<?php endif; ?>
			<?php if ( '' !== $lead ) : ?>
				<p class="lead"><?php echo esc_html( $lead ); ?></p>
			<?php endif; ?>
			<?php if ( '' !== $sub_title || '' !== $sub_text || '' !== $btn_home || '' !== $btn_svc ) : ?>
				<div class="e404-sub">
					<?php if ( '' !== $sub_title ) : ?>
						<h2><?php echo esc_html( $sub_title ); ?></h2>
					<?php endif; ?>
					<?php if ( '' !== $sub_text ) : ?>
						<p><?php echo esc_html( $sub_text ); ?></p>
					<?php endif; ?>
					<?php if ( '' !== $btn_home || '' !== $btn_svc ) : ?>
						<div class="e404-btns">
							<?php if ( '' !== $btn_home ) : ?>
								<a class="btn btn-red" href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<?php echo esc_html( $btn_home ); ?>
									<?php echo llb_btn_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
								</a>
							<?php endif; ?>
							<?php if ( '' !== $btn_svc && $services ) : ?>
								<a class="btn btn-line" href="<?php echo esc_url( $services ); ?>">
									<?php echo esc_html( $btn_svc ); ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
