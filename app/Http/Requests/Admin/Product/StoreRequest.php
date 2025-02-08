<?php

namespace App\Http\Requests\Admin\Product;

use App\Enum\StatusEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'category' => ['required', 'exists:categories,id'],
            'brand' => ['required', 'exists:brands,id'],
            'short_description' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
            'status' => ['required', Rule::enum(StatusEnum::class)],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp'],
            'variation_names' => ['nullable', 'array', 'exists:attributes,id'],
            'variation_values' => ['nullable', 'array', 'exists:attribute_values,id'],
        ];
    }
}
