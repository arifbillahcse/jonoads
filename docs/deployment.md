# Deployment

The app is a standard Laravel 12 deployment: PHP 8.2+, a database, a queue
worker, and a web server pointed at `public/`. Nothing here needs Docker or a
build server.

## Server requirements

| Need | Notes |
|------|-------|
| PHP 8.2+ | with `pdo_mysql`, `mbstring`, `gd`, `intl`, `zip`, `curl` |
| MySQL 8 or MariaDB 10.6+ | Postgres works too; change `DB_CONNECTION` |
| Node 20+ | only to build assets — not needed at runtime |
| Composer 2 | |
| A cron entry | for Laravel's scheduler |
| A queue worker | Supervisor, or the host's process manager |

## First deploy

```bash
git clone <repo> /var/www/jonoads && cd /var/www/jonoads

composer install --no-dev --optimize-autoloader
npm ci && npm run build

cp .env.example .env
php artisan key:generate
```

Fill in `.env` before going further — at minimum `APP_URL`, the `DB_*` block,
the `MAIL_*` block, and `ADMIN_EMAIL` / `ADMIN_PASSWORD`. Then:

```bash
php artisan migrate --force
php artisan db:seed --force        # imports the site copy; first deploy only
php artisan storage:link           # so uploaded images resolve
```

Point the web server's document root at `public/`, not the project root.

### Environment values that matter

| Key | Why |
|-----|-----|
| `APP_ENV=production`, `APP_DEBUG=false` | `APP_DEBUG=true` in production leaks stack traces |
| `APP_URL` | absolute URLs in the sitemap, emails and signed unsubscribe links |
| `ADMIN_EMAIL`, `ADMIN_PASSWORD` | the first panel login; set before seeding |
| `MAIL_CONTACT_ADDRESS` | where enquiry notifications go |
| `MAIL_MAILER=smtp` | it defaults to `log`, which writes mail to a file instead of sending |

## Every deploy after that

```bash
php artisan down --render="errors::503"

git pull
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force

php artisan optimize          # config, route, view and event caches
php artisan queue:restart     # workers keep old code in memory otherwise

php artisan up
```

`php artisan optimize` is the one step people forget. Without it every request
re-parses config and routes, and with a stale cache a deploy can appear to
change nothing at all.

## Queue worker

Confirmation emails and enquiry notifications go through the queue. Without a
worker the site still works — mail just never leaves.

```ini
[program:jonoads-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/jonoads/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/jonoads/storage/logs/worker.log
stopwaitsecs=3600
```

## Scheduler

```cron
* * * * * cd /var/www/jonoads && php artisan schedule:run >> /dev/null 2>&1
```

## Backups

No backup package is installed, so this is a cron job. Adjust the retention and
destination to suit the host:

```bash
#!/usr/bin/env bash
# /usr/local/bin/jonoads-backup — run daily from cron
set -euo pipefail

STAMP=$(date +%F)
DEST=/var/backups/jonoads
mkdir -p "$DEST"

mysqldump --single-transaction --quick jonoads | gzip > "$DEST/db-$STAMP.sql.gz"
tar -czf "$DEST/uploads-$STAMP.tar.gz" -C /var/www/jonoads storage/app/public

# Keep 30 days
find "$DEST" -name '*.gz' -mtime +30 -delete
```

Test the restore, not just the backup — an untested backup is a guess.

## After going live

- [ ] `APP_DEBUG=false` confirmed in the deployed `.env`
- [ ] HTTPS enforced; the app sets HSTS automatically once requests are secure
- [ ] `/robots.txt` and `/sitemap.xml` both load on the real domain
- [ ] Submit a test enquiry, confirm it appears under **Leads** and the email lands
- [ ] Subscribe with a real address and complete the double opt-in
- [ ] Sign in to `/admin` and change the seeded admin password
- [ ] Upload real team headshots — cards fall back to initials without them
- [ ] Replace the default share card under **Settings** if brand artwork exists
- [ ] Run Lighthouse on the homepage and the contact page

## Rollback

```bash
php artisan down --render="errors::503"
git reset --hard <previous-sha>
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan optimize
php artisan queue:restart
php artisan up
```

Migrations are not rolled back automatically. If the bad deploy migrated, decide
deliberately: `php artisan migrate:rollback --step=1` drops whatever that
migration created, including any data in it.
