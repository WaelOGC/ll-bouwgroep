# Design reference

Visual layout and style reference for the L&L Bouwgroep website. **Design = layout and style only.** All website text comes from [10-page-content.md](10-page-content.md).

## Approved Home reference

| File | Status |
|------|--------|
| **`home-v2.html`** | **Approved Home design** (desktop, tablet, phone). Implements the live Home, site header, mobile menu and footer from theme version **0.14.0**. |
| `home.png` | Superseded by `home-v2.html` — do not use for new Home work. |

Open `docs/design/home-v2.html` in a browser and match it 1:1 (CSS values, spacing, breakpoints, structure, motion).

## Other design images (`docs/design/`)

| File | Shows |
|------|--------|
| `home-responsive.png` | Older Home responsive notes (superseded by home-v2.html) |
| `over-ons.png` | Over ons page |
| `diensten.png` | Diensten page |
| `projecten.png` | Projecten page |
| `contact.png` | Contact page |

## Decisions

1. **Design = layout and style only.** All text comes from `10-page-content.md`. If design text differs from the docs, the docs win.
2. **Home** follows `home-v2.html` exactly (header, footer, all Home sections).
3. **No Google Maps embed (AVG).** Contact page shows a static map image with a button "Route bekijken" that opens Google Maps in a new tab. Map image and address are editable in the Customizer.
4. **All company data comes from the Customizer**, never hard-coded: phone, email, address, KvK, BTW, opening hours, map image. Copyright year is generated automatically. Demo placeholders may be seeded when empty.
5. **Fonts:** Barlow (headings) + Inter (body), self-hosted.
6. **Images in the design are placeholders.** They must be replaced by real photos from the client before launch.
7. **Responsive is mandatory** — see [07-coding-standards.md](07-coding-standards.md).
