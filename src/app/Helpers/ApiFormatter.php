<?php

namespace App\Helpers;

class ApiFormatter
{
    protected static $response =  [
        'ok' =>  null,
        'data' => null,
    ];

    public static function responseSuccess($ok = null, $data = null, $status_code = 200)
    {
        self::$response = [
            'ok' => $ok,
            'data' => $data,
        ];

        return response()->json(self::$response, $status_code);
    }

    public static function responseError($ok = null, $err = null, $msg = null, $status_code = 200)
    {
        self::$response = [
            'ok' => $ok,
            'err' => $err,
            'msg' => $msg,
        ];

        return response()->json(self::$response, $status_code);
    }
}
