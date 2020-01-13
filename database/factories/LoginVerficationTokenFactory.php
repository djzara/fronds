<?php
use Illuminate\Database\Eloquent\Factory;
use Faker\Generator as Faker;

/** @var Factory $factory */
$factory->define(\Fronds\Models\LoginVerificationToken::class, static function (Faker $faker) {
    $ipAddress = '9.2.3.4';
    $user = factory(\Fronds\Models\User::class)->create(
        [
            'email' => $faker->email
        ]
    );
    return [
        'user_id' => static function () use ($user) {
            return $user->id;
        },
        'token' => static function () use ($ipAddress, $user) {
            return Crypt::encrypt([
                'username' => $user->email,
                'is_valid' => true,
                'ip' => $ipAddress
            ]);
        },
        'origin_ip' => $ipAddress
    ];
});
