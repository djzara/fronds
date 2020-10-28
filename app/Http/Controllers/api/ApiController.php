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

/**
 * Class ApiController
 * @package Fronds\Http\Controllers\api
 */
abstract class ApiController extends Controller
{

    protected $currentResponse;

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
    ) :JsonResponse {
        return $this->apiResponse($message, $responseCode, $payload);
    }

    /**
     * @param FrondsException $exception
     * @return JsonResponse
     */
    final protected function apiError(FrondsException $exception): JsonResponse
    {
        $responseArr = [
            'error_code' => $exception->getExceptionCode(),
            'message' => $exception->getMessage()
        ];
        return $this->apiResponse($exception->getMessage(), $exception->getHttpErrorCode(), $responseArr);
    }

    /**
     * @param JsonResponse $appendTo
     * @param string $rsvpTo
     * @param string $rsvpUsing
     * @param array $rsvpPayload
     * @return JsonResponse
     */
    final protected function apiRsvp(
        JsonResponse $appendTo,
        string $rsvpTo,
        string $rsvpUsing,
        array $rsvpPayload = []
    ):JsonResponse {
        $rsvp = [
            'rsvp' => [
                'to' => $rsvpTo,
                'using' => $rsvpUsing,
                'with' => $rsvpPayload
            ]
        ];
        $originalResponseCode = $appendTo->getStatusCode();
        $originalData = $appendTo->getData(true); // underneath it's just calling json_decode, takes the same params
        $newResponse = array_merge($originalData['data'], $rsvp);
        return $this->apiResponse($originalData['message'], $originalResponseCode, $newResponse);
    }

    /**
     * @param string $message
     * @param int $responseCode
     * @param array $payload
     * @return JsonResponse
     */
    final protected function apiResponse(string $message, int $responseCode, array $payload = []): JsonResponse
    {
        $responseArr = [
            'message' => $message,
            'data' => $payload
        ];
        return response()->json($responseArr, $responseCode);
    }
}
