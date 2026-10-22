<?php
/**
 * Theme Customizer settings.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns default Customizer values (visitor-facing Dutch where applicable).
 *
 * Single source of truth for theme option defaults.
 *
 * @return array<string, mixed>
 */
function llb_customizer_defaults() {
	return array(
		'llb_company_name'       => 'L&L Bouw B.V.',
		'llb_phone'              => '',
		'llb_email'              => '',
		'llb_address_street'     => '',
		'llb_address_postcode'   => '',
		'llb_address_city'       => 'Zoetermeer',
		'llb_kvk'                => '',
		'llb_btw'                => '',
		'llb_hours_monday'       => '08:00 – 17:00',
		'llb_hours_tuesday'      => '08:00 – 17:00',
		'llb_hours_wednesday'    => '08:00 – 17:00',
		'llb_hours_thursday'     => '08:00 – 17:00',
		'llb_hours_friday'       => '08:00 – 17:00',
		'llb_hours_saturday'     => 'Gesloten',
		'llb_hours_sunday'       => 'Gesloten',
		'llb_map_image'          => 0,
		'llb_map_url'            => '',
		'llb_header_cta_text'    => 'Offerte aanvragen',
		'llb_header_cta_url'     => '',
		'llb_footer_tagline'     => 'Vakmanschap waarop u kunt bouwen.',
		'llb_footer_text'        => 'Bouw- en renovatiewerkzaamheden voor woningen en bedrijfspanden.',
		'llb_footer_copyright'   => 'Alle rechten voorbehouden.',
		'llb_cf7_shortcode'      => '',
		'llb_color_red'          => '#D0021B',
		'llb_color_green'        => '#0B6B3A',
		'llb_service_projects_heading' => 'Bekijk ons werk',
		'llb_service_projects_btn'     => 'Bekijk onze projecten',
		'llb_service_faq_heading'      => 'Veelgestelde vragen',
		'llb_service_faq_btn'          => 'Bekijk alle vragen',
		'llb_service_others_heading'   => 'Onze diensten',
		'llb_404_title'                => 'Pagina niet gevonden',
		'llb_404_lead'                 => 'De pagina die u zoekt bestaat niet meer, is verplaatst of de URL is niet correct.',
		'llb_404_sub_title'            => 'Op zoek naar een bouw- of renovatieproject?',
		'llb_404_sub_text'             => 'Bekijk onze diensten of neem contact met L&L Bouw B.V. op.',
		'llb_404_btn_home'             => 'Naar de homepage',
		'llb_404_btn_services'         => 'Bekijk onze diensten',
	);
}

/**
 * Registers Customizer panel, sections, and settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @return void
 */
function llb_customize_register( $wp_customize ) {
	$defaults = llb_customizer_defaults();

	$wp_customize->add_panel(
		'llb_theme_options',
		array(
			'title'    => __( 'L&L Bouw', 'll-bouwgroep' ),
			'priority' => 30,
		)
	);

	// Company & contact.
	$wp_customize->add_section(
		'llb_section_company',
		array(
			'title'       => __( 'Company & contact', 'll-bouwgroep' ),
			'description' => __( 'Leave empty until the real company data is available. Empty fields are hidden on the website.', 'll-bouwgroep' ),
			'panel'       => 'llb_theme_options',
			'priority'    => 10,
		)
	);

	$company_fields = array(
		'llb_company_name'     => array(
			'label'    => __( 'Company name', 'll-bouwgroep' ),
			'sanitize' => 'sanitize_text_field',
			'type'     => 'text',
		),
		'llb_phone'            => array(
			'label'    => __( 'Phone', 'll-bouwgroep' ),
			'sanitize' => 'sanitize_text_field',
			'type'     => 'text',
		),
		'llb_email'            => array(
			'label'    => __( 'Email', 'll-bouwgroep' ),
			'sanitize' => 'sanitize_email',
			'type'     => 'email',
		),
		'llb_address_street'   => array(
			'label'    => __( 'Street + number', 'll-bouwgroep' ),
			'sanitize' => 'sanitize_text_field',
			'type'     => 'text',
		),
		'llb_address_postcode' => array(
			'label'    => __( 'Postcode', 'll-bouwgroep' ),
			'sanitize' => 'sanitize_text_field',
			'type'     => 'text',
		),
		'llb_address_city'     => array(
			'label'    => __( 'City', 'll-bouwgroep' ),
			'sanitize' => 'sanitize_text_field',
			'type'     => 'text',
		),
		'llb_kvk'              => array(
			'label'    => __( 'KvK number', 'll-bouwgroep' ),
			'sanitize' => 'sanitize_text_field',
			'type'     => 'text',
		),
		'llb_btw'              => array(
			'label'    => __( 'BTW number', 'll-bouwgroep' ),
			'sanitize' => 'sanitize_text_field',
			'type'     => 'text',
		),
	);

	foreach ( $company_fields as $id => $field ) {
		llb_customizer_add_setting_control(
			$wp_customize,
			$id,
			array(
				'default'           => $defaults[ $id ],
				'sanitize_callback' => $field['sanitize'],
				'section'           => 'llb_section_company',
				'label'             => $field['label'],
				'type'              => $field['type'],
			)
		);
	}

	// Opening hours.
	$wp_customize->add_section(
		'llb_section_hours',
		array(
			'title'       => __( 'Opening hours', 'll-bouwgroep' ),
			'description' => __( 'Example: 08:00 – 17:00 or Gesloten.', 'll-bouwgroep' ),
			'panel'       => 'llb_theme_options',
			'priority'    => 20,
		)
	);

	$hours_fields = array(
		'llb_hours_monday'    => __( 'Monday', 'll-bouwgroep' ),
		'llb_hours_tuesday'   => __( 'Tuesday', 'll-bouwgroep' ),
		'llb_hours_wednesday' => __( 'Wednesday', 'll-bouwgroep' ),
		'llb_hours_thursday'  => __( 'Thursday', 'll-bouwgroep' ),
		'llb_hours_friday'    => __( 'Friday', 'll-bouwgroep' ),
		'llb_hours_saturday'  => __( 'Saturday', 'll-bouwgroep' ),
		'llb_hours_sunday'    => __( 'Sunday', 'll-bouwgroep' ),
	);

	foreach ( $hours_fields as $id => $label ) {
		llb_customizer_add_setting_control(
			$wp_customize,
			$id,
			array(
				'default'           => $defaults[ $id ],
				'sanitize_callback' => 'sanitize_text_field',
				'section'           => 'llb_section_hours',
				'label'             => $label,
				'type'              => 'text',
			)
		);
	}

	// Map.
	$wp_customize->add_section(
		'llb_section_map',
		array(
			'title'    => __( 'Map', 'll-bouwgroep' ),
			'panel'    => 'llb_theme_options',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'llb_map_image',
		array(
			'default'           => $defaults['llb_map_image'],
			'sanitize_callback' => 'absint',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'llb_map_image',
			array(
				'label'     => __( 'Static map image', 'll-bouwgroep' ),
				'section'   => 'llb_section_map',
				'mime_type' => 'image',
			)
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_map_url',
		array(
			'default'           => $defaults['llb_map_url'],
			'sanitize_callback' => 'esc_url_raw',
			'section'           => 'llb_section_map',
			'label'             => __( 'Route URL (Google Maps)', 'll-bouwgroep' ),
			'description'       => __( 'Opens in a new tab. If empty, a Google Maps link is built from the address.', 'll-bouwgroep' ),
			'type'              => 'url',
		)
	);

	// Header.
	$wp_customize->add_section(
		'llb_section_header',
		array(
			'title'    => __( 'Header', 'll-bouwgroep' ),
			'panel'    => 'llb_theme_options',
			'priority' => 50,
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_header_cta_text',
		array(
			'default'           => $defaults['llb_header_cta_text'],
			'sanitize_callback' => 'sanitize_text_field',
			'section'           => 'llb_section_header',
			'label'             => __( 'Button text', 'll-bouwgroep' ),
			'type'              => 'text',
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_header_cta_url',
		array(
			'default'           => $defaults['llb_header_cta_url'],
			'sanitize_callback' => 'esc_url_raw',
			'section'           => 'llb_section_header',
			'label'             => __( 'Button link', 'll-bouwgroep' ),
			'description'       => __( 'If empty, links to /contact/.', 'll-bouwgroep' ),
			'type'              => 'url',
		)
	);

	// Footer.
	$wp_customize->add_section(
		'llb_section_footer',
		array(
			'title'    => __( 'Footer', 'll-bouwgroep' ),
			'panel'    => 'llb_theme_options',
			'priority' => 60,
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_footer_tagline',
		array(
			'default'           => $defaults['llb_footer_tagline'],
			'sanitize_callback' => 'sanitize_text_field',
			'section'           => 'llb_section_footer',
			'label'             => __( 'Tagline', 'll-bouwgroep' ),
			'type'              => 'text',
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_footer_text',
		array(
			'default'           => $defaults['llb_footer_text'],
			'sanitize_callback' => 'sanitize_textarea_field',
			'section'           => 'llb_section_footer',
			'label'             => __( 'Footer text', 'll-bouwgroep' ),
			'type'              => 'textarea',
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_footer_copyright',
		array(
			'default'           => $defaults['llb_footer_copyright'],
			'sanitize_callback' => 'sanitize_text_field',
			'section'           => 'llb_section_footer',
			'label'             => __( 'Copyright text', 'll-bouwgroep' ),
			'description'       => __( 'The © symbol, current year and company name are added automatically.', 'll-bouwgroep' ),
			'type'              => 'text',
		)
	);

	// Contact form.
	$wp_customize->add_section(
		'llb_section_cf7',
		array(
			'title'    => __( 'Contact form', 'll-bouwgroep' ),
			'panel'    => 'llb_theme_options',
			'priority' => 70,
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_cf7_shortcode',
		array(
			'default'           => $defaults['llb_cf7_shortcode'],
			'sanitize_callback' => 'sanitize_text_field',
			'section'           => 'llb_section_cf7',
			'label'             => __( 'Contact Form 7 shortcode', 'll-bouwgroep' ),
			'description'       => __( 'Paste the shortcode from Contact → Contact Forms. If empty or CF7 is inactive, only contact details are shown.', 'll-bouwgroep' ),
			'type'              => 'text',
		)
	);

	// Service template labels.
	$wp_customize->add_section(
		'llb_section_service_template',
		array(
			'title'    => __( 'Service template', 'll-bouwgroep' ),
			'panel'    => 'llb_theme_options',
			'priority' => 75,
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_service_projects_heading',
		array(
			'default'           => $defaults['llb_service_projects_heading'],
			'sanitize_callback' => 'sanitize_text_field',
			'section'           => 'llb_section_service_template',
			'label'             => __( 'Related projects heading', 'll-bouwgroep' ),
			'type'              => 'text',
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_service_projects_btn',
		array(
			'default'           => $defaults['llb_service_projects_btn'],
			'sanitize_callback' => 'sanitize_text_field',
			'section'           => 'llb_section_service_template',
			'label'             => __( 'Related projects button text', 'll-bouwgroep' ),
			'type'              => 'text',
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_service_faq_heading',
		array(
			'default'           => $defaults['llb_service_faq_heading'],
			'sanitize_callback' => 'sanitize_text_field',
			'section'           => 'llb_section_service_template',
			'label'             => __( 'Related FAQ heading', 'll-bouwgroep' ),
			'type'              => 'text',
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_service_faq_btn',
		array(
			'default'           => $defaults['llb_service_faq_btn'],
			'sanitize_callback' => 'sanitize_text_field',
			'section'           => 'llb_section_service_template',
			'label'             => __( 'Related FAQ button text', 'll-bouwgroep' ),
			'type'              => 'text',
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_service_others_heading',
		array(
			'default'           => $defaults['llb_service_others_heading'],
			'sanitize_callback' => 'sanitize_text_field',
			'section'           => 'llb_section_service_template',
			'label'             => __( 'Other services heading', 'll-bouwgroep' ),
			'type'              => 'text',
		)
	);

	// 404 page.
	$wp_customize->add_section(
		'llb_section_404',
		array(
			'title'    => __( '404 page', 'll-bouwgroep' ),
			'panel'    => 'llb_theme_options',
			'priority' => 76,
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_404_title',
		array(
			'default'           => $defaults['llb_404_title'],
			'sanitize_callback' => 'sanitize_text_field',
			'section'           => 'llb_section_404',
			'label'             => __( 'Heading (H1)', 'll-bouwgroep' ),
			'type'              => 'text',
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_404_lead',
		array(
			'default'           => $defaults['llb_404_lead'],
			'sanitize_callback' => 'sanitize_textarea_field',
			'section'           => 'llb_section_404',
			'label'             => __( 'Lead text', 'll-bouwgroep' ),
			'type'              => 'textarea',
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_404_sub_title',
		array(
			'default'           => $defaults['llb_404_sub_title'],
			'sanitize_callback' => 'sanitize_text_field',
			'section'           => 'llb_section_404',
			'label'             => __( 'Subheading (H2)', 'll-bouwgroep' ),
			'type'              => 'text',
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_404_sub_text',
		array(
			'default'           => $defaults['llb_404_sub_text'],
			'sanitize_callback' => 'sanitize_textarea_field',
			'section'           => 'llb_section_404',
			'label'             => __( 'Sub text', 'll-bouwgroep' ),
			'type'              => 'textarea',
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_404_btn_home',
		array(
			'default'           => $defaults['llb_404_btn_home'],
			'sanitize_callback' => 'sanitize_text_field',
			'section'           => 'llb_section_404',
			'label'             => __( 'Home button text', 'll-bouwgroep' ),
			'type'              => 'text',
		)
	);

	llb_customizer_add_setting_control(
		$wp_customize,
		'llb_404_btn_services',
		array(
			'default'           => $defaults['llb_404_btn_services'],
			'sanitize_callback' => 'sanitize_text_field',
			'section'           => 'llb_section_404',
			'label'             => __( 'Services button text', 'll-bouwgroep' ),
			'type'              => 'text',
		)
	);

	// Brand colors.
	$wp_customize->add_section(
		'llb_section_colors',
		array(
			'title'    => __( 'Brand colors', 'll-bouwgroep' ),
			'panel'    => 'llb_theme_options',
			'priority' => 80,
		)
	);

	$wp_customize->add_setting(
		'llb_color_red',
		array(
			'default'           => $defaults['llb_color_red'],
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'llb_color_red',
			array(
				'label'   => __( 'Primary red', 'll-bouwgroep' ),
				'section' => 'llb_section_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'llb_color_green',
		array(
			'default'           => $defaults['llb_color_green'],
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'llb_color_green',
			array(
				'label'   => __( 'Secondary green', 'll-bouwgroep' ),
				'section' => 'llb_section_colors',
			)
		)
	);
}
add_action( 'customize_register', 'llb_customize_register' );

/**
 * Adds a setting and a basic control to the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @param string               $id           Setting ID.
 * @param array                $args         Setting/control args.
 * @return void
 */
function llb_customizer_add_setting_control( $wp_customize, $id, $args ) {
	$wp_customize->add_setting(
		$id,
		array(
			'default'           => $args['default'],
			'sanitize_callback' => $args['sanitize_callback'],
			'capability'        => 'edit_theme_options',
		)
	);

	$control = array(
		'label'   => $args['label'],
		'section' => $args['section'],
		'type'    => $args['type'],
	);

	if ( ! empty( $args['description'] ) ) {
		$control['description'] = $args['description'];
	}

	$wp_customize->add_control( $id, $control );
}
