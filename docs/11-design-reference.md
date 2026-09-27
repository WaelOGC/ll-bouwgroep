# Design reference

Visual layout and style reference for the L&L Bouwgroep website. **Design = layout and style only.** All website text comes from [10-page-content.md](10-page-content.md).

## Design images (`docs/design/`)

| File | Shows |
|------|--------|
| `home.png` | Home page, desktop |
| `home-responsive.png` | Home page, tablet + mobile |
| `over-ons.png` | Over ons page |
| `diensten.png` | Diensten page |
| `projecten.png` | Projecten page |
| `contact.png` | Contact page |

## Decisions

1. **Design = layout and style only.** All text comes from `10-page-content.md`. If design text differs from the docs, the docs win.
2. **New sections from the design will be built:** homepage mini FAQ, separate FAQ page, opening hours on Contact, project filter, featured project with image slider. Content is in `10-page-content.md`.
3. **No Google Maps embed (AVG).** Contact page shows a static map image with a button "Route bekijken" that opens Google Maps in a new tab. Map image and address are editable in the Customizer.
4. **All company data comes from the Customizer**, never hard-coded: phone, email, address, KvK, BTW, opening hours, map image. Copyright year is generated automatically. Current values are placeholders (company registration at KvK is pending).
5. **Fonts follow the docs, not the design:** Barlow (headings) + Inter (body), self-hosted.
6. **Images in the design are AI-generated placeholders.** They must be replaced by real photos from the client before launch.
