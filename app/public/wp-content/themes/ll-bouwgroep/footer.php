<?php
/**
 * Footer template (design v2).
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
$services     = function_exists( 'llb_get_services' ) ? llb_get_services() : array();

$legal_parts = array();
if ( '' !== $company_name ) {
	$legal_parts[] = $company_name;
}
if ( '' !== $kvk ) {
	$legal_parts[] = 'KvK: ' . $kvk;
}
if ( '' !== $btw ) {
	$legal_parts[] = 'BTW: ' . $btw;
}
$legal_line = implode( ' — ', $legal_parts );

$address_html = '';
if ( '' !== $address ) {
	$address_html = nl2br( esc_html( str_replace( ', ', "\n", $address ) ), false );
	// Prefer street / city on two lines when Customizer has separate fields.
	$street   = trim( (string) llb_get_option( 'llb_address_street' ) );
	$postcode = trim( (string) llb_get_option( 'llb_address_postcode' ) );
	$city     = trim( (string) llb_get_option( 'llb_address_city' ) );
	if ( '' !== $street && ( '' !== $postcode || '' !== $city ) ) {
		$line2        = trim( $postcode . ' ' . $city );
		$address_html = esc_html( $street ) . '<br>' . esc_html( $line2 );
	}
}
?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) : ?>
<footer class="ftr" role="contentinfo">
	<div class="wrap">
		<div class="ftr-grid">
			<div>
				<a class="ftr-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( ( '' !== $company_name ? $company_name : get_bloginfo( 'name' ) ) . ' — home' ); ?>">
					<img src="<?php echo esc_url( llb_asset( 'images/ll-logo.webp' ) ); ?>" alt="<?php echo esc_attr( '' !== $company_name ? $company_name : get_bloginfo( 'name' ) ); ?>" width="800" height="379" loading="lazy" decoding="async">
				</a>
				<?php if ( '' !== $tagline ) : ?>
					<div class="ftr-tag"><?php echo esc_html( $tagline ); ?></div>
				<?php endif; ?>
				<div class="rule" aria-hidden="true"></div>
				<?php if ( '' !== $footer_text ) : ?>
					<p><?php echo esc_html( $footer_text ); ?></p>
				<?php endif; ?>
				<?php get_template_part( 'template-parts/social-icons', null, array( 'variant' => 'footer' ) ); ?>
			</div>
			<div>
				<h4>Navigatie</h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'fallback_cb'    => false,
						'menu_class'     => '',
						'depth'          => 1,
						'items_wrap'     => '<ul class="ftr-links">%3$s</ul>',
					)
				);
				?>
			</div>
			<div>
				<h4>Diensten</h4>
				<?php if ( ! empty( $services ) ) : ?>
					<ul class="ftr-links">
						<?php foreach ( $services as $service ) : ?>
							<li>
								<a href="<?php echo esc_url( get_permalink( $service ) ); ?>"><?php echo esc_html( get_the_title( $service ) ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<div>
				<h4>Contact</h4>
				<ul class="ftr-c">
					<?php if ( '' !== $phone && '' !== $phone_tel ) : ?>
						<li>
							<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
							<a href="<?php echo esc_url( 'tel:' . $phone_tel ); ?>"><?php echo esc_html( $phone ); ?></a>
						</li>
					<?php endif; ?>
					<?php if ( '' !== $email ) : ?>
						<li>
							<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
							<a href="<?php echo esc_url( 'mailto:' . antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a>
						</li>
					<?php endif; ?>
					<?php if ( '' !== $address_html ) : ?>
						<li>
							<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zm0 9.5c-1.4 0-2.5-1.1-2.5-2.5S10.6 6.5 12 6.5s2.5 1.1 2.5 2.5-1.1 2.5-2.5 2.5z"/></svg>
							<span style="padding:4px 0;display:inline-block"><?php echo $address_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?></span>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="ftr-bot">
			<?php if ( '' !== $legal_line ) : ?>
				<span><?php echo esc_html( $legal_line ); ?></span>
			<?php endif; ?>
			<?php if ( '' !== $copyright ) : ?>
				<span><?php echo esc_html( $copyright ); ?></span>
			<?php endif; ?>
		</div>
	</div>
</footer>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
