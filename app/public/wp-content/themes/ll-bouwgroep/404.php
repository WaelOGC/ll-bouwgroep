<?php
/**
 * 404 template.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="llb-main">
	<div class="llb-container">
		<div class="llb-404 llb-content-narrow">
			<span class="llb-accent-line" aria-hidden="true"></span>
			<h1>Pagina niet gevonden</h1>
			<p class="llb-404__lead">De pagina die u zoekt bestaat niet meer, is verplaatst of de URL is niet correct.</p>
			<h2>Op zoek naar een bouw- of renovatieproject?</h2>
			<p>Bekijk onze diensten of neem contact met L&L Bouwgroep B.V. op.</p>
			<div class="llb-btn-group">
				<a class="llb-btn llb-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span>Naar de homepage</span>
					<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</a>
				<a class="llb-btn llb-btn--outline" href="<?php echo esc_url( llb_page_url( 'diensten' ) ); ?>">
					<span>Bekijk onze diensten</span>
					<?php echo llb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</a>
			</div>
		</div>
	</div>
</main>
<?php
get_footer();
