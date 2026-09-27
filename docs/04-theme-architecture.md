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

Editable from **Appearance → Customize**:

- Logo
- Colors
- Fonts
- Contact info: phone, email, address, KvK, BTW (use TODO until real values exist)
- Opening hours
- Map image (static)
- “Route bekijken” URL (Google Maps link, opens in new tab)
- Social links
- Header CTA
- Footer text
- Contact Form 7 shortcode (for the contact page)

All company data comes from the Customizer — never hard-coded. Copyright year is generated automatically.

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

All user-facing strings wrapped with `__()` / `esc_html__()` (and related i18n functions) using text domain `ll-bouwgroep`.

## Front-end stack

- **Vanilla JS only** — no jQuery dependency (CF7 may enqueue its own scripts when a form is present)
- Mobile-first responsive CSS
