<?php


namespace Tests\Unit\Services\UserServices;

use Fronds\Lib\Exceptions\Data\FrondsEntityNotFoundException;
use Fronds\Lib\Exceptions\Security\FrondsSecurityException;
use Fronds\Models\LoginVerificationToken;
use Fronds\Repositories\User\LoginVerificationTokenRepository;
use Fronds\Repositories\User\UserRepository;
use Fronds\Services\UserServices\UserAuthService;
use Tests\TestCase;
use Fronds\Models\User;
use Crypt;

class UserAuthServiceTest extends TestCase
{

    /**
     * @var UserRepository|object
     */
    private $userRepositoryMock;

    /**
     * @var LoginVerificationTokenRepository|object
     */
    private $loginVerificationTokenRepositoryMock;

    /**
     * @var UserAuthService
     */
    private $userAuthService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = $this->mock(UserRepository::class);
        $this->loginVerificationTokenRepositoryMock = $this->mock(LoginVerificationTokenRepository::class);
        $this->userAuthService = new UserAuthService(
            $this->userRepositoryMock,
            $this->loginVerificationTokenRepositoryMock
        );
    }

    public function testStartUserVerifyBadCredentials(): void
    {
        $this->expectException(FrondsEntityNotFoundException::class);
        $this->expectExceptionMessage(__('auth.no_user'));
        $this->userRepositoryMock->shouldReceive('getIdByUsername')
            ->with('fronds_bad_username')
            ->andThrow(FrondsEntityNotFoundException::class, __('auth.no_user'));
        $this->userAuthService->startUserVerify('fronds_bad_username', '');
    }

    public function testStartUserVerifyGoodEmailBadPass(): void
    {
        $user = factory(User::class)->create();
        $loginVerificationToken = factory(LoginVerificationToken::class, [
            'user_id' => $user->id
        ])->make()[0];
        $this->userRepositoryMock->shouldReceive('getIdByUsername')
            ->with($user->email)
            ->andReturn($user->id);

        $this->loginVerificationTokenRepositoryMock->shouldReceive('addLoginToken')
            ->with($user->id, $user->email, false)
        ->andReturn($loginVerificationToken);
        $token = $this->userAuthService->startUserVerify($user->email, '');
        $this->assertEquals($token, $loginVerificationToken->token);
    }

    public function testStartUserVerificationValid(): void
    {
        $user = factory(User::class)->create();
        $loginVerificationToken = factory(LoginVerificationToken::class, [
            'user_id' => $user->id
        ])->make()[0];
        $this->userRepositoryMock->shouldReceive('getIdByUsername')
            ->with($user->email)
            ->andReturn($user->id);

        $this->loginVerificationTokenRepositoryMock->shouldReceive('addLoginToken')
            ->with($user->id, $user->email, true)
            ->andReturn($loginVerificationToken);
        $token = $this->userAuthService->startUserVerify($user->email, 'secret');
        $this->assertEquals($token, $loginVerificationToken->token);
    }

    public function testEndUserVerifyInvalidIp(): void
    {
        // the default doesn't take the current "request" in to account

        $token = factory(LoginVerificationToken::class)->create();
        $this->userRepositoryMock->shouldReceive('getIdByUsername')
            ->with($token->user->email)
            ->andReturn($token->user_id);
        $this->loginVerificationTokenRepositoryMock->shouldReceive('retrieveLoginStatus')
            ->with($token->token)
            ->andReturn($token);

        $this->assertFalse($token->valid_origin);

        $this->expectException(FrondsSecurityException::class);
        $this->expectExceptionMessage('Token Validation Failed, ip mismatch');
        $this->userAuthService->endUserVerify($token->token);
    }

    public function testEndUserVerifyValidIp(): void
    {
        // request always uses localhost for testing
        $user = factory(User::class)->create();
        $token = factory(LoginVerificationToken::class)->create([
            'origin_ip' => '127.0.0.1',
            'token' => Crypt::encrypt([
                'username' => $user->email,
                'is_valid' => true,
                'ip' => '127.0.0.1'
            ]),
            'user_id' => $user->id
        ]);
        $this->userRepositoryMock->shouldReceive('getIdByUsername')
            ->with($token->user->email)
            ->andReturn($token->user_id);
        $this->loginVerificationTokenRepositoryMock->shouldReceive('retrieveLoginStatus')
            ->with($token->token)
            ->andReturn($token);
        $this->loginVerificationTokenRepositoryMock->shouldReceive('setTokenUsed')
            ->with($token->id);

        $this->assertTrue($token->valid_origin);

        $this->userAuthService->endUserVerify($token->token);
    }
}
