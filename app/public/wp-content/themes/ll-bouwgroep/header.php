<?php
/**
 * Header template.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$company_name = trim( (string) llb_get_option( 'llb_company_name' ) );
$phone        = trim( (string) llb_get_option( 'llb_phone' ) );
$phone_tel    = preg_replace( '/[^\d+]/', '', $phone );
$cta_text     = trim( (string) llb_get_option( 'llb_header_cta_text' ) );
$cta_url      = llb_get_header_cta_url();
$logo_alt     = '' !== $company_name ? $company_name : get_bloginfo( 'name' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main">Ga naar de inhoud</a>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) : ?>
<header class="llb-site-header" role="banner" data-llb-header>
	<div class="llb-container llb-header-inner">
		<div class="llb-site-branding">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( has_custom_logo() ) : ?>
					<?php
					$logo_id = (int) get_theme_mod( 'custom_logo' );
					echo wp_get_attachment_image(
						$logo_id,
						'full',
						false,
						array(
							'class' => 'llb-site-logo custom-logo',
							'alt'   => $logo_alt,
						)
					);
					?>
				<?php else : ?>
					<img
						class="llb-site-logo"
						src="<?php echo esc_url( llb_asset( 'images/logo.jpeg' ) ); ?>"
						width="160"
						height="80"
						alt="<?php echo esc_attr( $logo_alt ); ?>"
						decoding="async"
					>
				<?php endif; ?>
			</a>
		</div>

		<nav class="llb-nav-primary" aria-label="Hoofdmenu">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => false,
					'menu_class'     => 'llb-menu llb-menu--primary',
					'depth'          => 2,
				)
			);
			?>
		</nav>

		<div class="llb-header-actions">
			<?php if ( '' !== $phone && '' !== $phone_tel ) : ?>
				<a class="llb-header-phone" href="<?php echo esc_url( 'tel:' . $phone_tel ); ?>">
					<?php echo llb_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
					<span><?php echo esc_html( $phone ); ?></span>
				</a>
			<?php endif; ?>
			<?php if ( '' !== $cta_text ) : ?>
				<a class="llb-btn llb-btn--primary" href="<?php echo esc_url( $cta_url ); ?>">
					<span><?php echo esc_html( $cta_text ); ?></span>
					<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</a>
			<?php endif; ?>
		</div>

		<button
			type="button"
			class="llb-nav-toggle"
			aria-expanded="false"
			aria-controls="llb-nav-panel"
			data-llb-nav-toggle
		>
			<span class="screen-reader-text" data-llb-nav-label>Menu openen</span>
			<?php echo llb_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
			<?php echo llb_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
		</button>
	</div>

	<div class="llb-nav-panel" id="llb-nav-panel" data-llb-nav-panel hidden>
		<nav aria-label="Hoofdmenu">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => false,
					'menu_class'     => 'llb-menu llb-menu--primary',
					'depth'          => 2,
				)
			);
			?>
		</nav>
		<div class="llb-nav-panel-actions">
			<?php if ( '' !== $phone && '' !== $phone_tel ) : ?>
				<a class="llb-header-phone" href="<?php echo esc_url( 'tel:' . $phone_tel ); ?>">
					<?php echo llb_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
					<span><?php echo esc_html( $phone ); ?></span>
				</a>
			<?php endif; ?>
			<?php if ( '' !== $cta_text ) : ?>
				<a class="llb-btn llb-btn--primary" href="<?php echo esc_url( $cta_url ); ?>">
					<span><?php echo esc_html( $cta_text ); ?></span>
					<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</header>
<?php endif; ?>
