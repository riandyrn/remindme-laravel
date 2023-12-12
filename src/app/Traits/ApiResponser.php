<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser
{
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json([
            'ok' => true,
            'data' => $data
        ], $code);
    }


    public function errorResponse($message, $errorMessages = "", $code = Response::HTTP_NOT_FOUND)
    {
        return response()->json([
            'ok' => false,
            'err' => $message,
            'msg' => $errorMessages
        ], $code);
    }
}
