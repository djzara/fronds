<?php

declare(strict_types=1);

namespace Database\Factories;

use Fronds\Models\Comment;
use Fronds\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class CommentFactory
 *
 * @package Database\Factories
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class CommentFactory extends Factory
{

    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->text,
            'comment_email' => $this->faker->email,
            'display_name' => $this->faker->name,
            'is_hidden' => $this->faker->boolean,
            'internal_owner' => User::factory()->create()->id

        ];
    }
}
