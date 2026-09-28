# Plugin compatibility

The theme must be **fully compatible** with:

- Yoast SEO
- Rank Math SEO
- Elementor
- Contact Form 7
- Site Kit by Google
- Complianz (or any plugin implementing the WP Consent API)
- Cloudflare Turnstile for Contact Form 7

**LiteSpeed Cache** (hosting): cache plugin, no theme code needed — see [12-deployment.md](12-deployment.md).

The theme must still work with **no plugins installed**. Plugins are enhancements, not requirements. Always guard plugin APIs with `function_exists()`, `class_exists()`, or `defined()` before calling them.

Only **one** SEO plugin is active on the site at a time — never Yoast and Rank Math together.

---

## SEO: Yoast SEO or Rank Math

- `add_theme_support( 'title-tag' )` — no hardcoded `<title>`
- Theme never outputs meta descriptions or Open Graph (the active SEO plugin owns those)

### Breadcrumbs helper: `llb_breadcrumbs()`

Runs only when **Theme Options → SEO → Breadcrumbs** is on, and never on the homepage.

1. If `yoast_breadcrumb()` exists → use it
2. Elseif `rank_math_the_breadcrumbs()` exists → use it
3. Else → the theme trail from `llb_get_breadcrumb_trail()` (Home → Diensten/Projecten/page ancestors → current page, current item not a link)

Either way the output is wrapped in `<nav class="llb-crumbs">` so the theme styling applies. `wpseo_breadcrumb_separator` and `rank_math/frontend/breadcrumb/separator` are filtered to the theme separator (`/`), so the plugin trail looks identical to the theme trail.

### Structured data

- **`BreadcrumbList`** — the theme only prints it when **neither** Yoast nor Rank Math is active. Both plugins emit their own, so this avoids duplicates.
- **`GeneralContractor` (LocalBusiness)** — printed site-wide when **Theme Options → SEO → Local business structured data** is on, built from the Customizer company data, opening hours and social profiles. Turn it off if the SEO plugin is already configured to output full organisation data, to avoid two competing entities.
- **`FAQPage`** — on the FAQ page and services with related questions, via the `llb_output_faq_schema` filter.

**Implementation:** `inc/compat/seo.php` (breadcrumbs, FAQ schema) and `inc/features/schema.php` (local business).

See also [05-seo.md](05-seo.md).

---

## Elementor

- Theme templates remain the default. Elementor is **optional per page**.
- Every template must call `the_content()` so Elementor can render.
- Provide a **clean full-width page template** with no container restrictions, so Elementor layouts are not squeezed.
- Support Elementor’s own **Elementor Canvas** and **Elementor Full Width** templates without breaking.
- Register Elementor theme locations (header / footer) via `elementor_theme_register_locations`, so Elementor Pro Theme Builder can replace header/footer if needed. If not used, theme header/footer are shown.
- Set `$content_width` and do **not** add global CSS that overrides Elementor widgets.

### Builder pages

When a page is built with Elementor (`_elementor_edit_mode` = `builder`), the theme renders **header + `the_content()` + footer** only — no page hero, no table of contents, no `.prose` wrapper — so the Elementor design is not wrapped in theme chrome.

- `llb_is_elementor_builder_page( $post_id )` detects builder pages
- `template_include` (priority 9) swaps in `page-templates/template-elementor.php`
- Pages using **Elementor Canvas** or **Elementor Full Width** (`_wp_page_template` starting with `elementor_`) are left alone, so Elementor's own templates keep working
- `page.php` has the same early check as a safety net

**Implementation:** `inc/compat/elementor.php` — `llb_register_elementor_locations()`, `llb_is_elementor_builder_page()`, `llb_elementor_template_include()`, Google Fonts filter; header/footer use `elementor_theme_do_location()`.

### AVG note

Elementor loads Google Fonts by default — this **must be disabled** in Elementor settings. Fonts are self-hosted by the theme. The theme also forces `elementor/frontend/print_google_fonts` to false.

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

**Implementation:** `inc/compat/cf7.php` — conditional `wpcf7_enqueue_*`, helper `llb_contact_form()`.

### Spam protection: Cloudflare Turnstile

Turnstile replaces reCAPTCHA (no Google request, privacy friendly, no cookie banner needed).

- Install **Cloudflare Turnstile** and add the `[cf7-turnstile]` tag (or the tag the plugin documents) to the form, above the submit button
- The theme styles the widget in `assets/css/design-v2.css`: full width on phones, 12px radius, and the same bottom spacing as the other form fields
- Selectors covered: `.wpcf7-form .cf-turnstile`, `.cf7-cf-turnstile`, `.wpcf7-cf-turnstile` and their iframes

---

## Site Kit by Google

- The theme calls `wp_head()`, `wp_body_open()` and `wp_footer()`, which is everything Site Kit needs to inject its tags
- **Do not** paste Analytics or Search Console tags into Theme Options → Tracking; configure them in Site Kit
- With Complianz installed, enable **Consent Mode** in Site Kit so Google tags respect the visitor's choice

---

## Consent: Complianz / WP Consent API

The theme never sets a cookie or loads a third-party script on its own. The only consent-sensitive output is the Tracking section of Theme Options.

- `llb_consent_api_available()` returns true when `wp_has_consent()` (WP Consent API) or `cmplz_has_consent()` (Complianz) exists
- `llb_has_consent( $category )` asks the plugin; **without a consent plugin it always returns false**, so tracking snippets are never printed
- Each snippet (head / body / footer) has its own category: `functional`, `preferences`, `statistics` or `marketing`
- The dashboard shows an error notice when tracking code is saved but no consent plugin is active

**Implementation:** `inc/features/tracking.php`.

---

## Recommended plugins

| Plugin | Why |
|--------|-----|
| **Contact Form 7** | Contact and quote form |
| **Cloudflare Turnstile** (for CF7) | Spam protection without Google or extra cookies |
| **Flamingo** | Stores CF7 submissions in the dashboard as a backup for lost e-mail |
| **FluentSMTP** or **WP Mail SMTP** | Reliable delivery of form e-mail |
| **Yoast SEO** *or* **Rank Math** | Titles, meta descriptions, sitemaps, breadcrumbs — never both |
| **Site Kit by Google** | Search Console and Analytics, with Consent Mode |
| **Complianz** | Cookie banner, privacy statement and WP Consent API support |
| **Wordfence** | Firewall, login protection, malware scanning |
| **UpdraftPlus** | Scheduled off-site backups |
| **LiteSpeed Cache** | Caching on LiteSpeed hosting (see [12-deployment.md](12-deployment.md)) |

The theme works with none of these installed.
