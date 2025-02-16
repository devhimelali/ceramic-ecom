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
            } else {
                $setting->value = $request->$type;
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
    // public function aboutPageChange(Request $request)
    // {
    //     // Handle about_one__image__one upload
    //     if ($request->hasFile('about_one__image__one')) {
    //         $file = $request->file('about_one__image__one');
    //         $filename = 'setting_' . 'about_one__image__one' . time() . '.' . $file->getClientOriginalExtension();
    //         $file->move(public_path('assets/images/settings/'), $filename);

    //         $about_one__image__one = Setting::where('key', 'about_one__image__one')->first();
    //         if ($about_one__image__one && $about_one__image__one->value) {
    //             // Delete the old image
    //             unlink(public_path('assets/images/settings/' . $about_one__image__one->value));
    //             // Save the new file
    //             $about_one__image__one->value = $filename;
    //             $about_one__image__one->is_image = 1;
    //             $about_one__image__one->save();
    //         } else {
    //             // Create a new record if not found
    //             Setting::create([
    //                 'key' => 'about_one__image__one',
    //                 'value' => $filename,
    //                 'is_image' => 1
    //             ]);
    //         }
    //     }

    //     // Handle about_one__image__two upload
    //     if ($request->hasFile('about_one__image__two')) {
    //         $file = $request->file('about_one__image__two');
    //         $filename = 'setting_' . 'about_one__image__two' . time() . '.'  . $file->getClientOriginalExtension();
    //         $file->move(public_path('assets/images/settings/'), $filename);

    //         $about_one__image__two = Setting::where('key', 'about_one__image__two')->first();
    //         if ($about_one__image__two && $about_one__image__two->value) {
    //             // Delete the old image
    //             unlink(public_path('assets/images/settings/' . $about_one__image__two->value));
    //             // Save the new file
    //             $about_one__image__two->value = $filename;
    //             $about_one__image__two->is_image = 1;
    //             $about_one__image__two->save();
    //         } else {
    //             // Create a new record if not found
    //             Setting::create([
    //                 'key' => 'about_one__image__two',
    //                 'value' => $filename,
    //                 'is_image' => 1
    //             ]);
    //         }
    //     }

    //     // Handle about_one__image__three upload
    //     if ($request->hasFile('about_one__image__three')) {
    //         $file = $request->file('about_one__image__three');
    //         $filename = 'setting_' . 'about_one__image__three' . time() . '.'  . $file->getClientOriginalExtension();
    //         $file->move(public_path('assets/images/settings/'), $filename);

    //         $about_one__image__three = Setting::where('key', 'about_one__image__three')->first();
    //         if ($about_one__image__three && $about_one__image__three->value) {
    //             // Delete the old image
    //             unlink(public_path('assets/images/settings/' . $about_one__image__three->value));
    //             // Save the new file
    //             $about_one__image__three->value = $filename;
    //             $about_one__image__three->is_image = 1;
    //             $about_one__image__three->save();
    //         } else {
    //             // Create a new record if not found
    //             Setting::create([
    //                 'key' => 'about_one__image__three',
    //                 'value' => $filename,
    //                 'is_image' => 1
    //             ]);
    //         }
    //     }
    //     if ($request->about_sec_1) {
    //         $about_sec_1 = Setting::where('key', 'about_sec_1')->first();
    //         if ($about_sec_1 && $about_sec_1->value) {
    //             $about_sec_1->value = $request->about_sec_1;
    //             $about_sec_1->save();
    //         } else {
    //             Setting::create([
    //                 'key' => 'about_sec_1',
    //                 'value' => $request->about_sec_1
    //             ]);
    //         }
    //     }
    //     if ($request->about_sec_2) {
    //         $about_sec_2 = Setting::where('key', 'about_sec_2')->first();
    //         if ($about_sec_2 && $about_sec_2->value) {
    //             $about_sec_2->value = $request->about_sec_2;
    //             $about_sec_2->save();
    //         } else {
    //             Setting::create([
    //                 'key' => 'about_sec_2',
    //                 'value' => $request->about_sec_2
    //             ]);
    //         }
    //     }
    //     return response()->json(['status' => 'success', 'message' => 'Page updated successfully!']);
    // }



    public function aboutPageChange(Request $request)
    {
        // Define image keys and default folder
        $imageKeys = ['about_one__image__one', 'about_one__image__two', 'about_one__image__three'];
        // Handle image uploads
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
                Setting::updateOrCreate(['key' => $key, 'value' => $imagePath, 'is_image' => 1]);
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
            'products' => Product::with('images', 'attributes', 'attributeValues')->where('status', StatusEnum::ACTIVE)->latest()->limit(4)->get(),
        ];
        return view('admin.page-settings.home.home', $data);
    }

    public function homePageChange(Request $request)
    {
        $settings = [
            'home_about_sec_1' => $request->home_about_sec_1,
            'home_reliable_one_content' => $request->home_reliable_one_content
        ];
        dd($request->all());

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


    // public function homeSlider()
    // {
    //     $data = [
    //         'sliders' => Slider::orderBy('order')->get(),
    //         'active' => 'home',
    //     ];
    //     // resources/views/admin/page-settings/home
    //     return view('admin.page-settings.home.slider', $data);
    // }
}
