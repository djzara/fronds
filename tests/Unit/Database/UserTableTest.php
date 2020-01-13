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
        $user = factory(User::class)->create();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteUser(): void
    {
        $user = factory(User::class)->create();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $user->delete();
        $this->assertDatabaseMissing('users', ['deleted_at' => null, 'id' => $user->id]);
        $user->forceDelete();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testForms(): void
    {
        $user = factory(User::class)->create();
        factory(Form::class)->create([
            'created_by' => $user->id
        ]);
        $this->assertCount(1, $user->forms);
    }

    public function testSettings(): void
    {
        $user = factory(User::class)->create();
        factory(FrondsSetting::class, 4)->create([
            'owner' => $user->id
        ]);
        $this->assertCount(4, $user->settings);
    }

    public function testToken(): void
    {
        $user = factory(User::class)->create();
        $loginVerificationToken = factory(LoginVerificationToken::class)->create([
            'user_id' => $user->id
        ]);
        $this->assertEquals($loginVerificationToken->id, $user->token->id);
    }

    public function testComments(): void
    {
        $user = factory(User::class)->create();
        factory(Comment::class, 2)->create([
            'internal_owner' => $user->id
        ]);
        $this->assertCount(2, $user->comments);
    }

    public function testFileUploads(): void
    {
        $user = factory(User::class)->create();
        factory(FileUpload::class, 4)->create([
            'uploaded_by' => $user->id
        ]);
        $this->assertCount(4, $user->uploads);
    }
}
