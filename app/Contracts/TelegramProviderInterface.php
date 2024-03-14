<?php

namespace App\Contracts;

interface TelegramProviderInterface
{
    public function sendMessage($chatId, $message);
}