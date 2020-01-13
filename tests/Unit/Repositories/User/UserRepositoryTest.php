<?php

namespace Tests\Unit\Repositories\User;

use Fronds\Lib\Exceptions\Data\FrondsEntityNotFoundException;
use Fronds\Models\User;
use Fronds\Repositories\User\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @var UserRepository
     */
    private $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = resolve(UserRepository::class);
    }

    public function testGetIdByUsernameValid(): void
    {
        $user = factory(User::class)->create();
        $idFromRepository = $this->repository->getIdByUsername($user->email);
        $this->assertEquals($user->id, $idFromRepository);
    }

    public function testGetIdByUsernameInvalid(): void
    {
        $this->expectException(FrondsEntityNotFoundException::class);
        $this->expectExceptionMessage(__('auth.no_user'));
        $this->repository->getIdByUsername('thiswillnevereverevereverbearealusername');
    }
}
