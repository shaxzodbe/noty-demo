<?php

namespace App\Http\Controllers;

use App\Contracts\EmailProviderInterface;
use App\Contracts\SMSProviderInterface;
use App\Contracts\TelegramProviderInterface;
use App\Models\User;
use App\Services\EmailService;
use App\Services\SMSService;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class UserSettingsController extends Controller
{
    public function updateSettings(Request $request)
    {
        $request->validate([
          'method' => 'required|in:sms,email,telegram',
          'user_id' => 'sometimes|exists:users,id',
          'subject' => 'string|nullable',
          'message' => 'string|nullable',
        ]);

        $userId = $request->input('user_id');
        $method = $request->input('method');
        $subject = $request->input('subject');
        $message = $request->input('message');

        $user = User::findOrFail($userId);

        $subject = $subject ?? '';
        $message = $message ?? '';

        switch ($method) {
            case 'sms':
                $smsService = app(SMSService::class);
                $this->send($smsService, $user->phone, $message);
                break;
            case 'email':
                $this->send(new EmailService(), $user->email, $subject, $message);
                break;
            case 'telegram':
                $telegramService = app(TelegramService::class);
                $this->send($telegramService, $user->telegramChatId, $message);
                break;
            default:
                return response()->json(['error' => 'Unsupported communication method'], 400);
        }

        return response()->json(['message' => 'Settings updated successfully']);
    }

    private function send($provider, $recipient, $arg1, $arg2 = null): void {
        if ($provider instanceof SMSProviderInterface) {
            $provider->sendSMS($recipient, $arg1);
        } elseif ($provider instanceof EmailProviderInterface) {
            $provider->sendEmail($recipient, $arg1, $arg2);
        } elseif ($provider instanceof TelegramProviderInterface) {
            $provider->sendMessage($recipient, $arg1);
        } else {
            throw new \InvalidArgumentException('Invalid provider type');
        }
    }
}
