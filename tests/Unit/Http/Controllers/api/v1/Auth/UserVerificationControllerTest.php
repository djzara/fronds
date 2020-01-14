<?php

namespace Tests\Unit\Http\Controllers\api\v1\Auth;

use Crypt;
use Fronds\Lib\Constants\ExceptionConstants;
use Fronds\Lib\Exceptions\Data\FrondsEntityNotFoundException;
use Fronds\Lib\Exceptions\Security\FrondsSecurityException;
use Fronds\Models\User;
use Fronds\Services\UserServices\UserAuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class UserVerificationControllerTest
 * @package Tests\Unit\Http\Controllers\api\v1\Auth
 */
class UserVerificationControllerTest extends TestCase
{

    use RefreshDatabase;

    private $userAuthServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->userAuthServiceMock = $this->mock(UserAuthService::class);
    }

    /**
     * When it comes time for the username/password combo test, we drop in to currently available
     * fronds custom exceptions
     */
    public function testInvalidUserPassCombo(): void
    {
        $user = factory(User::class)->make([
            'password' => bcrypt('secret')
        ]);
        $this->userAuthServiceMock->shouldReceive('startUserVerify')
            ->with($user->email, 'secret')
            ->andReturn('tokenPayload');
        $response = $this->post(route('fronds.admin.submit.login'), [
            'email' => $user->email,
            'password' => 'invalidpassword'
        ]);

        $response->assertRedirect();
    }

    /**
     * The following test assumes api mode for login
     */
    public function testMissingUsername(): void
    {

        $response = $this->postJson(route('admin.auth.verify'), [
            'password' => 'secret'
        ]);
        $response->assertStatus(422);
        $response->assertExactJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => [
                    __('validation.custom.email.required')
                ]
            ]
        ]);
    }

    /**
     * The following test assumes api mode for login
     */
    public function testInvalidUsername(): void
    {
        $this->userAuthServiceMock->shouldReceive('startUserVerify')
            ->with('iamnotanemail', 'secret')
            ->andReturn('$tokenPayload');
        $response = $this->postJson(route('admin.auth.verify'), [
            'email' => 'iamnotanemail',
            'password' => 'secret'
        ]);
        $response->assertStatus(422);
        $response->assertExactJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => [
                    __('validation.custom.email.email')
                ]
            ]
        ]);
    }

    /**
     * The following test assumes api mode for login
     */
    public function testValidUserGetsToken(): void
    {

        $user = factory(User::class)->make([
            'password' => bcrypt('secret')
        ]);
        $tokenPayload = Crypt::encrypt([
            'username' => $user->email,
            'is_valid' => true,
            'ip' => '0.0.0.0'
        ]);
        $this->userAuthServiceMock->shouldReceive('startUserVerify')
            ->with($user->email, 'secret')
            ->andReturn($tokenPayload);
        $response = $this->postJson(route('admin.auth.verify'), [
            'email' => $user->email,
            'password' => 'secret'
        ]);
        $response->assertOk();
        $response->assertExactJson([
            'message' => 'negotiations started',
            'data' => [
                'rsvp' => [
                    'to' => route('admin.auth.resolve'),
                    'using' => 'POST',
                    'with' => [
                        'negotiation_token' => $tokenPayload
                    ]

                ]
            ]
        ]);
    }

    /**
     * The following test assumes api mode for login
     */
    public function testValidUserValidToken(): void
    {
        $user = factory(User::class)->make([
            'password' => bcrypt('secret')
        ]);
        $tokenPayload = Crypt::encrypt([
            'username' => $user->email,
            'is_valid' => true,
            'ip' => '0.0.0.0'
        ]);
        $this->userAuthServiceMock->shouldReceive('endUserVerify')
            ->with($tokenPayload);
        $response = $this->postJson(route('admin.auth.resolve'), [
            'negotiation_token' => $tokenPayload
        ]);
        $response->assertOk();
        $response->assertExactJson([
            'message' => __('auth.login_success'),
            'data' => [
                'redirectTo' => route('fronds.admin.manage')
            ]
        ]);
    }

    /**
     * The following test assumes api mode for login
     */
    public function testValidUserInvalidToken(): void
    {
        $user = factory(User::class)->make([
            'password' => bcrypt('secret')
        ]);
        $tokenPayload = Crypt::encrypt([
            'username' => $user->email,
            'is_valid' => true,
            'ip' => '0.0.0.0'
        ]);
        $this->userAuthServiceMock->shouldReceive('endUserVerify')
            ->with($tokenPayload)
        ->andThrow(FrondsEntityNotFoundException::class, 'An invalid token was passed in');
        $response = $this->postJson(route('admin.auth.resolve'), [
            'negotiation_token' => $tokenPayload
        ]);
        $response->assertNotFound();
        $response->assertExactJson([
            'message' => 'An invalid token was passed in',
            'data' => [
                'error_code' => ExceptionConstants::FRONDS_DATA
                    | ExceptionConstants::COULD_NOT_FIND
                    | ExceptionConstants::FRONDS_ERROR,
                'message' => 'An invalid token was passed in'
            ]
        ]);
    }

    /**
     * The following test assumes api mode for login
     */
    public function testValidUserInvalidIp(): void
    {
        $user = factory(User::class)->make([
            'password' => bcrypt('secret')
        ]);
        $tokenPayload = Crypt::encrypt([
            'username' => $user->email,
            'is_valid' => true,
            'ip' => '0.0.0.0'
        ]);
        $this->userAuthServiceMock->shouldReceive('endUserVerify')
            ->with($tokenPayload)
            ->andThrow(FrondsSecurityException::class, 'Token Validation Failed, ip mismatch');
        $response = $this->postJson(route('admin.auth.resolve'), [
            'negotiation_token' => $tokenPayload
        ]);
        $response->assertStatus(422);
        $response->assertExactJson([
            'message' => 'Token Validation Failed, ip mismatch',
            'data' => [
                'error_code' => ExceptionConstants::FRONDS_CLIENT
                    | ExceptionConstants::FRONDS_HALT
                    | ExceptionConstants::ILLEGAL_ACCESS,
                'message' => 'Token Validation Failed, ip mismatch'
            ]
        ]);
    }
}
