<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Setting;
use App\Enum\StatusEnum;
use App\Helpers\ImageUploadHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        $data = [
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
            } elseif (!$setting->is_image) {
                // Only update text if it's not an image setting
                $setting->value = $request->$type;
                $setting->is_image = 0;
            }

            $setting->save();
        }

        return redirect()->back()->withSuccess("Settings Updated Successfully");
    }



    public function aboutPage()
    {
        $data = [
            'active' => 'settings'
        ];
        return view('admin.page-settings.about.about-page', $data);
    }

    public function aboutPageChange(Request $request)
    {
        // Define image keys and default folder
        $imageKeys = ['about_one__image__one', 'about_one__image__two', 'about_one__image__three', 'about_two__image__one', 'about_two__image__two'];
        $uploadPath = public_path('assets/images/settings/');

        // Handle image uploads
        foreach ($imageKeys as $key) {
            if ($request->$key) {
                $file = $request->$key;
                $filename = ImageUploadHelper::uploadImage($file, 'uploads/settings');

                $setting = Setting::where('key', $key)->first();

                if ($setting && $setting->value) {
                    if ($setting->value && file_exists(public_path($setting->value))) {
                        unlink(public_path($setting->value));
                    }
                    $setting->update(['value' => $filename, 'is_image' => 1]);
                } else {
                    Setting::create(['key' => $key, 'value' => $filename, 'is_image' => 1]);
                }
            }
        }

        // Handle text updates
        $textKeys = ['about_sec_1', 'about_sec_2'];
        foreach ($textKeys as $key) {
            if ($request->filled($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->$key]);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Page updated successfully!']);
    }


    public function homePage()
    {
        $data = [
            'active' => 'home',
            'sliders' => Slider::get(),
            'brands' => Brand::where('status', StatusEnum::ACTIVE)->latest()->limit(15)->get(),
            'settings' => Setting::get(),
        ];
        return view('admin.page-settings.home.home', $data);
    }

    public function homePageChange(Request $request)
    {
        $settings = [
            'home_about_sec_1' => $request->home_about_sec_1,
            'home_reliable_one_content' => $request->home_reliable_one_content,
            'home_service_one_content' => $request->home_service_one_content
        ];

        foreach ($settings as $key => $value) {
            if ($value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        $imageKeys = ['home_one__image__one', 'home_one__image__two', 'home_one__image__three', 'home_two__image__one', 'home_two__image__two',];

        foreach ($imageKeys as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $imagePath = ImageUploadHelper::uploadImage($file, 'uploads/settings');
                $setting = Setting::where('key', $key)->first();
                if ($setting && $setting->value) {
                    if ($setting->value && file_exists(public_path($setting->value))) {
                        unlink(public_path($setting->value));
                    }
                }

                Setting::updateOrCreate(['key' => $key], ['value' => $imagePath, 'is_image' => 1]);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Page updated successfully!']);
    }
}
