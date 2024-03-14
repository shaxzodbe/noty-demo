<?php

namespace App\Contracts;

interface SMSProviderInterface
{
    public function sendSMS($phoneNumber, $message);
}