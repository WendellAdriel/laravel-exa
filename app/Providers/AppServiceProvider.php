<?php

namespace App\Providers;

use Exa\Services\SlackClient;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerSlackClient();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
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
