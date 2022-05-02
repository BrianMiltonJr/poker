<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashoutStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'game_id' => ['required', 'integer', 'exists:games,id'],
            'player_id' => ['required', 'integer', 'exists:players,id'],
        ];
    }
}
