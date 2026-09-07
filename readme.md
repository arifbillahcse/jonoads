# Jono Advertising — jonoads.com

Marketing site for Jono Advertising, built on Laravel with a Filament admin panel
so the team can edit stats, case studies, team bios and testimonials without a
developer.

## Status

Phases 1–2 of 6 are complete. The site renders from Blade through Laravel, and
every piece of copy that used to be hardcoded now has a table and a seeder. The
views still print inline markup; they start reading from the database in Phase 4.

| Phase | Scope | State |
|-------|-------|-------|
| 1 | Foundation — app skeleton, Vite, shared layout, routes | Done |
| 2 | Data layer — migrations, models, content seeders | Done |
| 3 | Filament admin panel — 15 resources, roles, settings | Not started |
| 4 | Blade port — sections read from the database | Not started |
| 5 | Forms & lead capture | Not started |
| 6 | QA, hardening, launch prep | Not started |

## Requirements

- PHP 8.2+
- Composer
- Node 20+

## Local setup

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate

npm run dev          # in one terminal (Vite dev server)
php artisan serve    # in another
```

The site is then at http://localhost:8000.

For a production-style build instead of the dev server:

```bash
npm run build
php artisan serve
```

## Layout

```
app/Http/Controllers/PageController.php   one method per public page
routes/web.php                            named routes for all 7 pages
resources/views/layouts/app.blade.php     <head>, Vite entry, header + footer
resources/views/partials/                 header and footer (were duplicated
                                          across 6 static HTML files)
resources/views/pages/                    one view per page
resources/css/app.css                     was assets/css/style.css
resources/js/app.js                       was assets/js/script.js
```

### Pages

| Route | Name | View |
|-------|------|------|
| `/` | `home` | `pages.home` |
| `/roas-engine` | `roas-engine` | `pages.roas-engine` |
| `/services` | `services` | `pages.services` |
| `/work` | `work` | `pages.work` |
| `/team` | `team` | `pages.team` |
| `/contact` | `contact` | `pages.contact` |
| `/smb` | `smb` | `pages.smb` |

### Navigation

The header and footer are single partials. When a nav item points at the page
you are already on, it renders as an in-page `#top` anchor instead of a reload —
the same behaviour the static build maintained by hand in six separate copies.
Adding a page means adding a route plus one entry in
`resources/views/partials/header.blade.php`.

## Data model

21 tables hold the content that was previously hardcoded in HTML. Child tables
are edited inline on their parent in the admin panel, which is why 21 tables
become roughly 15 admin screens.

| Table(s) | Holds |
|----------|-------|
| `site_settings` | Contact address, Skool/podcast/merch links, footer line |
| `stats` | Every animated counter, grouped by the strip it appears in |
| `brand_logos` | The scrolling brand marquee |
| `services`, `service_features` | 4 services and their capability lists |
| `engagement_models`, `engagement_features` | Media Management / Team Augment / Media Audit |
| `roas_steps`, `roas_step_features` | Review / Operate / Improve, plus each stage breakdown |
| `case_studies`, `case_study_stats` | 6 case studies and their result figures |
| `testimonials` | Client quotes |
| `comparison_metrics`, `comparison_checks` | Jono vs. average agency charts and checklist |
| `team_members` | Founder and team grid |
| `partners` | Partner network |
| `locations` | Offices |
| `smb_contents`, `industries` | SMB page copy and target industries |
| `contact_leads` | Enquiries (populated in Phase 5) |
| `newsletter_subscribers` | Signups (populated in Phase 5) |

Seeding imports the live site copy, so a fresh database is populated rather than
empty:

```bash
php artisan migrate:fresh --seed
```

That loads 22 stats, 18 brand logos, 4 services (16 features), 3 engagement
models (11 features), 3 ROAS steps (18 features), 6 case studies (11 stats),
7 team members, 6 partners, 5 locations, 8 industries, 4 comparison metrics,
6 comparison checks, 1 testimonial and 6 site settings.

### Conventions

- Content models use the `Publishable` trait: `Model::forDisplay()` returns
  published records in admin-defined order. Every front-end query should use it.
- Content models are soft-deleted, so removing something from the site in the
  panel is recoverable.
- Images are plain path columns (`photo_path`, `logo_path`, `image_path`) written
  by Filament's file upload, rather than a media-library package — each record
  has at most one image, so the extra tables would not earn their keep.
- Team initials are derived from the name on save when no headshot exists, so a
  member never renders as an empty box.

## Configuration

Values surfaced in the site come from config rather than hardcoded markup:

| Setting | Env key | Used by |
|---------|---------|---------|
| Contact address | `MAIL_CONTACT_ADDRESS` | Footer, enquiry notifications |
| Skool community | `SKOOL_URL` | Footer |

## Known gaps

- The `Podcast` and `Merch` footer links point at anchors that do not exist yet;
  both depend on add-ons that are not in the core scope.
- Team cards show initials rather than headshots — real photos are still needed.
- No favicon yet (Phase 6).
