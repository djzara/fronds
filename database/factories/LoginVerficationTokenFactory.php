<?php

use Faker\Generator as Faker;

$factory->define(\Fronds\Models\LoginVerificationToken::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(\Fronds\Models\User::class)->create()->id;
        },
        'token' => $faker->randomAscii,
        'origin_ip' => $faker->ipv4
    ];
});
