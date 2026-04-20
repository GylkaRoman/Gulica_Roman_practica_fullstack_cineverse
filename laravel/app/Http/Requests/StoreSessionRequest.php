<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'movie_id' => ['required', 'exists:movies,id'],
            'hall_id' => ['required', 'exists:halls,id'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'format' => ['required', 'in:2D,3D'],
            'language' => ['required', 'in:ro,ru,en'],
            'base_price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
