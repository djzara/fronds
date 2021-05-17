<?php

declare(strict_types=1);
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 17:12
 */

namespace Tests\Unit\Database;

use Fronds\Models\Comment;
use Fronds\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class CommentTableTest
 *
 * @package Tests\Unit\Database
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class CommentTableTest extends TestCase
{

    use RefreshDatabase;


    public function testAddComment(): void
    {
        $comment = Comment::factory()->create();
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteComment(): void
    {
        $comment = Comment::factory()->create();
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
        $commentToDelete = Comment::whereId($comment->id)->first();
        $commentToDelete->delete();
        $this->assertDatabaseMissing('comments', ['deleted_at' => null, 'id' => $commentToDelete->id]);
        $commentToDelete->forceDelete();
        $this->assertDatabaseMissing('comments', ['id' => $commentToDelete->id]);
    }

    public function testInternalUser(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create([
            'internal_owner' => $user->id
        ]);
        self::assertEquals($user->id, $comment->internal->id);
    }
}
