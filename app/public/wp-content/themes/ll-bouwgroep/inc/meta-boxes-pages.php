<?php
/**
 * Page and FAQ meta box field definitions.
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns page-template meta box definitions for post type `page`.
 *
 * @return array<string, array<string, mixed>>
 */
function llb_meta_box_page_config() {
	$home     = 'page-templates/template-home.php';
	$about    = 'page-templates/template-about.php';
	$services = 'page-templates/template-services.php';
	$projects = 'page-templates/template-projects.php';
	$contact  = 'page-templates/template-contact.php';
	$faq      = 'page-templates/page-faq.php';

	$hero_templates = array( $home, $about, $services, $projects, $contact, $faq );

	$page_notice = __( 'Save and reload the page after changing the template to see the matching fields.', 'll-bouwgroep' );

	return array(
		'llb_page_hero'              => array(
			'title'       => __( 'Page hero', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'templates'   => $hero_templates,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_hero_image',
					'type'  => 'image',
					'label' => __( 'Hero image', 'll-bouwgroep' ),
				),
				array(
					'key'         => '_llb_hero_image_mobile',
					'type'        => 'image',
					'label'       => __( 'Hero image (mobile)', 'll-bouwgroep' ),
					'description' => __( 'Portrait image for phones and portrait tablets. If empty, the desktop hero image is used.', 'll-bouwgroep' ),
				),
				array(
					'key'         => '_llb_hero_title',
					'type'        => 'textarea',
					'label'       => __( 'Hero title (H1)', 'll-bouwgroep' ),
					'description' => __( 'One line per visual line (3 lines recommended). If empty, the page title is used.', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_hero_intro',
					'type'  => 'textarea',
					'label' => __( 'Hero intro', 'll-bouwgroep' ),
				),
			),
		),
		'llb_home_hero_buttons'      => array(
			'title'       => __( 'Hero buttons', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $home,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_hero_btn1_text',
					'type'  => 'text',
					'label' => __( 'Primary button text', 'll-bouwgroep' ),
				),
				array(
					'key'         => '_llb_hero_btn1_url',
					'type'        => 'url',
					'label'       => __( 'Primary button link', 'll-bouwgroep' ),
					'description' => __( 'If empty: header button link', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_hero_btn2_text',
					'type'  => 'text',
					'label' => __( 'Secondary button text', 'll-bouwgroep' ),
				),
				array(
					'key'         => '_llb_hero_btn2_url',
					'type'        => 'url',
					'label'       => __( 'Secondary button link', 'll-bouwgroep' ),
					'description' => __( 'If empty: Services page', 'll-bouwgroep' ),
				),
			),
		),
		'llb_home_intro'             => array(
			'title'       => __( 'Introduction', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $home,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_intro_heading',
					'type'  => 'text',
					'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_intro_text',
					'type'  => 'textarea',
					'label' => __( 'Text', 'll-bouwgroep' ),
				),
			),
		),
		'llb_home_bath'              => array(
			'title'       => __( 'Bathrooms highlight', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $home,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_bath_image',
					'type'  => 'image',
					'label' => __( 'Image', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_bath_heading',
					'type'  => 'text',
					'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_bath_text',
					'type'  => 'textarea',
					'label' => __( 'Text', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_bath_subheading',
					'type'  => 'text',
					'label' => __( 'Subheading (H3)', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_bath_btn_text',
					'type'  => 'text',
					'label' => __( 'Button text', 'll-bouwgroep' ),
				),
				array(
					'key'         => '_llb_bath_btn_url',
					'type'        => 'url',
					'label'       => __( 'Button link', 'll-bouwgroep' ),
					'description' => __( 'If empty: Badkamers & toiletten service', 'll-bouwgroep' ),
				),
			),
		),
		'llb_home_services'          => array(
			'title'       => __( 'Services section', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $home,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_services_heading',
					'type'  => 'text',
					'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'         => '_llb_services_intro',
					'type'        => 'textarea',
					'label'       => __( 'Intro', 'll-bouwgroep' ),
					'description' => __( 'Services are loaded from Services, in their Order.', 'll-bouwgroep' ),
				),
			),
		),
		'llb_home_why'               => array(
			'title'       => __( 'Why us', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $home,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_why_image',
					'type'  => 'image',
					'label' => __( 'Image', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_why_heading',
					'type'  => 'text',
					'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_why_text',
					'type'  => 'textarea',
					'label' => __( 'Text', 'll-bouwgroep' ),
				),
				array(
					'key'    => '_llb_why_items',
					'type'   => 'repeater',
					'label'  => __( 'Items', 'll-bouwgroep' ),
					'fields' => array(
						array(
							'key'     => 'icon',
							'type'    => 'select',
							'label'   => __( 'Icon', 'll-bouwgroep' ),
							'options' => llb_why_icon_options(),
						),
						array(
							'key'   => 'title',
							'type'  => 'text',
							'label' => __( 'Title (H3)', 'll-bouwgroep' ),
						),
						array(
							'key'   => 'text',
							'type'  => 'textarea',
							'label' => __( 'Text', 'll-bouwgroep' ),
						),
					),
				),
			),
		),
		'llb_home_projects'          => array(
			'title'       => __( 'Projects section', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $home,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_projects_heading',
					'type'  => 'text',
					'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_projects_text',
					'type'  => 'textarea',
					'label' => __( 'Text', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_projects_btn_text',
					'type'  => 'text',
					'label' => __( 'Button text', 'll-bouwgroep' ),
				),
			),
		),
		'llb_home_faq'               => array(
			'title'       => __( 'FAQ section', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $home,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_faq_heading',
					'type'  => 'text',
					'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'         => '_llb_faq_btn_text',
					'type'        => 'text',
					'label'       => __( 'Button text', 'll-bouwgroep' ),
					'description' => __( 'Questions marked \'Show on homepage\' on the FAQ page are shown.', 'll-bouwgroep' ),
				),
			),
		),
		'llb_home_cta'               => array(
			'title'       => __( 'Final call to action', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $home,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_cta_image',
					'type'  => 'image',
					'label' => __( 'Background image', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_cta_heading',
					'type'  => 'text',
					'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_cta_text',
					'type'  => 'textarea',
					'label' => __( 'Text', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_cta_btn_text',
					'type'  => 'text',
					'label' => __( 'Button text', 'll-bouwgroep' ),
				),
			),
		),
		'llb_about_sections'         => array(
			'title'       => __( 'Sections', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $about,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'    => '_llb_sections',
					'type'   => 'repeater',
					'label'  => __( 'Sections', 'll-bouwgroep' ),
					'fields' => array(
						array(
							'key'   => 'heading',
							'type'  => 'text',
							'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
						),
						array(
							'key'   => 'text',
							'type'  => 'textarea',
							'label' => __( 'Text', 'll-bouwgroep' ),
						),
						array(
							'key'   => 'image',
							'type'  => 'image',
							'label' => __( 'Image', 'll-bouwgroep' ),
						),
					),
				),
			),
		),
		'llb_about_steps'            => array(
			'title'       => __( 'Steps', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $about,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'    => '_llb_steps',
					'type'   => 'repeater',
					'label'  => __( 'Steps', 'll-bouwgroep' ),
					'fields' => array(
						array(
							'key'   => 'title',
							'type'  => 'text',
							'label' => __( 'Title (H3)', 'll-bouwgroep' ),
						),
						array(
							'key'   => 'text',
							'type'  => 'textarea',
							'label' => __( 'Text', 'll-bouwgroep' ),
						),
						array(
							'key'   => 'image',
							'type'  => 'image',
							'label' => __( 'Image', 'll-bouwgroep' ),
						),
					),
				),
			),
		),
		'llb_about_cta'              => array(
			'title'       => __( 'Call to action', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $about,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_cta_image',
					'type'  => 'image',
					'label' => __( 'Background image', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_cta_heading',
					'type'  => 'text',
					'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_cta_text',
					'type'  => 'textarea',
					'label' => __( 'Text', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_cta_btn_text',
					'type'  => 'text',
					'label' => __( 'Button text', 'll-bouwgroep' ),
				),
			),
		),
		'llb_projects_intro'         => array(
			'title'       => __( 'Introduction', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $projects,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_intro_heading',
					'type'  => 'text',
					'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_intro_text',
					'type'  => 'textarea',
					'label' => __( 'Text', 'll-bouwgroep' ),
				),
			),
		),
		'llb_projects_labels'        => array(
			'title'       => __( 'Labels', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $projects,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_filter_all_label',
					'type'  => 'text',
					'label' => __( 'Filter “all” label', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_card_btn_text',
					'type'  => 'text',
					'label' => __( 'Project card button text', 'll-bouwgroep' ),
				),
			),
		),
		'llb_projects_single'        => array(
			'title'       => __( 'Single project texts', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $projects,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_single_intro',
					'type'  => 'textarea',
					'label' => __( 'Intro', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_single_about_heading',
					'type'  => 'text',
					'label' => __( 'About heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_single_work_heading',
					'type'  => 'text',
					'label' => __( 'Work heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_single_result_heading',
					'type'  => 'text',
					'label' => __( 'Result heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_single_cta_heading',
					'type'  => 'text',
					'label' => __( 'CTA heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_single_cta_text',
					'type'  => 'textarea',
					'label' => __( 'CTA text', 'll-bouwgroep' ),
				),
				array(
					'key'         => '_llb_single_cta_btn_text',
					'type'        => 'text',
					'label'       => __( 'CTA button text', 'll-bouwgroep' ),
					'description' => __( 'If empty: header button text', 'll-bouwgroep' ),
				),
			),
		),
		'llb_contact_details'        => array(
			'title'       => __( 'Contact details', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $contact,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_details_heading',
					'type'  => 'text',
					'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'         => '_llb_details_text',
					'type'        => 'textarea',
					'label'       => __( 'Text', 'll-bouwgroep' ),
					'description' => __( 'Phone, email and address come from the Customizer.', 'll-bouwgroep' ),
				),
			),
		),
		'llb_contact_form'           => array(
			'title'       => __( 'Form', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $contact,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_form_heading',
					'type'  => 'text',
					'label' => __( 'Heading (H2)', 'll-bouwgroep' ),
				),
				array(
					'key'         => '_llb_form_text',
					'type'        => 'textarea',
					'label'       => __( 'Text', 'll-bouwgroep' ),
					'description' => __( 'The form itself: Customizer → Contact form.', 'll-bouwgroep' ),
				),
			),
		),
		'llb_contact_hours_map'      => array(
			'title'       => __( 'Opening hours and map', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $contact,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_hours_heading',
					'type'  => 'text',
					'label' => __( 'Opening hours heading', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_map_btn_text',
					'type'  => 'text',
					'label' => __( 'Map button text', 'll-bouwgroep' ),
				),
			),
		),
		'llb_contact_faq_link'       => array(
			'title'       => __( 'FAQ link', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $contact,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_faq_link_text',
					'type'  => 'text',
					'label' => __( 'FAQ link text', 'll-bouwgroep' ),
				),
			),
		),
		'llb_faq_nav'                => array(
			'title'       => __( 'Category navigation', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $faq,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_fnav_label',
					'type'  => 'text',
					'label' => __( 'Category navigation label', 'll-bouwgroep' ),
				),
			),
		),
		'llb_faq_questions'          => array(
			'title'       => __( 'Questions', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $faq,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'         => '_llb_faq_items',
					'type'        => 'repeater',
					'label'       => __( 'Questions', 'll-bouwgroep' ),
					'description' => __( 'Questions without an answer are hidden on the website.', 'll-bouwgroep' ),
					'fields'      => array(
						array(
							'key'   => 'question',
							'type'  => 'text',
							'label' => __( 'Question', 'll-bouwgroep' ),
						),
						array(
							'key'   => 'answer',
							'type'  => 'textarea',
							'label' => __( 'Answer', 'll-bouwgroep' ),
						),
						array(
							'key'     => 'category',
							'type'    => 'select',
							'label'   => __( 'Category', 'll-bouwgroep' ),
							'options' => array(
								'algemeen' => 'Algemeen',
								'badkamer' => 'Badkamer & toilet',
								'kosten'   => 'Kosten & btw',
								'aanbouw'  => 'Aan- en uitbouw',
							),
						),
						array(
							'key'   => 'show_on_home',
							'type'  => 'checkbox',
							'label' => __( 'Show on homepage', 'll-bouwgroep' ),
						),
					),
				),
			),
		),
		'llb_faq_cta'                => array(
			'title'       => __( 'Call to action', 'll-bouwgroep' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'template'    => $faq,
			'description' => $page_notice,
			'fields'      => array(
				array(
					'key'   => '_llb_cta_image',
					'type'  => 'image',
					'label' => __( 'Background image', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_cta_heading',
					'type'  => 'text',
					'label' => __( 'Heading', 'll-bouwgroep' ),
				),
				array(
					'key'   => '_llb_cta_btn_text',
					'type'  => 'text',
					'label' => __( 'Button text', 'll-bouwgroep' ),
				),
			),
		),
	);
}
