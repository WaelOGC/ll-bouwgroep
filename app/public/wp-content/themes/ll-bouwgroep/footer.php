<?php
/**
 * Footer template.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="llb-site-footer" role="contentinfo">
	<div class="llb-container">
		<nav class="llb-nav-footer" aria-label="<?php echo esc_attr__( 'Footermenu', 'll-bouwgroep' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'    => false,
					'menu_class'     => 'llb-menu llb-menu--footer',
				)
			);
			?>
		</nav>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
