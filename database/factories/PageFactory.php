<?php

declare(strict_types=1);

namespace Database\Factories;

use Fronds\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class PageFactory
 *
 * @package Database\Factories
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'page_title' => $this->faker->title,
            'slug' => $this->faker->slug,
            'page_layout' => $this->faker->title
        ];
    }
}
