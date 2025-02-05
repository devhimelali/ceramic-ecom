<?php

namespace App\Http\Requests\Admin\Brand;

use App\Enum\StatusEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        $id = $this->route("brand");
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('brands', 'name')->ignore($id)],
            'slug' => ['required', 'string', 'max:255', Rule::unique('brands', 'slug')->ignore($id)],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'description' => ['nullable', 'string'],
            "status" => ["required", Rule::enum(StatusEnum::class)],
        ];
    }
}
