<?php
/**
 * User: zara
 * Date: 2019-05-19
 * Time: 17:54
 */

namespace Fronds\Http\Controllers\api;

use Fronds\Http\Controllers\Controller;
use Fronds\Lib\Constants\HttpConstants;
use Fronds\Lib\Exceptions\FrondsException;
use Illuminate\Http\JsonResponse;

abstract class ApiController extends Controller
{

    /**
     * @param string $message
     * @param array $payload
     * @param int $responseCode
     * @return JsonResponse
     */
    final protected function apiSuccess(
        string $message,
        array $payload = [],
        int $responseCode = HttpConstants::HTTP_OK
    ) : JsonResponse {
        return $this->apiResponse($message, $responseCode, $payload);
    }

    /**
     * @param FrondsException $exception
     * @return JsonResponse
     */
    final protected function apiError(FrondsException $exception) : JsonResponse
    {
        $responseArr = [
            'error_code' => $exception->getExceptionCode(),
            'message' => $exception->getMessage()
        ];
        return $this->apiResponse($exception->getMessage(), $exception->getHttpErrorCode(), $responseArr);
    }

    /**
     * @param string $message
     * @param int $responseCode
     * @param array $payload
     * @return JsonResponse
     */
    final protected function apiResponse(string $message, int $responseCode, array $payload = []) : JsonResponse
    {
        $responseArr = [
            'message' => $message,
            'data' => $payload
        ];
        return response()->json($responseArr, $responseCode);
    }
}
