<?php

namespace App\Helpers;

class ApiFormatter
{
    protected static $response =  [
        'ok' =>  null,
        'data' => null,
    ];

    public static function responseSuccess($ok = null, $data = null)
    {
        self::$response = [
            'ok' => $ok,
            'data' => $data,
        ];

        return response()->json(self::$response);
    }

    public static function responseError($ok = null, $err = null, $msg = null)
    {
        self::$response = [
            'ok' => $ok,
            'err' => $err,
            'msg' => $msg,
        ];

        return response()->json(self::$response);
    }
}
