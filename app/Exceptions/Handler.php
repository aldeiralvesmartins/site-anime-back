<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ErrorMessages;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use ErrorMessages;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            debug($e);
            $this->report($e);
        });
    }

    public function render($request, Throwable $e)
    {
        $detailsError = $this->getDetailsError($e);

        return response()->json(
            MessageException::getMessage('Unknow Error',
                $detailsError['statusCode'],
                [
                    'msg' => $detailsError['message']
                ]
            ), $detailsError['statusCode'] === 0 ? Response::HTTP_UNPROCESSABLE_ENTITY : $detailsError['statusCode']);
    }
}
