<?php

namespace Fronds\Http\Requests;

use Fronds\Rules\Slug as SlugRule;
use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO: make sure to only allow users with the correct permissions
        // instead of just leaving this as true
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
            'page' => ['sometimes', 'uuid'],
            'title' => ['required'],
            'slug' => ['required', new SlugRule(), 'unique:pages,slug'],
            'layout' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'page.sometimes' => __('validation.custom.page.sometimes'),
            'page.uuid' => __('validation.custom.page.uuid'),
            'title.required' => __('validation.custom.title.required'),
            'slug.required' => __('validation.custom.slug.required'),
            'slug.unique' => __('validation.custom.slug.unique'),
            'layout.required' => __('validation.custom.layout.required')
        ];
    }
}
