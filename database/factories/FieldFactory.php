<?php

declare(strict_types=1);

namespace Database\Factories;

use Fronds\Models\Field;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class FieldFactory
 *
 * @package Database\Factories
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class FieldFactory extends Factory
{
    protected $model = Field::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'field_label' => $this->faker->randomAscii,
            'field_type' => 'text',
            'field_hint' => $this->faker->randomAscii
        ];
    }
}
