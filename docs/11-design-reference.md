# Design reference

Visual layout and style reference for the L&L Bouwgroep website. **Design = layout and style only.** All website text comes from [10-page-content.md](10-page-content.md).

## Approved page references

The `*-v2.html` files in `docs/design/` are the **only approved design references**. Open them in a browser and match them 1:1 (CSS values, spacing, breakpoints, structure, motion).

| File | Status |
|------|--------|
| **`home-v2.html`** | **Approved Home design** (desktop, tablet, phone). Live from theme **0.14.0**. |
| **`over-ons-v2.html`** | **Approved Over ons design** (desktop, tablet, phone). Live from theme **0.15.0**. Same design system as Home (`design-v2.css`). |
| **`diensten-v2.html`** | **Approved Diensten design** (desktop, tablet, phone). Live from theme **0.16.0**. Same design system (`design-v2.css`). |
| **`projecten-v2.html`** | **Approved Projecten design** (desktop, tablet, phone). Live from theme **0.17.0**. Same design system (`design-v2.css`). |
| **`contact-v2.html`** | **Approved Contact design** (desktop, tablet, phone). Live from theme **0.18.0**. Same design system (`design-v2.css`). |
| **`faq-v2.html`** | **Approved FAQ design** (desktop, tablet, phone). Live from theme **0.19.0**. Same design system (`design-v2.css`). |
| **`dienst-v2.html`** | **Approved single service design** (desktop, tablet, phone). Live from theme **0.20.0**. Same design system (`design-v2.css`). Built on Badkamers & toiletten; applies to all 9 services. |
| **`project-v2.html`** | **Approved single project design** (desktop, tablet, phone). Live from theme **0.21.0**. Same design system (`design-v2.css`). Built on Aanbouw met lichtstraat; applies to all projects. |
| **`privacy-v2.html`** | **Approved Privacyverklaring design** (desktop, tablet, phone). Live from theme **0.22.0**. Same design system (`design-v2.css`). Also the reference for the **default page template** (`page.php`: hero or dark `.thero`, TOC + `.prose`). |
| **`404-v2.html`** | **Approved 404 design** (desktop, tablet, phone). Live from theme **0.22.0**. Same design system (`design-v2.css`). |

## Archived PNG references

Older PNG mockups live in `docs/design/archive/` (`contact.png`, `diensten.png`, `home.png`, `home-responsive.png`, `over-ons.png`, `projecten.png`). They are superseded by the `*-v2.html` files and must not be used for new work.

## Decisions

1. **Design = layout and style only.** All text comes from `10-page-content.md`. If design text differs from the docs, the docs win.
2. **Home** follows `home-v2.html` exactly (header, footer, all Home sections).
3. **Over ons** follows `over-ons-v2.html` exactly (page hero, splits, steps, CTA).
4. **Diensten** follows `diensten-v2.html` exactly (page hero, service cards).
5. **Projecten** follows `projecten-v2.html` exactly (page hero, intro, featured block, filter, grid, pagination).
6. **Contact** follows `contact-v2.html` exactly (page hero, info panel, CF7 form).
7. **Veelgestelde vragen** follows `faq-v2.html` exactly (page hero, category nav, accordion groups, short CTA).
8. **Single service** follows `dienst-v2.html` exactly (service hero, intro split, checklist/text sections, steps, related projects/FAQ, other services, CTA).
9. **Single project** follows `project-v2.html` exactly (project hero with category label, gallery, text + werkzaamheden panel, related projects, CTA).
10. **Privacyverklaring** follows `privacy-v2.html` exactly (page hero, sticky TOC, prose, company card).
11. **Default pages** (`page.php`) follow `privacy-v2.html` structure: image hero or dark `.thero`, TOC when ≥2 H2s, `.prose` content.
12. **404** follows `404-v2.html` exactly (large light “404”, heading, sub-block, buttons).
13. **No Google Maps embed (AVG).** Contact page shows a static map image with a button "Route bekijken" that opens Google Maps in a new tab. Map image and address are editable in the Customizer.
14. **All company data comes from the Customizer**, never hard-coded: phone, email, address, KvK, BTW, opening hours, map image. Copyright year is generated automatically. Demo placeholders may be seeded when empty.
15. **Fonts:** Barlow (headings) + Inter (body), self-hosted.
16. **Images in the design are placeholders.** They must be replaced by real photos from the client before launch.
17. **Responsive is mandatory** — see [07-coding-standards.md](07-coding-standards.md).
