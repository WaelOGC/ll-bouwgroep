# Theme architecture

## Location and naming

| Item | Value |
|------|--------|
| Theme folder | `app/public/wp-content/themes/ll-bouwgroep/` |
| Text domain | `ll-bouwgroep` |
| Function / prefix | `llb_` |

Classic PHP theme (no block theme, no page builder).

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
│   ├── contact-form.php
│   └── helpers.php
├── template-parts/
├── page-templates/
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

## Contact form

Built into the theme:

- `wp_mail` for sending
- Nonce verification
- Honeypot
- Server-side validation
- AVG consent checkbox

Local email testing: **Mailpit** (Local by Flywheel).

## Internationalization

All user-facing strings wrapped with `__()` / `esc_html__()` (and related i18n functions) using text domain `ll-bouwgroep`.

## Front-end stack

- **Vanilla JS only** — no jQuery dependency
- Mobile-first responsive CSS
