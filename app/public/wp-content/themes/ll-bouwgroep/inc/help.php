<?php
/**
 * Theme Help admin page (Getting started + Theme Options).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the Help submenu under Theme Options.
 *
 * @return void
 */
function llb_add_help_page() {
	global $llb_help_page_hook;

	$llb_help_page_hook = add_submenu_page(
		'llb-theme-options',
		__( 'Help', 'll-bouwgroep' ),
		__( 'Help', 'll-bouwgroep' ),
		'manage_options',
		'llb-help',
		'llb_render_help_page'
	);
}
add_action( 'admin_menu', 'llb_add_help_page', 20 );

/**
 * Enqueues Help page CSS/JS on that screen only.
 *
 * @param string $hook Current admin page hook suffix.
 * @return void
 */
function llb_enqueue_help_assets( $hook ) {
	global $llb_help_page_hook;

	if ( empty( $llb_help_page_hook ) || $hook !== $llb_help_page_hook ) {
		return;
	}

	$css = LLB_DIR . '/assets/css/admin-help.css';
	$js  = LLB_DIR . '/assets/js/admin-help.js';

	wp_enqueue_style(
		'llb-help',
		llb_asset( 'css/admin-help.css' ),
		array(),
		file_exists( $css ) ? (string) filemtime( $css ) : LLB_VERSION
	);
	wp_enqueue_script(
		'llb-help',
		llb_asset( 'js/admin-help.js' ),
		array(),
		file_exists( $js ) ? (string) filemtime( $js ) : LLB_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'llb_enqueue_help_assets' );

/**
 * Renders the Help admin page.
 *
 * @return void
 */
function llb_render_help_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$llbh_full = false;
	?>
	<div class="wrap llbo-wrap">
		<hr class="wp-header-end">
		<?php require LLB_DIR . '/template-parts/admin/help.php'; ?>
	</div>
	<?php
}

/**
 * Renders the standalone Full view Help page (admins only).
 *
 * @return void
 */
function llb_render_help_full() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die(
			esc_html__( 'Sorry, you are not allowed to access this page.', 'll-bouwgroep' ),
			'',
			array( 'response' => 403 )
		);
	}

	nocache_headers();
	header( 'X-Robots-Tag: noindex, nofollow', true );

	$llbh_full = true;
	$llbh_lang = ( 0 === strpos( get_user_locale(), 'nl' ) ) ? 'nl' : 'en';
	$css       = LLB_DIR . '/assets/css/admin-help.css';
	$js        = LLB_DIR . '/assets/js/admin-help.js';
	$css_ver   = file_exists( $css ) ? (string) filemtime( $css ) : LLB_VERSION;
	$js_ver    = file_exists( $js ) ? (string) filemtime( $js ) : LLB_VERSION;
	?>
<!DOCTYPE html>
<html lang="<?php echo esc_attr( $llbh_lang ); ?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Help &amp; documentation</title>
<link rel="stylesheet" href="<?php echo esc_url( llb_asset( 'css/admin-help.css' ) ); ?>?ver=<?php echo esc_attr( $css_ver ); ?>">
</head>
<body class="llbh-fullpage">
<?php require LLB_DIR . '/template-parts/admin/help.php'; ?>
<script src="<?php echo esc_url( llb_asset( 'js/admin-help.js' ) ); ?>?ver=<?php echo esc_attr( $js_ver ); ?>"></script>
</body>
</html>
	<?php
	exit;
}
add_action( 'admin_post_llb_help_full', 'llb_render_help_full' );
add_action( 'admin_post_nopriv_llb_help_full', 'auth_redirect' );
