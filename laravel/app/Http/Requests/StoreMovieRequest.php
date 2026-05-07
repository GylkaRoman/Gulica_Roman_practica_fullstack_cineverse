<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'original_title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:500'],
            'poster_url' => ['required', 'url'],
            'trailer_url' => ['required', 'url'],
            'genre' => ['required', 'string', 'max:50'],
            'duration' => ['required', 'string', 'min:1', 'max:500'],
            'age_rating' => ['required', 'string', 'max:50'],
            'director' => ['required', 'string', 'max:100'],
            'actors' => ['required', 'string', 'max:255'],
        ];
    }
}
