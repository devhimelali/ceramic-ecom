<?php

use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Frontend\ContactController;

Route::get('/', [FrontendController::class, 'home'])->name('frontend.home');
Route::get('/all-categories', [FrontendController::class, 'allCategories'])->name('frontend.allCategories');
Route::get('/all-products', [FrontendController::class, 'productsPage'])->name('frontend.productsPage');
Route::get('/products/{slug}', [FrontendController::class, 'productDetails'])->name('product.details');
Route::get('/contact', [ContactController::class, 'contact'])->name('frontend.contact');
Route::post('/contact', [ContactController::class, 'store']);
Route::get('enquire-form/{productId}', [OrderController::class, 'enquireForm'])->name('enquireForm');
Route::post('enquire', [OrderController::class, 'store'])->name('enquire');
Route::get('about-us', [FrontendController::class, 'aboutUs'])->name('frontend.aboutUs');
