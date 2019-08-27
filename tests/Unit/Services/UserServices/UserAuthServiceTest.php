<?php


namespace Tests\Unit\Services\UserServices;

use Fronds\Lib\Exceptions\Data\FrondsEntityNotFoundException;
use Fronds\Models\LoginVerificationToken;
use Fronds\Repositories\User\LoginVerificationTokenRepository;
use Fronds\Repositories\User\UserRepository;
use Fronds\Services\UserServices\UserAuthService;
use Tests\TestCase;
use Fronds\Models\User;

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
}
