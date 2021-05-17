<?php

declare(strict_types=1);

namespace Database\Factories;

use Fronds\Models\FileUpload;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class FileUploadFactory
 *
 * @package Database\Factories
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class FileUploadFactory extends Factory
{
    protected $model = FileUpload::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'original_file_name' => $this->faker->randomAscii,
            'current_file_name' => $this->faker->randomAscii,
            'file_mime' => $this->faker->fileExtension,
            'current_file_url' => $this->faker->url
        ];
    }
}
