<?php
/**
 * Theme bootstrap.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LLB_VERSION', '0.1.0' );
define( 'LLB_DIR', get_template_directory() );
define( 'LLB_URI', get_template_directory_uri() );

require_once LLB_DIR . '/inc/setup.php';
require_once LLB_DIR . '/inc/post-types.php';
require_once LLB_DIR . '/inc/enqueue.php';
require_once LLB_DIR . '/inc/helpers.php';
