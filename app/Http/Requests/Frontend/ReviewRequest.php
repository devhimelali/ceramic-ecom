<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string'],
            'headline' => ['required', 'string'],
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp'],
            'videos' => ['nullable', 'array', 'max:3'],
            'videos.*' => ['file', 'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime']
        ];
    }
}
