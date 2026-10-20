<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'thumbnail' => 'nullable|file|max:5120',
            'thumbnail_alt_en' => 'nullable|string|max:255',
            'thumbnail_alt_id' => 'nullable|string|max:255',
            'thumbnail_caption_en' => 'nullable|string',
            'thumbnail_caption_id' => 'nullable|string',
            'article_category_id' => 'required',
            'title_en' => 'required',
            'content_en' => 'required',
            'title_id' => 'required',
            'content_id' => 'required',
            'status' => 'required'
        ];
    }
}
