# Theme architecture

## Location and naming

| Item | Value |
|------|--------|
| Theme folder | `app/public/wp-content/themes/ll-bouwgroep/` |
| Text domain | `ll-bouwgroep` |
| Function / prefix | `llb_` |

Classic PHP theme (no block theme). Elementor may be used optionally per page; see [09-plugin-compatibility.md](09-plugin-compatibility.md).

## Proposed structure

```
ll-bouwgroep/
├── style.css
├── functions.php
├── inc/
│   ├── setup.php
│   ├── enqueue.php
│   ├── customizer.php
│   ├── meta-boxes.php
│   ├── meta-boxes-pages.php
│   ├── content-defaults.php
│   ├── import.php
│   ├── post-types.php
│   ├── helpers.php
│   ├── queries.php
│   ├── shortcodes.php
│   └── compat/
│       ├── seo.php
│       ├── elementor.php
│       └── cf7.php
├── template-parts/
│   ├── page-hero.php
│   ├── section-heading.php
│   ├── cta-band.php
│   ├── usp-strip.php
│   └── home/
│       ├── hero.php
│       ├── usp.php
│       ├── bathrooms.php
│       ├── services.php
│       ├── projects.php
│       ├── why.php
│       ├── faq.php
│       └── cta.php
├── page-templates/
│   ├── template-home.php
│   ├── template-about.php
│   ├── template-services.php
│   ├── template-projects.php
│   ├── template-contact.php
│   ├── page-faq.php
│   └── template-full-width.php
├── single-dienst.php
├── assets/
│   ├── css/
│   ├── js/
│   ├── fonts/
│   └── images/
└── languages/
```

## Customizer (global settings)

Panel **L&L Bouwgroep** (`llb_theme_options`). All company data comes from the Customizer — never hard-coded outside `llb_customizer_defaults()`. Copyright year is generated automatically.

Fonts are fixed (self-hosted Barlow + Inter, AVG). Not editable in the Customizer. Site logo uses the native WordPress Custom Logo control.

| Section | Setting IDs | Notes |
|---------|-------------|--------|
| Company & contact | `llb_company_name`, `llb_phone`, `llb_email`, `llb_address_street`, `llb_address_postcode`, `llb_address_city`, `llb_kvk`, `llb_btw` | Empty fields hidden on the front end |
| Opening hours | `llb_hours_monday` … `llb_hours_sunday` | Grouped for display via `llb_get_opening_hours()` |
| Map | `llb_map_image`, `llb_map_url` | Static image + route URL (fallback from address) |
| Social media | `llb_social_facebook`, `llb_social_instagram`, `llb_social_linkedin` | Empty = not shown |
| Header | `llb_header_cta_text`, `llb_header_cta_url` | Empty URL → `/contact/` |
| Footer | `llb_footer_tagline`, `llb_footer_text`, `llb_footer_copyright` | © + year + company auto-prefixed |
| Contact form | `llb_cf7_shortcode` | Output in Phase 5 |
| Brand colors | `llb_color_red`, `llb_color_green` | Inline CSS only when changed from default |

Helpers: `llb_get_option()`, `llb_get_address()`, `llb_get_map_url()`, `llb_get_header_cta_url()`, `llb_get_opening_hours()`, `llb_get_copyright()`.

## Query helpers (`inc/queries.php`)

| Helper | Returns |
|--------|---------|
| `llb_get_services()` | Published `dienst` posts (`menu_order`, then title) |
| `llb_get_why_items()` | Home USP strip items (`_llb_why_items` from the front page) |
| `llb_get_home_projects( $limit )` | Featured projects first, then newest |
| `llb_get_faq_page_id()` | First published page using the FAQ template |
| `llb_get_home_faq_items()` | FAQ items with Show on homepage + answer |
| `llb_get_service_url( $slug )` | Service permalink or Services page fallback |

Home sections live in `template-parts/home/`. Shared parts: `page-hero.php` (angled panel), `usp-strip.php` (Home why items), `cta-band.php` (split CTA with optional image).

## Shortcodes

| Shortcode | Output |
|-----------|--------|
| `[llb_company_details]` | Company name, address, email and phone from the Customizer (`inc/shortcodes.php`). Used on the Privacyverklaring page. Empty values are skipped. |

## Page templates

| File | Template Name | Role |
|------|---------------|------|
| `page-templates/template-home.php` | Home | Front page sections |
| `page-templates/template-about.php` | About | Over ons (hero, USP strip, sections + steps, CTA) |
| `page-templates/template-services.php` | Services overview | Diensten page (hero, USP strip, services grid) |
| `single-dienst.php` | — | Single service (hero, sections, steps, CTA) |
| `page-templates/template-projects.php` | Projects overview | Projecten page + single project labels |
| `page-templates/template-contact.php` | Contact | Contact / Offerte |
| `page-templates/page-faq.php` | FAQ | Veelgestelde vragen |
| `page-templates/template-full-width.php` | Full width | Elementor layouts |

Full design for Home, Diensten, single service and Over ons in Phase 4c. Remaining stubs in Phase 4d.

Page meta boxes are registered per template (`template` / `templates` in `llb_meta_box_page_config()`). After changing a page template: save and reload to see matching fields.

### Page / FAQ fields

- Shared **Page hero** on all templates except Full width
- Home, About, Projects, Contact, FAQ: section boxes as listed in Phase 3c-2
- FAQ repeater `_llb_faq_items`: question, answer, category (`algemeen` / `badkamer` / `kosten` / `aanbouw`), Show on homepage
- Questions without an answer are hidden on the website

### Default content import

- Appearance → **Import default content** (`inc/import.php`)
- Defaults from `inc/content-defaults.php` (Dutch text from [10-page-content.md](10-page-content.md))
- Creates pages, 9 services, FAQ items, Primary/Footer menus; skips existing slugs; never overwrites
- Service slugs: `badkamers-toiletten`, `renovatie-verbouwing`, `stucwerk`, `tegelwerk`, `timmerwerk`, `schilder-afbouwwerk`, `keukenverbouwingen`, `aan-uitbouw`, `overige-bouwkundige-werkzaamheden`

## Meta boxes

Native WordPress meta box API (no ACF). Engine: `inc/meta-boxes.php` via `llb_meta_box_config()`.

- Meta keys prefixed `_llb_` (hidden from Custom Fields)
- Context `normal`, priority `high` (main column, below the editor). Featured project box uses `side`.
- In the block editor, meta boxes appear below the content.
- Field types: `text`, `textarea`, `lines`, `url`, `checkbox`, `select`, `image`, `gallery`, `repeater`
- Read helpers: `llb_get_meta( $post_id, $key )`, `llb_get_lines( $post_id, $key )`
- Admin assets: `assets/css/admin-meta.css`, `assets/js/admin-meta.js` (vanilla JS + `wp.media`)

Native fields (not duplicated as meta):

- **Featured image** — service hero / project main image
- **Excerpt** — service card short description
- **Order** (page attributes) — service order on overview pages

### Service (`dienst`)

| Box | Fields |
|-----|--------|
| Service hero | `_llb_hero_title`, `_llb_hero_intro` |
| Services overview page | `_llb_overview_text`, `_llb_overview_button` |
| Service sections | `_llb_sections` (repeater: heading, text, list) |
| Service steps | `_llb_steps_heading`, `_llb_steps` (repeater: title, text) |
| Service call to action | `_llb_cta_heading`, `_llb_cta_text`, `_llb_cta_button` |

### About page (`template-about.php`)

| Box | Fields |
|-----|--------|
| Page hero | Shared `_llb_hero_*` |
| Sections | `_llb_sections` (repeater: heading, text, image) |
| Steps | `_llb_steps` (repeater: title, text, image) |
| Call to action | `_llb_cta_image`, `_llb_cta_heading`, `_llb_cta_text`, `_llb_cta_btn_text` |

Repeater sub fields may include `image` (attachment ID, sanitized with `absint`; media picker works on rows added via “Add row”).

### Project (`project`)

| Box | Fields |
|-----|--------|
| Project details | `_llb_project_description`, `_llb_project_work`, `_llb_project_result` |
| Project gallery | `_llb_project_gallery` |
| Featured project (side) | `_llb_project_featured` |

Projects list table shows a **Featured** column (★ when checked).

### FAQ page (repeatable)

On the FAQ page (`page-faq.php`) — Phase 3c-2:

- Repeatable items: question, answer, category, checkbox **“Toon op homepage”**
- Homepage mini FAQ shows items with “Toon op homepage” checked (defaults: questions 1, 2, 3 and 7 from [10-page-content.md § 16](10-page-content.md#16-veelgestelde-vragen))

## Custom post types

Registered in the theme (`inc/post-types.php`):

### `dienst`

- Featured image
- Excerpt
- Custom fields as needed for service detail
- Rewrite slug `diensten`, `has_archive` false

### `project`

- Featured image
- Excerpt
- Custom fields: description (`[Projectbeschrijving]`), werkzaamheden (`[Werkzaamheden]`), resultaat (`[Beschrijving eindresultaat]`), gallery
- Checkbox **“Uitgelicht project”** (featured project)
- Image gallery for the featured project slider
- Taxonomy **`project_categorie`** (hierarchical) for the archive filter
- Rewrite slug `projecten`, `has_archive` false

Default website texts live in [10-page-content.md](10-page-content.md). Those values are the theme defaults and must stay editable from the WordPress dashboard.

## URL structure

- **Diensten** overview = a normal WordPress Page (slug `diensten`), editable in the dashboard
- **Projecten** overview = a normal WordPress Page (slug `projecten`), editable in the dashboard
- Single service: `/diensten/{slug}/` (CPT `dienst`, no archive)
- Single project: `/projecten/{slug}/` (CPT `project`, no archive)
- Project category: `/projectcategorie/{slug}/`
- **Pagination on the Projecten page:** do NOT use `/projecten/page/2/` (conflicts with single project URLs `/projecten/{slug}/`). Use `/projecten/?pagina=2`.
- **Project filter:** `/projecten/?categorie={slug}`.
- **Reason:** overview texts stay editable from the dashboard, and no URL conflict between Page and CPT archive
- Rewrite rules flush only on theme activation. After changes: **Settings → Permalinks → Save**.

## Contact form (Contact Form 7)

No custom theme contact form. Integration lives in `inc/compat/cf7.php`:

- Customizer setting for the CF7 form shortcode
- If CF7 is inactive or no shortcode is set → show contact details only (no errors)
- Brand styles for `.wpcf7`
- AVG consent via CF7 `[acceptance]` field
- Conditional CF7 asset loading (`wpcf7_load_js` / `wpcf7_load_css`)

Local email testing: **Mailpit** (Local by Flywheel).

Full rules: [09-plugin-compatibility.md](09-plugin-compatibility.md).

## Page templates

- Standard theme templates call `the_content()`
- **Full-width** page template (`page-templates/template-full-width.php`): no container restrictions for Elementor layouts
- **FAQ** page template (`page-templates/page-faq.php`): Veelgestelde vragen page

## Plugin compatibility layer

`inc/compat/` loads guarded integrations for SEO (Yoast / Rank Math), Elementor, and CF7. See [09-plugin-compatibility.md](09-plugin-compatibility.md).

## Internationalization

See the **Language rule** in [07-coding-standards.md](07-coding-standards.md): admin UI = English with `__()` / `esc_html__()`; visitor text = Dutch (from `10-page-content.md` and template strings).

## Front-end stack

- **Vanilla JS only** — no jQuery dependency (CF7 may enqueue its own scripts when a form is present)
- Mobile-first responsive CSS
