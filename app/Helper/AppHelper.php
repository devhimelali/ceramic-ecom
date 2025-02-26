<?php

use App\Models\Setting;
use App\Models\Category;

function app_setting($key)
{
    $setting = Setting::where('key', $key)->first();
    if (isset($setting)) {
        if ($setting->is_image == 0) {
            $setting = isset($setting) ? $setting->value : "";
        } else {
            $setting = isset($setting) ? '/assets/images/settings/' . $setting->value : "";
        }
    } else {
        $setting = '';
    }
    return $setting;
}

function category_show()
{
    $categories = Category::with('children')->where('front_show', 1)->limit(10)->get();
    return $categories;
}
