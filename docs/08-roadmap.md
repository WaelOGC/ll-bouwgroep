# Roadmap

## Phase 1 — Docs (current)

Project documentation in `docs/` (this set of files). No theme code yet.

## Phase 2 — Theme foundation

Scaffold the classic theme under `app/public/wp-content/themes/ll-bouwgroep/` (`style.css`, `functions.php`, `inc/`, assets, languages).

## Phase 3 — Customizer + meta boxes + CPTs + plugin compatibility

- Customizer: logo, colors, fonts, contact info, social, header CTA, footer text, CF7 shortcode
- Meta boxes for page heroes and section fields
- Register CPTs `dienst` and `project`
- Plugin compatibility layer in `inc/compat/` (`seo.php`, `elementor.php`, `cf7.php`)

## Phase 4 — Templates and design

- Page templates and template parts per [03-sitemap.md](03-sitemap.md)
- Full-width page template for Elementor
- Brand styling per [01-brand-guide.md](01-brand-guide.md)
- Mobile-first CSS and vanilla JS

## Phase 5 — CF7 integration + privacy

- Contact Form 7 shortcode output, brand styles, conditional assets, `[acceptance]` consent
- Privacyverklaring page and legal footer
- Disable Elementor Google Fonts (AVG)

## Phase 6 — SEO / performance, testing, launch

- Title tag, semantics, Yoast / Rank Math cooperation via `llb_breadcrumbs()`
- Image/performance checks
- Testing on Local, then production launch

## Later

- Multilingual support
- Extra pages as the client grows (~6 months horizon)
