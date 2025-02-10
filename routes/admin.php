<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AttributeValueController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('status-update/{encryptModelNameID}', [GeneralController::class, 'statusUpdate'])->name('status.update');
    Route::resource('categories', CategoryController::class);
    Route::get('categories/front-show/{id}', [CategoryController::class, 'frontShow'])->name('category.frontShow');

    Route::resource('brands', BrandController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('attribute-values', AttributeValueController::class);
    Route::resource('products', ProductController::class);
    Route::get('get-attribute-values', [GeneralController::class, 'getAttributeValues'])->name('get.attribute.values');
    Route::post('delete-product-image', [ProductController::class, 'deleteProductImage'])->name('delete.product.image');
    Route::resource('contacts', ContactController::class);
    Route::post('/contact-us/{id}/reply', [ContactController::class, 'reply'])->name('contact.reply');
    Route::resource('orders', OrderController::class);
});
