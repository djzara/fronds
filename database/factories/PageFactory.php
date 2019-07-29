<?php

use Faker\Generator as Faker;

$factory->define(\Fronds\Models\Page::class, function (Faker $faker) {
    return [
        'page_title' => $faker->title,
        'page_body' => $faker->text,
        'page_content_width' => $faker->numberBetween(0,255),
        'page_content_height' => $faker->numberBetween(0, 255),
        'form_id' => function() {
            return factory(\Fronds\Models\Form::class)->create()->id;
        }
    ];
});
