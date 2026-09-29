<?php
/**
 * Maintenance mode: branded holding page for visitors, normal site for admins.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const LLB_MAINTENANCE_COOKIE = 'llb_maintenance_preview';

/**
 * Whether maintenance mode is switched on.
 *
 * @return bool
 */
function llb_maintenance_enabled() {
	return llb_theme_option_on( 'maintenance_enabled' );
}

/**
 * Returns the stored preview token.
 *
 * @return string
 */
function llb_maintenance_token() {
	return llb_theme_option_text( 'maintenance_preview_token' );
}

/**
 * Returns the shareable preview URL, or an empty string when no token exists.
 *
 * @return string
 */
function llb_maintenance_preview_url() {
	$token = llb_maintenance_token();
	if ( '' === $token ) {
		return '';
	}

	return add_query_arg( 'preview', rawurlencode( $token ), home_url( '/' ) );
}

/**
 * Stores a new preview token and returns it.
 *
 * @return string
 */
function llb_maintenance_regenerate_token() {
	$options                              = llb_get_theme_options();
	$options['maintenance_preview_token'] = llb_generate_maintenance_token();

	update_option( 'llb_theme_options', $options );

	return $options['maintenance_preview_token'];
}

/**
 * Handles the "Generate new preview link" button.
 *
 * @return void
 */
function llb_handle_regenerate_maintenance_token() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to do this.', 'll-bouwgroep' ), '', array( 'response' => 403 ) );
	}

	check_admin_referer( 'llb_regenerate_maintenance_token' );

	llb_maintenance_regenerate_token();

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'      => 'llb-theme-options',
				'tab'       => 'maint',
				'llb-token' => 'new',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_llb_regenerate_maintenance_token', 'llb_handle_regenerate_maintenance_token' );

/**
 * Shows a confirmation notice after regenerating the token.
 *
 * @return void
 */
function llb_maintenance_token_notice() {
	if ( ! isset( $_GET['llb-token'] ) || 'new' !== $_GET['llb-token'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only notice.
		return;
	}

	if ( ! isset( $_GET['page'] ) || 'llb-theme-options' !== $_GET['page'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}

	echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'A new preview link was generated. The old link no longer works.', 'll-bouwgroep' ) . '</p></div>';
}
add_action( 'admin_notices', 'llb_maintenance_token_notice' );

/**
 * Whether the current visitor holds a valid preview cookie.
 *
 * @return bool
 */
function llb_maintenance_has_preview_cookie() {
	$token = llb_maintenance_token();

	if ( '' === $token || empty( $_COOKIE[ LLB_MAINTENANCE_COOKIE ] ) ) {
		return false;
	}

	return hash_equals( $token, sanitize_text_field( wp_unslash( $_COOKIE[ LLB_MAINTENANCE_COOKIE ] ) ) );
}

/**
 * Whether the current request must be served the holding page.
 *
 * @return bool
 */
function llb_maintenance_should_block() {
	if ( ! llb_maintenance_enabled() ) {
		return false;
	}

	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
		return false;
	}

	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return false;
	}

	if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
		return false;
	}

	if ( current_user_can( 'manage_options' ) ) {
		return false;
	}

	return ! llb_maintenance_has_preview_cookie();
}

/**
 * Consumes the preview token from the URL and stores it as a cookie for 7 days.
 *
 * @return void
 */
function llb_maintenance_catch_preview_token() {
	if ( ! llb_maintenance_enabled() || empty( $_GET['preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- token compared with hash_equals below.
		return;
	}

	$token = llb_maintenance_token();
	if ( '' === $token ) {
		return;
	}

	$given = sanitize_text_field( wp_unslash( $_GET['preview'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! hash_equals( $token, $given ) ) {
		return;
	}

	setcookie(
		LLB_MAINTENANCE_COOKIE,
		$token,
		array(
			'expires'  => time() + WEEK_IN_SECONDS,
			'path'     => COOKIEPATH ? COOKIEPATH : '/',
			'domain'   => COOKIE_DOMAIN,
			'secure'   => is_ssl(),
			'httponly' => true,
			'samesite' => 'Lax',
		)
	);

	wp_safe_redirect( home_url( '/' ) );
	exit;
}

/**
 * Serves the holding page to visitors while maintenance mode is on.
 *
 * @return void
 */
function llb_maintenance_template_redirect() {
	llb_maintenance_catch_preview_token();

	if ( ! llb_maintenance_should_block() ) {
		return;
	}

	nocache_headers();
	status_header( 503 );
	header( 'Retry-After: 3600' );

	llb_maintenance_render_page();
	exit;
}
add_action( 'template_redirect', 'llb_maintenance_template_redirect', 0 );

/**
 * Prints the branded holding page.
 *
 * @return void
 */
function llb_maintenance_render_page() {
	$company = trim( (string) llb_get_option( 'llb_company_name' ) );
	if ( '' === $company ) {
		$company = get_bloginfo( 'name' );
	}

	$heading = llb_theme_option_text( 'maintenance_heading' );
	$text    = llb_theme_option_text( 'maintenance_text' );
	$phone   = trim( (string) llb_get_option( 'llb_phone' ) );
	$tel     = preg_replace( '/[^\d+]/', '', $phone );
	$email   = trim( (string) llb_get_option( 'llb_email' ) );
	$red     = trim( (string) llb_get_option( 'llb_color_red' ) );
	$green   = trim( (string) llb_get_option( 'llb_color_green' ) );
	$logo    = llb_asset( 'images/logo-header.webp' );

	if ( '' === $red ) {
		$red = '#D0021B';
	}
	if ( '' === $green ) {
		$green = '#0B6B3A';
	}
	?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<meta name="robots" content="noindex, nofollow">
	<title><?php echo esc_html( $heading . ' — ' . $company ); ?></title>
	<link rel="stylesheet" href="<?php echo esc_url( llb_asset( 'css/fonts.css' ) ); ?>">
	<style>
		:root{--red:<?php echo esc_html( $red ); ?>;--green:<?php echo esc_html( $green ); ?>;--black:#1F1F1F;--text:#4A4A4A;--radius:12px}
		*{box-sizing:border-box}
		body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:40px 20px;background:#F5F5F3;color:var(--text);font-family:"Inter",system-ui,-apple-system,"Segoe UI",Arial,sans-serif;line-height:1.7}
		.llb-mt{width:100%;max-width:560px;background:#fff;border:1px solid #E3E2DE;border-radius:var(--radius);padding:32px 24px;text-align:center}
		.llb-mt img{height:56px;width:auto;margin:0 auto 24px;display:block}
		.llb-mt h1{font-family:"Barlow",system-ui,-apple-system,"Segoe UI",Arial,sans-serif;font-size:28px;line-height:1.15;color:var(--black);margin:0 0 20px;letter-spacing:-.01em}
		.llb-mt .rule{display:flex;width:64px;height:4px;margin:0 auto 20px}
		.llb-mt .rule::before,.llb-mt .rule::after{content:"";flex:1}
		.llb-mt .rule::before{background:var(--red)}
		.llb-mt .rule::after{background:var(--green)}
		.llb-mt p{margin:0 0 20px}
		.llb-mt ul{list-style:none;margin:0;padding:0;display:grid;gap:10px}
		.llb-mt a{color:var(--red);font-weight:600;text-decoration:none}
		.llb-mt a:hover{text-decoration:underline}
		@media (min-width:768px){
			.llb-mt{padding:56px 48px}
			.llb-mt h1{font-size:38px}
		}
	</style>
</head>
<body>
	<main class="llb-mt">
		<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $company ); ?>" width="120" height="56">
		<?php if ( '' !== $heading ) : ?>
			<h1><?php echo esc_html( $heading ); ?></h1>
		<?php endif; ?>
		<div class="rule" aria-hidden="true"></div>
		<?php if ( '' !== $text ) : ?>
			<p><?php echo esc_html( $text ); ?></p>
		<?php endif; ?>
		<?php if ( '' !== $tel || '' !== $email ) : ?>
			<ul>
				<?php if ( '' !== $tel ) : ?>
					<li>Bel ons: <a href="<?php echo esc_url( 'tel:' . $tel ); ?>"><?php echo esc_html( $phone ); ?></a></li>
				<?php endif; ?>
				<?php if ( '' !== $email ) : ?>
					<li>Mail ons: <a href="<?php echo esc_url( 'mailto:' . antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></li>
				<?php endif; ?>
			</ul>
		<?php endif; ?>
	</main>
</body>
</html>
	<?php
}

/**
 * Admin-only bar on the front end while maintenance mode is on.
 *
 * @return void
 */
function llb_maintenance_admin_bar_notice() {
	if ( ! llb_maintenance_enabled() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="llb-maintenance-bar" role="status">
		<?php echo esc_html__( 'Maintenance mode is ON — visitors see the holding page.', 'll-bouwgroep' ); ?>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=llb-theme-options&tab=maint' ) ); ?>"><?php echo esc_html__( 'Settings', 'll-bouwgroep' ); ?></a>
	</div>
	<style>
		.llb-maintenance-bar{background:#8a2b06;color:#fff;text-align:center;padding:10px 16px;font:600 14px/1.4 system-ui,-apple-system,sans-serif;position:relative;z-index:100000}
		.llb-maintenance-bar a{color:#fff;text-decoration:underline;margin-left:8px}
	</style>
	<?php
}
add_action( 'wp_body_open', 'llb_maintenance_admin_bar_notice', 4 );
