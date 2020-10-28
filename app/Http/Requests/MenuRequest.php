<?php

namespace Fronds\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

/**
 * Class MenuRequest
 *
 * @package Fronds\Http\Requests
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class MenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required'],
            'type' => ['required', Rule::in(['list', 'dropdown'])],
            'items' => ['required'],
            'items.*.direct_to' => ['required', Rule::in(['external', 'page'])],
            'items.*.external_link' => ['sometimes', 'url'],
            'items.*.page_id' => ['sometimes', 'uuid', 'exists:pages'],
            'items.*.label' => ['required'],
            'items.*.list_order' => ['sometimes', 'numeric'],
            'items.*.uuid' => ['sometimes', 'uuid', 'exists:menu_items']

        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => __('validation.custom.menu_name.required'),
            'type.required' => __('validation.custom.menu_type.required'),
            'type.in' => __('validation.custom.menu_type.in'),
            'items.required' => __(),
            'items.*.direct_to.required' => __('validation.custom.menu_items.directs_to.required'),
            'items.*.direct_to.in' => __('validation.custom.menu_items.directs_to.in'),
            'items.*.external_link.sometimes' => __('validation.custom.menu_items.external_link.sometimes'),
            'items.*.external_link.url' => __('validation.custom.menu_items.external_link.url'),
            'items.*.page_id.sometimes' => __('validation.custom.menu_items.page_id.sometimes'),
            'items.*.page_id.uuid' => __('validation.custom.menu_items.page_id.uuid'),
            'items.*.page_id.exists' => __('validation.custom.menu_items.page_id.exists'),
            'items.*.label.required' => __('validation.custom.menu_items.label.required'),
            'items.*.list_order.sometimes' => __('validation.custom.menu_items.list_order.sometimes'),
            'items.*.list_order.numeric' => __('validation.custom.menu_items.list_order.numeric')
        ];
    }
}
