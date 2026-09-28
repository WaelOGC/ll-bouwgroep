<?php
/**
 * Default Dutch website content (from docs/10-page-content.md).
 *
 * @package LL_Bouwgroep
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Joins paragraphs with a blank line.
 *
 * @param string ...$paragraphs Paragraphs.
 * @return string
 */
function llb_join_paragraphs( ...$paragraphs ) {
	$parts = array();
	foreach ( $paragraphs as $paragraph ) {
		$paragraph = trim( (string) $paragraph );
		if ( '' !== $paragraph ) {
			$parts[] = $paragraph;
		}
	}
	return implode( "\n\n", $parts );
}

/**
 * Returns all default content for import (Dutch, exact from 10-page-content.md).
 *
 * @return array<string, mixed>
 */
function llb_default_content() {
	return array(
		'pages'    => llb_default_pages(),
		'services' => llb_default_services(),
		'faq'      => llb_default_faq_items(),
		'menus'    => llb_default_menus(),
	);
}

/**
 * Default pages.
 *
 * @return array<int, array<string, mixed>>
 */
function llb_default_pages() {
	return array(
		array(
			'title'    => 'Home',
			'slug'     => 'home',
			'template' => 'page-templates/template-home.php',
			'meta'     => array(
				'_llb_hero_title'        => "Van complete\nbadkamer tot\nvolledige verbouwing",
				'_llb_hero_intro'        => 'L&L Bouwgroep B.V. verzorgt bouw- en renovatiewerkzaamheden voor woningen en bedrijfspanden in Zoetermeer en omgeving. Van een complete badkamerrenovatie tot een volledige verbouwing: wij verzorgen het traject van begin tot eind.',
				'_llb_hero_btn1_text'    => 'Uw plannen bespreken',
				'_llb_hero_btn1_url'     => '',
				'_llb_hero_btn2_text'    => 'Bekijk onze diensten',
				'_llb_hero_btn2_url'     => '',
				'_llb_intro_heading'     => 'Bouwen en renoveren met één aanspreekpunt',
				'_llb_intro_text'        => llb_join_paragraphs(
					'Bij L&L Bouwgroep B.V. kunt u terecht voor uiteenlopende bouw- en renovatiewerkzaamheden. Onze specialiteit ligt onder andere bij het compleet renoveren en realiseren van badkamers en toiletten.',
					'Van leidingwerk, elektra en tegelwerk tot stucwerk, sanitair en de complete afwerking: wij verzorgen desgewenst het volledige traject. Zo heeft u één aanspreekpunt, één planning en duidelijkheid tijdens het hele project.',
					'Ook voor complete verbouwingen van woningen en bedrijfspanden kunt u bij ons terecht.'
				),
				'_llb_bath_heading'      => 'Een complete badkamer van sloop tot afwerking',
				'_llb_bath_text'         => llb_join_paragraphs(
					'Een nieuwe badkamer of toilet vraagt om verschillende werkzaamheden en vakgebieden. Daarom kunnen wij het volledige project voor u verzorgen.',
					'Van de eerste sloopwerkzaamheden en het leidingwerk tot elektra, stucwerk, tegelwerk, montage van sanitair en de uiteindelijke afwerking.'
				),
				'_llb_bath_subheading'   => "Eén aanspreekpunt.\nEén planning.\nEen compleet eindresultaat.",
				'_llb_bath_btn_text'     => 'Bekijk badkamers & toiletten',
				'_llb_bath_btn_url'      => '',
				'_llb_services_heading'  => 'Onze diensten',
				'_llb_services_intro'    => 'L&L Bouwgroep B.V. verzorgt verschillende werkzaamheden binnen bouw, renovatie en afbouw.',
				'_llb_why_heading'       => 'Ervaren vakmensen en duidelijke afspraken',
				'_llb_why_text'          => llb_join_paragraphs(
					'Bij L&L Bouwgroep werken ervaren vakmensen die ieder hun eigen jarenlange ervaring in de bouw meebrengen. Binnen ons team varieert die praktijkervaring van 10 tot 25 jaar.',
					'Die ervaring combineren we met een persoonlijke en professionele werkwijze. We denken met u mee, houden de lijnen kort en vinden het belangrijk dat afspraken worden nagekomen.'
				),
				'_llb_why_items'         => array(
					array(
						'icon'  => 'hard-hat',
						'title' => '10–25 jaar praktijkervaring',
						'text'  => 'Ervaren vakmensen met jarenlange ervaring binnen verschillende werkzaamheden in de bouw en renovatie.',
					),
					array(
						'icon'  => 'toolbox',
						'title' => 'Eén aanspreekpunt',
						'text'  => 'Wij kunnen verschillende werkzaamheden binnen één project verzorgen, zodat u niet meerdere partijen hoeft aan te sturen.',
					),
					array(
						'icon'  => 'ruler-square',
						'title' => 'Duidelijke afspraken',
						'text'  => 'Een persoonlijke werkwijze met korte communicatielijnen en aandacht voor duidelijke afspraken.',
					),
				),
				'_llb_projects_heading'  => 'Bekijk ons werk',
				'_llb_projects_text'     => llb_join_paragraphs(
					'Van badkamers en toiletten tot complete verbouwingen: ieder project vraagt om een praktische aanpak en een goede afwerking.',
					'Bekijk een selectie van onze gerealiseerde projecten en ontdek wat L&L Bouwgroep voor uw verbouwing kan betekenen.'
				),
				'_llb_projects_btn_text' => 'Bekijk onze projecten',
				'_llb_faq_heading'       => 'Veelgestelde vragen',
				'_llb_faq_btn_text'      => 'Bekijk alle vragen',
				'_llb_cta_heading'       => 'Heeft u verbouwingsplannen?',
				'_llb_cta_text'          => llb_join_paragraphs(
					'Wilt u uw badkamer of toilet volledig laten vernieuwen, of heeft u andere plannen voor uw woning of bedrijfspand?',
					'Neem contact op met L&L Bouwgroep B.V. voor een vrijblijvende kennismaking en bespreking van de mogelijkheden.'
				),
				'_llb_cta_btn_text'      => 'Neem contact met ons op',
			),
		),
		array(
			'title'    => 'Over ons',
			'slug'     => 'over-ons',
			'template' => 'page-templates/template-about.php',
			'meta'     => array(
				'_llb_hero_title'   => 'Over L&L Bouwgroep',
				'_llb_hero_intro'   => 'Vakmanschap, ervaring en een persoonlijke werkwijze vormen de basis van L&L Bouwgroep B.V.',
				'_llb_sections'     => array(
					array(
						'heading' => 'Bouwen met aandacht voor het volledige project',
						'text'    => llb_join_paragraphs(
							'Bij een verbouwing komen vaak verschillende werkzaamheden samen. L&L Bouwgroep B.V. kan meerdere onderdelen van een project verzorgen, van de eerste werkzaamheden tot de uiteindelijke afwerking.',
							'Vooral bij badkamers en toiletten is een goede samenwerking tussen verschillende vakgebieden belangrijk. Daarom bieden wij de mogelijkheid om het volledige traject bij één partij onder te brengen.'
						),
					),
					array(
						'heading' => 'Ervaren vakmensen',
						'text'    => llb_join_paragraphs(
							'Binnen L&L Bouwgroep werken vakmensen met ieder hun eigen ervaring en specialisme. De praktijkervaring binnen ons team varieert van 10 tot 25 jaar.',
							'Deze ervaring zetten wij in bij uiteenlopende bouw- en renovatiewerkzaamheden.'
						),
					),
					array(
						'heading' => 'Persoonlijk, professioneel en duidelijk',
						'text'    => llb_join_paragraphs(
							'Wij vinden het belangrijk om goed naar uw plannen te luisteren en mee te denken over de mogelijkheden.',
							'Tijdens een project houden we de communicatielijnen kort en streven we naar duidelijke afspraken. Zo weet u waar u aan toe bent en werken we gericht toe naar het gewenste eindresultaat.'
						),
					),
				),
				'_llb_steps'        => array(
					array(
						'title' => 'Uw plannen',
						'text'  => 'We bespreken uw wensen, plannen en de werkzaamheden die nodig zijn.',
					),
					array(
						'title' => 'De uitvoering',
						'text'  => 'De verschillende werkzaamheden worden volgens de gemaakte afspraken uitgevoerd.',
					),
					array(
						'title' => 'De afwerking',
						'text'  => 'We werken toe naar een compleet eindresultaat waarbij ook de laatste afwerking aandacht krijgt.',
					),
				),
				'_llb_cta_heading'  => 'Uw plannen bespreken?',
				'_llb_cta_text'     => 'Heeft u plannen voor een renovatie, verbouwing, badkamer, toilet of andere bouwkundige werkzaamheden?',
				'_llb_cta_btn_text' => 'Neem contact met ons op',
			),
		),
		array(
			'title'    => 'Diensten',
			'slug'     => 'diensten',
			'template' => 'page-templates/template-services.php',
			'meta'     => array(
				'_llb_hero_title' => 'Bouw- en renovatiewerkzaamheden',
				'_llb_hero_intro' => 'Van een complete badkamer tot een volledige verbouwing: L&L Bouwgroep B.V. verzorgt uiteenlopende werkzaamheden voor woningen en bedrijfspanden.',
			),
		),
		array(
			'title'    => 'Projecten',
			'slug'     => 'projecten',
			'template' => 'page-templates/template-projects.php',
			'meta'     => array(
				'_llb_hero_title'            => 'Onze projecten',
				'_llb_hero_intro'            => 'Bekijk een selectie van projecten van L&L Bouwgroep B.V. en ontdek hoe verschillende bouw- en renovatiewerkzaamheden samenkomen in een compleet eindresultaat.',
				'_llb_intro_heading'         => 'Van badkamer tot volledige verbouwing',
				'_llb_intro_text'            => 'Onze projecten omvatten onder andere badkamer- en toiletrenovaties, renovatiewerkzaamheden en diverse bouwkundige werkzaamheden.',
				'_llb_filter_all_label'      => 'Alle projecten',
				'_llb_card_btn_text'         => 'Bekijk project',
				'_llb_single_intro'          => 'Een project van L&L Bouwgroep B.V.',
				'_llb_single_about_heading'  => 'Over dit project',
				'_llb_single_work_heading'   => 'Uitgevoerde werkzaamheden',
				'_llb_single_result_heading' => 'Het resultaat',
				'_llb_single_cta_heading'    => 'Heeft u een vergelijkbaar project?',
				'_llb_single_cta_text'       => 'Bespreek uw plannen vrijblijvend met L&L Bouwgroep B.V.',
				'_llb_single_cta_btn_text'   => '',
			),
		),
		array(
			'title'    => 'Contact',
			'slug'     => 'contact',
			'template' => 'page-templates/template-contact.php',
			'meta'     => array(
				'_llb_hero_title'      => 'Uw plannen bespreken?',
				'_llb_hero_intro'      => llb_join_paragraphs(
					'Wilt u uw badkamer of toilet volledig laten vernieuwen, heeft u plannen voor een verbouwing of wilt u andere bouwkundige werkzaamheden bespreken?',
					'Neem contact op met L&L Bouwgroep B.V. voor een vrijblijvende kennismaking en bespreking van de mogelijkheden.'
				),
				'_llb_details_heading' => 'Neem contact met ons op',
				'_llb_details_text'    => 'Heeft u vragen of wilt u uw project bespreken? Vul het contactformulier in of neem rechtstreeks contact met ons op.',
				'_llb_form_heading'    => 'Vertel ons over uw plannen',
				'_llb_form_text'       => 'Beschrijf kort wat u wilt laten verbouwen of renoveren. Op basis daarvan kunnen we uw aanvraag bekijken en de mogelijkheden bespreken.',
				'_llb_hours_heading'   => 'Openingstijden',
				'_llb_map_btn_text'    => 'Route bekijken',
				'_llb_faq_link_text'   => 'Heeft u een vraag? Bekijk onze veelgestelde vragen.',
			),
		),
		array(
			'title'    => 'Veelgestelde vragen',
			'slug'     => 'veelgestelde-vragen',
			'template' => 'page-templates/page-faq.php',
			'meta'     => array(
				'_llb_hero_title'   => 'Veelgestelde vragen',
				'_llb_hero_intro'   => 'Heeft u een vraag over uw badkamer, toilet of verbouwing? Hieronder vindt u antwoorden op de vragen die wij het vaakst krijgen. Staat uw vraag er niet tussen? Neem gerust contact met ons op.',
				'_llb_fnav_label'   => 'Categorieën',
				'_llb_faq_items'    => llb_default_faq_items(),
				'_llb_cta_heading'  => 'Staat uw vraag er niet tussen?',
				'_llb_cta_btn_text' => 'Neem contact op',
			),
		),
		array(
			'title'    => 'Privacyverklaring',
			'slug'     => 'privacyverklaring',
			'template' => '',
			'content'  => llb_default_privacy_content(),
			'meta'     => array(),
		),
	);
}

/**
 * Default FAQ items (§ 16).
 *
 * @return array<int, array<string, string>>
 */
function llb_default_faq_items() {
	return array(
		array(
			'question'     => 'Is een offerte vrijblijvend?',
			'answer'       => 'Ja. Wij komen graag bij u langs voor een vrijblijvende kennismaking en maken daarna een offerte op maat.',
			'category'     => 'algemeen',
			'show_on_home' => '1',
		),
		array(
			'question'     => 'In welke regio werken jullie?',
			'answer'       => 'Wij werken in Zoetermeer en omgeving.',
			'category'     => 'algemeen',
			'show_on_home' => '1',
		),
		array(
			'question'     => 'Verzorgen jullie het complete project?',
			'answer'       => 'Ja. Van de eerste sloopwerkzaamheden tot de laatste afwerking verzorgen wij het volledige traject, met één aanspreekpunt en één planning.',
			'category'     => 'algemeen',
			'show_on_home' => '1',
		),
		array(
			'question'     => 'Nemen jullie het afval en puin mee?',
			'answer'       => '',
			'category'     => 'algemeen',
			'show_on_home' => '',
		),
		array(
			'question'     => 'Geven jullie garantie op het werk?',
			'answer'       => '',
			'category'     => 'algemeen',
			'show_on_home' => '',
		),
		array(
			'question'     => 'Wat kost een nieuwe badkamer?',
			'answer'       => 'De prijs hangt af van de grootte van de ruimte, het gekozen sanitair en tegelwerk, en of leidingen of elektra verlegd moeten worden. Na een bezoek ontvangt u een duidelijke offerte op maat.',
			'category'     => 'badkamer',
			'show_on_home' => '',
		),
		array(
			'question'     => 'Hoe lang duurt een badkamerrenovatie?',
			'answer'       => 'Een complete badkamerrenovatie duurt meestal twee tot drie weken, afhankelijk van de omvang van de werkzaamheden. Houd daarnaast rekening met de levertijd van sanitair en tegels.',
			'category'     => 'badkamer',
			'show_on_home' => '1',
		),
		array(
			'question'     => 'Kunnen jullie ook alleen een toilet renoveren?',
			'answer'       => 'Ja. Wij renoveren ook losse toiletten, van sloopwerk tot de complete afwerking.',
			'category'     => 'badkamer',
			'show_on_home' => '',
		),
		array(
			'question'     => 'Hoeveel btw betaal ik bij een verbouwing?',
			'answer'       => 'Voor de meeste werkzaamheden, zoals sanitair, elektra en tegelwerk, geldt 21% btw. Voor stucwerk, schilderwerk, behangen en isolatie aan woningen ouder dan twee jaar geldt 9% btw. In onze offerte ziet u dit duidelijk terug.',
			'category'     => 'kosten',
			'show_on_home' => '',
		),
		array(
			'question'     => 'Heb ik een vergunning nodig voor een aanbouw?',
			'answer'       => 'Dat hangt af van uw situatie. Een aanbouw aan de achterkant tot 4 meter diep is vaak vergunningsvrij. Aan de voorkant of bij een grotere aanbouw is meestal een omgevingsvergunning nodig. Controleer dit altijd via het Omgevingsloket. Wij denken graag met u mee.',
			'category'     => 'aanbouw',
			'show_on_home' => '',
		),
		array(
			'question'     => 'Werken jullie ook voor bedrijfspanden?',
			'answer'       => 'Ja. Wij voeren werkzaamheden uit voor zowel woningen als bedrijfspanden.',
			'category'     => 'aanbouw',
			'show_on_home' => '',
		),
	);
}

/**
 * Default services (§§ 1, 3, 4–12).
 *
 * @return array<int, array<string, mixed>>
 */
function llb_default_services() {
	return array(
		array(
			'title'    => 'Badkamers & toiletten',
			'slug'     => 'badkamers-toiletten',
			'menu_order' => 1,
			'excerpt'  => 'Complete renovatie en realisatie van badkamers en toiletten, van sloopwerk tot afwerking.',
			'meta'     => array(
				'_llb_hero_title'      => 'Badkamer of toilet laten renoveren?',
				'_llb_hero_intro'      => 'L&L Bouwgroep B.V. verzorgt complete badkamer- en toiletrenovaties: van de eerste sloopwerkzaamheden tot de laatste afwerking.',
				'_llb_overview_text'   => llb_join_paragraphs(
					'Een badkamer of toilet renoveren betekent vaak dat verschillende werkzaamheden samenkomen. L&L Bouwgroep kan het volledige traject verzorgen.',
					'Van sloopwerk, leidingwerk en elektra tot stucwerk, tegelwerk, sanitair en de uiteindelijke afwerking.'
				),
				'_llb_overview_button' => 'Meer over badkamers & toiletten',
				'_llb_sections'        => array(
					array(
						'heading' => 'Uw complete badkamer onder één dak',
						'text'    => llb_join_paragraphs(
							'Een badkamerverbouwing bestaat uit verschillende werkzaamheden. Denk aan sloopwerk, leidingwerk, elektra, stucwerk, tegelwerk, sanitair en afwerking.',
							'Door verschillende werkzaamheden binnen één project te combineren, heeft u één aanspreekpunt en één planning.'
						),
						'list'    => '',
					),
					array(
						'heading' => 'Werkzaamheden voor uw badkamer of toilet',
						'text'    => '',
						'list'    => "Sloopwerkzaamheden\nLeidingwerk\nElektra\nStucwerk\nTegelwerk\nMontage van sanitair\nAfwerking",
					),
				),
				'_llb_steps_heading'   => 'Van eerste werkzaamheden tot compleet eindresultaat',
				'_llb_steps'           => array(
					array(
						'title' => '1. Bespreken van uw plannen',
						'text'  => 'We bespreken uw wensen en de werkzaamheden die nodig zijn.',
					),
					array(
						'title' => '2. Uitvoering',
						'text'  => 'De werkzaamheden worden volgens de gemaakte afspraken uitgevoerd.',
					),
					array(
						'title' => '3. Afwerking',
						'text'  => 'De verschillende onderdelen worden samengebracht tot een compleet eindresultaat.',
					),
				),
				'_llb_cta_heading'     => 'Uw badkamer of toilet vernieuwen?',
				'_llb_cta_text'        => 'Bespreek uw plannen vrijblijvend met L&L Bouwgroep B.V.',
				'_llb_cta_button'      => 'Vraag een kennismaking aan',
			),
		),
		array(
			'title'      => 'Renovatie en verbouwing',
			'slug'       => 'renovatie-verbouwing',
			'menu_order' => 2,
			'excerpt'    => 'Voor uiteenlopende renovatie- en verbouwingswerkzaamheden aan woningen en bedrijfspanden.',
			'meta'       => array(
				'_llb_hero_title'      => 'Renovatie en verbouwing',
				'_llb_hero_intro'      => 'Voor renovatie- en verbouwingswerkzaamheden aan woningen en bedrijfspanden kunt u terecht bij L&L Bouwgroep B.V.',
				'_llb_overview_text'   => llb_join_paragraphs(
					'Heeft u plannen om een woning of bedrijfspand te renoveren of te verbouwen? Wij verzorgen uiteenlopende werkzaamheden binnen renovatie en verbouwing.',
					'Samen bespreken we de werkzaamheden en mogelijkheden voor uw project.'
				),
				'_llb_overview_button' => 'Meer over renovatie en verbouwing',
				'_llb_sections'        => array(
					array(
						'heading' => 'Een praktische aanpak voor uw verbouwing',
						'text'    => 'Iedere verbouwing heeft zijn eigen werkzaamheden en aandachtspunten. Wij denken met u mee over de uitvoering en kunnen verschillende werkzaamheden binnen één project verzorgen.',
						'list'    => '',
					),
					array(
						'heading' => 'Verschillende werkzaamheden combineren',
						'text'    => 'Van timmerwerk en stucwerk tot tegelwerk, schilderwerk en andere bouwkundige werkzaamheden: afhankelijk van uw project kunnen verschillende onderdelen worden gecombineerd.',
						'list'    => '',
					),
				),
				'_llb_steps_heading'   => '',
				'_llb_steps'           => array(),
				'_llb_cta_heading'     => 'Uw verbouwingsplannen bespreken?',
				'_llb_cta_text'        => 'Neem contact met ons op voor een vrijblijvende kennismaking.',
				'_llb_cta_button'      => '',
			),
		),
		array(
			'title'      => 'Stucwerk',
			'slug'       => 'stucwerk',
			'menu_order' => 3,
			'excerpt'    => 'Strakke afwerking van wanden en plafonds als onderdeel van uw renovatie of verbouwing.',
			'meta'       => array(
				'_llb_hero_title'      => 'Stucwerk',
				'_llb_hero_intro'      => 'Strak stucwerk vormt een belangrijke basis voor de verdere afwerking van een ruimte.',
				'_llb_overview_text'   => llb_join_paragraphs(
					'Goed uitgevoerd stucwerk vormt een belangrijke basis voor de verdere afwerking van een ruimte.',
					'L&L Bouwgroep verzorgt stucwerk als onderdeel van verschillende renovatie- en verbouwingsprojecten.'
				),
				'_llb_overview_button' => 'Meer over stucwerk',
				'_llb_sections'        => array(
					array(
						'heading' => 'Stucwerk als onderdeel van uw verbouwing',
						'text'    => 'Bij renovatie- en verbouwingsprojecten komt stucwerk vaak samen met andere werkzaamheden. L&L Bouwgroep kan het stucwerk daarom onderdeel maken van het totale project.',
						'list'    => '',
					),
					array(
						'heading' => 'Van renovatie tot afwerking',
						'text'    => 'Heeft u stucwerk nodig voor een badkamer, woning, bedrijfspand of ander renovatieproject? Bespreek uw plannen met ons.',
						'list'    => '',
					),
				),
				'_llb_steps_heading'   => '',
				'_llb_steps'           => array(),
				'_llb_cta_heading'     => 'Stucwerk nodig?',
				'_llb_cta_text'        => 'Neem contact op en bespreek de mogelijkheden.',
				'_llb_cta_button'      => '',
			),
		),
		array(
			'title'      => 'Tegelwerk',
			'slug'       => 'tegelwerk',
			'menu_order' => 4,
			'excerpt'    => 'Tegelwerk voor onder andere badkamers, toiletten, keukens en andere ruimtes.',
			'meta'       => array(
				'_llb_hero_title'      => 'Tegelwerk',
				'_llb_hero_intro'      => 'Professioneel tegelwerk voor badkamers, toiletten, keukens en andere ruimtes binnen uw renovatie of verbouwing.',
				'_llb_overview_text'   => llb_join_paragraphs(
					'Tegelwerk speelt een belangrijke rol bij onder andere badkamers, toiletten en keukens.',
					'Wij verzorgen tegelwerk als onderdeel van een groter renovatieproject of verbouwing.'
				),
				'_llb_overview_button' => 'Meer over tegelwerk',
				'_llb_sections'        => array(
					array(
						'heading' => 'Tegelwerk als onderdeel van het totaalproject',
						'text'    => 'Tegelwerk is vaak één van meerdere werkzaamheden binnen een renovatie. Daarom kunnen wij het tegelwerk combineren met onder andere sloopwerk, stucwerk, leidingwerk en sanitair.',
						'list'    => '',
					),
					array(
						'heading' => 'Een complete afwerking',
						'text'    => 'Van badkamer en toilet tot keuken of andere ruimte: wij verzorgen tegelwerk als onderdeel van uiteenlopende projecten.',
						'list'    => '',
					),
				),
				'_llb_steps_heading'   => '',
				'_llb_steps'           => array(),
				'_llb_cta_heading'     => 'Uw tegelwerk bespreken?',
				'_llb_cta_text'        => 'Neem contact op met L&L Bouwgroep.',
				'_llb_cta_button'      => '',
			),
		),
		array(
			'title'      => 'Timmerwerk',
			'slug'       => 'timmerwerk',
			'menu_order' => 5,
			'excerpt'    => 'Diverse timmerwerkzaamheden binnen renovatie, verbouwing en afbouw.',
			'meta'       => array(
				'_llb_hero_title'      => 'Timmerwerk',
				'_llb_hero_intro'      => 'Timmerwerk voor uiteenlopende renovatie-, verbouwings- en bouwkundige werkzaamheden.',
				'_llb_overview_text'   => llb_join_paragraphs(
					'Voor diverse bouwkundige en renovatiewerkzaamheden is vakkundig timmerwerk nodig.',
					'L&L Bouwgroep verzorgt timmerwerk binnen uiteenlopende verbouwings- en renovatieprojecten.'
				),
				'_llb_overview_button' => 'Meer over timmerwerk',
				'_llb_sections'        => array(
					array(
						'heading' => 'Timmerwerk binnen uw project',
						'text'    => 'Bij een verbouwing kunnen verschillende timmerwerkzaamheden nodig zijn. L&L Bouwgroep verzorgt timmerwerk als onderdeel van het totale project.',
						'list'    => '',
					),
					array(
						'heading' => 'Combinatie met andere werkzaamheden',
						'text'    => 'Timmerwerk kan worden gecombineerd met andere werkzaamheden zoals stucwerk, tegelwerk, schilderwerk en overige bouwkundige werkzaamheden.',
						'list'    => '',
					),
				),
				'_llb_steps_heading'   => '',
				'_llb_steps'           => array(),
				'_llb_cta_heading'     => 'Timmerwerk nodig?',
				'_llb_cta_text'        => 'Bespreek uw project met L&L Bouwgroep.',
				'_llb_cta_button'      => '',
			),
		),
		array(
			'title'      => 'Schilder- en afbouwwerk',
			'slug'       => 'schilder-afbouwwerk',
			'menu_order' => 6,
			'excerpt'    => 'Voor een verzorgde en complete afwerking van uw project.',
			'meta'       => array(
				'_llb_hero_title'      => 'Schilder- en afbouwwerk',
				'_llb_hero_intro'      => 'De afwerking maakt uw verbouwing compleet. L&L Bouwgroep verzorgt schilder- en afbouwwerk als onderdeel van uiteenlopende projecten.',
				'_llb_overview_text'   => llb_join_paragraphs(
					'De laatste werkzaamheden bepalen voor een belangrijk deel de uitstraling van een ruimte.',
					'Daarom verzorgen wij ook schilder- en afbouwwerkzaamheden als onderdeel van het totale project.'
				),
				'_llb_overview_button' => 'Meer over schilder- en afbouwwerk',
				'_llb_sections'        => array(
					array(
						'heading' => 'Aandacht voor de laatste fase',
						'text'    => 'Na de bouwkundige werkzaamheden volgt de afwerking. Schilder- en afbouwwerk zorgt ervoor dat de verschillende onderdelen van een project samenkomen.',
						'list'    => '',
					),
					array(
						'heading' => 'Een compleet project',
						'text'    => 'Waar mogelijk kunnen de afbouwwerkzaamheden worden gecombineerd met andere werkzaamheden binnen uw renovatie of verbouwing.',
						'list'    => '',
					),
				),
				'_llb_steps_heading'   => '',
				'_llb_steps'           => array(),
				'_llb_cta_heading'     => 'Uw project compleet laten afwerken?',
				'_llb_cta_text'        => 'Neem contact met ons op.',
				'_llb_cta_button'      => '',
			),
		),
		array(
			'title'      => 'Keukenverbouwingen',
			'slug'       => 'keukenverbouwingen',
			'menu_order' => 7,
			'excerpt'    => 'Werkzaamheden rondom het verbouwen en vernieuwen van keukens.',
			'meta'       => array(
				'_llb_hero_title'      => 'Keukenverbouwingen',
				'_llb_hero_intro'      => 'Een keukenverbouwing vraagt vaak om meer dan alleen het plaatsen van een keuken. L&L Bouwgroep verzorgt verschillende werkzaamheden rondom keukenverbouwingen.',
				'_llb_overview_text'   => llb_join_paragraphs(
					'Een keukenverbouwing kan verschillende bouwkundige werkzaamheden met zich meebrengen.',
					'L&L Bouwgroep kan werkzaamheden rondom uw keukenverbouwing verzorgen en deze waar nodig combineren met andere renovatie- en afbouwwerkzaamheden.'
				),
				'_llb_overview_button' => 'Meer over keukenverbouwingen',
				'_llb_sections'        => array(
					array(
						'heading' => 'Werkzaamheden rondom uw keuken',
						'text'    => 'Afhankelijk van uw plannen kunnen verschillende bouwkundige en afbouwwerkzaamheden onderdeel zijn van de verbouwing.',
						'list'    => '',
					),
					array(
						'heading' => 'Van voorbereiding tot afwerking',
						'text'    => 'Door werkzaamheden te combineren, kunnen verschillende onderdelen van uw keukenverbouwing binnen één project worden uitgevoerd.',
						'list'    => '',
					),
				),
				'_llb_steps_heading'   => '',
				'_llb_steps'           => array(),
				'_llb_cta_heading'     => 'Plannen voor een keukenverbouwing?',
				'_llb_cta_text'        => 'Bespreek uw wensen met L&L Bouwgroep.',
				'_llb_cta_button'      => '',
			),
		),
		array(
			'title'      => 'Aan- en uitbouw',
			'slug'       => 'aan-uitbouw',
			'menu_order' => 8,
			'excerpt'    => 'Bouwkundige werkzaamheden voor het realiseren van een aan- of uitbouw.',
			'meta'       => array(
				'_llb_hero_title'      => 'Aan- en uitbouw',
				'_llb_hero_intro'      => 'Wilt u uw woning uitbreiden? L&L Bouwgroep verzorgt diverse bouwkundige werkzaamheden rondom aan- en uitbouw.',
				'_llb_overview_text'   => 'Wilt u uw woning uitbreiden met een aan- of uitbouw? L&L Bouwgroep verzorgt diverse bouwkundige werkzaamheden rondom aan- en uitbouw.',
				'_llb_overview_button' => 'Meer over aan- en uitbouw',
				'_llb_sections'        => array(
					array(
						'heading' => 'Meer ruimte voor uw woning',
						'text'    => 'Een aan- of uitbouw kan verschillende bouwkundige werkzaamheden met zich meebrengen. Wij bespreken graag wat er binnen uw project nodig is.',
						'list'    => '',
					),
					array(
						'heading' => 'Bouwkundige werkzaamheden',
						'text'    => 'Van timmerwerk tot afwerking: afhankelijk van uw plannen kunnen verschillende werkzaamheden worden gecombineerd.',
						'list'    => '',
					),
				),
				'_llb_steps_heading'   => '',
				'_llb_steps'           => array(),
				'_llb_cta_heading'     => 'Uw plannen voor een aan- of uitbouw bespreken?',
				'_llb_cta_text'        => 'Neem contact op met L&L Bouwgroep.',
				'_llb_cta_button'      => '',
			),
		),
		array(
			'title'      => 'Overige bouwkundige werkzaamheden',
			'slug'       => 'overige-bouwkundige-werkzaamheden',
			'menu_order' => 9,
			'excerpt'    => 'Ook voor andere bouwkundige werkzaamheden kunt u contact met ons opnemen.',
			'meta'       => array(
				'_llb_hero_title'      => 'Overige bouwkundige werkzaamheden',
				'_llb_hero_intro'      => 'Heeft u bouwkundige werkzaamheden die niet direct binnen één van onze diensten vallen? Neem contact met ons op.',
				'_llb_overview_text'   => llb_join_paragraphs(
					'Niet iedere verbouwing past binnen één standaard categorie.',
					'Heeft u andere bouwkundige werkzaamheden of een combinatie van verschillende werkzaamheden? Neem contact met ons op om uw plannen te bespreken.'
				),
				'_llb_overview_button' => 'Bespreek uw project',
				'_llb_sections'        => array(
					array(
						'heading' => 'Uw project, uw situatie',
						'text'    => 'Geen verbouwing is hetzelfde. Soms bestaat een project uit meerdere verschillende werkzaamheden. We bespreken graag wat uw plannen zijn en welke werkzaamheden nodig zijn.',
						'list'    => '',
					),
				),
				'_llb_steps_heading'   => '',
				'_llb_steps'           => array(),
				'_llb_cta_heading'     => 'Bespreek uw project',
				'_llb_cta_text'        => 'Neem vrijblijvend contact met ons op.',
				'_llb_cta_button'      => '',
			),
		),
	);
}

/**
 * Default menus.
 *
 * @return array<string, array<string, mixed>>
 */
function llb_default_menus() {
	return array(
		'primary' => array(
			'name'  => 'Primary menu',
			'items' => array( 'home', 'over-ons', 'diensten', 'projecten', 'contact' ),
		),
		'footer'  => array(
			'name'  => 'Footer menu',
			'items' => array( 'home', 'over-ons', 'diensten', 'projecten', 'contact', 'veelgestelde-vragen', 'privacyverklaring' ),
		),
	);
}

/**
 * Privacy page body as block markup (§ 17).
 *
 * @return string
 */
function llb_default_privacy_content() {
	$blocks = array();

	$blocks[] = "<!-- wp:paragraph -->\n<p>L&L Bouwgroep B.V. respecteert uw privacy. Op deze pagina leggen wij uit welke persoonsgegevens wij verwerken wanneer u gebruikmaakt van onze website en contact met ons opneemt.</p>\n<!-- /wp:paragraph -->";

	$blocks[] = "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Welke gegevens verwerken wij?</h2>\n<!-- /wp:heading -->";
	$blocks[] = "<!-- wp:paragraph -->\n<p>Wanneer u contact met ons opneemt, kunnen wij persoonsgegevens verwerken die u zelf aan ons verstrekt, zoals uw naam, e-mailadres, telefoonnummer en de informatie die u in uw bericht vermeldt.</p>\n<!-- /wp:paragraph -->";

	$blocks[] = "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Waarvoor gebruiken wij deze gegevens?</h2>\n<!-- /wp:heading -->";
	$blocks[] = "<!-- wp:paragraph -->\n<p>Wij gebruiken de ontvangen gegevens om:</p>\n<!-- /wp:paragraph -->";
	$blocks[] = "<!-- wp:list -->\n<ul class=\"wp-block-list\"><!-- wp:list-item -->\n<li>uw aanvraag te beantwoorden;</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li>contact met u op te nemen over uw project;</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li>uw vragen te behandelen;</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li>uw aanvraag of kennismaking verder te bespreken.</li>\n<!-- /wp:list-item --></ul>\n<!-- /wp:list -->";

	$blocks[] = "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Bewaartermijn</h2>\n<!-- /wp:heading -->";
	$blocks[] = "<!-- wp:paragraph -->\n<p>Wij bewaren persoonsgegevens niet langer dan noodzakelijk is voor het doel waarvoor deze zijn verzameld, tenzij een wettelijke bewaartermijn van toepassing is.</p>\n<!-- /wp:paragraph -->";

	$blocks[] = "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Delen van gegevens</h2>\n<!-- /wp:heading -->";
	$blocks[] = "<!-- wp:paragraph -->\n<p>Wij delen uw persoonsgegevens niet zomaar met derden. Wanneer het noodzakelijk is om gebruik te maken van een dienstverlener voor de werking van onze website of communicatie, gebeurt dit binnen de geldende privacyregels.</p>\n<!-- /wp:paragraph -->";

	$blocks[] = "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Uw rechten</h2>\n<!-- /wp:heading -->";
	$blocks[] = "<!-- wp:paragraph -->\n<p>U heeft onder de AVG onder andere het recht om uw persoonsgegevens in te zien, te laten corrigeren of onder bepaalde omstandigheden te laten verwijderen.</p>\n<!-- /wp:paragraph -->";
	$blocks[] = "<!-- wp:paragraph -->\n<p>Wilt u gebruikmaken van uw rechten of heeft u een vraag over uw persoonsgegevens? Neem dan contact met ons op.</p>\n<!-- /wp:paragraph -->";

	$blocks[] = "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Contact</h2>\n<!-- /wp:heading -->";
	$blocks[] = "<!-- wp:shortcode -->\n[llb_company_details]\n<!-- /wp:shortcode -->";

	return implode( "\n\n", $blocks );
}
