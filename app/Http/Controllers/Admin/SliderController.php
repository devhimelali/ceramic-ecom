<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function index()
    {
        $data = [
            'sliders' => Slider::orderBy('order')->get(),
            'active' => 'home',
        ];
        // resources/views/admin/page-settings/home
        return view('admin.page-settings.home.slider', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'fields.*.title' => 'required|string|max:255',
            'fields.*.description' => 'nullable|string',
            'fields.*.file' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:2048', // Example file types and max size
        ]);

        // Loop through the fields to handle multiple uploads
        foreach ($request->fields as $key => $field) {
            // Store title and description
            $fileData = [
                'title' => $field['title'],
                'description' => $field['description'] ?? null,
            ];

            // Handle file upload if present
            if (isset($field['file'])) {
                $file = $field['file'];

                // Change the file name to a unique one
                $newFileName = time() . '-' . $file->getClientOriginalName();

                // Store the file
                // $filePath = $file->storeAs('uploads', $newFileName, 'public/slider');
                $imagePath = ImageUploadHelper::uploadImage($file, 'uploads/sliders');
                // dd($imagePath);
                $fileData['image'] = $imagePath;
            }

            // Store the file data in the database
            Slider::create($fileData);
        }

        // Return a response
        return response()->json([
            'success' => true,
            'message' => 'Form submitted successfully!',
        ]);
    }
}
