<?php
/**
 * Footer template.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$company_name = trim( (string) llb_get_option( 'llb_company_name' ) );
$tagline      = trim( (string) llb_get_option( 'llb_footer_tagline' ) );
$footer_text  = trim( (string) llb_get_option( 'llb_footer_text' ) );
$phone        = trim( (string) llb_get_option( 'llb_phone' ) );
$phone_tel    = preg_replace( '/[^\d+]/', '', $phone );
$email        = trim( (string) llb_get_option( 'llb_email' ) );
$address      = llb_get_address();
$kvk          = trim( (string) llb_get_option( 'llb_kvk' ) );
$btw          = trim( (string) llb_get_option( 'llb_btw' ) );
$copyright    = llb_get_copyright();

$socials = array(
	array(
		'url'   => trim( (string) llb_get_option( 'llb_social_facebook' ) ),
		'icon'  => 'facebook',
		'label' => 'Facebook',
	),
	array(
		'url'   => trim( (string) llb_get_option( 'llb_social_instagram' ) ),
		'icon'  => 'instagram',
		'label' => 'Instagram',
	),
	array(
		'url'   => trim( (string) llb_get_option( 'llb_social_linkedin' ) ),
		'icon'  => 'linkedin',
		'label' => 'LinkedIn',
	),
);

$legal_parts = array();
if ( '' !== $kvk ) {
	$legal_parts[] = 'KvK: ' . $kvk;
}
if ( '' !== $btw ) {
	$legal_parts[] = 'BTW: ' . $btw;
}
$legal_line = implode( ' — ', $legal_parts );
?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) : ?>
<footer class="llb-site-footer" role="contentinfo">
	<div class="llb-footer-accent" aria-hidden="true"></div>
	<div class="llb-footer-main">
		<div class="llb-container llb-footer-grid">
			<div class="llb-footer-col llb-footer-col--brand">
				<?php if ( '' !== $company_name ) : ?>
					<p class="llb-footer-brand-name"><?php echo esc_html( $company_name ); ?></p>
				<?php endif; ?>
				<?php if ( '' !== $tagline ) : ?>
					<p class="llb-footer-tagline"><?php echo esc_html( $tagline ); ?></p>
				<?php endif; ?>
				<?php if ( '' !== $footer_text ) : ?>
					<p class="llb-footer-text"><?php echo esc_html( $footer_text ); ?></p>
				<?php endif; ?>
				<?php
				$has_social = false;
				foreach ( $socials as $social ) {
					if ( '' !== $social['url'] ) {
						$has_social = true;
						break;
					}
				}
				?>
				<?php if ( $has_social ) : ?>
					<div class="llb-footer-social">
						<?php foreach ( $socials as $social ) : ?>
							<?php if ( '' === $social['url'] ) : ?>
								<?php continue; ?>
							<?php endif; ?>
							<a href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
								<?php echo llb_icon( $social['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="llb-footer-col llb-footer-col--nav">
				<p class="llb-footer-heading">Navigatie</p>
				<nav class="llb-nav-footer" aria-label="Footermenu">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'fallback_cb'    => false,
							'menu_class'     => 'llb-menu llb-menu--footer',
							'depth'          => 1,
						)
					);
					?>
				</nav>
			</div>

			<div class="llb-footer-col llb-footer-col--contact">
				<p class="llb-footer-heading">Contact</p>
				<ul class="llb-footer-contact">
					<?php if ( '' !== $phone && '' !== $phone_tel ) : ?>
						<li>
							<?php echo llb_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
							<a href="<?php echo esc_url( 'tel:' . $phone_tel ); ?>"><?php echo esc_html( $phone ); ?></a>
						</li>
					<?php endif; ?>
					<?php if ( '' !== $email ) : ?>
						<li>
							<?php echo llb_icon( 'email' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
							<a href="<?php echo esc_url( 'mailto:' . antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a>
						</li>
					<?php endif; ?>
					<?php if ( '' !== $address ) : ?>
						<li>
							<?php echo llb_icon( 'location' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
							<span><?php echo esc_html( $address ); ?></span>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>

	<div class="llb-footer-bottom">
		<div class="llb-container llb-footer-bottom-inner">
			<?php if ( '' !== $copyright ) : ?>
				<p><?php echo esc_html( $copyright ); ?></p>
			<?php endif; ?>
			<?php if ( '' !== $legal_line ) : ?>
				<p><?php echo esc_html( $legal_line ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</footer>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
