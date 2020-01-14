<?php

namespace Fronds\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends FormRequest
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
            'email' => ['email', 'required'],
            'password' => ['filled'],
            'avatar' => ['sometimes', 'filled', 'image', 'size:2048'],
            'action' => ['sometimes'] // for logging
        ];
    }

    public function messages()
    {
        return [
            'email.required' => __('validation.custom.email.required'),
            'email.email' => __('validation.custom.email.email')
        ];
    }
}
