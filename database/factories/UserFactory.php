<?php

declare(strict_types=1);

namespace Database\Factories;

use Fronds\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Class UserFactory
 *
 * @package Database\Factories
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('secret'),
            'remember_token' => Str::random(),
            'fronds_folder_key' => 'folder_key'
        ];
    }
}
