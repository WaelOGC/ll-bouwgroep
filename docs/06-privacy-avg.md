# Privacy (AVG / GDPR)

## Privacyverklaring

Provide a Dutch **Privacyverklaring** page covering AVG/GDPR obligations for the site and contact form.

Base text: [10-page-content.md § 16](10-page-content.md#16-privacyverklaring). **Must be reviewed by the client before launch.**

## Legal footer (required)

Dutch business websites must show in the footer:

- Company name: **L&L Bouwgroep B.V.**
- KvK number: **TODO**
- BTW number: **TODO**
- Address: **TODO**
- Email: **TODO**

## Contact form (Contact Form 7)

- Contact form is provided by **Contact Form 7** (not a custom theme form)
- Explicit consent via CF7 `[acceptance]` field, linked to the Privacyverklaring
- Collect only data that is needed
- **No reCAPTCHA by default** (third-party request, AVG)
- See [04-theme-architecture.md](04-theme-architecture.md) and [09-plugin-compatibility.md](09-plugin-compatibility.md)

## Elementor and fonts

- Elementor’s default Google Fonts loading **must be disabled** in Elementor settings
- Theme fonts are self-hosted

## Cookies and tracking

- **No tracking cookies by default** → no cookie consent banner required at launch
- If analytics, Google Maps, or other third-party embeds are added later, a consent solution becomes required

## Fonts and third-party requests

- Self-hosted fonts only
- No external requests (CDNs, trackers, embeds) without consent
