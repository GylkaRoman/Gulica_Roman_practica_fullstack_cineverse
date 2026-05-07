<?php

namespace App\Http\Requests;

use App\Enums\SessionFormat;
use App\Enums\SessionLanguage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreSessionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'movie_id' => ['required', 'exists:movies,id'],
            'hall_id' => ['required', 'exists:halls,id'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'format' => ['required', new Enum(SessionFormat::class)],
            'language' => ['required', new Enum(SessionLanguage::class)],
            'base_price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
