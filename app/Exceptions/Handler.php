<?php

namespace App\Exceptions;

use Exa\Exceptions\ExaException;
use Exa\Http\Responses\ApiErrorResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
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
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return $this->error($exception, Response::HTTP_UNAUTHORIZED, 'Unauthenticated');
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return $this->error($exception, Response::HTTP_UNPROCESSABLE_ENTITY, $exception->errors());
        }

        if (
            $exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException
            || $exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
        ) {
            return $this->error($exception, Response::HTTP_NOT_FOUND, 'Resource not found');
        }

        if ($exception instanceof ExaException) {
            return $this->error($exception);
        }

        return $this->error($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        return $this->error($exception, Response::HTTP_UNAUTHORIZED, 'Unauthenticated');
    }

    private function error(Throwable $exception, ?int $code = null, string|array|null $message = null): ApiErrorResponse
    {
        $finalMessage = is_array($message)
            ? implode(', ', Arr::flatten($message))
            : $message;

        return new ApiErrorResponse(
            $finalMessage ?? $exception->getMessage(),
            $exception,
            $code ?? $exception->getCode()
        );
    }
}
