<?php

declare(strict_types=1);

/** @noinspection PhpUndefinedVariableInspection */

use Faker\Generator as Faker;
use Fronds\Models\Page;

/** @noinspection PhpUndefinedVariableInspection */
$factory->define(
    Page::class, static function (Faker $faker) {
    return [
        'page_title' => $faker->title,
        'slug' => $faker->slug,
        'page_layout' => $faker->title
    ];
});
