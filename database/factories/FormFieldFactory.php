<?php

declare(strict_types=1);
namespace Database\Factories;

use Fronds\Models\Field;
use Fronds\Models\Form;
use Fronds\Models\FormField;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class FormFieldFactory
 *
 * @package Database\Factories
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class FormFieldFactory extends Factory
{
    protected $model = FormField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'form_id' => Form::factory()->create()->id,
            'field_id' => Field::factory()->create()->id,
            'field_value' => $this->faker->randomAscii
        ];
    }
}
