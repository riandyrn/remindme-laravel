<?php

namespace App\Helpers;

class ApiFormatter
{
    protected static $response =  [
        'ok' =>  null,
        'data' => null,
    ];

    public static function responseSuccess($data = null, $status_code = 200)
    {
        self::$response = [
            'ok' => true,
            'data' => $data,
        ];

        return response()->json(self::$response, $status_code);
    }

    public static function responseError($err = null, $msg = null, $status_code = 200)
    {
        self::$response = [
            'ok' => false,
            'err' => $err,
            'msg' => $msg,
        ];

        return response()->json(self::$response, $status_code);
    }

}
