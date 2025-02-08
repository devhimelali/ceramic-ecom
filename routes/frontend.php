<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $data = [
        'active' => 'home'
    ];
    return view('frontend.home', $data);
});
