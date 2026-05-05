<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSessionRequest extends FormRequest
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
            'movie_id' => 'sometimes|exists:movies,id',
            'hall_id' => 'sometimes|exists:halls,id',
            'date' => 'sometimes|date',
            'time' => 'sometimes',
            'format' => 'sometimes|in:2D,3D',
            'language' => 'sometimes|in:ru,en,ro',
            'base_price' => 'sometimes|numeric|min:0',
        ];
    }
}
