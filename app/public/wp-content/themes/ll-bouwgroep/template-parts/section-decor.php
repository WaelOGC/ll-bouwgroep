<?php
/**
 * Section decoration layer (blueprint / tool pattern / stripes).
 *
 * Args:
 * - blueprint (bool)
 * - tool_pattern (bool) — full-section MDI/Lucide icon wallpaper
 * - stripes (bool)
 * - stripes_corner (bool)
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueprint      = ! empty( $args['blueprint'] );
$tool_pattern   = ! empty( $args['tool_pattern'] );
$stripes        = ! empty( $args['stripes'] );
$stripes_corner = ! empty( $args['stripes_corner'] );

if ( ! $blueprint && ! $tool_pattern && ! $stripes && ! $stripes_corner ) {
	return;
}

$classes = 'llb-section-decor';
if ( $blueprint ) {
	$classes .= ' llb-section-decor--blueprint';
}
if ( $tool_pattern ) {
	$classes .= ' llb-section-decor--tool-pattern';
}
if ( $stripes ) {
	$classes .= ' llb-section-decor--stripes';
}
if ( $stripes_corner ) {
	$classes .= ' llb-section-decor--stripes-corner';
}

$uid     = wp_unique_id( 'llb-d-' );
$grad_id = $uid . '-g';
?>
<div class="<?php echo esc_attr( $classes ); ?>" data-llb-decor aria-hidden="true">
	<?php if ( $blueprint ) : ?>
		<svg class="llb-section-decor__blueprint" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true" focusable="false">
			<defs>
				<linearGradient id="<?php echo esc_attr( $grad_id ); ?>" x1="0%" y1="0%" x2="100%" y2="100%">
					<stop offset="0%" stop-color="#D0021B"/>
					<stop offset="100%" stop-color="#0B6B3A"/>
				</linearGradient>
				<pattern id="<?php echo esc_attr( $uid ); ?>-p" width="4" height="4" patternUnits="userSpaceOnUse">
					<path d="M4 0H0V4" fill="none" stroke="url(#<?php echo esc_attr( $grad_id ); ?>)" stroke-width="0.18"/>
				</pattern>
			</defs>
			<rect width="100" height="100" fill="url(#<?php echo esc_attr( $uid ); ?>-p)" class="llb-section-decor__grid-fill"/>
			<g class="llb-section-decor__measures" fill="none" stroke="url(#<?php echo esc_attr( $grad_id ); ?>)" stroke-width="0.4" stroke-linecap="square">
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

	<?php if ( $tool_pattern && function_exists( 'llb_decor_tool_pattern_placements' ) ) : ?>
		<div class="llb-tool-pattern" data-llb-tool-pattern data-llb-parallax>
			<?php foreach ( llb_decor_tool_pattern_placements() as $index => $item ) : ?>
				<?php
				$icon_uid = $uid . '-t' . $index;
				$svg      = llb_get_decor_icon_svg( $item['set'], $item['icon'], $icon_uid );
				if ( '' === $svg ) {
					continue;
				}
				$style = sprintf(
					'left:%s%%;top:%s%%;--llb-tool-s:%spx;--llb-tool-rot:%sdeg;--llb-float-dur:%ss;--llb-float-delay:%ss;--llb-float-x:%spx;--llb-float-y:%spx;--llb-float-r:%sdeg;--llb-float-s:%s;',
					esc_attr( (string) $item['x'] ),
					esc_attr( (string) $item['y'] ),
					esc_attr( (string) $item['s'] ),
					esc_attr( (string) $item['r'] ),
					esc_attr( (string) $item['dur'] ),
					esc_attr( (string) $item['delay'] ),
					esc_attr( (string) $item['fx'] ),
					esc_attr( (string) $item['fy'] ),
					esc_attr( (string) $item['frot'] ),
					esc_attr( (string) $item['fscale'] )
				);
				?>
				<span class="llb-tool-pattern__item" style="<?php echo esc_attr( $style ); ?>">
					<span class="llb-tool-pattern__float">
						<?php echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG from theme files. ?>
					</span>
				</span>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
