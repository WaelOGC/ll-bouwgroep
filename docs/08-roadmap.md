# Roadmap

## Phase 1 — Docs **(done)**

Project documentation in `docs/` (this set of files). No theme code yet.

## Phase 2 — Theme foundation **(done)**

Scaffold the classic theme under `app/public/wp-content/themes/ll-bouwgroep/` (`style.css`, `functions.php`, `inc/`, assets, languages).

## Phase 3 — Customizer + meta boxes + CPTs + plugin compatibility **(done)**

- Customizer: company & contact, opening hours, map, social, header CTA, footer, CF7 shortcode, brand colors **(done — Phase 3b)**
- **3c-1:** meta box engine + service and project fields **(done)**
- **3c-2:** page fields (Home, Over ons, Diensten, Projecten, Contact) + FAQ repeater + import of default Dutch content **(done)**
- Register CPTs `dienst` and `project` **(done — Phase 3a)**
- Taxonomy `project_categorie` **(done — Phase 3a)**; project meta “Uitgelicht project” + gallery **(done — Phase 3c-1)**
- **3d:** Plugin compatibility layer in `inc/compat/` (`seo.php`, `elementor.php`, `cf7.php`) **(done)**

## Phase 4 — Templates and design **(done)**

- **4a:** Design system, header, footer, default page, 404, template parts, helpers **(done)**
- **4b:** Home page template and sections **(done)**
- **4c:** Services overview + single service + About **(done)**
- **4d:** Projects overview + single project + Contact + FAQ **(done)**

## Phase 5 — CF7 integration + privacy

- Contact Form 7 shortcode output, brand styles, conditional assets, `[acceptance]` consent
- Privacyverklaring page and legal footer
- Disable Elementor Google Fonts (AVG)
- No Google Maps embed (static image + external link only)

## Phase 6 — SEO / performance, testing, launch

- Title tag, semantics, Yoast / Rank Math cooperation via `llb_breadcrumbs()`
- FAQPage JSON-LD + `llb_output_faq_schema` filter
- Image/performance checks; replace AI placeholder photos with client photos
- Testing on Local, then production launch

## Later

- Multilingual support
- Extra pages as the client grows (~6 months horizon)
