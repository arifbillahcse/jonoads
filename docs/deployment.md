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
```

No `storage:link` step — uploaded images (logos, headshots, the hero photo) save
directly into `public/storage/`, a real folder rather than the symlink Laravel
normally creates. Several hosts this site has run on block Apache from
following that symlink at all, which shows up as a 403 on every uploaded
image with the rest of the site working fine, and it's not always something a
project-level `.htaccess` can override. Writing straight into `public/`
avoids the question entirely, symlink-friendly host or not.

**Moving an existing deployment onto this?** If `public/storage` is currently
a symlink (from before this change), remove it and let uploads carry across
to the new real folder:

```bash
rm public/storage                              # removes the symlink, not its target
mkdir -p public/storage
cp -r storage/app/public/. public/storage/     # carries over anything already uploaded
chmod -R 755 public/storage
```

Point the web server's document root at `public/`, not the project root.

**Seeing a 403 instead of the site?** That is what a server returns when the
document root has no `index.php` in it and directory listing is off — in other
words, when the domain is pointing at the project folder rather than `public/`.
Fix the document root if you can. Where the host won't allow it, the `.htaccess`
in the project root forwards requests into `public/` and refuses `.env` and the
application folders, so the site works either way. A 403 can also mean the files
aren't readable by the web server: folders should be 755 and files 644, owned by
the hosting account rather than root.

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

## Installing without shell access (cPanel)

`install.php` in the project root does the half of a deploy that needs no
terminal. It cannot run Composer — resolving Laravel and Filament needs more
memory and time than a web request gets, and `exec()` is disabled on most shared
hosting — so the dependencies have to arrive with the upload.

**Before uploading**, on any machine with PHP and Node:

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build
```

Then zip the project *including* `vendor/` and `public/build/`, and upload it
through cPanel → File Manager.

**No machine with PHP/Node either?** Use the `Build upload-ready release`
GitHub Actions workflow (`.github/workflows/build-release.yml`). Open the
repo's **Actions** tab → select it → **Run workflow**. It installs Composer
and npm dependencies in CI, builds the assets, and uploads a
`jonoads-release.zip` to the finished run's **Artifacts** section — download
that and upload it straight through cPanel File Manager (extract it into the
project root, replacing/merging with what's already there). It also runs
automatically on every push to `claude/project-structure-assets-h4hobt`, so a
fresh zip is always waiting after a deploy.

Until `vendor/autoload.php` and `public/build/manifest.json` both exist on the
server, `install.php` shows those two checks in red and keeps the submit
button disabled — that's the installer refusing to run against an incomplete
upload, not a bug.

**If your host allows shell commands from PHP**, the failing "Composer
dependencies uploaded" row shows a **Try to run Composer now** button — enter
the setup code and it looks for Composer on the server and runs
`composer install` directly from the web request, showing the real output
either way. Most shared hosting disables `exec()`/`shell_exec()`/`proc_open()`
specifically to prevent this, so expect it to say so and fall back to
uploading `vendor/` yourself — that's the expected outcome on a locked-down
host, not a broken feature. It still cannot build `public/build/`, since that
needs Node, not Composer.

### Deploying via cPanel's Git Version Control instead

If you're pulling the repo straight from GitHub with cPanel's **Git™ Version
Control** feature rather than uploading a zip, point the repository at this
project as usual, and set the domain/subdomain's **Document Root** to the
repo's `public/` subfolder (e.g.
`/home/USER/repositories/jonoads/public`) — not the repo root. That keeps
`.env` and the application code outside the web root, the same as the zip
upload path above.

A `.cpanel.yml` at the project root runs automatically whenever you click
**Deploy HEAD Commit** in the Git Version Control UI. It runs
`composer install --no-dev` in place, so `vendor/` is rebuilt on every deploy
without needing a zip or a shell — this only works because Composer happens
to be available on this host (check cPanel → Software → Composer); if it
isn't, skip straight to the zip-upload steps above instead.

Node.js is a separate matter: most shared hosts don't offer it, so
`public/build/` still won't exist after a Git deploy. Build it once with the
**Build upload-ready release** GitHub Actions workflow (see above), then from
the downloaded `jonoads-release.zip` extract just the `public/build/` folder
and upload it into the cloned repo's `public/build/` via File Manager — you
don't need the rest of the zip, since Git and `.cpanel.yml` already handle
the code and `vendor/`. Re-do this only when front-end assets change; a plain
code deploy doesn't touch `public/build/`.

If a deploy task fails, cPanel shows the task output right in the Git Version
Control UI after you click Deploy — the likeliest failure is the Composer
binary path in `.cpanel.yml` not matching this host; cPanel → Software →
Composer names the correct path to swap in.

**"Deploy HEAD Commit" is greyed out even with a valid `.cpanel.yml` and no
uncommitted changes?** That means shell/SSH access is disabled for this
account — cPanel's deployment tasks need it even though Git cloning itself
doesn't. `.cpanel.yml` cannot help here. Try `install.php`'s **Try to run
Composer now** button instead (see above) — it uses PHP's own
`exec`/`shell_exec`/`proc_open` rather than cPanel's deploy mechanism, so it
sometimes works even when Deploy is blocked. If that also reports shell
execution is disabled, this host blocks it at the PHP level too, and there's
no way around it short of building `vendor/` elsewhere and uploading it.

**Point the domain at `public/`**, not the project root — cPanel → Domains →
Document Root. Serving the project root exposes `.env` to the web. The installer
checks this and warns you.

**Create the database** under cPanel → MySQL Databases: a database, a user, and
All Privileges for that user on it.

**Then visit `https://yourdomain.com/install.php`.** It will:

1. Check PHP version, extensions and folder permissions
2. Ask for the setup code in `storage/app/install-token.txt` — being able to
   read that file is what proves you own the server rather than just finding
   the page
3. Take the database, admin and SMTP details
4. Write `.env`, generate the app key, migrate, seed, link storage, cache config

On success it writes `storage/installed.lock`, deletes the token and tries to
delete itself.

> **Delete `install.php` afterwards.** It usually removes itself, but if the
> file is not writable it cannot, and it will say so. Left in place, anyone who
> finds the URL could repoint the site at their own database.

To reinstall deliberately, delete `storage/installed.lock` first.
