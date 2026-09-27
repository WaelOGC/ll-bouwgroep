<?php
/**
 * Theme bootstrap.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LLB_VERSION', wp_get_theme( get_template() )->get( 'Version' ) );
define( 'LLB_DIR', get_template_directory() );
define( 'LLB_URI', get_template_directory_uri() );

require_once LLB_DIR . '/inc/setup.php';
require_once LLB_DIR . '/inc/post-types.php';
require_once LLB_DIR . '/inc/enqueue.php';
require_once LLB_DIR . '/inc/helpers.php';
require_once LLB_DIR . '/inc/decor-icons.php';
require_once LLB_DIR . '/inc/queries.php';
require_once LLB_DIR . '/inc/customizer.php';
require_once LLB_DIR . '/inc/shortcodes.php';
require_once LLB_DIR . '/inc/compat/seo.php';
require_once LLB_DIR . '/inc/compat/elementor.php';
require_once LLB_DIR . '/inc/compat/cf7.php';
require_once LLB_DIR . '/inc/meta-boxes.php';
require_once LLB_DIR . '/inc/content-defaults.php';
require_once LLB_DIR . '/inc/import.php';
require_once LLB_DIR . '/inc/demo-images.php';
