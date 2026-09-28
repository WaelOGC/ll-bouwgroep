# Launch checklist

Run through this list before the site goes live, and once more right after the DNS switch. Related: [12-deployment.md](12-deployment.md) and [09-plugin-compatibility.md](09-plugin-compatibility.md).

## 1. Content

- [ ] All pages filled: Home, Over ons, Diensten, 9 service pages, Projecten, Contact, Veelgestelde vragen, Privacyverklaring
- [ ] Real company data in **Customizer → L&L Bouwgroep**: company name, phone, e-mail, address, KvK, BTW, opening hours
- [ ] Demo images replaced by real project photos (WebP, max 2000px wide)
- [ ] No placeholder text left (`Voorbeeldstraat`, `079 123 45 67`, `info@llbouwgroep.nl`, lorem ipsum)
- [ ] Every project has a category, a featured image and a gallery
- [ ] Primary and Footer menus point at the right pages
- [ ] Spelling and grammar checked in Dutch

## 2. Theme Options

- [ ] **General** — animations on, projects on (or off if the client is not ready to show work), back to top on
- [ ] **Contact buttons** — WhatsApp number in international format if the client wants the button; mobile bar texts correct
- [ ] **SEO** — local business structured data on, breadcrumbs on, area served correct
- [ ] **Announcement** — off, unless there is a current message (check the end date)
- [ ] **Tracking** — empty unless a consent plugin is active; Analytics belongs in Site Kit
- [ ] **Branding** — dashboard footer text set
- [ ] **Maintenance** — **off** at launch

## 3. Plugins

- [ ] Contact Form 7 active, form tested end to end, e-mail arrives at the real address
- [ ] SMTP plugin (FluentSMTP / WP Mail SMTP) configured and test mail delivered
- [ ] Flamingo active so submissions are also stored in the dashboard
- [ ] Cloudflare Turnstile added to the form and verified with a real submission
- [ ] One SEO plugin only (Yoast **or** Rank Math), never both
- [ ] Complianz configured: cookie banner, privacy statement, WP Consent API on
- [ ] Site Kit connected, Consent Mode enabled
- [ ] Wordfence active with login protection
- [ ] UpdraftPlus scheduled to off-site storage, and one restore tested
- [ ] LiteSpeed Cache on, with CSS/JS combine verified not to break the layout

## 4. SEO and indexing

- [ ] **Settings → Reading → Discourage search engines** is **unchecked**
- [ ] Permalinks saved once after the final deploy
- [ ] `robots.txt` allows crawling
- [ ] XML sitemap reachable and submitted to Search Console
- [ ] Titles and meta descriptions filled for every page
- [ ] Breadcrumbs visible on inner pages, not on the homepage
- [ ] Rich Results Test passes for `GeneralContractor` and `BreadcrumbList`
- [ ] No duplicate organisation schema (theme **or** SEO plugin, not both)
- [ ] 404 page works and offers a route back
- [ ] Redirects in place for any old URLs

## 5. Privacy / AVG

- [ ] Privacyverklaring published and linked in the footer and the form consent text
- [ ] **Settings → Privacy** points at that page
- [ ] No external fonts or scripts (fonts are self-hosted; Elementor Google Fonts disabled)
- [ ] Cookie banner appears before any statistics or marketing script loads
- [ ] Form consent checkbox is required and links to the Privacyverklaring
- [ ] See [06-privacy-avg.md](06-privacy-avg.md)

## 6. Technical

- [ ] HTTPS with a valid certificate; `http://` redirects to `https://`
- [ ] `www` and non-`www` resolve to one canonical host
- [ ] `WP_DEBUG` off in production
- [ ] Site Health shows no critical issues
- [ ] Admin user is not named `admin`, with a strong password
- [ ] `languages/ll-bouwgroep.pot` up to date
- [ ] **Settings → General → Site Language** = Nederlands; the admin user profile language = English

## 7. Front-end pass

Test on a real phone and on desktop, in a private window (logged out).

- [ ] Home, a service page, a project, Contact, FAQ, Privacyverklaring, 404
- [ ] Header menu, mobile menu, and the mobile menu closing the contact bar
- [ ] Floating buttons do not cover content or the mobile bar
- [ ] WhatsApp button opens WhatsApp with the Dutch pre-filled message
- [ ] `tel:` and `mailto:` links work from a phone
- [ ] Back to top appears after scrolling and returns to the top
- [ ] Announcement bar closes and stays closed after a reload
- [ ] Contact form validation messages are Dutch
- [ ] Keyboard navigation reaches every control and focus is visible
- [ ] Lighthouse on mobile: performance, accessibility, best practices, SEO all green

## 8. Maintenance mode rehearsal

- [ ] Turn maintenance on, open the site logged out: HTTP 503, holding page with logo and contact details
- [ ] Logged in as administrator the normal site is still visible, with the warning bar
- [ ] The preview link opens the real site in a private window
- [ ] wp-login and wp-admin stay reachable
- [ ] Turn maintenance **off** again

## 9. After go-live

- [ ] Purge LiteSpeed Cache
- [ ] Request indexing in Search Console for the homepage
- [ ] Send a test form submission from the live domain and confirm it arrives
- [ ] Take a fresh backup and keep the previous theme zip for rollback
- [ ] Hand over: admin credentials, plugin licences, and a short editing guide
