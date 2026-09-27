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

## Plugin independence

The theme must work correctly with **no plugins installed**. Yoast (and any others) are enhancements, not requirements.
