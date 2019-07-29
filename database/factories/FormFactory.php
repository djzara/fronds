<?php

use Faker\Generator as Faker;

$factory->define(\Fronds\Models\Form::class, function (Faker $faker) {
    return [
        'created_by' => function() {
            return factory(\Fronds\Models\User::class)->create()->id;
        },
        'form_link_title' => $faker->randomAscii,
        'form_title' => $faker->randomAscii,
        'form_description' => $faker->randomAscii,
        'form_raw_body' => $faker->randomAscii,
        'is_published' => $faker->boolean,
        'submit_to' => $faker->randomElement(['database', 'mail', 's3', 'csv'])
    ];
});
