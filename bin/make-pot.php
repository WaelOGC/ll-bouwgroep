<?php
/**
 * Minimal gettext extractor for the ll-bouwgroep text domain.
 *
 * Used when WP-CLI is not available:
 *   php bin/make-pot.php
 *
 * @package LL_Bouwgroep
 */

$theme_dir = dirname( __DIR__ ) . '/app/public/wp-content/themes/ll-bouwgroep';
$pot_file  = $theme_dir . '/languages/ll-bouwgroep.pot';
$domain    = 'll-bouwgroep';

if ( ! is_dir( $theme_dir ) ) {
	fwrite( STDERR, "Theme directory not found: {$theme_dir}\n" );
	exit( 1 );
}

$files = array();
$iterator = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $theme_dir, FilesystemIterator::SKIP_DOTS ) );
foreach ( $iterator as $file ) {
	if ( 'php' === strtolower( $file->getExtension() ) ) {
		$files[] = $file->getPathname();
	}
}
sort( $files );

$entries = array();

foreach ( $files as $file ) {
	$source = file_get_contents( $file );
	$lines  = explode( "\n", $source );
	$rel    = str_replace( '\\', '/', substr( $file, strlen( $theme_dir ) + 1 ) );

	foreach ( $lines as $number => $line ) {
		$pattern = '/\b(?:esc_html__|esc_attr__|esc_html_e|esc_attr_e|__|_e|_x|esc_html_x)\s*\(\s*'
			. '(\'(?:\\\\.|[^\'\\\\])*\'|"(?:\\\\.|[^"\\\\])*")'
			. '(?:\s*,\s*(\'(?:\\\\.|[^\'\\\\])*\'|"(?:\\\\.|[^"\\\\])*"))?'
			. '(?:\s*,\s*(\'(?:\\\\.|[^\'\\\\])*\'|"(?:\\\\.|[^"\\\\])*"))?/';

		if ( ! preg_match_all( $pattern, $line, $matches, PREG_SET_ORDER ) ) {
			continue;
		}

		foreach ( $matches as $match ) {
			$args = array_slice( $match, 1 );
			$args = array_values( array_filter( $args, static function ( $value ) {
				return '' !== $value;
			} ) );

			$unquoted = array_map( 'unquote_php_string', $args );

			// The text domain is always the last argument we captured.
			if ( ! in_array( $domain, $unquoted, true ) ) {
				continue;
			}

			$text    = $unquoted[0];
			$context = ( 3 === count( $unquoted ) ) ? $unquoted[1] : '';

			if ( '' === $text ) {
				continue;
			}

			$key = $context . "\4" . $text;

			if ( ! isset( $entries[ $key ] ) ) {
				$entries[ $key ] = array(
					'text'      => $text,
					'context'   => $context,
					'references' => array(),
				);
			}

			$entries[ $key ]['references'][] = $rel . ':' . ( $number + 1 );
		}
	}
}

/**
 * Converts a quoted PHP string literal to its value.
 *
 * @param string $value Quoted literal.
 * @return string
 */
function unquote_php_string( $value ) {
	$quote = substr( $value, 0, 1 );
	$inner = substr( $value, 1, -1 );

	if ( "'" === $quote ) {
		return str_replace( array( "\\'", '\\\\' ), array( "'", '\\' ), $inner );
	}

	return str_replace( array( '\\"', '\\n', '\\t', '\\\\' ), array( '"', "\n", "\t", '\\' ), $inner );
}

/**
 * Escapes a string for a PO msgid / msgstr.
 *
 * @param string $value Raw string.
 * @return string
 */
function po_escape( $value ) {
	return str_replace(
		array( '\\', '"', "\n", "\t" ),
		array( '\\\\', '\\"', '\\n', '\\t' ),
		$value
	);
}

ksort( $entries );

$date = gmdate( 'Y-m-d H:iO' );

$out  = "# Copyright (C) 2026 Wael Safan\n";
$out .= "# This file is distributed under the GPL-2.0-or-later license.\n";
$out .= "msgid \"\"\n";
$out .= "msgstr \"\"\n";
$out .= "\"Project-Id-Version: L&L Bouwgroep 0.25.0\\n\"\n";
$out .= "\"Report-Msgid-Bugs-To: https://github.com/WaelOGC/ll-bouwgroep/issues\\n\"\n";
$out .= "\"POT-Creation-Date: {$date}\\n\"\n";
$out .= "\"MIME-Version: 1.0\\n\"\n";
$out .= "\"Content-Type: text/plain; charset=UTF-8\\n\"\n";
$out .= "\"Content-Transfer-Encoding: 8bit\\n\"\n";
$out .= "\"PO-Revision-Date: YEAR-MO-DA HO:MI+ZONE\\n\"\n";
$out .= "\"Last-Translator: FULL NAME <EMAIL@ADDRESS>\\n\"\n";
$out .= "\"Language-Team: LANGUAGE <LL@li.org>\\n\"\n";
$out .= "\"Plural-Forms: nplurals=2; plural=(n != 1);\\n\"\n";
$out .= "\"X-Domain: {$domain}\\n\"\n";

foreach ( $entries as $entry ) {
	$out .= "\n";
	foreach ( array_unique( $entry['references'] ) as $reference ) {
		$out .= "#: {$reference}\n";
	}
	if ( '' !== $entry['context'] ) {
		$out .= 'msgctxt "' . po_escape( $entry['context'] ) . "\"\n";
	}
	$out .= 'msgid "' . po_escape( $entry['text'] ) . "\"\n";
	$out .= "msgstr \"\"\n";
}

if ( ! is_dir( dirname( $pot_file ) ) ) {
	mkdir( dirname( $pot_file ), 0755, true );
}

file_put_contents( $pot_file, $out );

printf( "Wrote %d strings to %s\n", count( $entries ), $pot_file );
