# Sitemap

Page texts: [10-page-content.md](10-page-content.md). Design layout: [11-design-reference.md](11-design-reference.md).

## Home

Content: [10-page-content.md § 1. Home](10-page-content.md#1-home)

- **Hero** — image, title, subtitle, CTA
- **Intro** — company introduction
- **Bathrooms & toilets highlight** — specialty callout
- **Services grid** — overview of services
- **Why us** — experience 10–25 years, one contact, one planning
- **Featured projects** — selected portfolio items (featured project with image slider)
- **Mini FAQ** — questions 1, 2, 3 and 7; button to FAQ page
- **CTA** — “Uw plannen bespreken?”

## Over ons

Content: [10-page-content.md § 2. Over ons](10-page-content.md#2-over-ons)

- Story
- Experienced craftsmen
- Way of working

## Diensten

Content: [10-page-content.md § 3. Diensten (overview)](10-page-content.md#3-diensten-overview-page) and §§ 4–12 (single services)

- **Overview** — WordPress Page (slug `diensten`); see [URL structure](04-theme-architecture.md#url-structure)
- **Single service** — Custom Post Type `dienst` (`/diensten/{slug}/`)

Services:

1. Badkamers & toiletten — [§ 4](10-page-content.md#4-dienst--badkamers--toiletten)
2. Renovatie en verbouwing — [§ 5](10-page-content.md#5-dienst--renovatie-en-verbouwing)
3. Stucwerk — [§ 6](10-page-content.md#6-dienst--stucwerk)
4. Tegelwerk — [§ 7](10-page-content.md#7-dienst--tegelwerk)
5. Timmerwerk — [§ 8](10-page-content.md#8-dienst--timmerwerk)
6. Schilder- en afbouwwerk — [§ 9](10-page-content.md#9-dienst--schilder--en-afbouwwerk)
7. Keukenverbouwingen — [§ 10](10-page-content.md#10-dienst--keukenverbouwingen)
8. Aan- en uitbouw — [§ 11](10-page-content.md#11-dienst--aan--en-uitbouw)
9. Overige bouwkundige werkzaamheden — [§ 12](10-page-content.md#12-dienst--overige-bouwkundige-werkzaamheden)

## Projecten

Content: [10-page-content.md § 13. Projecten (overview page)](10-page-content.md#13-projecten-overview-page) and [§ 14. Single Project](10-page-content.md#14-single-project-template)

- **Overview** — WordPress Page (slug `projecten`); see [URL structure](04-theme-architecture.md#url-structure)
- **Category filter** — taxonomy `project_categorie` (`/projectcategorie/{slug}/`)
- **Featured project** — with image slider
- **Single project** — Custom Post Type `project` (`/projecten/{slug}/`)

## Contact / Offerte aanvragen

Content: [10-page-content.md § 15. Contact](10-page-content.md#15-contact--offerte-aanvragen)

- Contact form
- Contact details (phone, email, address — TODO until provided)
- Opening hours (Customizer; TODO: confirm with client)
- Static map image + “Route bekijken” button (no Google Maps embed)
- Link to FAQ page
- CTA

## Veelgestelde vragen

Content: [10-page-content.md § 16. Veelgestelde vragen](10-page-content.md#16-veelgestelde-vragen)

- URL: `/veelgestelde-vragen/`
- Linked from Home (mini FAQ), Contact, and footer menu
- **Not** in the main header navigation

## Privacyverklaring

Content: [10-page-content.md § 17. Privacyverklaring](10-page-content.md#17-privacyverklaring)

- Privacy policy page (Dutch AVG/GDPR)

## 404

Content: [10-page-content.md § 18. 404](10-page-content.md#18-404)

- Custom 404 page

## Header / Navigation

Content: [10-page-content.md § 19. Header / Navigation](10-page-content.md#19-header--navigation)

- Logo, main navigation (Home, Over ons, Diensten, Projecten, Contact), header CTA
- Main navigation stays unchanged (FAQ is not in the main nav)

## Footer

Content: [10-page-content.md § 20. Footer](10-page-content.md#20-footer)

- Company blurb, navigation (includes Veelgestelde vragen + Privacyverklaring), contact placeholders, KvK/BTW, copyright
