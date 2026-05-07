<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSessionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'movie_id' => ['sometimes', 'integer', 'exists:movies,id'],
            'hall_id' => ['sometimes', 'integer', 'exists:halls,id'],
            'date' => ['sometimes', 'date', 'after_or_equal:today'],
            'time' => ['sometimes', 'date_format:H:i'],
            'format' => ['sometimes', 'in:2D,3D'],
            'language' => ['sometimes', 'in:ru,en,ro'],
            'base_price' => ['sometimes', 'numeric', 'min:0'],
        ];
    }
}
