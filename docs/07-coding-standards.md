# Coding standards

## WordPress standards

Follow the official **WordPress Coding Standards** for PHP, CSS, and JavaScript.

## Security

- Escape all output: `esc_html`, `esc_attr`, `esc_url`, `wp_kses_post` (and related helpers)
- Sanitize all input
- Nonces on every form and meta box save
- Capability checks before privileged actions

## Naming and scope

- Prefix everything with `llb_`
- No leaking global variables

## Language rule

- Everything the **admin sees in the dashboard** is written in **English**: post type labels, taxonomy labels, menu location names, Customizer panels/sections/controls, meta box titles and field labels, admin notices, help text.
- Everything the **visitor sees on the website** is **Dutch**: all content from `10-page-content.md`, default values, and visitor-facing template text (skip link, aria-labels, "no results" messages, buttons).
- Admin strings: English, wrapped in `__()` / `esc_html__()` with text domain `ll-bouwgroep`.
- Visitor strings: Dutch, as they are now.
- No translation files (`.po` / `.mo`) are needed.

## Versioning

- Semantic versioning: `0.x.y` until launch, `1.0.0` at launch.
- Single source of truth: `Version` in `style.css`. `LLB_VERSION` reads that value via `wp_get_theme( get_template() )->get( 'Version' )`.
- Every task that changes theme code: bump `Version` in `style.css` + add a `CHANGELOG.md` entry, in the same commit.
  - New feature / phase = minor (`0.3.0`). Fix = patch (`0.3.1`).
- Docs-only changes: no version bump.
- Reason: on the live server LiteSpeed Cache can serve old CSS/JS. A new version number forces fresh files.

## File hygiene

- Comment every file header
- Keep files small and single-purpose

## Plugin independence and guards

The theme must work correctly with **no plugins installed**. Yoast SEO, Rank Math SEO, Elementor, and Contact Form 7 are enhancements, not requirements.

Before calling any plugin API, always check:

- `function_exists()`
- `class_exists()`
- `defined()`

See [09-plugin-compatibility.md](09-plugin-compatibility.md).
