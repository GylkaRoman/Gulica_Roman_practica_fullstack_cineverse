<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHallRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'rows_count' => ['required', 'integer', 'min:4'],
            'seats_per_row' => ['required', 'integer', 'min:4'],
        ];
    }
}
