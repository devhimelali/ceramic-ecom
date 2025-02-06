<?php

namespace App\Http\Controllers;

use App\Enum\StatusEnum;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function statusUpdate($encryptModelNameID)
    {
        try {
            // Decrypt the data from the URL
            $data = json_decode(decrypt($encryptModelNameID), true);
            $modelClass = "App\\Models\\" . $data['model'];
            if (!class_exists($modelClass)) {
                return redirect()->route('attributes.index')->with('error', 'Model not found.');
            }
            $model = $modelClass::findOrFail($data['id']);
            $model->status = $model->status == StatusEnum::ACTIVE ? StatusEnum::INACTIVE : StatusEnum::ACTIVE;
            $model->save();
            return response()->json(['status' => 'success', 'message' => 'Status updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Invalid request.'], 400);
        }
    }
}
