# SEO and Yoast

## Title tag

- Use `add_theme_support( 'title-tag' )`
- Do **not** hardcode a `<title>` in the theme

## What Yoast owns

The theme must **not** output:

- Meta descriptions
- Open Graph tags
- Schema / structured data

Yoast SEO handles these on production.

## Heading structure

- Exactly **one `<h1>`** per page
- Logical **H2 / H3** order (no skipped levels for decoration)

## Semantics and accessibility

HTML5 landmarks:

- `header`
- `nav`
- `main`
- `article` (where appropriate)
- `footer`

Include a **skip link** to main content.

## Breadcrumbs

If `yoast_breadcrumb()` (or equivalent Yoast breadcrumb function) exists, support outputting Yoast breadcrumbs.

## Performance

- Optimized images
- `loading="lazy"` where appropriate
- `srcset` via WordPress image sizes
- Minimal CSS/JS
- No unnecessary render-blocking extras
