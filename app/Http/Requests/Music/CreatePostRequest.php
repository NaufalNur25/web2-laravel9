<?php

namespace App\Http\Requests\Music;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'spotify_id' => ['required', 'string'],
            'expires_at' => ['nullable', 'date'],
            'content' => ['required', 'string'],
            'visibility' => ['required', 'boolean'],
        ];
    }
}
