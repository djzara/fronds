<?php

use Faker\Generator as Faker;

$factory->define(\Fronds\Models\Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'comment_email' => $faker->email,
        'display_name' => $faker->name,
        'is_hidden' => $faker->boolean,
        'internal_owner' => function() {
            return factory(\Fronds\Models\User::class)->create()->id;
        }
    ];
});
