<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class ImageUploadHelper
{
    public static function uploadImage($file, $folder = 'images')
    {
        $image = $file;
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs($folder, $imageName, 'public');
        return 'storage/' . $folder . '/' . $imageName;
    }
}
