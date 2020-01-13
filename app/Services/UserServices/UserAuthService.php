<?php


namespace Fronds\Services\UserServices;

use Auth;
use Fronds\Lib\Exceptions\Data\FrondsEntityNotFoundException;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Lib\Exceptions\Security\FrondsSecurityException;
use Fronds\Repositories\User\LoginVerificationTokenRepository;
use Fronds\Repositories\User\UserRepository;
use Fronds\Services\FrondsService;

/**
 * Class UserAuthService
 * @package Fronds\Services\UserServices
 */
class UserAuthService extends FrondsService
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var LoginVerificationTokenRepository
     */
    private $loginVerifyRepository;

    /**
     * UserAuthService constructor.
     * @param UserRepository $userRepository
     * @param LoginVerificationTokenRepository $loginVerifyRepository
     */
    public function __construct(UserRepository $userRepository, LoginVerificationTokenRepository $loginVerifyRepository)
    {
        $this->userRepository = $userRepository;
        $this->loginVerifyRepository = $loginVerifyRepository;
    }

    /**
     * First step, generate an encrypted token based on the username and password
     * Two tokens are generated. Tokens are one time use, so storing them in the database
     * doesn't matter, since once a token is used one time, that's it. They aren't decryption keys
     * Again they are NOT encryption keys and should never, ever be used as such.
     * A user won't be logged in unless the key itself works, not direct username and password
     * akin to generating a one time use login token.
     * So, no matter what username and password a user gives, a key token is returned.
     * However, if the username and password did not match, when the token is sent back in to be
     * verified, it won't work.
     *
     * Keys are constructed using the base64 encoded ipaddress of the person
     * logging in. If a login is successful, then the key will work and log the user in. However,
     * if the token, user, or password, were intercepted at any point in the transaction, the token will
     * become invalid by nature as the ip address the new information is coming from will have been touched
     * @param string $username
     * @param string $password
     * @return string
     * @throws FrondsException
     */
    public function startUserVerify(string $username, string $password): string
    {
        $userId = $this->userRepository->getIdByUsername($username);
        $token = '';
        if (Auth::validate(['email' => $username, 'password' => $password])) {
            $token = $this->loginVerifyRepository->addLoginToken($userId, $username, true);
        } else {
            $token = $this->loginVerifyRepository->addLoginToken($userId, $username, false);
        }
        return $token->token;
    }

    /**
     * Finish a user verification handshake and log the user in.
     * This functionality can be expanded to cover more than just login actions
     * and should be in the future. For example, changes that require a logged in user
     * to provide their password.
     * @param string $verificationToken
     * @throws FrondsException|FrondsEntityNotFoundException
     */
    public function endUserVerify(string $verificationToken): void
    {
        $token = $this->loginVerifyRepository->retrieveLoginStatus($verificationToken);
        fronds_throw_unless(
            $token->valid_origin,
            FrondsSecurityException::class,
            'Token Validation Failed, ip mismatch'
        );
        // this may need to move
        Auth::loginUsingId($token->user_id);
        $this->loginVerifyRepository->setTokenUsed($token->id);
    }
}
