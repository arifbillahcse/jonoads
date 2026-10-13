# Jono Advertising

Marketing site for Jono Advertising, built on Laravel 12 with a Filament 4
admin panel. Content (hero image, logo, Calendly/booking link, team members,
case studies, testimonials, services, stats, etc.) is managed through the
admin panel rather than hard-coded in the templates.

## Stack

**Backend**
- PHP 8.2+
- Laravel 12 (`laravel/framework`) — routing, Eloquent, Blade, queues, caching
- Filament 4 (`filament/filament`) — the `/admin` panel used to manage all
  site content (pages, settings, uploads) without touching code
- Laravel Tinker (`laravel/tinker`) — REPL for debugging via `php artisan tinker`

**Frontend**
- Blade templates (`resources/views/`), no separate JS framework/SPA
- Plain JS and CSS, each built as a single bundle: `resources/js/app.js`
  and `resources/css/app.css`
- Vite 6 (via `laravel-vite-plugin`) compiles and hashes those into
  `public/build/`; `npm run dev` for local hot-reload, `npm run build`
  for the production bundle
- Google Fonts (Josefin Sans, Inter) loaded directly in the layout

**Database**
- SQLite for local development (`DB_CONNECTION=sqlite`, zero setup)
- MySQL in production (`DB_CONNECTION=mysql`)
- Sessions, cache, and queue all back onto the database connection
  (`SESSION_DRIVER=database`, `CACHE_STORE=database`,
  `QUEUE_CONNECTION=database`) — no separate Redis/Memcached dependency

**Storage**
- Local disk (`FILESYSTEM_DISK=local`) — uploaded files (team photos,
  logos, etc.) live under `storage/app/public/`, served via the
  `php artisan storage:link` symlink at `public/storage`

**Dev tooling**
- Laravel Pint (`laravel/pint`) — code style
- PHPUnit (`phpunit/phpunit`) + Mockery — tests, run via `composer test`
- Faker (`fakerphp/faker`) — fake data in seeders/factories
- Laravel Sail / Pail — optional Docker dev environment / log tailing,
  not required for this project's actual deploy target (shared hosting)

**Mail**
- `log` driver locally (writes to `storage/logs` instead of sending);
  swap `MAIL_MAILER` to `smtp` in production for real delivery of
  contact-form notifications

## Local setup

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite   # local DB (DB_CONNECTION=sqlite)
php artisan migrate --seed

npm run dev      # Vite dev server
php artisan serve
```

Admin panel: `/admin`. The first admin user is created by
`AdminUserSeeder` from `ADMIN_EMAIL` / `ADMIN_PASSWORD` / `ADMIN_NAME` in
`.env` (see `.env.example` for defaults — leave `ADMIN_PASSWORD` unset
locally rather than blank, since a blank value still counts as "set").

## Production deploy notes

- Set `APP_ENV=production`, `APP_DEBUG=false`, and a real `APP_URL`
  (used in the sitemap, emails, and signed links).
- Switch `DB_CONNECTION` to `mysql` and fill in the `DB_*` credentials.
- Run `php artisan storage:link` so uploaded files (team photos, logos,
  etc. in `storage/app/public/`) are reachable at `/storage/...`. On
  hosts where the web root is a separate folder from the Laravel project
  root (common on shared hosting), the symlink has to exist *inside that
  web root*, not just inside the project's own `public/` folder.
- After editing `.env` on a server where `config:cache` has ever been
  run, run `php artisan config:clear` (or re-run `config:cache`) —
  cached config otherwise keeps using the old values.
- `storage/framework/{cache,sessions,views}` and `bootstrap/cache` must
  exist and be writable. These are empty directories kept in git only via
  `.gitignore` placeholders, so a zip-based upload/deploy can silently
  drop them — if so, recreate them manually.
- `install.php` (project root) is a standalone diagnostic script for
  non-SSH / cPanel-style deploys: it checks directory writability,
  whether `vendor/` and `public/build/` exist, etc. Safe to run from the
  browser when setting up on a host without shell access; not needed
  otherwise.

Migrating content from one environment to another requires two separate
steps — neither alone is enough:
1. **Database rows** (e.g. `mysqldump --no-create-info --complete-insert`
   from the source DB, imported into the destination DB).
2. **Uploaded files** — anything referenced from `storage/app/public/`
   (team photos, uploaded logos, etc.) are real files, not in git, and
   have to be copied separately (e.g. tar the folder on the old host,
   extract it into the same path on the new one).

## One-off `Fix*` commands

`app/Console/Commands/Fix*.php` are one-off Artisan commands used to patch
a specific piece of already-seeded content on a live deployment (e.g.
`php artisan fix:booking-url`), without re-running the full seeder set and
risking duplicate-key errors. They're safe to re-run and are kept even
once stale — each one is a dated record of a real content change, not
meant to be deleted or edited after the fact.

## Testing

```bash
composer test
```
