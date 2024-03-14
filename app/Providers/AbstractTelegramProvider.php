<?php

namespace App\Providers;

use App\Contracts\TelegramProviderInterface;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;

abstract class AbstractTelegramProvider implements TelegramProviderInterface
{
    protected Api $telegram;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    protected function logResponse($chatId, $response): void
    {
        if ($response->isOk()) {
            Log::info("Message sent to Telegram chat ID: $chatId");
        } else {
            Log::error("Error sending message to Telegram chat ID: $chatId");
        }
    }

    protected function logException($chatId, $e): void
    {
        Log::error("Exception occurred while sending message to Telegram chat ID: $chatId");
        Log::error($e->getMessage());
    }
}
