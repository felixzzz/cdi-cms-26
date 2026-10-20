<?php

namespace App\Http\Requests\AboutUs;

use Illuminate\Foundation\Http\FormRequest;

class OurHistoryRequest extends FormRequest
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
            'image' => 'nullable|file|max:5120',
            'title_en' => 'required',
            'content_en' => 'required',
            'tagline_en' => 'required',
            'title_id' => 'required',
            'content_id' => 'required',
            'tagline_id' => 'required'
        ];
    }
}
