<?php

declare(strict_types=1);

/** @noinspection PhpUndefinedVariableInspection */

use Faker\Generator as Faker;
use Fronds\Models\FrondsSetting;

/** @noinspection PhpUndefinedVariableInspection */
$factory->define(
    FrondsSetting::class, static function (Faker $faker) {
    return [
        'setting_name' => $faker->randomAscii,
        'setting_value' => $faker->randomAscii,
        'setting_switch' => $faker->boolean,
        'setting_type' => $faker->randomElement(['text', 'switch', 'time']),
        'owner' => $faker->uuid
    ];
});
