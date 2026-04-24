<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'session_id' => ['required', 'exists:movie_sessions,id'],
            'seat_ids' => ['required', 'array', 'min:1'],
            'seat_ids.*' => ['exists:seats,id'],
        ];
    }
}
