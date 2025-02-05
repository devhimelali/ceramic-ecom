<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/redirect', [RedirectController::class, 'redirectUser'])->name('dashboard');
});

Route::get('/', function () {
    return view('welcome');
});
