<?php

namespace App\Services;

use App\Providers\AbstractTelegramProvider;

class TelegramService extends AbstractTelegramProvider
{

    public function sendMessage($chatId, $message): bool
    {
        try {
            $response = $this->telegram->sendMessage([
              'chat_id' => $chatId,
              'text' => $message,
            ]);

            $this->logResponse($chatId, $response);
            return $response->isOk();
        } catch (\Exception $e) {
            $this->logException($chatId, $e);
            return false;
        }
    }
}