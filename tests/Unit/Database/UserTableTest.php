<?php

namespace Tests\Unit\Database;

use Fronds\Models\Comment;
use Fronds\Models\FileUpload;
use Fronds\Models\Form;
use Fronds\Models\FrondsSetting;
use Fronds\Models\LoginVerificationToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Fronds\Models\User;

class UserTableTest extends TestCase
{

    use RefreshDatabase;

    public function testAddUser(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteUser(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $user->delete();
        $this->assertDatabaseMissing('users', ['deleted_at' => null, 'id' => $user->id]);
        $user->forceDelete();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testForms(): void
    {
        $user = User::factory()->create();
        Form::factory()->create([
            'created_by' => $user->id
        ]);
        self::assertCount(1, $user->forms);
    }

    public function testSettings(): void
    {
        $user = User::factory()->create();
        FrondsSetting::factory()->count(4)->create([
            'owner' => $user->id
        ]);
        self::assertCount(4, $user->settings);
    }

    public function testToken(): void
    {
        $user = User::factory()->create();
        $loginVerificationToken = LoginVerificationToken::factory()->create([
            'user_id' => $user->id
        ]);
        self::assertEquals($loginVerificationToken->id, $user->token->id);
    }

    public function testComments(): void
    {
        $user = User::factory()->create();
        Comment::factory()->count(2)->create([
            'internal_owner' => $user->id
        ]);
        self::assertCount(2, $user->comments);
    }

    public function testFileUploads(): void
    {
        $user = User::factory()->create();
        FileUpload::factory()->count(4)->create([
            'uploaded_by' => $user->id
        ]);
        self::assertCount(4, $user->uploads);
    }
}
