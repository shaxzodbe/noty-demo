<?php

namespace App\Services;

use App\Providers\AbstractSMSProvider;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;

class SMSService extends AbstractSMSProvider
{

    public function sendSMS($phoneNumber, $message): bool
    {
        try {
            $this->twilioClient->messages->create(
              $phoneNumber,
              [
                'from' => $this->getTwilioPhoneNumber(),
                'body' => $message
              ]
            );

            return true;
        } catch (TwilioException $e) {
            Log::error('Error sending SMS: ' . $e->getMessage());
            return false;
        }
    }
}