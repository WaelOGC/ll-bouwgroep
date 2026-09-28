# Design reference

Visual layout and style reference for the L&L Bouwgroep website. **Design = layout and style only.** All website text comes from [10-page-content.md](10-page-content.md).

## Approved page references

| File | Status |
|------|--------|
| **`home-v2.html`** | **Approved Home design** (desktop, tablet, phone). Live from theme **0.14.0**. |
| **`over-ons-v2.html`** | **Approved Over ons design** (desktop, tablet, phone). Live from theme **0.15.0**. Same design system as Home (`design-v2.css`). |
| **`diensten-v2.html`** | **Approved Diensten design** (desktop, tablet, phone). Live from theme **0.16.0**. Same design system (`design-v2.css`). |
| `home.png` | Superseded by `home-v2.html` — do not use for new Home work. |
| `over-ons.png` | Superseded by `over-ons-v2.html` — do not use for new Over ons work. |
| `diensten.png` | Superseded by `diensten-v2.html` — do not use for new Diensten work. |

Open the approved HTML files in a browser and match them 1:1 (CSS values, spacing, breakpoints, structure, motion).

## Other design images (`docs/design/`)

| File | Shows |
|------|--------|
| `home-responsive.png` | Older Home responsive notes (superseded by home-v2.html) |
| `projecten.png` | Projecten page |
| `contact.png` | Contact page |

## Decisions

1. **Design = layout and style only.** All text comes from `10-page-content.md`. If design text differs from the docs, the docs win.
2. **Home** follows `home-v2.html` exactly (header, footer, all Home sections).
3. **Over ons** follows `over-ons-v2.html` exactly (page hero, splits, steps, CTA).
4. **Diensten** follows `diensten-v2.html` exactly (page hero, service cards).
5. **No Google Maps embed (AVG).** Contact page shows a static map image with a button "Route bekijken" that opens Google Maps in a new tab. Map image and address are editable in the Customizer.
6. **All company data comes from the Customizer**, never hard-coded: phone, email, address, KvK, BTW, opening hours, map image. Copyright year is generated automatically. Demo placeholders may be seeded when empty.
7. **Fonts:** Barlow (headings) + Inter (body), self-hosted.
8. **Images in the design are placeholders.** They must be replaced by real photos from the client before launch.
9. **Responsive is mandatory** — see [07-coding-standards.md](07-coding-standards.md).
