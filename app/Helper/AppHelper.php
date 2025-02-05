<?php

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
