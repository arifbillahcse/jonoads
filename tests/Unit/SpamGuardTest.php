<?php

namespace Tests\Unit;

use App\Support\SpamGuard;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class SpamGuardTest extends TestCase
{
    public function test_an_empty_honeypot_passes_and_a_filled_one_does_not(): void
    {
        $this->assertTrue(SpamGuard::honeypotIsClean(''));
        $this->assertTrue(SpamGuard::honeypotIsClean(null));
        $this->assertFalse(SpamGuard::honeypotIsClean('http://spam.example'));
    }

    public function test_timing_accepts_a_plausible_gap_and_rejects_the_rest(): void
    {
        $this->assertTrue(SpamGuard::elapsedIsPlausible(
            Crypt::encryptString((string) (now()->getTimestamp() - 30)),
        ));

        $this->assertFalse(SpamGuard::elapsedIsPlausible(
            Crypt::encryptString((string) now()->getTimestamp()),
        ), 'an instant submission is a bot');

        $this->assertFalse(SpamGuard::elapsedIsPlausible(null));
        $this->assertFalse(SpamGuard::elapsedIsPlausible('not-encrypted'));

        $this->assertFalse(SpamGuard::elapsedIsPlausible(
            Crypt::encryptString((string) (now()->getTimestamp() + 600)),
        ), 'a future-dated timestamp must not pass');
    }
}
