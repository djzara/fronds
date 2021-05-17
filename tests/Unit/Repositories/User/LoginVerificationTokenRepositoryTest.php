<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\User;

use Carbon\Carbon;
use Fronds\Lib\Exceptions\Data\FrondsEntityException;
use Fronds\Lib\Exceptions\Data\FrondsEntityNotFoundException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Models\LoginVerificationToken;
use Fronds\Models\User;
use Fronds\Repositories\FrondsRepository;
use Fronds\Repositories\User\LoginVerificationTokenRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class LoginVerificationTokenRepositoryTest
 * @package Tests\Unit\Repositories\User
 */
class LoginVerificationTokenRepositoryTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @var LoginVerificationTokenRepository
     */
    private $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = resolve(LoginVerificationTokenRepository::class);
    }

    public function testCheckModelClass(): void
    {
        self::assertInstanceOf(FrondsRepository::class, $this->repository);
        self::assertEquals(LoginVerificationToken::class, $this->repository->getModelClass());
    }

    /**
     * @throws \Fronds\Lib\Exceptions\Data\FrondsCreateEntityException
     * @throws \Fronds\Lib\Exceptions\FrondsException
     */
    public function testAddLoginToken(): void
    {
        $user = User::factory()->create();
        $validToken = $this->repository->addLoginToken($user->id, $user->name, true);
        $invalidToken = $this->repository->addLoginToken($user->id, $user->name, false);
        self::assertNotNull($validToken);
        self::assertNotNull($invalidToken);
    }

    public function testRetrieveLoginTokenStatusValid(): void
    {
        $token = LoginVerificationToken::factory()->create();
        try {
            $result = $this->repository->retrieveLoginStatus($token->token);
            self::assertNotNull($result);
        } catch (FrondsException $exception) {
            self::fail($exception->getMessage());
        }
    }

    public function testRetrieveLoginTokenStatusInvalid(): void
    {
        $this->expectException(FrondsEntityNotFoundException::class);
        $this->expectExceptionMessage('An invalid token was passed in');
        $this->repository->retrieveLoginStatus('thisisabadtoken');
    }

    public function testTokenUsedInvalidToken(): void
    {
        $this->expectException(FrondsEntityException::class);
        $this->expectExceptionMessage('Unknown token');
        $this->repository->setTokenUsed(12345667789);
    }

    public function testTokenUsedInvalidTokenCustomDate(): void
    {
        $customDate = Carbon::createFromTimestamp(time());
        $this->expectException(FrondsEntityException::class);
        $this->expectExceptionMessage('Unknown token');
        $this->repository->setTokenUsed(12345667789, $customDate);
    }

    public function testTokenUsedValidToken(): void
    {
        $token = LoginVerificationToken::factory()->create();
        $this->repository->setTokenUsed($token->id);
        $token->refresh();
        self::assertNotNull($token->used_on);
    }

    public function testTokenUsedValidTokenCustomDate(): void
    {
        $currentTime = time();
        $customDate = Carbon::createFromTimestamp($currentTime);
        $token = LoginVerificationToken::factory()->create();
        $this->repository->setTokenUsed($token->id, $customDate);
        $token->refresh();
        self::assertNotNull($token->used_on);
        self::assertSame($token->used_on->timestamp, $currentTime);
    }
}
