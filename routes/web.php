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

use Illuminate\Support\Facades\Artisan;

Route::get('optimize-clear', function () {
    Artisan::call('optimize:clear');
});


Route::get('/slider', function () {
    $data = [
        'active' => 'reviews'
    ];
    return view('test', $data);
});
