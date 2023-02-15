<?php

namespace App\Providers;

use Exa\Support\Formatter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->configureIndexRoute();

        $this->configureV1Routes();
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    private function configureIndexRoute(): void
    {
        Route::get(self::HOME, function () {
            return response()->json([
                'application' => config('app.name'),
                'environment' => config('app.env'),
                'php_version' => phpversion(),
                'laravel_version' => App::version(),
                'status' => Response::HTTP_OK,
                'datetime' => Carbon::now()->format(Formatter::API_DATETIME_FORMAT),
            ]);
        })->name('login');
    }

    private function configureV1Routes(): void
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
