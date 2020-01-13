<?php
/**
 * User: zara
 * Date: 2019-02-25
 * Time: 17:01
 */

namespace Tests\Unit\Database;


use Fronds\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Fronds\Models\LoginVerificationToken;
use Tests\TestCase;
use Crypt;

class LoginVerificationTokenTableTest extends TestCase
{

    use RefreshDatabase;

    public function testAddLoginVerificationToken(): void
    {
        $loginVerificationToken = factory(LoginVerificationToken::class)->create();
        $this->assertDatabaseHas('login_verification_tokens', ['id' => $loginVerificationToken->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteLoginVerificationToken(): void
    {
        $loginVerificationToken = factory(LoginVerificationToken::class)->create();
        $this->assertDatabaseHas('login_verification_tokens', ['id' => $loginVerificationToken->id]);
        $loginVerificationToken = LoginVerificationToken::whereId($loginVerificationToken->id)->first();
        $loginVerificationToken->delete();
        $this->assertDatabaseMissing('login_verification_tokens',
            ['used_on' => null, 'id' => $loginVerificationToken->id]);
        $loginVerificationToken->forceDelete();
        $this->assertDatabaseMissing('login_verification_tokens', ['id' => $loginVerificationToken->id]);
    }

    public function testForUser(): void
    {
        $user = factory(User::class)->create();
        $loginVerificationToken = factory(LoginVerificationToken::class)->create([
            'user_id' => $user->id
        ]);
        $this->assertEquals($user->id, $loginVerificationToken->user->id);
    }

    public function testIsValidOriginAccessorInvalid(): void
    {
        $loginVerificationToken = factory(LoginVerificationToken::class)->create();
        $this->assertFalse($loginVerificationToken->valid_origin);
    }

    public function testIsValidOriginAccessorValid(): void
    {
        $user = factory(User::class)->create();
        $loginVerificationToken = factory(LoginVerificationToken::class)->create([
            'origin_ip' => '127.0.0.1',
            'token' => Crypt::encrypt([
                'username' => $user->email,
                'is_valid' => true,
                'ip' => '127.0.0.1'
            ]),
            'user_id' => $user->id
        ]);
        $this->assertTrue($loginVerificationToken->valid_origin);
    }
}