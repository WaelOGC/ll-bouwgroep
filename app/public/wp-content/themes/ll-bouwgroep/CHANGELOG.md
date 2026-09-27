# Changelog

All notable changes to the L&L Bouwgroep theme are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project uses [Semantic Versioning](https://semver.org/).

## [0.8.2] — 2026-09-27

### Changed
- Wider hero text panel

### Fixed
- Services carousel stays inside the content width and shows exactly 4 / 2 / 1 cards

## [0.8.1] — 2026-09-27

### Fixed
- Home layout now follows the reference design (order, hero, USP strip, services carousel, projects grid, CTA, footer columns)

### Added
- Animated backgrounds, hover effects, scroll reveal, services dropdown, footer logo setting, CTA image field

## [0.8.0] — 2026-09-27

### Added
- Home page template and sections, query helpers, `llb-card` image size, new icons

### Fixed
- Duplicate menu IDs (mobile panel)

## [0.7.0] — 2026-09-27

### Added
- Design system, header (sticky, mobile menu), footer, default page, 404, template parts, helpers

## [0.6.0] — 2026-09-27

### Added
- SEO compat (breadcrumbs helper, FAQPage schema)
- Elementor compat (theme locations, Google Fonts off)
- CF7 compat (conditional assets, `llb_contact_form()`)

## [0.5.1] — 2026-09-27

### Fixed
- Privacy page showed placeholder text; added `[llb_company_details]` shortcode

## [0.5.0] — 2026-09-27

### Added
- Page templates (stubs): Home, About, Services overview, Projects overview, Contact, FAQ, Full width
- Page fields per template + FAQ repeater
- Default Dutch content + Appearance → Import default content

### Fixed
- Hidden image Remove button (WordPress `.button` vs `[hidden]`)

## [0.4.0] — 2026-09-27

### Added
- Meta box engine (config-driven field types, save/sanitize, admin UI)
- Service fields (hero, overview, sections, steps, CTA)
- Project fields (details, gallery, featured flag) + Featured admin column

### Fixed
- Brand color comparison is case-insensitive

## [0.3.0] — 2026-09-27

### Added
- Customizer (company & contact, opening hours, map, social, header CTA, footer, CF7 shortcode, brand colors)
- Option helpers (`llb_get_option`, address, map URL, header CTA URL, opening hours, copyright)

## [0.2.0] — 2026-09-27

### Added
- Custom post types `dienst` and `project`, plus taxonomy `project_categorie` (Phase 3a)
- Theme versioning from `style.css` via `LLB_VERSION` / `CHANGELOG.md`

### Changed
- Admin labels (CPT, taxonomy, menu locations) switched to English

## [0.1.0] — 2026-09-27

### Added
- Theme foundation (Phase 2): setup, enqueue, helpers, header/footer/index, self-hosted fonts, base CSS
