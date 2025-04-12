<?php

use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Frontend\ContactController;

Route::get('/', [FrontendController::class, 'home'])->name('frontend.home');
Route::get('/categories', [FrontendController::class, 'allCategories'])->name('frontend.allCategories');
Route::get('/products', [FrontendController::class, 'productsPage'])->name('frontend.productsPage');
Route::get('/products/{slug}', [FrontendController::class, 'productDetails'])->name('product.details');
Route::get('/contact', [ContactController::class, 'contact'])->name('frontend.contact');
Route::post('/contact', [ContactController::class, 'store']);
Route::get('enquire-form/{productId}', [OrderController::class, 'enquireForm'])->name('enquireForm');
Route::post('enquire', [OrderController::class, 'store'])->name('enquire');
Route::get('about-us', [FrontendController::class, 'aboutUs'])->name('frontend.aboutUs');
Route::post('submit-single-product-query/{id}', [OrderController::class, 'storeSingleProductQuery'])->name('submit.single.product.query');
Route::get('add-to-cart/{id}', [OrderController::class, 'addToCart'])->name('add.to.cart.form');
Route::post('submit-cart', [OrderController::class, 'submitCart'])->name('submit.cart');
Route::get('terms-and-conditions', [FrontendController::class, 'termAndCondition'])->name('term.and.condition');
Route::get('privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacy.policy');
