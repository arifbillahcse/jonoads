<?php

namespace App\Support;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

/**
 * Two cheap, no-dependency checks that stop most drive-by form spam without
 * putting a CAPTCHA in front of a real prospect:
 *
 *  - a honeypot field that is hidden from people but filled in by bots
 *  - an encrypted timestamp, so a form submitted implausibly fast is rejected
 *
 * Neither is a substitute for rate limiting, which the routes also apply.
 */
class SpamGuard
{
    /** Field names deliberately look like ones a bot would want to fill. */
    public const HONEYPOT = 'website';

    public const TIMESTAMP = 'form_started_at';

    /** A human needs at least this long to fill in a form honestly. */
    public const MIN_SECONDS = 2;

    /** Encrypted so the value cannot simply be replayed or back-dated. */
    public static function timestamp(): string
    {
        return Crypt::encryptString((string) now()->getTimestamp());
    }

    public static function honeypotIsClean(mixed $value): bool
    {
        return blank($value);
    }

    public static function elapsedIsPlausible(mixed $encrypted): bool
    {
        if (blank($encrypted)) {
            return false;
        }

        try {
            $startedAt = (int) Crypt::decryptString((string) $encrypted);
        } catch (DecryptException) {
            return false;
        }

        return (now()->getTimestamp() - $startedAt) >= self::MIN_SECONDS;
    }
}
