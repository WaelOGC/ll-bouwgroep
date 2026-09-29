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
│   ├── theme-options.php
│   ├── meta-boxes.php
│   ├── meta-boxes-pages.php
│   ├── content-defaults.php
│   ├── import.php
│   ├── post-types.php
│   ├── helpers.php
│   ├── queries.php
│   ├── shortcodes.php
│   ├── features/
│   │   ├── contact-buttons.php
│   │   ├── schema.php
│   │   ├── maintenance.php
│   │   ├── announcement.php
│   │   ├── tracking.php
│   │   ├── branding.php
│   │   └── back-to-top.php
│   └── compat/
│       ├── seo.php
│       ├── elementor.php
│       └── cf7.php
├── template-parts/
│   ├── page-hero.php
│   ├── section-heading.php
│   ├── cta-band.php
│   ├── usp-strip.php
│   ├── project-card.php
│   ├── gallery-slider.php
│   ├── faq-accordion.php
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
├── single-project.php
├── assets/
│   ├── css/
│   ├── js/
│   ├── fonts/
│   └── images/
└── languages/
```

## Theme Options

Top-level admin menu **Theme Options** (`inc/theme-options.php`), directly below Appearance. Capability: `manage_options`. English UI labels; every value the visitor reads is Dutch.

**One page with tabs** (approved admin UI: `docs/design/theme-options-v2.html`). Slug: `admin.php?page=llb-theme-options`. Active tab in the URL (`&tab=` / `#tab`). Old sub-page URLs (`llb-to-*`, `llb-import-content`, legacy Appearance URLs) redirect to the matching tab.

| Tab | `tab` value | Section key |
|-----|-------------|-------------|
| Overview | `overview` | — (mirrors toggles) |
| General | `general` | `general` |
| Contact buttons | `contact` | `contact` |
| Social media | `social` | `social` |
| SEO | `seo` | `seo` |
| Maintenance | `maint` | `maintenance` |
| Announcement | `ann` | `announcement` |
| Tracking | `track` | `tracking` |
| Branding | `brand` | `branding` |
| Import content | `import` | — (runs `llb_run_content_import`) |

### Storage and helpers

| Item | Value |
|------|--------|
| Option name | `llb_theme_options` (single array) |
| Settings group | `llb_theme_options_group` |
| Read value | `llb_theme_option( $key )` — toggles return `int`, everything else returns `string` |
| Read trimmed string | `llb_theme_option_text( $key )` |
| Read toggle as bool | `llb_theme_option_on( $key )` |
| Full array | `llb_get_theme_options()` — saved values merged over the defaults |
| Social links | `llb_get_social_links()` — non-empty profiles in display order |
| Key types | `llb_theme_options_types()` — `bool`, `text`, `textarea`, `url`, `date`, `tel`, `code`, `consent` |
| Section ownership | `llb_theme_options_sections()` — keys per tab (for sanitize) |

**One form, one save.** The page posts `llb_theme_options[_section]=all`. `llb_sanitize_theme_options()` writes every section’s keys in one go (checkboxes become `0` when unchecked). Per-section `_section` values still work for backward compatibility. Admin CSS/JS load only on this page (`assets/css/admin-theme-options.css`, `assets/js/admin-theme-options.js`).

### Option keys and defaults

| Key | Type | Default | Used by |
|-----|------|---------|---------|
| `animations` | bool | `1` | General |
| `projects` | bool | `1` | General |
| `back_to_top` | bool | `1` | General |
| `whatsapp_enabled` | bool | `0` | Contact buttons |
| `whatsapp_number` | tel | `''` | Contact buttons |
| `whatsapp_message` | text | `Hallo, ik heb een vraag.` | Contact buttons |
| `mobile_bar_enabled` | bool | `0` | Contact buttons |
| `mobile_bar_call_text` | text | `Bel ons` | Contact buttons |
| `mobile_bar_quote_text` | text | `Offerte aanvragen` | Contact buttons |
| `social_instagram` | url | `''` | Social media |
| `social_facebook` | url | `''` | Social media |
| `social_linkedin` | url | `''` | Social media |
| `social_youtube` | url | `''` | Social media |
| `social_google` | url | `''` | Social media |
| `social_show_footer` | bool | `1` | Social media |
| `social_show_contact` | bool | `1` | Social media |
| `social_show_menu` | bool | `0` | Social media |
| `schema_local_business` | bool | `1` | SEO |
| `breadcrumbs` | bool | `1` | SEO |
| `schema_area_served` | text | `Zoetermeer en omgeving` | SEO |
| `maintenance_enabled` | bool | `0` | Maintenance |
| `maintenance_heading` | text | `Onze website wordt vernieuwd` | Maintenance |
| `maintenance_text` | textarea | `Binnenkort vindt u hier de nieuwe website van L&L Bouwgroep B.V.` | Maintenance |
| `maintenance_preview_token` | text | `''` | Maintenance (generated, never edited by hand) |
| `announcement_enabled` | bool | `0` | Announcement |
| `announcement_text` | text | `''` | Announcement |
| `announcement_link` | url | `''` | Announcement |
| `announcement_link_text` | text | `''` | Announcement |
| `announcement_start` | date (`Y-m-d`) | `''` | Announcement |
| `announcement_end` | date (`Y-m-d`) | `''` | Announcement |
| `tracking_head` | code | `''` | Tracking |
| `tracking_body` | code | `''` | Tracking |
| `tracking_footer` | code | `''` | Tracking |
| `tracking_head_category` | consent | `statistics` | Tracking |
| `tracking_body_category` | consent | `statistics` | Tracking |
| `tracking_footer_category` | consent | `marketing` | Tracking |
| `admin_footer_text` | text | `L&L Bouwgroep B.V.` | Branding |

Consent categories follow the WP Consent API names: `functional`, `preferences`, `statistics`, `marketing`.

Social icons render via `template-parts/social-icons.php` (Instagram → Facebook → LinkedIn → YouTube → Google). Placement toggles gate footer, contact page and phone menu. Former Customizer social mods migrate once into these keys.
### What each toggle does

| Toggle | Effect |
|--------|--------|
| **Animations** | Off: no `body.llb-motion` class. All decorative motion (hero entrance, image reveal `.rv`, hover zoom/lift) is gated under that class. FAQ open/close and colour hover feedback stay. Images are visible immediately. Back to top scrolls instantly instead of smoothly. `prefers-reduced-motion` still applies when animations are on. |
| **Projects** | Off: hides Home “Bekijk ons werk”, related projects on service pages, and Projecten links in menus/templates. Projecten page, singles and category URLs return the theme 404 for visitors (admins still see them with a notice bar). Excluded from core / Yoast / Rank Math sitemaps and site search. CPT stays in the dashboard. |
| **Back to top button** | On: round button bottom-right that appears after 600px of scrolling. |
| **WhatsApp button** | On *and* a number filled in: round WhatsApp button bottom-right linking to `wa.me` in a new tab. Hidden when the number is empty. |
| **Mobile contact bar** | On: fixed bar under 768px with a `tel:` button and a quote button. Adds body padding (plus safe-area inset) and lifts the floating buttons above it. Hidden while the mobile menu is open. |
| **Local business structured data** | On: `GeneralContractor` JSON-LD in `wp_head` on every page, built from the Customizer company data. Empty values are skipped. |
| **Breadcrumbs** | On: trail above the H1 on every page except the homepage. Source: Yoast, else Rank Math, else the theme trail. The theme only adds `BreadcrumbList` JSON-LD when neither SEO plugin is active. |
| **Maintenance mode** | On: visitors get a branded holding page with HTTP 503, `Retry-After: 3600` and `noindex`. Administrators see the normal site plus a warning bar. wp-admin, wp-login, REST, cron and AJAX are never blocked. A preview link (`?preview=TOKEN`) sets a 7-day cookie for people who need to see the real site. |
| **Announcement bar** | On, text filled in and within the optional start/end dates: a thin dark bar above the header at `wp_body_open` priority 3, with an optional link and a close button. The dismissal is stored in `localStorage` under a hash of the message, so editing the text shows the bar again. |

### Feature modules (`inc/features/`)

Loaded from `functions.php` after `inc/theme-options.php`.

| File | Responsibility |
|------|----------------|
| `contact-buttons.php` | WhatsApp button, mobile contact bar, related body classes |
| `schema.php` | `GeneralContractor` JSON-LD, opening-hours parsing, logo URL |
| `maintenance.php` | Holding page, 503 headers, preview token and cookie, admin warning bar |
| `announcement.php` | Announcement bar markup and date window |
| `tracking.php` | Consent-gated head / body / footer snippets, consent helpers |
| `branding.php` | Login screen styling, login logo link, dashboard footer text |
| `back-to-top.php` | Back to top button and the shared `.llb-float-stack` wrapper |

The floating buttons render once through `wp_footer` priority 5 inside `.llb-float-stack`; the mobile bar renders separately at priority 6. Body classes: `llb-has-whatsapp`, `llb-has-mobile-bar`, `llb-has-back-to-top`, `llb-has-announce`.

Tracking snippets are **never** printed when no consent plugin is available. `llb_consent_api_available()` looks for `wp_has_consent()` (WP Consent API) or `cmplz_has_consent()` (Complianz); the dashboard shows an error notice when code is saved without one. Google Analytics and Search Console belong in Site Kit by Google, not in these fields.

Saving Theme Options purges LiteSpeed Cache when that plugin is active (`do_action( 'litespeed_purge_all' )`). Legacy URLs (`llb-to-*`, `llb-import-content`, Appearance `themes.php?page=…`) redirect to `admin.php?page=llb-theme-options` with the matching `tab`.

## Customizer (global settings)

Panel **L&L Bouwgroep** (Customizer panel ID `llb_theme_options` — separate from the Theme Options database option above). All company data comes from the Customizer — never hard-coded outside `llb_customizer_defaults()`. Copyright year is generated automatically.

Fonts are fixed (self-hosted Barlow + Inter, AVG). Not editable in the Customizer. Site logo uses the native WordPress Custom Logo control.

| Section | Setting IDs | Notes |
|---------|-------------|--------|
| Company & contact | `llb_company_name`, `llb_phone`, `llb_email`, `llb_address_street`, `llb_address_postcode`, `llb_address_city`, `llb_kvk`, `llb_btw` | Empty fields hidden on the front end |
| Opening hours | `llb_hours_monday` … `llb_hours_sunday` | Grouped for display via `llb_get_opening_hours()` |
| Map | `llb_map_image`, `llb_map_url` | Static image + route URL (fallback from address) |
| Social media | Theme Options keys `social_instagram`, `social_facebook`, `social_linkedin`, `social_youtube`, `social_google` | Empty = not shown; placement via `social_show_*` |
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
| `llb_get_faq_items_grouped()` | FAQ items with answers, grouped by category order |
| `llb_get_service_url( $slug )` | Service permalink or Services page fallback |
| `llb_get_projects_page_id()` | Projects overview page ID |
| `llb_get_projects_page_meta( $key )` | Meta from the Projects page (single project labels) |
| `llb_get_projects_page_url( $args )` | Projects URL with optional `categorie` / `pagina` |
| `llb_query_projects( $slug, $paged )` | Filtered, paginated project query |
| `llb_get_featured_project()` | First featured published project |
| `llb_get_project_gallery_ids( $id )` | Gallery IDs, fallback featured image |

Home sections live in `template-parts/home/`. Shared parts: `page-hero.php` (angled panel; content stays inside the diagonal), `usp-strip.php`, `cta-band.php`, `project-card.php`, `gallery-slider.php`, `faq-accordion.php`.

`template_redirect`: `/projectcategorie/{slug}/` → 301 to `/projecten/?categorie={slug}`.

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
| `page-templates/template-projects.php` | Projects overview | Projecten (filter, grid, pagination, featured slider) |
| `single-project.php` | — | Single project (hero, gallery, about/work/result, CTA) |
| `page-templates/template-contact.php` | Contact | Contact / Offerte (form, details, map, FAQ) |
| `page-templates/page-faq.php` | FAQ | Veelgestelde vragen (grouped accordion + CTA) |
| `page-templates/template-full-width.php` | Full width | Elementor layouts |
| `page-templates/template-elementor.php` | — (not selectable) | Applied automatically to Elementor builder pages: header, `the_content()`, footer |

Phase 4 templates complete (Home, Diensten, Over ons, Projecten, Contact, FAQ, singles).

Page meta boxes are registered per template (`template` / `templates` in `llb_meta_box_page_config()`). After changing a page template: save and reload to see matching fields.

### Page / FAQ fields

- Shared **Page hero** on all templates except Full width
- Home, About, Projects, Contact, FAQ: section boxes as listed in Phase 3c-2
- FAQ repeater `_llb_faq_items`: question, answer, category (`algemeen` / `badkamer` / `kosten` / `aanbouw`), Show on homepage
- Questions without an answer are hidden on the website

### Default content import

- Theme Options → **Import content** tab (`llb_run_content_import` in `inc/import.php`)
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
