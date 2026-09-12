<?php

/**
 * One-time browser installer for hosts without shell access (cPanel and similar).
 *
 * It does the half of a deploy that does NOT need a terminal: writes .env,
 * generates the app key, runs migrations and seeders, links storage and warms
 * the caches. It deliberately does not try to run Composer — resolving Laravel
 * and Filament needs far more memory and time than a web request gets, and
 * exec() is disabled on most shared hosting. Upload `vendor/` and
 * `public/build/` with the rest of the files.
 *
 * Security: reading the generated token proves you have real file access to the
 * server, not just the URL. After a successful run the installer locks itself,
 * deletes the token and tries to delete this file. If it cannot, it says so —
 * delete install.php yourself. Leaving it in place would let anyone who finds
 * the URL repoint your database.
 */

declare(strict_types=1);

// Migrating and seeding on shared hosting is slow; give it room.
@set_time_limit(0);
@ini_set('memory_limit', '512M');

const MIN_PHP_VERSION = '8.2.0';

/** Laravel's own requirements, plus what Filament needs for image uploads. */
const REQUIRED_EXTENSIONS = [
    'bcmath', 'ctype', 'curl', 'dom', 'fileinfo', 'filter', 'hash', 'mbstring',
    'openssl', 'pcre', 'pdo', 'session', 'tokenizer', 'xml', 'gd',
];

$root = __DIR__;
$lockFile = $root . '/storage/installed.lock';
$tokenFile = $root . '/storage/app/install-token.txt';

// ---------------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------------

function h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function field(string $key, string $default = ''): string
{
    return trim((string) ($_POST[$key] ?? $default));
}

/** A check row: passed, a label, and what to do when it has not. */
function check(string $label, bool $ok, string $detail = ''): array
{
    return ['label' => $label, 'ok' => $ok, 'detail' => $detail];
}

function requirementChecks(string $root): array
{
    $rows = [
        check(
            'PHP ' . MIN_PHP_VERSION . ' or newer',
            version_compare(PHP_VERSION, MIN_PHP_VERSION, '>='),
            'Running ' . PHP_VERSION . '. Change it under cPanel → Select PHP Version.'
        ),
    ];

    foreach (REQUIRED_EXTENSIONS as $extension) {
        $rows[] = check(
            'Extension: ' . $extension,
            extension_loaded($extension),
            'Enable it under cPanel → Select PHP Version → Extensions.'
        );
    }

    $rows[] = check(
        'Composer dependencies uploaded',
        is_file($root . '/vendor/autoload.php'),
        'vendor/ is missing. Build it elsewhere and upload it — this installer cannot run Composer.'
    );

    $rows[] = check(
        'Front-end assets built',
        is_file($root . '/public/build/manifest.json'),
        'public/build/ is missing. Run "npm run build" elsewhere and upload the result.'
    );

    foreach (['storage', 'storage/app', 'storage/framework', 'storage/logs', 'bootstrap/cache'] as $path) {
        $full = $root . '/' . $path;
        $rows[] = check(
            'Writable: ' . $path,
            is_dir($full) && is_writable($full),
            'Set this folder to 755 (or 775) in cPanel → File Manager → Permissions.'
        );
    }

    $rows[] = check(
        'Project root writable (for .env)',
        is_writable($root),
        'The installer needs to create a .env file here.'
    );

    return $rows;
}

/**
 * cPanel serves public_html, but Laravel must be served from public/. Getting
 * this wrong exposes .env to the web, so it is worth saying plainly.
 */
function documentRootAdvice(string $root): array
{
    $docRoot = realpath((string) ($_SERVER['DOCUMENT_ROOT'] ?? '')) ?: '';
    $public = realpath($root . '/public') ?: '';
    $appRoot = realpath($root) ?: '';

    if ($docRoot !== '' && $docRoot === $public) {
        return ['ok' => true, 'message' => 'The domain already points at public/. Nothing to change.'];
    }

    if ($docRoot !== '' && $docRoot === $appRoot) {
        return [
            'ok' => false,
            'message' => 'The domain points at the project root, which exposes .env and storage/ to the web. '
                . 'Point the document root at ' . $public . ' under cPanel → Domains, or move these files above '
                . 'public_html and put the contents of public/ inside it.',
        ];
    }

    return [
        'ok' => false,
        'message' => 'Could not confirm the document root (it reports ' . ($docRoot ?: 'nothing')
            . '). Make sure the domain serves ' . ($public ?: $root . '/public') . ' and not the project root.',
    ];
}

/** Proves the person running this has file access, not just the URL. */
function ensureToken(string $tokenFile): string
{
    if (is_file($tokenFile)) {
        return trim((string) file_get_contents($tokenFile));
    }

    @mkdir(dirname($tokenFile), 0755, true);
    $token = bin2hex(random_bytes(16));
    file_put_contents($tokenFile, $token);

    return $token;
}

function tokenIsValid(string $tokenFile, string $given): bool
{
    if (! is_file($tokenFile) || $given === '') {
        return false;
    }

    return hash_equals(trim((string) file_get_contents($tokenFile)), trim($given));
}

function testDatabase(array $db): ?string
{
    try {
        new PDO(
            sprintf('mysql:host=%s;port=%s;dbname=%s', $db['host'], $db['port'], $db['name']),
            $db['user'],
            $db['pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 5],
        );

        return null;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

function envQuote(string $value): string
{
    // Quote anything with whitespace or characters dotenv would choke on.
    return preg_match('/[\s"#\'=]/', $value) ? '"' . addcslashes($value, '"\\') . '"' : $value;
}

function writeEnvFile(string $root, array $data): void
{
    $key = 'base64:' . base64_encode(random_bytes(32));

    $lines = [
        'APP_NAME=' . envQuote($data['app_name']),
        'APP_ENV=production',
        'APP_KEY=' . $key,
        'APP_DEBUG=false',
        'APP_URL=' . envQuote($data['app_url']),
        '',
        'LOG_CHANNEL=stack',
        'LOG_LEVEL=error',
        '',
        'DB_CONNECTION=mysql',
        'DB_HOST=' . envQuote($data['db']['host']),
        'DB_PORT=' . envQuote($data['db']['port']),
        'DB_DATABASE=' . envQuote($data['db']['name']),
        'DB_USERNAME=' . envQuote($data['db']['user']),
        'DB_PASSWORD=' . envQuote($data['db']['pass']),
        '',
        'SESSION_DRIVER=database',
        'SESSION_LIFETIME=120',
        'CACHE_STORE=database',
        'QUEUE_CONNECTION=database',
        'FILESYSTEM_DISK=local',
        '',
        'MAIL_MAILER=' . envQuote($data['mail']['mailer']),
        'MAIL_HOST=' . envQuote($data['mail']['host']),
        'MAIL_PORT=' . envQuote($data['mail']['port']),
        'MAIL_USERNAME=' . envQuote($data['mail']['user']),
        'MAIL_PASSWORD=' . envQuote($data['mail']['pass']),
        'MAIL_FROM_ADDRESS=' . envQuote($data['mail']['from']),
        'MAIL_FROM_NAME=' . envQuote($data['app_name']),
        'MAIL_CONTACT_ADDRESS=' . envQuote($data['mail']['contact']),
        '',
        '# The first panel login, created by the seeder.',
        'ADMIN_NAME=' . envQuote($data['admin']['name']),
        'ADMIN_EMAIL=' . envQuote($data['admin']['email']),
        'ADMIN_PASSWORD=' . envQuote($data['admin']['pass']),
        '',
        'SKOOL_URL=https://www.skool.com',
        '',
    ];

    file_put_contents($root . '/.env', implode("\n", $lines));
    @chmod($root . '/.env', 0600);
}

/**
 * Boots the framework in-process and runs the artisan commands a deploy needs.
 * Returns one row per command so the result page can show what happened.
 */
function runInstallCommands(string $root): array
{
    require_once $root . '/vendor/autoload.php';

    /** @var \Illuminate\Foundation\Application $app */
    $app = require $root . '/bootstrap/app.php';

    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    $steps = [
        ['Clearing stale caches', 'config:clear', []],
        ['Creating database tables', 'migrate', ['--force' => true]],
        ['Loading site content', 'db:seed', ['--force' => true]],
        ['Linking uploaded files', 'storage:link', []],
        ['Caching config and routes', 'optimize', []],
    ];

    $results = [];

    foreach ($steps as [$label, $command, $arguments]) {
        try {
            $status = $kernel->call($command, $arguments);
            $output = trim($kernel->output());
            $results[] = [
                'label' => $label,
                'ok' => $status === 0,
                // storage:link is the one that commonly fails on shared hosting,
                // and the site still works without it apart from uploaded images.
                'fatal' => $status !== 0 && $command !== 'storage:link',
                'output' => $output,
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'label' => $label,
                'ok' => false,
                'fatal' => $command !== 'storage:link',
                'output' => $e->getMessage(),
            ];
        }
    }

    return $results;
}

// ---------------------------------------------------------------------------
// Flow
// ---------------------------------------------------------------------------

$alreadyInstalled = is_file($lockFile);
$action = (string) ($_POST['action'] ?? '');
$errors = [];
$results = [];
$installed = false;

$requirements = requirementChecks($root);
$requirementsMet = ! in_array(false, array_column($requirements, 'ok'), true);
$docRoot = documentRootAdvice($root);

$token = $alreadyInstalled ? '' : ensureToken($tokenFile);
$givenToken = field('token');

if (! $alreadyInstalled && $action === 'install') {
    if (! tokenIsValid($tokenFile, $givenToken)) {
        $errors[] = 'That setup code is not correct. Open storage/app/install-token.txt in cPanel File Manager and copy the value exactly.';
    }

    if (! $requirementsMet) {
        $errors[] = 'Some requirements are still failing. Fix the red rows above and reload this page.';
    }

    $data = [
        'app_name' => field('app_name', 'Jono Advertising'),
        'app_url' => rtrim(field('app_url'), '/'),
        'db' => [
            'host' => field('db_host', 'localhost'),
            'port' => field('db_port', '3306'),
            'name' => field('db_name'),
            'user' => field('db_user'),
            'pass' => field('db_pass'),
        ],
        'admin' => [
            'name' => field('admin_name', 'Site Admin'),
            'email' => field('admin_email'),
            'pass' => field('admin_pass'),
        ],
        'mail' => [
            'mailer' => field('mail_mailer', 'smtp'),
            'host' => field('mail_host'),
            'port' => field('mail_port', '587'),
            'user' => field('mail_user'),
            'pass' => field('mail_pass'),
            'from' => field('mail_from'),
            'contact' => field('mail_contact'),
        ],
    ];

    if ($data['app_url'] === '' || ! filter_var($data['app_url'], FILTER_VALIDATE_URL)) {
        $errors[] = 'Enter the full site address, including https://';
    }

    if ($data['db']['name'] === '' || $data['db']['user'] === '') {
        $errors[] = 'Database name and username are both required.';
    }

    if (! filter_var($data['admin']['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address for the admin login.';
    }

    if (strlen($data['admin']['pass']) < 12) {
        $errors[] = 'Use an admin password of at least 12 characters — this login can edit the whole site.';
    }

    if (! $errors) {
        if ($dbError = testDatabase($data['db'])) {
            $errors[] = 'Could not connect to the database: ' . $dbError;
        }
    }

    if (! $errors) {
        writeEnvFile($root, $data);
        $results = runInstallCommands($root);
        $fatal = array_filter($results, fn (array $r): bool => $r['fatal']);

        if (! $fatal) {
            $installed = true;
            file_put_contents($lockFile, date('c'));
            @unlink($tokenFile);
            // Best effort — the success page checks and says so if it survived.
            @unlink(__FILE__);
        } else {
            $errors[] = 'Installation stopped. The details are below; fix the cause and run this page again.';
        }
    }
}

$selfRemains = is_file(__FILE__);

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title>Install — Jono Advertising</title>
<style>
  :root {
    --black: #0a0a0a; --near-black: #0e1012; --surface: #14171a;
    --line: rgba(255,255,255,.12); --white: #fff; --muted: #8b96a0;
    --cyan: #35c1f1; --good: #4ec9a0; --bad: #f2777a; --warn: #f0c674;
  }
  * { box-sizing: border-box; }
  body {
    margin: 0; background: var(--black); color: var(--white);
    font: 16px/1.6 -apple-system, BlinkMacSystemFont, "Segoe UI", Inter, sans-serif;
    padding: 40px 20px;
  }
  .wrap { max-width: 760px; margin: 0 auto; }
  h1 { font-size: 1.9rem; margin: 0 0 6px; letter-spacing: -.01em; }
  h2 { font-size: 1.05rem; margin: 34px 0 12px; }
  .dot { color: var(--cyan); }
  .lede { color: var(--muted); margin: 0 0 28px; }
  .card { background: var(--surface); border: 1px solid var(--line); border-radius: 6px; padding: 22px; margin-bottom: 20px; }
  .rows { display: flex; flex-direction: column; gap: 2px; }
  .row { display: grid; grid-template-columns: 22px 1fr; gap: 10px; padding: 5px 0; font-size: .9rem; align-items: start; }
  .row .mark { font-weight: 700; }
  .ok .mark { color: var(--good); } .no .mark { color: var(--bad); }
  .row small { display: block; color: var(--muted); font-size: .82rem; }
  label { display: block; font-size: .82rem; font-weight: 600; margin-bottom: 6px; }
  input, select {
    width: 100%; background: var(--near-black); border: 1px solid var(--line);
    border-radius: 4px; color: var(--white); font: inherit; font-size: .93rem; padding: 10px 12px;
  }
  input:focus, select:focus { outline: none; border-color: var(--cyan); }
  .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  .field { margin-bottom: 16px; min-width: 0; }
  .hint { color: var(--muted); font-size: .8rem; margin-top: 5px; }
  button {
    background: var(--cyan); color: var(--black); border: 0; border-radius: 999px;
    font: inherit; font-weight: 700; padding: 13px 30px; cursor: pointer;
  }
  button[disabled] { opacity: .4; cursor: not-allowed; }
  .alert { border-radius: 4px; padding: 14px 16px; margin-bottom: 18px; font-size: .9rem; }
  .alert-bad { background: rgba(242,119,122,.12); border: 1px solid var(--bad); }
  .alert-warn { background: rgba(240,198,116,.1); border: 1px solid var(--warn); }
  .alert-good { background: rgba(78,201,160,.1); border: 1px solid var(--good); }
  .alert ul { margin: 8px 0 0; padding-left: 18px; }
  code { background: var(--near-black); border: 1px solid var(--line); border-radius: 3px; padding: 1px 6px; font-size: .86rem; word-break: break-all; }
  pre { background: var(--near-black); border: 1px solid var(--line); border-radius: 4px; padding: 10px 12px; font-size: .78rem; overflow-x: auto; color: var(--muted); margin: 6px 0 0; }
  ol { padding-left: 20px; } ol li { margin-bottom: 10px; }
  @media (max-width: 620px) { .grid { grid-template-columns: 1fr; } }
</style>
</head>
<body>
<div class="wrap">

<h1>Jono<span class="dot">.</span> installer</h1>

<?php if ($alreadyInstalled && ! $installed): ?>

  <p class="lede">This site is already installed.</p>
  <div class="alert alert-warn">
    <strong>Delete <code>install.php</code> now.</strong>
    Left in place, anyone who finds this URL could point your site at their own database.
    <?php if (! $selfRemains): ?>
      <br><br>It appears to have removed itself already — refresh to confirm you get a 404.
    <?php endif; ?>
  </div>
  <p class="hint">
    To install again deliberately, delete <code>storage/installed.lock</code> first.
  </p>

<?php elseif ($installed): ?>

  <p class="lede">Done. The site is live.</p>

  <div class="alert alert-good"><strong>Installation finished.</strong></div>

  <?php if ($selfRemains): ?>
  <div class="alert alert-bad">
    <strong>One thing left: delete <code>install.php</code>.</strong>
    It could not remove itself — open cPanel → File Manager, find <code>install.php</code>
    in the project root and delete it. Until you do, anyone with this URL can reconfigure your site.
  </div>
  <?php endif; ?>

  <div class="card">
    <div class="rows">
      <?php foreach ($results as $result): ?>
      <div class="row <?= $result['ok'] ? 'ok' : 'no' ?>">
        <span class="mark"><?= $result['ok'] ? '✓' : '!' ?></span>
        <span>
          <?= h($result['label']) ?>
          <?php if (! $result['ok'] && $result['output'] !== ''): ?>
            <small>Continued without this. <?= h($result['output']) ?></small>
          <?php endif; ?>
        </span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <h2>Next</h2>
  <ol>
    <li>Delete <code>install.php</code> if it is still there.</li>
    <li>Sign in at <code><?= h(field('app_url')) ?>/admin</code> and change the password you just set.</li>
    <li>Send a test enquiry from the contact page and check it appears under <strong>Leads</strong>.</li>
    <li>Upload team headshots — cards show initials until you do.</li>
  </ol>

<?php else: ?>

  <p class="lede">
    Sets up the database and configuration. Composer and npm are not run here —
    upload <code>vendor/</code> and <code>public/build/</code> with the rest of the files.
  </p>

  <?php if ($errors): ?>
  <div class="alert alert-bad">
    <strong>Could not continue:</strong>
    <ul><?php foreach ($errors as $error): ?><li><?= h($error) ?></li><?php endforeach; ?></ul>
  </div>
  <?php endif; ?>

  <?php if ($results): ?>
  <div class="card">
    <div class="rows">
      <?php foreach ($results as $result): ?>
      <div class="row <?= $result['ok'] ? 'ok' : 'no' ?>">
        <span class="mark"><?= $result['ok'] ? '✓' : '✕' ?></span>
        <span><?= h($result['label']) ?>
          <?php if ($result['output'] !== ''): ?><pre><?= h($result['output']) ?></pre><?php endif; ?>
        </span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

  <h2>Server check</h2>
  <div class="card">
    <div class="rows">
      <?php foreach ($requirements as $row): ?>
      <div class="row <?= $row['ok'] ? 'ok' : 'no' ?>">
        <span class="mark"><?= $row['ok'] ? '✓' : '✕' ?></span>
        <span><?= h($row['label']) ?>
          <?php if (! $row['ok']): ?><small><?= h($row['detail']) ?></small><?php endif; ?>
        </span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <?php if (! $docRoot['ok']): ?>
  <div class="alert alert-warn">
    <strong>Check the document root.</strong> <?= h($docRoot['message']) ?>
  </div>
  <?php endif; ?>

  <form method="POST">
    <input type="hidden" name="action" value="install">

    <h2>Setup code</h2>
    <div class="card">
      <div class="field">
        <label for="token">Paste the code from <code>storage/app/install-token.txt</code></label>
        <input id="token" name="token" value="<?= h($givenToken) ?>" autocomplete="off" required>
        <p class="hint">
          Open that file in cPanel → File Manager. Being able to read it is what proves
          you own this server rather than merely finding this page.
        </p>
      </div>
    </div>

    <h2>Site</h2>
    <div class="card">
      <div class="grid">
        <div class="field">
          <label for="app_name">Site name</label>
          <input id="app_name" name="app_name" value="<?= h(field('app_name', 'Jono Advertising')) ?>" required>
        </div>
        <div class="field">
          <label for="app_url">Full address</label>
          <input id="app_url" name="app_url" type="url" placeholder="https://jonoads.com"
                 value="<?= h(field('app_url', 'https://' . ($_SERVER['HTTP_HOST'] ?? ''))) ?>" required>
        </div>
      </div>
    </div>

    <h2>Database</h2>
    <div class="card">
      <p class="hint" style="margin-top:0">
        Create the database and user first under cPanel → MySQL Databases, and give the
        user All Privileges. cPanel prefixes both with your account name.
      </p>
      <div class="grid">
        <div class="field">
          <label for="db_host">Host</label>
          <input id="db_host" name="db_host" value="<?= h(field('db_host', 'localhost')) ?>" required>
        </div>
        <div class="field">
          <label for="db_port">Port</label>
          <input id="db_port" name="db_port" value="<?= h(field('db_port', '3306')) ?>" required>
        </div>
      </div>
      <div class="field">
        <label for="db_name">Database name</label>
        <input id="db_name" name="db_name" value="<?= h(field('db_name')) ?>" placeholder="acct_jonoads" required>
      </div>
      <div class="grid">
        <div class="field">
          <label for="db_user">Username</label>
          <input id="db_user" name="db_user" value="<?= h(field('db_user')) ?>" required>
        </div>
        <div class="field">
          <label for="db_pass">Password</label>
          <input id="db_pass" name="db_pass" type="password" value="<?= h(field('db_pass')) ?>">
        </div>
      </div>
    </div>

    <h2>Admin login</h2>
    <div class="card">
      <div class="field">
        <label for="admin_name">Name</label>
        <input id="admin_name" name="admin_name" value="<?= h(field('admin_name', 'Site Admin')) ?>" required>
      </div>
      <div class="grid">
        <div class="field">
          <label for="admin_email">Email</label>
          <input id="admin_email" name="admin_email" type="email" value="<?= h(field('admin_email')) ?>" required>
        </div>
        <div class="field">
          <label for="admin_pass">Password</label>
          <input id="admin_pass" name="admin_pass" type="password" minlength="12" required>
          <p class="hint">12 characters or more.</p>
        </div>
      </div>
    </div>

    <h2>Email</h2>
    <div class="card">
      <p class="hint" style="margin-top:0">
        Used for enquiry notifications and newsletter confirmations. Create an address
        under cPanel → Email Accounts and use its SMTP details.
      </p>
      <div class="grid">
        <div class="field">
          <label for="mail_mailer">Send using</label>
          <select id="mail_mailer" name="mail_mailer">
            <option value="smtp" <?= field('mail_mailer', 'smtp') === 'smtp' ? 'selected' : '' ?>>SMTP</option>
            <option value="log" <?= field('mail_mailer') === 'log' ? 'selected' : '' ?>>Write to a log file (no sending)</option>
          </select>
        </div>
        <div class="field">
          <label for="mail_contact">Send enquiries to</label>
          <input id="mail_contact" name="mail_contact" type="email"
                 value="<?= h(field('mail_contact', 'info@jonoadvertising.com')) ?>" required>
        </div>
      </div>
      <div class="grid">
        <div class="field">
          <label for="mail_host">SMTP host</label>
          <input id="mail_host" name="mail_host" value="<?= h(field('mail_host', 'localhost')) ?>">
        </div>
        <div class="field">
          <label for="mail_port">SMTP port</label>
          <input id="mail_port" name="mail_port" value="<?= h(field('mail_port', '587')) ?>">
        </div>
      </div>
      <div class="grid">
        <div class="field">
          <label for="mail_user">SMTP username</label>
          <input id="mail_user" name="mail_user" value="<?= h(field('mail_user')) ?>">
        </div>
        <div class="field">
          <label for="mail_pass">SMTP password</label>
          <input id="mail_pass" name="mail_pass" type="password" value="<?= h(field('mail_pass')) ?>">
        </div>
      </div>
      <div class="field">
        <label for="mail_from">Send from</label>
        <input id="mail_from" name="mail_from" type="email" value="<?= h(field('mail_from', 'hello@jonoads.com')) ?>">
      </div>
    </div>

    <button type="submit" <?= $requirementsMet ? '' : 'disabled' ?>>
      <?= $requirementsMet ? 'Install' : 'Fix the red rows first' ?>
    </button>
    <p class="hint">Takes up to a minute. Do not close the tab.</p>
  </form>

<?php endif; ?>

</div>
</body>
</html>
