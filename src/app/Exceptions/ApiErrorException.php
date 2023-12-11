<?php

namespace App\Exceptions;

use Exception;

class ApiErrorException extends Exception
{
    protected string $errCode;

    public function __construct(string $errCode, string $message, int $code)
    {
        parent::__construct($message, $code);
        $this->errCode = $errCode;
    }

    public function getErrCode(): string
    {
        return $this->errCode;
    }
}
