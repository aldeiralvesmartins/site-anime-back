<?php

namespace App\Exceptions;

class Cenfit
{
    public function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function messagException(string $message)
    {
        return throw new \Exception($message);
    }
}
