<?php

declare(strict_types=1);

namespace Database\Factories;

use Fronds\Models\FrondsSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class FrondsSettingFactory
 *
 * @package Database\Factories
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class FrondsSettingFactory extends Factory
{
    protected $model = FrondsSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'setting_name' => $this->faker->randomAscii,
            'setting_value' => $this->faker->randomAscii,
            'setting_switch' => $this->faker->boolean,
            'setting_type' => $this->faker->randomElement(['text', 'switch', 'time']),
            'owner' => $this->faker->uuid
        ];
    }
}
