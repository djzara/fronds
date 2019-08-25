<?php


namespace Fronds\Repositories\User;

use Carbon\Carbon;
use Fronds\Lib\Exceptions\Data\FrondsCreateEntityException;
use Fronds\Lib\Exceptions\Data\FrondsEntityException;
use Fronds\Lib\Exceptions\Data\FrondsEntityNotFoundException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Models\LoginVerificationToken;
use Fronds\Repositories\FrondsRepository;
use Exception;
use Crypt;

/**
 * Class LoginVerificationTokenRepository
 * @package Fronds\Repositories\User
 */
class LoginVerificationTokenRepository extends FrondsRepository
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return LoginVerificationToken::class;
    }

    /**
     * Send the token back to the user to keep. They can pass the token around all they like
     * but it won't do anything unless it's the exact user who is trying to login.
     * If a user is set as invalid, when we retrieve the information, we also know if
     * the original login attempt found a valid user.
     * @param string $userId
     * @param string $username
     * @param bool $isValid
     * @return LoginVerificationToken The public token
     * @throws FrondsException|FrondsCreateEntityException
     */
    public function addLoginToken(string $userId, string $username, bool $isValid): LoginVerificationToken
    {
        $tokenPayload = Crypt::encrypt([
            'username' => $username,
            'is_valid' => $isValid,
            'ip' => request()->ip()
        ]);

        $token = LoginVerificationToken::create([
            'user_id' => $userId,
            'token' => $tokenPayload,
            'origin_ip' => request()->ip()
        ]);

        fronds_throw_if(
            $token === null,
            FrondsCreateEntityException::class,
            'Could not create verification token'
        );

        return $token;
    }

    /**
     * When the token is grabbed again we'll deserialize and retrieve the
     * 3 items we put in and verify if they've changed or not. If they are not
     * The same when we decrypt, someone has swapped tokens for another and is
     * trying to use that token to login. This prevents users from just
     * trying to intercept a token in hopes of logging in with it.
     * The username and password may be valid, but if the token is coming from the wrong
     * place, the username and password may have been compromised anyway
     * TODO: since this is implemented, it's not useful until we are doing something with violations
     * @param string $token
     * @return LoginVerificationToken
     * @throws FrondsException|FrondsEntityNotFoundException
     */
    public function retrieveLoginStatus(string $token): LoginVerificationToken
    {
        $tokenEntity = LoginVerificationToken::whereToken($token)->first();

        fronds_throw_unless(
            $tokenEntity !== null,
            FrondsEntityNotFoundException::class,
            'An invalid token was passed in'
        );

        return $tokenEntity;
    }

    /**
     * @param int $id
     * @param Carbon|null $altDate
     * @throws FrondsException|FrondsEntityException
     */
    public function setTokenUsed(int $id, ?Carbon $altDate = null): void
    {
        $entity = LoginVerificationToken::whereId($id);
        if ($altDate === null) {
            try {
                $entity->delete();
            } catch (Exception $exception) {
                fronds_throw_if(
                    false,
                    FrondsEntityException::class,
                    'Unknown token'
                );
            }
        } else {
            $entity->used_on = $altDate;
            $entity->save();
        }
    }
}
