<?php

use Faker\Generator as Faker;

$factory->define(\Fronds\Models\Page::class, function (Faker $faker) {
    return [
        'page_title' => $faker->title,
        'slug' => $faker->slug,
        'page_layout' => $faker->title
    ];
});
