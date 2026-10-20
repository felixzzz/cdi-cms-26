<?php

namespace App\Http\Requests\Utility;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdditionalFileRequest extends FormRequest
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
            'unique_key' => [
                'nullable',
                Rule::unique('additional_files')->where(function ($query) {
                    return $query->where('type', request()->type);
                }),
            ],
            'name_en' => 'required',
            'name_id' => 'required'
        ];
    }
}
