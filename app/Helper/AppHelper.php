<?php

use GuzzleHttp\Client;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

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
    $categories = Category::with('children')
        ->whereNull('parent_id')
        ->where('front_show', 1)
        ->limit(10)
        ->get();
    return $categories;
}

function sendMarketingMessage($to, $message)
{

    $client = new Client();

    $username = env("TOUCH_SMS_USER_NAME");
    $password = env("TOUCH_SMS_PASSWORD");

    $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'Authorization' => 'Basic ' . base64_encode("$username:$password"),
    ];

    $body = json_encode([
        "reject_duplicates_by_recipient" => false,
        "messages" => [
            [
                "to" => $to,
                "from" => env("TOUCH_SMS_FROM"),
                "body" => $message
            ]
        ]
    ]);

    try {
        $response = $client->request('POST', 'https://app.touchsms.com.au/api/v2/sms', [
            'headers' => $headers,
            'body' => $body,
        ]);
        Log::info($response->getBody()->getContents());
    } catch (\Exception $e) {
        Log::error($e->getMessage());
    }
}

function uploadImage($file, $folder)
{
    if (!$file instanceof \Illuminate\Http\UploadedFile || !$file->isValid()) {
        throw new \Exception("Invalid image upload");
    }

    $imageName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

    $destinationPath = public_path('storage/' . $folder);
    if (!\File::exists($destinationPath)) {
        \File::makeDirectory($destinationPath, 0755, true, true);
    }

    $file->move($destinationPath, $imageName);

    return [
        'name' => $imageName,
        'path' => 'storage/' . $folder . '/' . $imageName
    ];
}

if(!function_exists('uploadVideo')) {
    function uploadVideo($file, $folder)
    {
        if (!$file instanceof \Illuminate\Http\UploadedFile || !$file->isValid()) {
            throw new \Exception("Invalid video upload");
        }

        $videoName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

        $destinationPath = public_path('storage/' . $folder);
        if (!\File::exists($destinationPath)) {
            \File::makeDirectory($destinationPath, 0755, true, true);
        }

        $file->move($destinationPath, $videoName);

        return [
            'name' => $videoName,
            'path' => 'storage/' . $folder . '/' . $videoName
        ];
    }
}


// function uploadVideo($file, $folder)
// {
//     $video = $file;
//     $videoName = uniqid() . time() . '.' . $video->getClientOriginalExtension();
//     $video->storeAs($folder, $videoName, 'public');
//     return ['name' => $videoName, 'path' => 'storage/' . $folder . '/' . $videoName];
// }
