<?php

declare(strict_types=1);

namespace Exa\Http\Routing;

use Carbon\Carbon;
use Exa\Support\Formatter;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use OpenApi\Attributes as OA;

#[OA\Info(title: 'Exa API', version: '1.0')]
#[OA\SecurityScheme(
    securityScheme: 'jwt',
    name: 'jwt',
    in: 'header',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT'
)]
final class RouteRegistrator
{
    public static function register(): void
    {
        self::registerIndexRoute();
        self::registerV1Routes();
    }

    private static function registerIndexRoute(): void
    {
        Route::get('/', function () {
            $data = [
                'application' => config('app.name'),
                'status' => Response::HTTP_OK,
                'datetime' => Carbon::now()->format(Formatter::API_DATETIME_FORMAT),
            ];

            if (! App::environment('local', 'testing')) {
                return response()->json($data);
            }

            $data = [
                ...$data,
                'environment' => config('app.env'),
                'php_version' => phpversion(),
                'laravel_version' => App::version(),
            ];

            return response()->json($data);
        })->name('login');
    }

    private static function registerV1Routes(): void
    {
        $modules = config('modules');

        foreach ($modules as $module) {
            Route::prefix('v1')
                ->middleware('api')
                ->namespace("Modules\\{$module}\\Controllers")
                ->group(base_path("modules/{$module}/Routes/v1.php"));
        }
    }
}
