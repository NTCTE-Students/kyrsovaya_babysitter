<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NannyController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return redirect()->route('nannies.index');
});

Route::get('/nannies', [NannyController::class, 'index'])->name('nannies.index');
Route::get('/nannies/{id}', [NannyController::class, 'show'])->name('nannies.show');

Route::post('/nannies/{nannyId}/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store')
    ->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');