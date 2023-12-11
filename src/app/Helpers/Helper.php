<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class Helper
{
    /**
     * @param  mixed  $result
     * @return JsonResponse
     */
    public static function apiResponse(mixed $result = []): JsonResponse
    {
        if ($result instanceof JsonResource) {
            $response = $result->additional([
                'ok' => true,
            ]);

            return $response->response()->setStatusCode(Response::HTTP_OK);
        } else {
            $response = [
                'ok' => true,
                'data' => $result,
            ];

            return response()->json($response, Response::HTTP_OK);
        }
    }

    /**
     * @param  string  $message
     * @param  int  $code
     * @param  array  $data
     * @return JsonResponse
     */
    public static function apiErrorResponse(string $message = '', string $errCode = '', int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'ok' => false,
            'message' => $message,
            'err' => $errCode,
        ], $code);
    }
}
