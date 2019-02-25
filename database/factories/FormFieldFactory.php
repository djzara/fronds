<?php

use Faker\Generator as Faker;

$factory->define(\Fronds\Models\FormField::class, function (Faker $faker) {
    return [
        'form_id' => function() {
            return factory(\Fronds\Models\Form::class)->create()->id;
        },
        'field_id' => function() {
            return factory(\Fronds\Models\Field::class)->create()->id;
        },
        'field_value' => $faker->randomAscii
    ];
});
