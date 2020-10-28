<?php

declare(strict_types=1);
/** @noinspection PhpUndefinedVariableInspection */

/** @noinspection PhpPossiblePolymorphicInvocationInspection */

/** @noinspection PhpPossiblePolymorphicInvocationInspection */

use Faker\Generator as Faker;
use Fronds\Models\Field;
use Fronds\Models\Form;
use Fronds\Models\FormField;

/** @noinspection PhpUndefinedVariableInspection */
$factory->define(
    FormField::class, static function (Faker $faker) {
    return [
        'form_id' => static function() {
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            return factory(Form::class)->create()->id;
        },
        'field_id' => static function() {
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            return factory(Field::class)->create()->id;
        },
        'field_value' => $faker->randomAscii
    ];
});
