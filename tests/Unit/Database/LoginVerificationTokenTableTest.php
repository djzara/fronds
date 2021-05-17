<?php

declare(strict_types=1);

namespace Tests\Unit\Database;

use Fronds\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Fronds\Models\LoginVerificationToken;
use Tests\TestCase;
use Crypt;

/**
 * Class LoginVerificationTokenTableTest
 *
 * @package Tests\Unit\Database
 * @author  Mike Lawson <mike@desertrat.io>
 * @license MIT https://opensource.org/licenses/MIT
 */
class LoginVerificationTokenTableTest extends TestCase
{

    use RefreshDatabase;

    public function testAddLoginVerificationToken(): void
    {
        $loginVerificationToken = LoginVerificationToken::factory()->create();
        $this->assertDatabaseHas('login_verification_tokens', ['id' => $loginVerificationToken->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteLoginVerificationToken(): void
    {
        $loginVerificationToken = LoginVerificationToken::factory()->create();
        $this->assertDatabaseHas('login_verification_tokens', ['id' => $loginVerificationToken->id]);
        $loginVerificationToken = LoginVerificationToken::whereId($loginVerificationToken->id)->first();
        $loginVerificationToken->delete();
        $this->assertDatabaseMissing(
            'login_verification_tokens',
            ['used_on' => null, 'id' => $loginVerificationToken->id]
        );
        $loginVerificationToken->forceDelete();
        $this->assertDatabaseMissing('login_verification_tokens', ['id' => $loginVerificationToken->id]);
    }

    public function testForUser(): void
    {
        $user = User::factory()->create();
        $loginVerificationToken = LoginVerificationToken::factory()->create([
            'user_id' => $user->id
        ]);
        self::assertEquals($user->id, $loginVerificationToken->user->id);
    }

    public function testIsValidOriginAccessorInvalid(): void
    {
        $loginVerificationToken = LoginVerificationToken::factory()->create();
        self::assertFalse($loginVerificationToken->valid_origin);
    }

    public function testIsValidOriginAccessorValid(): void
    {
        $user = User::factory()->create();
        $loginVerificationToken = LoginVerificationToken::factory()->create([
            'origin_ip' => '127.0.0.1',
            'token' => Crypt::encrypt([
                'username' => $user->email,
                'is_valid' => true,
                'ip' => '127.0.0.1'
            ]),
            'user_id' => $user->id
        ]);
        self::assertTrue($loginVerificationToken->valid_origin);
    }
}
