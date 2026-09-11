<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/roas-engine', [PageController::class, 'roasEngine'])->name('roas-engine');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/work', [PageController::class, 'work'])->name('work');
Route::get('/team', [PageController::class, 'team'])->name('team');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/smb', [PageController::class, 'smb'])->name('smb');

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
