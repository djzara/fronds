<?php

declare(strict_types=1);

use Faker\Generator as Faker;
use Fronds\Models\User;

$factory->define(\Fronds\Models\Comment::class, static function (Faker $faker) {
    return [
        'body' => $faker->text,
        'comment_email' => $faker->email,
        'display_name' => $faker->name,
        'is_hidden' => $faker->boolean,
        'internal_owner' => static function() {
            return factory(User::class)->create()->id;
        }
    ];
});
