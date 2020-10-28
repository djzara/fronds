<?php

declare(strict_types=1);

/** @noinspection PhpUndefinedVariableInspection */

use Faker\Generator as Faker;
use Fronds\Models\FileUpload;

/** @noinspection PhpUndefinedVariableInspection */
$factory->define(
    FileUpload::class, static function (Faker $faker) {
    return [
        'original_file_name' => $faker->randomAscii,
        'current_file_name' => $faker->randomAscii,
        'file_mime' => $faker->fileExtension,
        'current_file_url' => $faker->url
    ];
});
