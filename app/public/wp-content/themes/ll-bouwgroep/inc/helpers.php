<?php
/**
 * Theme helper functions.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the URL for a file inside the theme assets directory.
 *
 * @param string $path Relative path under assets/ (e.g. 'css/main.css').
 * @return string Asset URL (escape on output with esc_url()).
 */
function llb_asset( $path ) {
	$path = ltrim( (string) $path, '/' );
	return LLB_URI . '/assets/' . $path;
}
