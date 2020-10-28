<?php

declare(strict_types=1);
/** @noinspection PhpUndefinedVariableInspection */

/** @noinspection PhpPossiblePolymorphicInvocationInspection */

use Faker\Generator as Faker;
use Fronds\Models\Form;
use Fronds\Models\User;

/** @noinspection PhpUndefinedVariableInspection */
$factory->define(
    Form::class, static function (Faker $faker) {
    return [
        'created_by' => static function() {
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            return factory(User::class)->create()->id;
        },
        'form_link_title' => $faker->randomAscii,
        'form_title' => $faker->randomAscii,
        'form_description' => $faker->randomAscii,
        'form_raw_body' => $faker->randomAscii,
        'is_published' => $faker->boolean,
        'submit_to' => $faker->randomElement(['database', 'mail', 's3', 'csv'])
    ];
});
