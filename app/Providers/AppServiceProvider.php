<?php

declare(strict_types=1);

namespace App\Providers;

use Exa\Services\SlackClient;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
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

        Blueprint::macro('userActions', function () {
            $this->foreignId('created_by')->nullable()->constrained(table: User::getModelTable());
            $this->foreignId('updated_by')->nullable()->constrained(table: User::getModelTable());
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
