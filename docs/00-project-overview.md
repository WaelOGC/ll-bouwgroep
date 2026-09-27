# Project overview

## Client

**L&L Bouwgroep B.V.** — Netherlands.

Target area: **Zoetermeer en omgeving**.

Construction and renovation company. Specialty: complete bathroom and toilet renovation, covering the full trajectory from demolition through plumbing, electrical, plaster, tiling, sanitary installation, and finishing. Also delivers full renovations for homes and commercial buildings.

Team experience: **10–25 years**.

**Tagline:** “Vakmanschap waarop u kunt bouwen.”

## Goal

A simple, modern, elegant business website with **5–6 pages**, built to scale (the client may expand in about six months).

## Deliverable

- Custom **classic WordPress theme**, built from scratch
- Theme templates are the default; Elementor is optional per page (not required)
- The theme must still work with **no plugins installed**. Plugins are enhancements, not requirements.
- Fully compatible with:
  - Yoast SEO
  - Rank Math SEO
  - Elementor
  - Contact Form 7
- Only **one** SEO plugin is active at a time (never Yoast and Rank Math together)
- See [09-plugin-compatibility.md](09-plugin-compatibility.md) and [05-seo.md](05-seo.md)

## Admin model

The developer manages the site. Everything common — texts, images, colors, fonts, contact info, sections — must be editable from the WordPress dashboard. Code changes only for new features or large structural changes.

## Environment

| Item | Value |
|------|--------|
| Stack | Local by Flywheel |
| WordPress | 7.1.2 |
| PHP | 8.2.29 |
| Web server | nginx |
| Database | MySQL 8.4.0 |
| Local URL | `ll-bouwgroep.local` |

## Language

- Site content: **Dutch** now
- Theme strings: translation-ready for additional languages later
