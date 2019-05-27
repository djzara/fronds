<?php
/**
 * User: zara
 * Date: 2019-05-19
 * Time: 18:14
 */

namespace Fronds\Http\Controllers\api\v1\Auth;

use Fronds\Http\Controllers\api\ApiController;
use Illuminate\Http\JsonResponse;

/**
 * Auth concerning users
 * Class UserVerificationController
 * @package Fronds\Http\Controllers\api\v1\Auth
 */
class UserVerificationController extends ApiController
{
    /**
     * Retrieve the pre-login one time token for a given user/pass combo
     * This is what the username and password are actually sent to.
     * @return JsonResponse
     */
    public function loginToken() : JsonResponse
    {
        return $this->apiSuccess('called me');
    }
}
