<?php

namespace App\Exceptions;

use ErrorException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'not found'
                ], Response::HTTP_NOT_FOUND);
            }
        });

        $this->renderable(function (ErrorException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'internal server error'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    }
}
