<?php

declare(strict_types=1);

namespace Exa\Exceptions;

use Exa\Http\Responses\ApiErrorResponse;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

final class ExceptionHandler
{
    public static function handleException(Exception $exception): ApiErrorResponse
    {
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return self::error($exception, Response::HTTP_UNAUTHORIZED, 'Unauthenticated');
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return self::error($exception, Response::HTTP_UNPROCESSABLE_ENTITY, $exception->errors());
        }

        if (
            $exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException
            || $exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
        ) {
            return self::error($exception, Response::HTTP_NOT_FOUND, 'Resource not found');
        }

        if ($exception instanceof ExaException) {
            return self::error($exception);
        }

        return self::error($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private static function error(Exception $exception, ?int $code = null, string|array|null $message = null): ApiErrorResponse
    {
        $finalMessage = is_array($message)
            ? implode(', ', Arr::flatten($message))
            : $message;

        return new ApiErrorResponse(
            message: $finalMessage ?? $exception->getMessage(),
            exception: $exception,
            code: $code ?? $exception->getCode()
        );
    }
}
