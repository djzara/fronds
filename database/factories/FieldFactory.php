<?php

use Faker\Generator as Faker;

$factory->define(\Fronds\Models\Field::class, function (Faker $faker) {
    return [
        'field_label' => $faker->randomAscii,
        'field_markup_id' => $faker->randomAscii,
        'field_type' => 'text',
        'field_hint' => $faker->randomAscii
    ];
});
