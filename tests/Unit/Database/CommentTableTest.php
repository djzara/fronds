<?php
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

class CommentTableTest extends TestCase
{

    use RefreshDatabase;


    public function testAddComment(): void
    {
        $comment = factory(Comment::class)->create();
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);

    }

    /**
     * @throws \Exception
     */
    public function testDeleteComment(): void
    {
        $comment = factory(Comment::class)->create();
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
        $commentToDelete = Comment::whereId($comment->id)->first();
        $commentToDelete->delete();
        $this->assertDatabaseMissing('comments', ['deleted_at' => null, 'id' => $commentToDelete->id]);
        $commentToDelete->forceDelete();
        $this->assertDatabaseMissing('comments', ['id' => $commentToDelete->id]);
    }

    public function testInternalUser(): void
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create([
            'internal_owner' => $user->id
        ]);
        $this->assertEquals($user->id, $comment->internal->id);
    }
}
