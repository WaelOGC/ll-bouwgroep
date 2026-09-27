# Coding standards

## **Responsive is mandatory**

Everything we build now or later — every page, template, section, and element (headings, tagline, body text, images, background images, background decoration, colors, buttons, effects, spacing) — **MUST** look perfect on desktop, tablet and smartphone. On a phone the theme must feel like a native app.

**No task is “done” before it is verified on desktop, tablet AND phone widths.**

Standard test widths: **1440, 1280, 1024, 834, 768, 720, 600, 414, 390, 360**.

Rules:

- Mobile-first CSS only (`min-width` breakpoints; see below)
- No horizontal scroll (`overflow-x`)
- Nothing cut, hidden, or overlapping
- Images: `object-fit: cover`, never stretched
- Background images readable on every ratio (dark overlay strong enough that text is always readable)
- Decoration (icons / grid / stripes / angled edges) never cover content; lighter on mobile
- Type uses `clamp()`
- Primary buttons full-width on phone
- Tap targets ≥ 44px

This rule applies automatically to every future prompt.

---

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

## Responsive breakpoints

Mobile-first. Use **only** `min-width` media queries (never `max-width` for layout breakpoints).

| Token | Width | Use |
|-------|-------|-----|
| (default) | &lt; 600px | Mobile |
| `--llb-bp-sm` | 600px | Large mobile |
| `--llb-bp-md` | 768px | Tablet |
| `--llb-bp-lg` | 1024px | Small desktop |
| `--llb-bp-xl` | 1280px | Desktop |

Documented at the top of `assets/css/main.css`. Prefer these widths consistently across the theme.

## Plugin independence and guards

The theme must work correctly with **no plugins installed**. Yoast SEO, Rank Math SEO, Elementor, and Contact Form 7 are enhancements, not requirements.

Before calling any plugin API, always check:

- `function_exists()`
- `class_exists()`
- `defined()`

See [09-plugin-compatibility.md](09-plugin-compatibility.md).
