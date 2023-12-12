<?php

namespace App\Helpers;

class Constant
{
    public const ERR_INVALID_CREDS = "ERR_INVALID_CREDS";
    public const ERR_BAD_REQUEST = "ERR_BAD_REQUEST";
    public const ERR_INVALID_ACCESS_TOKEN = "ERR_INVALID_ACCESS_TOKEN";
    public const ERR_FORBIDDEN_ACCESS = "ERR_FORBIDDEN_ACCESS";
    public const ERR_NOT_FOUND = "ERR_NOT_FOUND";
    public const ERR_INTERNAL_ERROR = "ERR_INTERNAL_ERROR";
    public const ERR_INVALID_REFRESH_TOKEN = "ERR_INVALID_REFRESH_TOKEN";

    // In seconds
    public const ACCESS_TOKEN_TTL = 20;
    public const REFRESH_TOKEN_TTL = 60 * 60 * 24 * 7;

    public const CAN_ISSUE_ACCESS_TOKEN = 'can-issue-access-token';
    public const CAN_ACCESS_API = 'can-access-api';
}
