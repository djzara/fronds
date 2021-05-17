<?php

declare(strict_types=1);

namespace Database\Factories;

use Fronds\Models\Form;
use Fronds\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class FormFactory
 *
 * @package Database\Factories
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class FormFactory extends Factory
{
    protected $model = Form::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'created_by' => User::factory()->create()->id,
            'form_link_title' => $this->faker->randomAscii,
            'form_title' => $this->faker->randomAscii,
            'form_description' => $this->faker->randomAscii,
            'form_raw_body' => $this->faker->randomAscii,
            'is_published' => $this->faker->boolean,
            'submit_to' => $this->faker->randomElement(['database', 'mail', 's3', 'csv'])
        ];
    }
}
