# SEO

Details and plugin-specific rules: [09-plugin-compatibility.md](09-plugin-compatibility.md).

The theme supports **Yoast SEO** and **Rank Math SEO**. Only one SEO plugin is active on the site — never both. The theme must still work with no SEO plugin installed.

## Local SEO

Target area: **Zoetermeer en omgeving**.

SEO titles and meta descriptions are defined in [10-page-content.md § 20](10-page-content.md#20-seo-titles--meta-descriptions). The theme does **not** output them — enter them manually per page in Yoast SEO or Rank Math.

## Title tag

- Use `add_theme_support( 'title-tag' )`
- Do **not** hardcode a `<title>` in the theme

## What the SEO plugin owns

The theme must **not** output:

- Meta descriptions
- Open Graph tags
- Schema / structured data

Yoast or Rank Math handles these when active.

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

Use theme helper `llb_breadcrumbs()`:

1. If `yoast_breadcrumb()` exists → use it
2. Elseif `rank_math_the_breadcrumbs()` exists → use it
3. Else → output nothing

## Performance

- Optimized images
- `loading="lazy"` where appropriate
- `srcset` via WordPress image sizes
- Minimal CSS/JS
- No unnecessary render-blocking extras
