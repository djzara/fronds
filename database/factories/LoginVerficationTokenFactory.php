<?php

declare(strict_types=1);
/** @noinspection PhpPossiblePolymorphicInvocationInspection */

/** @noinspection PhpPossiblePolymorphicInvocationInspection */

/** @noinspection PhpVariableNamingConventionInspection */

/** @noinspection PhpVariableNamingConventionInspection */

/** @noinspection PhpVariableNamingConventionInspection */

/** @noinspection PhpVariableNamingConventionInspection */

/** @noinspection PhpVariableNamingConventionInspection */

use Fronds\Models\LoginVerificationToken;
use Fronds\Models\User;
use Illuminate\Database\Eloquent\Factory;
use Faker\Generator as Faker;

/** @var Factory $factory */
$factory->define(
    LoginVerificationToken::class, static function (Faker $faker) {
    $ipAddress = '9.2.3.4';
    $user = factory(User::class)->create(
        [
            'email' => $faker->email
        ]
    );
    return [
        'user_id' => static function () use ($user) {
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            return $user->id;
        },
        'token' => static function () use ($ipAddress, $user) {
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            return Crypt::encrypt([
                'username' => $user->email,
                'is_valid' => true,
                'ip' => $ipAddress
            ]);
        },
        'origin_ip' => $ipAddress
    ];
});
