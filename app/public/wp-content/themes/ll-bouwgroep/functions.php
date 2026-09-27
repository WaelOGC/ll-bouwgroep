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
require_once LLB_DIR . '/inc/customizer.php';
require_once LLB_DIR . '/inc/meta-boxes.php';
