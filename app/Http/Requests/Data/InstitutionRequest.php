<?php

namespace App\Http\Requests\Data;

use Illuminate\Foundation\Http\FormRequest;

class InstitutionRequest extends FormRequest
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
            'name' => 'required|string',
            'phone' => 'required|string',
            'fax' => 'required|string',
            'location_en' => 'required|string',
            'address_en' => 'required|string',
            'location_id' => 'required|string',
            'address_id' => 'required|string',
            'branch_phone.*' => 'nullable|string',
            'branch_fax.*' => 'nullable|string',
            'branch_location_en.*' => 'nullable|string',
            'branch_address_en.*' => 'nullable|string',
            'branch_location_id.*' => 'nullable|string',
            'branch_address_id.*' => 'nullable|string',
        ];
    }
}
