<?php
/**
 * Section decoration layer (blueprint / tools / stripes).
 *
 * Args:
 * - blueprint (bool)
 * - tools (string[]) tool keys: hammer, level, tape, trowel, tile, square
 * - stripes (bool)
 * - stripes_corner (bool) — corner accent only
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueprint      = ! empty( $args['blueprint'] );
$tools          = isset( $args['tools'] ) && is_array( $args['tools'] ) ? $args['tools'] : array();
$stripes        = ! empty( $args['stripes'] );
$stripes_corner = ! empty( $args['stripes_corner'] );

if ( ! $blueprint && empty( $tools ) && ! $stripes && ! $stripes_corner ) {
	return;
}

/**
 * Returns an inline stroke-only tool SVG.
 *
 * @param string $name Tool key.
 * @return string
 */
$llb_tool_svg = static function ( $name ) {
	$svgs = array(
		'hammer' => '<svg class="llb-decor-tool__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M38 8l10 10-6 6-10-10z"/><path d="M32 14l-4 4 18 18 4-4z"/><path d="M28 22L12 52c-1 2 1 4 3 3l26-20"/></svg>',
		'level'  => '<svg class="llb-decor-tool__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="6" y="24" width="52" height="16" rx="2"/><circle cx="32" cy="32" r="5"/><path d="M14 32h8M42 32h8"/></svg>',
		'tape'   => '<svg class="llb-decor-tool__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="26" cy="32" r="16"/><circle cx="26" cy="32" r="6"/><path d="M40 28h16v12H42"/><path d="M44 32h8M48 28v12"/></svg>',
		'trowel' => '<svg class="llb-decor-tool__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M12 44c8-2 18-8 28-22l6 6C32 42 22 50 12 50z"/><path d="M40 22l10-10 4 4-10 10"/></svg>',
		'tile'   => '<svg class="llb-decor-tool__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="10" y="10" width="20" height="20" rx="1"/><rect x="34" y="10" width="20" height="20" rx="1"/><rect x="10" y="34" width="20" height="20" rx="1"/><rect x="34" y="34" width="20" height="20" rx="1"/></svg>',
		'square' => '<svg class="llb-decor-tool__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M12 52V12h8v32h32v8H12z"/><path d="M20 28h12M20 36h20"/></svg>',
	);

	return isset( $svgs[ $name ] ) ? $svgs[ $name ] : '';
};

$classes = 'llb-section-decor';
if ( $blueprint ) {
	$classes .= ' llb-section-decor--blueprint';
}
if ( ! empty( $tools ) ) {
	$classes .= ' llb-section-decor--tools';
}
if ( $stripes ) {
	$classes .= ' llb-section-decor--stripes';
}
if ( $stripes_corner ) {
	$classes .= ' llb-section-decor--stripes-corner';
}

$pattern_id = 'llb-bp-' . wp_unique_id();
?>
<div class="<?php echo esc_attr( $classes ); ?>" data-llb-decor aria-hidden="true">
	<?php if ( $blueprint ) : ?>
		<svg class="llb-section-decor__blueprint" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true" focusable="false">
			<defs>
				<pattern id="<?php echo esc_attr( $pattern_id ); ?>" width="4" height="4" patternUnits="userSpaceOnUse">
					<path d="M4 0H0V4" fill="none" stroke="currentColor" stroke-width="0.15"/>
				</pattern>
			</defs>
			<rect width="100" height="100" fill="url(#<?php echo esc_attr( $pattern_id ); ?>)" class="llb-section-decor__grid-fill"/>
			<g class="llb-section-decor__measures" fill="none" stroke="currentColor" stroke-width="0.35" stroke-linecap="square">
				<path class="llb-measure-line" pathLength="100" d="M8 22 H42"/>
				<path class="llb-measure-tick" d="M8 20 V24 M42 20 V24"/>
				<path class="llb-measure-line" pathLength="100" d="M55 70 H92"/>
				<path class="llb-measure-tick" d="M55 68 V72 M92 68 V72"/>
				<path class="llb-measure-line" pathLength="100" d="M18 78 V48"/>
				<path class="llb-measure-tick" d="M16 78 H20 M16 48 H20"/>
			</g>
		</svg>
	<?php endif; ?>

	<?php if ( $stripes || $stripes_corner ) : ?>
		<div class="llb-section-decor__stripes">
			<span class="llb-section-decor__stripe llb-section-decor__stripe--red"></span>
			<span class="llb-section-decor__stripe llb-section-decor__stripe--green"></span>
			<span class="llb-section-decor__stripe llb-section-decor__stripe--red llb-section-decor__stripe--delay"></span>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $tools ) ) : ?>
		<div class="llb-section-decor__tools">
			<?php foreach ( array_values( $tools ) as $index => $tool ) : ?>
				<?php
				$svg = $llb_tool_svg( (string) $tool );
				if ( '' === $svg ) {
					continue;
				}
				?>
				<span class="llb-decor-tool llb-decor-tool--<?php echo esc_attr( (string) ( $index + 1 ) ); ?>" data-llb-parallax>
					<?php echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</span>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
