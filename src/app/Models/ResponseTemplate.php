<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseTemplate extends Model
{
    use HasFactory;

    public static function errInvalidRefreshToken() {
        return [
            'ok' => false,
            'err' => 'ERR_INVALID_REFRESH_TOKEN',
            'msg' => 'invalid refresh token'
        ];
    }

    public static function errUnauthorized() {
        return [
            'ok' => false,
            'err' => 'ERR_UNAUTHORIZED',
            'msg' => 'unauthorized'
        ];
    }

    public static function errInvalidCledential() {
        return [
            'ok' => false,
            'err' => 'ERR_INVALID_CREDS',
            'msg' => 'incorrect username or password'
        ];
    }

    public static function err500() {
        return [
            'ok' => false,
            'err' => 'ERR_INTERNAL_SERVER',
            'msg' => 'internal server error'
        ];
    }

    public static function err405() {
        return [
            'ok' => false,
            'err' => 'ERR_METHOD_NOT_ALLOWED',
            'msg' => 'method not allowed'
        ];
    }
}
