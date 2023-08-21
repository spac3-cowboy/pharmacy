<?php

namespace App\Http\Requests\Medicine;

use Illuminate\Foundation\Http\FormRequest;

class CreateMedicineRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|unique:medicines|string",
            "generic_name" => "required|string",
            "price" => "required|numeric",
            "manufacturing_price" => "required|numeric",
            "strength" => "required|string",
            "category_id" => "required|numeric"
        ];
    }
}
