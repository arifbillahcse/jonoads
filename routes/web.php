<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/roas-engine', [PageController::class, 'roasEngine'])->name('roas-engine');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/case-studies', [PageController::class, 'caseStudies'])->name('case-studies');
Route::get('/team', [PageController::class, 'team'])->name('team');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/smb', [PageController::class, 'smb'])->name('smb');

// The case studies page used to live at /work; keep that address working.
Route::permanentRedirect('/work', '/case-studies');

/*
|--------------------------------------------------------------------------
| Crawlers
|--------------------------------------------------------------------------
|
| Served from routes rather than static files so the sitemap carries absolute
| URLs for whichever domain the app is running on.
|
*/

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');

/*
|--------------------------------------------------------------------------
| Forms
|--------------------------------------------------------------------------
|
| Rate limits are per IP and deliberately generous: enough to stop a script,
| not enough to block someone who mistypes their email a few times.
|
*/

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,10')
    ->name('contact.store');

Route::post('/newsletter', [NewsletterController::class, 'subscribe'])
    ->middleware('throttle:5,10')
    ->name('newsletter.subscribe');

Route::get('/newsletter/confirm/{token}', [NewsletterController::class, 'confirm'])
    ->middleware('throttle:10,10')
    ->name('newsletter.confirm');

// Signed so an unsubscribe link cannot be guessed or forged for someone else.
Route::get('/newsletter/unsubscribe/{subscriber}', [NewsletterController::class, 'unsubscribe'])
    ->middleware('signed')
    ->name('newsletter.unsubscribe');
