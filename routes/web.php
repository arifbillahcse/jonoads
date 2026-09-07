<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
|
| Content is still inline in the Blade views at this stage. Phase 4 replaces
| the hardcoded markup with data from the CMS without changing these routes.
|
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/roas-engine', [PageController::class, 'roasEngine'])->name('roas-engine');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/work', [PageController::class, 'work'])->name('work');
Route::get('/team', [PageController::class, 'team'])->name('team');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/smb', [PageController::class, 'smb'])->name('smb');
