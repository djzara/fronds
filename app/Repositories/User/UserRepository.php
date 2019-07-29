<?php


namespace Fronds\Repositories\User;

use Fronds\Lib\Exceptions\Data\FrondsEntityException;
use Fronds\Lib\Traits\Repositories\UsesUserModels;
use Fronds\Models\User;
use Fronds\Repositories\FrondsRepository;
use Fronds\Lib\Exceptions\FrondsException;

/**
 * Class UserRepository
 * @package Fronds\Repositories\User
 */
class UserRepository extends FrondsRepository
{

    use UsesUserModels;

    public function getModelClass(): string
    {
        return User::class;
    }

    /**
     * @param string $username
     * @return string
     * @throws FrondsException
     */
    public function getIdByUsername(string $username): string
    {
        $userId = User::whereEmail($username)->id;
        fronds_throw_if(
            $userId === null,
            FrondsEntityException::class,
            'User does not exist!'
        );
        return $userId;
    }
}