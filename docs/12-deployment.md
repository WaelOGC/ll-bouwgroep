# Deployment

How to ship the L&L Bouwgroep theme from Local to production.

## Before upload

- Version bumped in `style.css`
- `CHANGELOG.md` updated
- `php -l` passes on every PHP file
- Tested on Local (`ll-bouwgroep.local`)

## Upload

- Zip the theme folder only (`ll-bouwgroep/`)
- Upload via **Appearance → Themes → Add New → Upload** (replace current), or via SFTP

## After upload

1. **Settings → Permalinks → Save** (only if CPTs or rewrites changed)
2. **LiteSpeed Cache → Toolbox → Purge All**
3. If LiteSpeed CSS/JS optimization is on: purge CSS/JS cache too
4. Test in a private browser window: home, a service, a project, contact form, mobile

## Images

- Theme demo images in `assets/images/` are **WebP** (not PNG). Keep logo transparency with WebP when needed (`logo-header.webp`).
- When adding new images: export as **WebP**, max **2000px** wide, and place them in `assets/images/` (or upload via Media Library). Prefer WebP over PNG/JPEG for photos.
- After upload on a site that still has old PNG demo attachments, open wp-admin once so the one-time migration (`llb_images_webp_v1`) can replace them.

## LiteSpeed Cache notes

- Theme assets have the version number in the URL, so a new version loads fresh after purge
- Changing a toggle on **Theme Options → General** purges LiteSpeed Cache automatically so visitors see the change immediately
- If LiteSpeed CSS/JS combine or minify breaks the layout: turn that option off, test, report
- Never edit theme files on the live server. Always: Local → GitHub → upload

## Rollback

Keep the previous theme zip. If the site breaks: upload the previous version, purge cache.

## Language settings

- **Settings → General → Site Language** = **Nederlands** (sets `lang="nl-NL"` for visitors and SEO)
- **Users → Profile → Language** = **English** (keeps the WordPress dashboard in English for the admin)
