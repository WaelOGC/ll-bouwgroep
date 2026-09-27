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
│   ├── post-types.php
│   ├── helpers.php
│   └── compat/
│       ├── seo.php
│       ├── elementor.php
│       └── cf7.php
├── template-parts/
├── page-templates/
│   ├── template-full-width.php
│   └── page-faq.php
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

## Meta boxes

- Native WordPress meta box API (no ACF)
- Placed in the **center** of the edit screen
- Per-page: hero image, title, subtitle, and page-specific section fields

### FAQ page (repeatable)

On the FAQ page (`page-faq.php`):

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
