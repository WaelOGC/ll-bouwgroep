# Brand guide

## Logo

Source file: [`assets/logo.jpeg`](assets/logo.jpeg)

Visual elements:

- Red “L”, green “L”, black “&”
- House roof and hammer motif
- Text “BOUWGROEP B.V.”
- Red/green underline

## Colors

All CSS variables use the `--llb-` prefix.

Use CSS custom properties:

| Token | Value | Role |
|-------|--------|------|
| `--llb-red` | `#D0021B` | Red (brand primary) |
| `--llb-green` | `#0B6B3A` | Green (brand secondary) |
| `--llb-black` | `#1F1F1F` | Dark surfaces / strong text |
| `--llb-text` | `#4A4A4A` | Body text |
| `--llb-light` | `#F5F5F3` | Light backgrounds |
| `--llb-white` | `#FFFFFF` | White |

## Typography

| Role | Family | Weights |
|------|--------|---------|
| Headings | Barlow | 600, 700 |
| Body | Inter | 400, 500 |

Font CSS variables:

| Token | Value |
|-------|--------|
| `--llb-font-heading` | `'Barlow', Arial, sans-serif` |
| `--llb-font-body` | `'Inter', Arial, sans-serif` |

Fonts must be **self-hosted** in the theme. Do **not** load Google Fonts (or any other font CDN) — GDPR / AVG compliance.

## Visual style

- Modern, clean, professional
- Generous whitespace
- Strong real-project photography
- Subtle angled shapes inspired by the logo roof line
- Red/green split line as accent

## Accessibility

Minimum **WCAG AA** contrast: **4.5:1** for body text against its background.
