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
            'fields.*.file' => 'nullable|image|mimes:jpg,webp,jpeg,png,gif|max:2048', // Example file types and max size
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
            'status' => "success",
            'message' => 'Form submitted successfully!',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|image|mimes:jpg,webp,jpeg,png,gif',
        ]);
        $slider = Slider::findOrFail($id);
        $slider->update($request->all());

        if ($request->hasFile('file')) {
            if ($slider->image && file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            }
            $imagePath = ImageUploadHelper::uploadImage($request->file, 'uploads/sliders');
            $slider->image = $imagePath;
            $slider->save();
        }

        return response()->json([
            'status' => "success",
            'message' => 'Slider updated successfully!',
        ]);
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        if (Slider::count() == 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'You cannot delete the last slider.',
            ]);
        }
        if ($slider->image && file_exists(public_path($slider->image))) {
            unlink(public_path($slider->image));
        }
        $slider->delete();
        return response()->json([
            'status' => "success",
            'message' => 'Slider deleted successfully!',
        ]);
    }
}
