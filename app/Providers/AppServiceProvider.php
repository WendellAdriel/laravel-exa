<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\CarbonImmutable;
use Exa\Services\SlackClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Modules\Auth\Models\User;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerSlackClient();
    }

    public function boot(): void
    {
        JsonResource::withoutWrapping();
        Date::use(CarbonImmutable::class);

        Model::shouldBeStrict();
        Model::automaticallyEagerLoadRelationships();
        DB::prohibitDestructiveCommands(app()->isProduction());

        Password::defaults(
            fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->max(255)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );

        Blueprint::macro('userActions', function () {
            $this->foreignId('created_by')->nullable()->constrained(table: User::getModelTable());
            $this->foreignId('updated_by')->nullable()->constrained(table: User::getModelTable());
            $this->foreignId('deleted_by')->nullable()->constrained(table: User::getModelTable());
        });
    }

    private function registerSlackClient(): void
    {
        $webhook = config('services.slack.webhook');
        if (! is_null($webhook)) {
            $this->app->bind(SlackClient::class, fn () => new SlackClient(
                config('services.slack.bot.name'),
                config('services.slack.bot.icon'),
                $webhook,
                config('services.slack.channel')
            ));
        }
    }
}
