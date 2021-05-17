<?php

declare(strict_types=1);

namespace Fronds\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class Slug
 *
 * @package Fronds\Rules
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class Slug implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[a-z\-]*$/', $value) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('widgets.action.panels.pages.validation.slug.slug');
    }
}
