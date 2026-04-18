<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'original_title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'poster_url' => 'required|url',
            'trailer_url' => 'required|url',
            'genre' => 'required|string|max:255',
            'duration' => 'required|integer|min:1|max:20',
            'age_rating' => 'required|string|max:50',
            'director' => 'required|string|max:50',
            'actors' => 'required|string|max:255',
        ];
    }
}
