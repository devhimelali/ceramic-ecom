<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'home'])->name('frontend.home');
Route::get('/all-categories', [FrontendController::class, 'allCategories'])->name('frontend.allCategories');
