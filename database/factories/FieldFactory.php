<?php

declare(strict_types=1);

/** @noinspection PhpUndefinedVariableInspection */

use Faker\Generator as Faker;
use Fronds\Models\Field;

/** @noinspection PhpUndefinedVariableInspection */
$factory->define(
    Field::class, static function (Faker $faker) {
    return [
        'field_label' => $faker->randomAscii,
        'field_type' => 'text',
        'field_hint' => $faker->randomAscii
    ];
});
