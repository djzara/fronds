<?php

use Faker\Generator as Faker;

$factory->define(\Fronds\Models\FileUpload::class, function (Faker $faker) {
    return [
        'original_file_name' => $faker->randomAscii,
        'current_file_name' => $faker->randomAscii,
        'file_mime' => $faker->fileExtension,
        'current_file_url' => $faker->url
    ];
});
