<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class ImageUploadHelper
{
    public static function uploadImage($file, $folder = 'images')
    {
        $image = $file;
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs($folder, $imageName, 'public');

        // Return the path to the uploaded image
        return 'storage/' . $folder . '/' . $imageName;
    }
}
