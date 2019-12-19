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
            'page.sometimes' => 'You must specify which page to modify',
            'page.uuid' => 'Invalid ID passed for page',
            'title.required' => 'All pages must have a title',
            'slug.required' => 'All pages must have a slug',
            'slug.unique' => 'This slug has already been used, please use a different title or modify the slug.',
            'layout' => 'All pages must have a layout'
        ];
    }
}
