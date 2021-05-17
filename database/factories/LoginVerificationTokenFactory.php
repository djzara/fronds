<?php

declare(strict_types=1);

namespace Database\Factories;

use Fronds\Models\LoginVerificationToken;
use Fronds\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Crypt;

/**
 * Class LoginVerificationTokenFactory
 *
 * @package Database\Factories
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class LoginVerificationTokenFactory extends Factory
{
    protected $model = LoginVerificationToken::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $ipAddress = '9.2.3.4';
        $user = User::factory()->create(
            [
                'email' => $this->faker->email
            ]
        );
        return [
            'user_id' => $user->id,
            'token' => Crypt::encrypt(
                [
                    'username' => $user->email,
                    'is_valid' => true,
                    'ip' => $ipAddress
                ]
            ),
            'origin_ip' => $ipAddress
        ];
    }
}
