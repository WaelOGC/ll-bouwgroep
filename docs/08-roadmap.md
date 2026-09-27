# Roadmap

## Phase 1 — Docs **(done)**

Project documentation in `docs/` (this set of files). No theme code yet.

## Phase 2 — Theme foundation **(done)**

Scaffold the classic theme under `app/public/wp-content/themes/ll-bouwgroep/` (`style.css`, `functions.php`, `inc/`, assets, languages).

## Phase 3 — Customizer + meta boxes + CPTs + plugin compatibility **(next)**

- Customizer: logo, colors, fonts, contact info, opening hours, map image, “Route bekijken” URL, social, header CTA, footer text, CF7 shortcode
- Meta boxes for page heroes and section fields
- FAQ repeatable meta box (question, answer, category, “Toon op homepage”)
- Register CPTs `dienst` and `project`
- Taxonomy `project_categorie`; project meta “Uitgelicht project” + gallery
- Plugin compatibility layer in `inc/compat/` (`seo.php`, `elementor.php`, `cf7.php`)

## Phase 4 — Templates and design

- Page templates and template parts per [03-sitemap.md](03-sitemap.md)
- Full-width page template for Elementor
- FAQ page template (`page-faq.php`) + homepage mini FAQ
- Project archive filter + featured project image slider
- Contact opening hours + static map / “Route bekijken”
- Brand styling per [01-brand-guide.md](01-brand-guide.md) and [11-design-reference.md](11-design-reference.md)
- Mobile-first CSS and vanilla JS

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
