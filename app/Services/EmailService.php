<?php

namespace App\Services;

use App\Providers\AbstractEmailProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailService extends AbstractEmailProvider
{

    public function sendEmail($email, $subject, $message): bool
    {
        try {
            Mail::send([], [], function ($message) use ($email, $subject, $message) {
                $message->to($email)
                  ->subject($subject)
                  ->setBody($message, 'text/html');
            });

            Log::info("Email sent to: $email, Subject: $subject");

            return true;
        } catch (\Exception $e) {
            Log::error("Error sending email: {$e->getMessage()}");

            return false;
        }
    }
}