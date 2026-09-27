# Plugin compatibility

The theme must be **fully compatible** with:

- Yoast SEO
- Rank Math SEO
- Elementor
- Contact Form 7

**LiteSpeed Cache** (hosting): cache plugin, no theme code needed — see [12-deployment.md](12-deployment.md).

The theme must still work with **no plugins installed**. Plugins are enhancements, not requirements. Always guard plugin APIs with `function_exists()`, `class_exists()`, or `defined()` before calling them.

Only **one** SEO plugin is active on the site at a time — never Yoast and Rank Math together.

---

## SEO: Yoast SEO or Rank Math

- `add_theme_support( 'title-tag' )` — no hardcoded `<title>`
- Theme never outputs meta descriptions, Open Graph, or schema (the active SEO plugin owns those)

### Breadcrumbs helper: `llb_breadcrumbs()`

1. If `yoast_breadcrumb()` exists → use it
2. Elseif `rank_math_the_breadcrumbs()` exists → use it
3. Else → output nothing

See also [05-seo.md](05-seo.md).

---

## Elementor

- Theme templates remain the default. Elementor is **optional per page**.
- Every template must call `the_content()` so Elementor can render.
- Provide a **clean full-width page template** with no container restrictions, so Elementor layouts are not squeezed.
- Support Elementor’s own **Elementor Canvas** and **Elementor Full Width** templates without breaking.
- Register Elementor theme locations (header / footer) via `elementor_theme_register_locations`, so Elementor Pro Theme Builder can replace header/footer if needed. If not used, theme header/footer are shown.
- Set `$content_width` and do **not** add global CSS that overrides Elementor widgets.

### AVG note

Elementor loads Google Fonts by default — this **must be disabled** in Elementor settings. Fonts are self-hosted by the theme.

---

## Contact Form 7

Contact Form 7 **replaces** any custom theme contact form.

- Customizer setting: CF7 form shortcode for the contact page
- If CF7 is not active or no form is set → show **contact details only** (no errors)
- Theme styles `.wpcf7` forms (inputs, labels, button, validation and response messages) in brand style
- AVG consent via CF7 `[acceptance]` field, linked to the Privacyverklaring page
- **No reCAPTCHA by default** (third-party request, AVG)
- Load CF7 CSS/JS only on pages that contain a form, using the `wpcf7_load_js` / `wpcf7_load_css` filters
- Local email testing via **Mailpit**
- Form fields (labels, dropdown options, consent text, button): [10-page-content.md § 15](10-page-content.md#15-contact--offerte-aanvragen)
