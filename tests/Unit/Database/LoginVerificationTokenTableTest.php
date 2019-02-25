<?php
/**
 * User: zara
 * Date: 2019-02-25
 * Time: 17:01
 */

namespace Tests\Unit\Database;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Fronds\Models\LoginVerificationToken;
use Tests\TestCase;

class LoginVerificationTokenTableTest extends TestCase
{

    use RefreshDatabase;

    public function testAddLoginVerificationToken() : void {
        $loginVerificationToken = factory(LoginVerificationToken::class)->create();
        $this->assertDatabaseHas('login_verification_tokens', ['id' => $loginVerificationToken->id]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteLoginVerificationToken() : void {
        $loginVerificationToken = factory(LoginVerificationToken::class)->create();
        $this->assertDatabaseHas('login_verification_tokens', ['id' => $loginVerificationToken->id]);
        $loginVerificationTokenToDelete = LoginVerificationToken::whereId($loginVerificationToken->id)->first();
        $loginVerificationTokenToDelete->delete();
        $this->assertDatabaseMissing('login_verification_tokens',
            ['used_on' => null, 'id' => $loginVerificationTokenToDelete->id]);
        $loginVerificationTokenToDelete->forceDelete();
        $this->assertDatabaseMissing('login_verification_tokens', ['id' => $loginVerificationTokenToDelete->id]);
    }
}