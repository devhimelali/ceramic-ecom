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
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category' => 'required|exists:categories,id',
            'brand' => 'nullable|exists:brands,id',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:regular_price',
            'status' => 'required|in:active,inactive',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',

            'attributes' => 'required|array|min:1',
            'attributes.*.name' => 'required|string|max:255',
            'attributes.*.values' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $values = array_filter(array_map('trim', explode(',', $value)));
                    if (empty($values)) {
                        $fail('Attribute values must contain at least one non-empty item.');
                    }
                }
            ],

            'variations' => 'required|array|min:1',
            'variations.*.attributes' => 'required|string|max:255',
            'variations.*.regular_price' => 'required|numeric|min:0',
            'variations.*.sale_price' => 'nullable|numeric|min:0|lte:variations.*.regular_price',
            'variations.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'variations.*.description' => 'nullable|string|max:1000',
        ];
    }
}
