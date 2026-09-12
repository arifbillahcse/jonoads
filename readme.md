# Jono Advertising — jonoads.com

Marketing site for Jono Advertising, built on Laravel with a Filament admin panel
so the team can edit stats, case studies, team bios and testimonials without a
developer.

## Status

All six phases are complete. The site runs on Laravel with a Filament admin
panel, renders entirely from the database, captures leads, and is ready to
deploy — see [docs/deployment.md](docs/deployment.md).

The one thing still outstanding is content, not code: real team headshots and
two or three more client testimonials. Both are listed under Known gaps.

| Phase | Scope | State |
|-------|-------|-------|
| 1 | Foundation — app skeleton, Vite, shared layout, routes | Done |
| 2 | Data layer — migrations, models, content seeders | Done |
| 3 | Filament admin panel — 16 resources, roles, settings | Done |
| 4 | Blade port — sections read from the database | Done |
| 5 | Forms & lead capture | Done |
| 6 | QA, hardening, launch prep | Done |

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

## Admin panel

The panel is at `/admin`. Sign in with the account created by `AdminUserSeeder`
— set `ADMIN_EMAIL` and `ADMIN_PASSWORD` in `.env` before seeding, or it falls
back to `admin@jonoads.com` / `password` for local work.

Navigation is grouped so the panel maps onto the site rather than the schema:

| Group | Screens |
|-------|---------|
| Homepage | Stats, Brand logos |
| Content | Services, ROAS Engine, Case studies, Testimonials, Comparison metrics, Comparison checklist, SMB industries, Engagement models, SMB page |
| People | Team members, Partners, Locations |
| Leads | Enquiries, Subscribers |
| Settings | Site settings, Panel users |

Notes on how it behaves:

- **Roles.** `admin` sees everything; `editor` sees content but not Settings or
  Panel users. The role lives on the user record — no permissions package.
- **Nested content edits inline.** Service capabilities, ROAS step checklists,
  engagement items and case-study results are repeaters on their parent record,
  so there are 16 screens for 21 tables.
- **Ordering is drag-and-drop** wherever the site renders a hand-ordered list,
  writing to `sort_order`.
- **The ROAS Engine has no create button** — the diagram is a fixed three-stage
  cycle, so a fourth step would break it.
- **Enquiries and subscribers are read-mostly**: they arrive from the site, so
  neither has a create action. Enquiries carry a status workflow, internal notes,
  and a navigation badge counting anything still marked new.
- **Dashboard** shows unhandled enquiries and subscriber counts, plus a content
  health panel flagging missing headshots, a thin testimonial section, and
  anything left unpublished.

## How a page is built

Each page view is mostly layout; the content comes from section components in
`resources/views/components/section/`, which read through `App\Support\SiteContent`:

```
resources/views/pages/home.blade.php     headings, CTAs, section scaffolding
  └── <x-section.case-grid />            queries + renders the case studies
        └── <x-stat-number :stat="…" />  the animated counter markup
app/Support/SiteContent.php              every public query, cached
```

`SiteContent` caches each query indefinitely. The `FlushesSiteContentCache`
trait clears that cache whenever any content model is saved, deleted or
restored — including child records, so editing one repeater item is enough.

The counters, ROAS ring, comparison bars and scroll reveals are unchanged: the
JavaScript still reads the same `data-target` / `data-prefix` / `data-suffix`
attributes, which are now printed from database values rather than typed by hand.

## Forms

Both public forms post to the application and persist. Nothing is faked.

| Route | Does |
|-------|------|
| `POST /contact` | Validates, stores a `ContactLead`, emails the team |
| `POST /newsletter` | Stores a pending subscriber, sends a confirmation link |
| `GET /newsletter/confirm/{token}` | Confirms, then burns the token so the link works once |
| `GET /newsletter/unsubscribe/{subscriber}` | Signed link; marks the subscriber unsubscribed |

**Spam handling.** Each form carries a honeypot field and an encrypted
timestamp; a filled honeypot or a submission faster than two seconds is
rejected. The timestamp is encrypted so it cannot be replayed or back-dated.
Both routes are rate limited per IP. There is deliberately no CAPTCHA — these
checks cost a real prospect nothing.

**Failure handling.** The enquiry is written to the database before the
notification is attempted, so an SMTP outage never loses a lead or shows the
sender an error; the failure is logged and the lead still appears in the panel.

**Export.** Both lead lists have an Export CSV button that streams whatever the
current filter and search show. Filament ships a queue-backed exporter, but it
needs three extra tables and a running worker — for lists this size a
synchronous stream is the better trade.

Run the tests with:

```bash
composer test
```

## SEO, accessibility and security

- **Metadata** on every page: canonical URL, Open Graph and Twitter card tags,
  and Organization JSON-LD carrying the contact address and office cities.
- **`/sitemap.xml` and `/robots.txt`** are routes, not static files, so the
  sitemap carries absolute URLs for whichever domain the app runs on. Robots
  keeps crawlers out of `/admin` and the one-time newsletter links.
- **Share card** at `public/share-card.png`, generated by
  `tools/generate-share-card.php`. It uses a substitute typeface because the
  brand faces are licensed through Google Fonts for web use only — upload real
  artwork under Settings and it takes precedence.
- **Favicon** is an SVG built from the wordmark, so it stays sharp at any size.
- **Accessibility**: a skip link ahead of the nav, content in a `<main>`
  landmark, labelled form fields with errors tied via `aria-describedby`, and
  visible focus states. Reduced-motion was already honoured.
- **Error pages** for 404, 419, 500 and 503, styled like the site rather than
  Laravel's defaults. The 419 page explains what an expired form means.
- **Security headers** on every response: `X-Content-Type-Options`,
  `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy`, plus HSTS once
  requests are over TLS. There is deliberately no CSP yet — Filament and Vite
  both need inline scripts, and a half-right CSP breaks the panel for no real
  gain.

## Data model

21 tables hold the content that was previously hardcoded in HTML. Child tables
are edited inline on their parent in the admin panel, which is why 21 tables
become 16 admin screens.

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
- Bios and case-study detail copy are stored newline-separated and split into
  paragraphs on render, so an editor gets paragraphs without writing HTML.
- One result per case study can be flagged as the headline. On the featured case
  study that flag drives both the section heading and the before/after chart.

## Configuration

Values surfaced in the site come from config rather than hardcoded markup:

| Setting | Env key | Used by |
|---------|---------|---------|
| Contact address | `MAIL_CONTACT_ADDRESS` | Footer, enquiry notifications |
| Skool community | `SKOOL_URL` | Footer |

## Deployment

See [docs/deployment.md](docs/deployment.md) for the server requirements, the
first and subsequent deploy steps, the queue worker and scheduler config, a
backup script, and a go-live checklist.

**No shell access?** `install.php` in the project root is a one-time browser
installer for cPanel-style hosting: it checks requirements, takes the database
and admin details, then writes `.env`, migrates, seeds and caches. It cannot run
Composer, so upload `vendor/` and `public/build/` with the files — no local PHP
or Node either? The **Build upload-ready release** GitHub Actions workflow
builds both in CI and hands you a ready-to-upload zip. It locks and deletes
itself when finished — see the cPanel section of the deployment doc.

## Known gaps

- The `Podcast` and `Merch` footer links point at anchors that do not exist yet;
  both depend on add-ons that are not in the core scope. Set their URLs under
  Settings once those exist.
- Team cards show initials rather than headshots — real photos are still needed.
- Sending the newsletter itself is not built; the signup list is exportable for
  whatever platform sends it. Connecting an ESP is a priced add-on.
