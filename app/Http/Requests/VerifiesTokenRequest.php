<?php

namespace Fronds\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VerifiesTokenRequest
 * @package Fronds\Http\Requests
 */
class VerifiesTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO: may need to be more strict in the future
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
            'negotiation_token' => ['required']
        ];
    }
}
