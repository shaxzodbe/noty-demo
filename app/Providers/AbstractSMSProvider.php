<?php

namespace App\Providers;

use App\Contracts\SMSProviderInterface;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

abstract class AbstractSMSProvider implements SMSProviderInterface
{
    protected Client $twilioClient;

    /**
     * @throws ConfigurationException
     */
    public function __construct()
    {
        $this->twilioClient = new Client(
          $this->getTwilioAccountSID(),
          $this->getTwilioAuthToken()
        );
    }

    /**
     * @throws ConfigurationException
     */
    protected function getTwilioAccountSID(): string
    {
        $twilioAccountSID = env('TWILIO_ACCOUNT_SID');

        if (!$twilioAccountSID) {
            throw new ConfigurationException('TWILIO_ACCOUNT_SID is not configured.');
        }

        return $twilioAccountSID;
    }

    /**
     * @throws ConfigurationException
     */
    protected function getTwilioAuthToken(): string
    {
        $twilioAuthToken = env('TWILIO_AUTH_TOKEN');

        if (!$twilioAuthToken) {
            throw new ConfigurationException('TWILIO_AUTH_TOKEN is not configured.');
        }

        return $twilioAuthToken;
    }

    /**
     * @throws ConfigurationException
     */
    protected function getTwilioPhoneNumber(): string
    {
        $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');

        if (!$twilioPhoneNumber) {
            throw new ConfigurationException('TWILIO_PHONE_NUMBER is not configured.');
        }

        return $twilioPhoneNumber;
    }
}
