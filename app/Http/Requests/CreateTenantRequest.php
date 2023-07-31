<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTenantRequest extends FormRequest
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
            "name" => "required|string",
            "password" => "required|string",
            "phone" => "required|string",
            "address" => "required|string",
            "bg" => "required|string",

            "tenant_name" => "required|string",
            "tenant_address" => "required|string",
            "tenant_email" => "required|string",
            "tenant_phone" => "required|string"
        ];
    }
}
