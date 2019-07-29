<?php

namespace Tests\Unit\Repositories\User;

use Fronds\Models\LoginVerificationToken;
use Fronds\Repositories\FrondsRepository;
use Fronds\Repositories\User\LoginVerificationTokenRepository;
use Tests\TestCase;

/**
 * Class LoginVerificationTokenRepositoryTest
 * @package Tests\Unit\Repositories\User
 */
class LoginVerificationTokenRepositoryTest extends TestCase
{
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
        $this->assertInstanceOf(FrondsRepository::class, $this->repository);
        $this->assertEquals(LoginVerificationToken::class, $this->repository->getModelClass());
    }

    public function tokenPacketProvider(): array
    {
        return [
            'valid user' => ['fronds_user', '127.0.0.1', true],
            'invalid user' => ['fronds_user2', '8.8.8.8', false]
        ];
    }

}