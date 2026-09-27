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
│   └── template-full-width.php
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
- Social links
- Header CTA
- Footer text
- Contact Form 7 shortcode (for the contact page)

## Meta boxes

- Native WordPress meta box API (no ACF)
- Placed in the **center** of the edit screen
- Per-page: hero image, title, subtitle, and page-specific section fields

## Custom post types

Registered in the theme:

### `dienst`

- Featured image
- Excerpt
- Custom fields as needed for service detail

### `project`

- Featured image
- Excerpt
- Custom fields (including gallery support)

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

## Plugin compatibility layer

`inc/compat/` loads guarded integrations for SEO (Yoast / Rank Math), Elementor, and CF7. See [09-plugin-compatibility.md](09-plugin-compatibility.md).

## Internationalization

All user-facing strings wrapped with `__()` / `esc_html__()` (and related i18n functions) using text domain `ll-bouwgroep`.

## Front-end stack

- **Vanilla JS only** — no jQuery dependency (CF7 may enqueue its own scripts when a form is present)
- Mobile-first responsive CSS
