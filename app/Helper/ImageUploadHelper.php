<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;
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

    public static function uploadProductImage($image, $folder = 'products', $productId = null)
    {
        $filename = 'product-' . ($productId ?? 'temp') . '-' . time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

        // Paths
        $pathOriginal = "uploads/$folder/original/" . $filename;
        $pathThumbnail = "uploads/$folder/thumbnail/" . $filename;
        $pathMedium = "uploads/$folder/medium/" . $filename;

        // Store Original Image
        Storage::disk('public')->put($pathOriginal, file_get_contents($image));

        $manager = new ImageManager(Driver::class);

        // Create and Store Thumbnail (270x270)
        $imageManager = $manager->read($image);
        $thumbnail = $imageManager->scaleDown(270, 270);
        Storage::disk('public')->put($pathThumbnail, (string) $thumbnail->encode());

        // Create and Store Medium Size Image (570x570)
        $medium = $imageManager->scaleDown(570, 570);
        Storage::disk('public')->put($pathMedium, (string) $medium->encode());

        return [
            'original' => $pathOriginal,
            'thumbnail' => $pathThumbnail,
            'medium' => $pathMedium,
            'filename' => $filename
        ];
    }


    public static function getProductImageUrl($filename, $folder = 'products', $type = 'thumbnail')
    {
        if (!$filename) {
            return asset('frontend/assets/images/product-placeholder.png'); // Default placeholder image
        }

        // Define the image path based on type
        $path = "uploads/{$folder}/{$type}/{$filename}";

        return Storage::disk('public')->exists($path) ? asset("storage/{$path}") : asset('images/no-image.png');
    }

    public static function deleteProductImage($filename, $folder = 'products')
    {
        Storage::disk('public')->delete("uploads/{$folder}/original/{$filename}");
        Storage::disk('public')->delete("uploads/{$folder}/thumbnail/{$filename}");
        Storage::disk('public')->delete("uploads/{$folder}/medium/{$filename}");
    }
}
