# Jono Advertising — jonoads.com

Marketing site for Jono Advertising, built on Laravel with a Filament admin panel
so the team can edit stats, case studies, team bios and testimonials without a
developer.

## Status

Phase 1 of 6 (Foundation) is complete. The site renders from Blade templates
through Laravel; page content is still inline in the views and moves into the
database in Phase 2/4.

| Phase | Scope | State |
|-------|-------|-------|
| 1 | Foundation — app skeleton, Vite, shared layout, routes | Done |
| 2 | Data layer — migrations, models, content seeders | Not started |
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
