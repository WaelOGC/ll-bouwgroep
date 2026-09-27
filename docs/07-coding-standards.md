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
