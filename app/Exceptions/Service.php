<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Throwable;

class Service extends Cenfit
{
    public function __construct(string $message = '', int $code = Response::HTTP_UNAUTHORIZED, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
