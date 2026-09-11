<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Baseline response headers. Deliberately conservative: no Content-Security-Policy
 * yet, because Filament and Vite's dev server both need inline scripts and a
 * half-right CSP breaks the panel while providing little benefit.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $headers = [
            // Stop browsers guessing a different content type than we sent.
            'X-Content-Type-Options' => 'nosniff',
            // No one should be framing this site.
            'X-Frame-Options' => 'SAMEORIGIN',
            // Send the origin to other sites, the full path to our own.
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            // Nothing here needs these, so switch them off by default.
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(), interest-cohort=()',
        ];

        // Only meaningful over TLS, and setting it in local dev would pin
        // developers to https on localhost.
        if ($request->secure()) {
            $headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains';
        }

        foreach ($headers as $name => $value) {
            $response->headers->set($name, $value, false);
        }

        return $response;
    }
}
