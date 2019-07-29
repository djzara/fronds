<?php

use Faker\Generator as Faker;

$factory->define(\Fronds\Models\FrondsSetting::class, function (Faker $faker) {
    return [
        'setting_name' => $faker->randomAscii,
        'setting_value' => $faker->randomAscii,
        'setting_switch' => $faker->boolean,
        'setting_type' => $faker->randomElement(['text', 'switch', 'time']),
        'owner' => $faker->uuid
    ];
});
