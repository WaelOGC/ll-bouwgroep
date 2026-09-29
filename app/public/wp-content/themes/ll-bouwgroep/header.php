<?php
/**
 * Header template (design v2).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$company_name = trim( (string) llb_get_option( 'llb_company_name' ) );
$cta_text     = trim( (string) llb_get_option( 'llb_header_cta_text' ) );
$cta_url      = llb_get_header_cta_url();
$logo_alt     = '' !== $company_name ? $company_name : get_bloginfo( 'name' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'llb-v2' ); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main">Ga naar de inhoud</a>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) : ?>
<header class="hdr" id="hdr" role="banner">
	<div class="wrap">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( $logo_alt . ' — home' ); ?>">
			<img
				src="<?php echo esc_url( llb_asset( 'images/logo-header.webp' ) ); ?>"
				width="100"
				height="50"
				alt="<?php echo esc_attr( $logo_alt ); ?>"
				decoding="async"
				fetchpriority="high"
			>
		</a>

		<nav class="nav" aria-label="Hoofdmenu">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => false,
					'menu_class'     => '',
					'depth'          => 2,
					'items_wrap'     => '<ul>%3$s</ul>',
				)
			);
			?>
		</nav>

		<?php if ( '' !== $cta_text ) : ?>
			<a class="btn btn-red hdr-cta" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_text ); ?></a>
		<?php endif; ?>

		<button type="button" class="burger" id="burger" aria-label="Menu openen" aria-expanded="false" aria-controls="mnav">
			<span></span>
		</button>
	</div>
</header>
<div class="mnav" id="mnav">
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => false,
			'fallback_cb'    => false,
			'menu_id'        => 'llb-menu-mobile',
			'menu_class'     => '',
			'depth'          => 2,
			'items_wrap'     => '<ul>%3$s</ul>',
		)
	);
	?>
	<?php if ( '' !== $cta_text ) : ?>
		<a class="btn btn-red" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_text ); ?></a>
	<?php endif; ?>
	<?php get_template_part( 'template-parts/social-icons', null, array( 'variant' => 'menu' ) ); ?>
</div>
<?php endif; ?>
