<?php

namespace Exa\Services;

use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

readonly class SlackClient
{
    public function __construct(
        private string $botName,
        private string $botIcon,
        private string $webhook,
        private string $defaultChannel
    ) {
    }

    public function sendNotification(string $message, array $users = [], ?string $target = null): void
    {
        try {
            if (App::environment('local')) {
                Log::debug("(SLACK CLIENT): {$message}");

                return;
            }

            $environment = strtoupper(config('app.env'));
            $formattedUsers = $this->formatUsersToMention($users);
            $message = empty($formattedUsers) ? $message : "{$formattedUsers}: {$message}";
            $finalMessage = "[{$environment}] - {$message}";
            $channelToNotify = empty($target) ? $this->defaultChannel : $target;

            $payloadData = [
                'username' => $this->botName,
                'icon_emoji' => $this->botIcon,
                'channel' => $channelToNotify,
                'text' => $finalMessage,
            ];

            $payload = ['payload' => json_encode($payloadData)];
            $ch = curl_init($this->webhook);

            $options = [
                CURLOPT_RETURNTRANSFER => true, // Avoid outputting the return in the console
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $payload,
            ];

            curl_setopt_array($ch, $options);
            if (! curl_exec($ch)) {
                throw new Exception(curl_error($ch));
            }
            curl_close($ch);
        } catch (Exception $exception) {
            $msgTpl = 'Failed to notify Slack Channel for webhook %s: "%s"';
            Log::error(sprintf($msgTpl, $this->webhook, $exception->getMessage()));
        }
    }

    private function formatUsersToMention(array $users): string
    {
        if (empty($users)) {
            return '';
        }

        $formatted = array_map(function ($user) {
            return "<@{$user}>";
        }, $users);

        return implode(', ', $formatted);
    }
}
