<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            if ($exception->getStatusCode() == 404) {
                return response()->view('errors/404', [], 404);
            }
        }

        if ( $request->expectsJson() or Str::contains($request->route()->getName(), 'api.') ) {
            switch (get_class($exception)) {
                case \Illuminate\Validation\ValidationException::class:
                    $number = 400;
                    if ($exception->validator->getMessageBag()->all() == [__('response.not_found')]) {
                        $number = 404;
                    }
                    return response()->json(['data' => 'error', 'message' => $exception->validator->getMessageBag()->all()], $number);
                case \Illuminate\Auth\Access\AuthorizationException::class:
                    return response()->json(['data' => 'error', 'message' => [__('response.unauthenticated')]], 401);
                case \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException::class:
                    return response()->json(['data' => 'error', 'message' => [__('response.not_supported')]], 405);
                default:
                    return parent::render($request, $exception);
            }
        }

        return parent::render($request, $exception);
    }
}
