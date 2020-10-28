<?php
/**
 * User: zara
 * Date: 2019-05-19
 * Time: 18:14
 */

namespace Fronds\Http\Controllers\api\v1\Auth;

use Fronds\Http\Controllers\api\ApiController;
use Fronds\Http\Requests\UserInfoRequest;
use Fronds\Http\Requests\VerifiesTokenRequest;
use Fronds\Lib\Exceptions\FrondsException;
use Fronds\Services\UserServices\UserAuthService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;

/**
 * Auth concerning users
 * Class UserVerificationController
 * @package Fronds\Http\Controllers\api\v1\Auth
 */
class UserVerificationController extends ApiController
{
    use AuthenticatesUsers;

    /**
     * @var UserAuthService
     */
    private UserAuthService $userAuthService;

    /**
     * @var JsonResponse
     */
    protected $currentResponse;

    /**
     * UserVerificationController constructor.
     * @param UserAuthService $userAuthService
     */
    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    /**
     * Retrieve the pre-login one time token for a given user/pass combo
     * This is what the username and password are actually sent to.
     * @param UserInfoRequest $userInfoRequest
     * @return JsonResponse
     * @codeCoverageIgnore
     * @deprecated
     */
    public function loginToken(UserInfoRequest $userInfoRequest): ?JsonResponse
    {
        try {
            $token = $this->userAuthService->startUserVerify(
                $userInfoRequest->input('email'),
                $userInfoRequest->input('password')
            );

            $baseResponse = $this->apiSuccess('negotiations started');
            $methodToUse = request()->method();
            $this->currentResponse = $this->apiRsvp(
                $baseResponse,
                route('admin.auth.resolve'),
                $methodToUse,
                ['negotiation_token' => $token]
            );
        } catch (FrondsException $frondsException) {
            $this->currentResponse = $this->apiError($frondsException);
        } finally {
            return $this->currentResponse;
        }
    }

    /**
     * @param VerifiesTokenRequest $verifiesTokenRequest
     * @return JsonResponse|null
     * @codeCoverageIgnore
     * @deprecated
     */
    public function finishLogin(VerifiesTokenRequest $verifiesTokenRequest): ?JsonResponse
    {
        try {
            $this->userAuthService->endUserVerify($verifiesTokenRequest->input('negotiation_token'));
            $this->currentResponse = $this->apiSuccess(__('auth.login_success'), [
                'redirectTo' => route('fronds.admin.manage')
            ]);
        } catch (FrondsException $frondsException) {
            $this->currentResponse = $this->apiError($frondsException);
        } finally {
            return $this->currentResponse;
        }
    }
}
