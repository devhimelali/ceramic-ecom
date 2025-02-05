<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        $data =[
            'active' => 'settings'
        ];
        return view("admin.setting.index", $data);
    }

    public function store(Request $request)
    {
        foreach ($request->types as $type) {
            $setting = Setting::firstOrNew(['key' => $type]);

            if ($request->hasFile($type)) {
                // Delete the old file if it exists
                if (!empty($setting->value) && file_exists(public_path('assets/images/settings/' . $setting->value))) {
                    unlink(public_path('assets/images/settings/' . $setting->value));
                }

                // Store the new file
                $file = $request->file($type);
                $filename = 'setting_' . $type . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/images/settings/'), $filename);

                $setting->value = $filename;
                $setting->is_image = 1;
            } else {
                $setting->value = $request->$type;
            }

            $setting->save();
        }

        return redirect()->back()->withSuccess("Settings Updated Successfully");
    }
}
