<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\MarketingController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('status-update/{encryptModelNameID}', [GeneralController::class, 'statusUpdate'])->name('status.update');
    Route::resource('categories', CategoryController::class);
    Route::get('categories/front-show/{id}', [CategoryController::class, 'frontShow'])->name('category.frontShow');

    Route::resource('brands', BrandController::class);
    // Route::resource('settings', SettingController::class);
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'store'])->name('settings.store');

    Route::get('settings/about-page', [SettingController::class, 'aboutPage'])->name('settings.aboutPage');
    Route::post('settings/about-page', [SettingController::class, 'aboutPageChange'])->name('settings.aboutPageChange');



    Route::resource('settings/sliders', SliderController::class);
    Route::get('settings/home-page', [SettingController::class, 'homePage'])->name('settings.homePage');
    Route::post('settings/home-page', [SettingController::class, 'homePageChange'])->name('settings.homePageChange');


    Route::resource('attributes', AttributeController::class);
    Route::resource('attribute-values', AttributeValueController::class);
    Route::resource('products', ProductController::class);
    Route::get('get-attribute-values', [GeneralController::class, 'getAttributeValues'])->name('get.attribute.values');
    Route::post('delete-product-image', [ProductController::class, 'deleteProductImage'])->name('delete.product.image');
    Route::resource('contacts', ContactController::class);
    Route::post('/contact-us/{id}/reply', [ContactController::class, 'reply'])->name('contact.reply');
    // Route::resource('orders', OrderController::class);
    Route::get('product-queries', [OrderController::class, 'productQueries'])->name('product.queries');
    Route::get('product-query/{id}', [OrderController::class, 'viewProductQuery'])->name('product.query');
    Route::post('product-query-status/{id}', [OrderController::class, 'changeProductQueryStatus'])->name('product.query.status');
    Route::get('chart-data', [DashboardController::class, 'getChartData'])->name('get.chart.data');
    Route::get('marketing', [MarketingController::class, 'index'])->name('marketing.index');
    Route::post('send-sms-selected-users', [MarketingController::class, 'sendSMSSelectedUsers'])->name('send.sms.selected.users');
    Route::post('send-sms-all-users', [MarketingController::class, 'sendSMSAllUsers'])->name('send.sms.all.users');

    Route::get('new-products', function () {
        $categories = \App\Models\Category::orderBy('name', 'asc')->get();
        $brands = \App\Models\Brand::orderBy('name', 'asc')->get();
        $statuses = \App\Enum\StatusEnum::cases();
//        $attributes = \App\Models\Attribute::where('status', orderBy('name', 'asc')->get();
        $data = [
            'categories' => $categories,
            'brands' => $brands,
            'statuses' => $statuses,
            'active' => 'products',

        ];
        return view('admin.new-products.create', $data);
    })->name('new.products');
});

Route::get('test', function () {
    $data = [
        'active' => 'products'
    ];
    return view('test', $data);
});
