<?php


namespace Fronds\Repositories\User;

use Fronds\Lib\Exceptions\Data\FrondsEntityNotFoundException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Lib\Traits\Repositories\UsesUserModels;
use Fronds\Models\User;
use Fronds\Repositories\FrondsRepository;

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
        $user = User::whereEmail($username)->first();
        fronds_throw_if(
            $user === null,
            FrondsEntityNotFoundException::class,
            __('auth.no_user')
        );
        return $user->id;
    }
}
