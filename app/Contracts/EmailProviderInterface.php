<?php

namespace App\Contracts;

interface EmailProviderInterface
{
    public function sendEmail($email, $subject, $message);
}