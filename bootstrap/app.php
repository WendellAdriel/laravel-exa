<?php

declare(strict_types=1);

use Exa\Commands\MakeModuleCommand;
use Exa\Exceptions\ExceptionHandler;
use Exa\Http\Middlewares\BlockViewerUsers;
use Exa\Http\Middlewares\HasRole;
use Exa\Http\Routing\RouteRegistrator;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        health: '/health',
        then: fn () => RouteRegistrator::register(),
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(append: [
            BlockViewerUsers::class,
        ])->alias([
            'has_role' => HasRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(fn (Exception $exception): Exa\Http\Responses\ApiErrorResponse => ExceptionHandler::handleException($exception));
    })
    ->withCommands([
        MakeModuleCommand::class,
    ])->create();
