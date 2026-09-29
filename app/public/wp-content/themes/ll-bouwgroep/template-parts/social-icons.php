<?php
/**
 * Social media icon links.
 *
 * @package LL_Bouwgroep
 *
 * @var array $args {
 *     @type string $variant footer|contact|menu
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$variant = isset( $args['variant'] ) ? (string) $args['variant'] : 'footer';

$show_map = array(
	'footer'  => 'social_show_footer',
	'contact' => 'social_show_contact',
	'menu'    => 'social_show_menu',
);

if ( ! isset( $show_map[ $variant ] ) || ! llb_theme_option_on( $show_map[ $variant ] ) ) {
	return;
}

$links = function_exists( 'llb_get_social_links' ) ? llb_get_social_links() : array();
if ( empty( $links ) ) {
	return;
}

$class = 'llb-social';
if ( 'footer' === $variant ) {
	$class .= ' llb-social--footer';
} else {
	$class .= ' llb-social--light';
}

$svgs = array(
	'instagram' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 8.2A3.2 3.2 0 1 1 12 8.8a3.2 3.2 0 0 1 0 6.4zM17.3 5.5a1.2 1.2 0 1 0 0 2.4 1.2 1.2 0 0 0 0-2.4zM12 2c-2.7 0-3 0-4.1.1C4.3 2.2 2.2 4.3 2.1 7.9 2 9 2 9.3 2 12s0 3 .1 4.1c.1 3.6 2.2 5.7 5.8 5.8 1.1.1 1.4.1 4.1.1s3 0 4.1-.1c3.6-.1 5.7-2.2 5.8-5.8.1-1.1.1-1.4.1-4.1s0-3-.1-4.1c-.1-3.6-2.2-5.7-5.8-5.8C15 2 14.7 2 12 2zm0 1.8c2.7 0 3 0 4 .1 2.6.1 3.9 1.4 4 4 .1 1 .1 1.3.1 4s0 3-.1 4c-.1 2.6-1.4 3.9-4 4-1 .1-1.3.1-4 .1s-3 0-4-.1c-2.6-.1-3.9-1.4-4-4-.1-1-.1-1.3-.1-4s0-3 .1-4c.1-2.6 1.4-3.9 4-4 1-.1 1.3-.1 4-.1z"/></svg>',
	'facebook'  => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 22v-8.2h2.8l.4-3.2h-3.2V8.6c0-.9.3-1.6 1.6-1.6h1.7V4.1c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2.3H7.3v3.2h2.8V22z"/></svg>',
	'linkedin'  => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9.8h4V21H3zM9.5 9.8h3.8v1.5h.1c.5-1 1.8-1.9 3.7-1.9 4 0 4.7 2.6 4.7 6V21h-4v-5c0-1.2 0-2.8-1.7-2.8s-2 1.3-2 2.7V21h-4z"/></svg>',
	'youtube'   => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M23 7.2a3 3 0 0 0-2.1-2.1C19 4.6 12 4.6 12 4.6s-7 0-8.9.5A3 3 0 0 0 1 7.2 31 31 0 0 0 .5 12 31 31 0 0 0 1 16.8a3 3 0 0 0 2.1 2.1c1.9.5 8.9.5 8.9.5s7 0 8.9-.5a3 3 0 0 0 2.1-2.1 31 31 0 0 0 .5-4.8 31 31 0 0 0-.5-4.8zM9.8 15V9l5.8 3z"/></svg>',
	'google'    => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.6 10.2H12v3.9h5.5c-.5 2.5-2.7 4.1-5.5 4.1a6.2 6.2 0 1 1 4-10.9l2.9-2.9A10.2 10.2 0 1 0 12 22.2c5.9 0 9.8-4.1 9.8-9.9 0-.7-.1-1.4-.2-2.1z"/></svg>',
);
?>
<div class="<?php echo esc_attr( $class ); ?>">
	<?php foreach ( $links as $link ) : ?>
		<?php
		$key = $link['key'];
		if ( ! isset( $svgs[ $key ] ) ) {
			continue;
		}
		?>
		<a
			href="<?php echo esc_url( $link['url'] ); ?>"
			target="_blank"
			rel="noopener"
			aria-label="<?php echo esc_attr( $link['label'] ); ?>"
		><?php echo $svgs[ $key ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></a>
	<?php endforeach; ?>
</div>
