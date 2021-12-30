<?php

namespace Nta\AuthOtp\app\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client as TwilioClient;

class SMSChannel
{
    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var string
     */
    protected $from;

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $smsDriver = config('otp.sms_driver');
        $message = $notification->toSMS($notifiable);
        $this->parseMessage($message);

        switch ($smsDriver) {
            case 'twilio':
                $client = new TwilioClient(config('otp.twilio.account_sid'), config('otp.twilio.auth_token'));
                $client->messages->create(
                    $this->to,
                    [
                        'from' => $this->from,
                        'body' => $this->body
                    ]
                );
                break;
            case 'nexmo':
                $basic  = new \Vonage\Client\Credentials\Basic(config('otp.nexmo.account_sid'), config('otp.nexmo.auth_token'));
                $client = new \Vonage\Client($basic);
                $response = $client->sms()->send(
                    new \Vonage\SMS\Message\SMS($this->to, $this->from, $this->body)
                );
                break;
        }
    }

    /**
     * Parse message
     *
     * @param  mixed $message
     *
     * @return void
     */
    public function parseMessage($message)
    {
        if (is_array($message)
            && (false === isset($message['to']) || false === isset($message['body']))
        ) {
            logger(__METHOD__ . ": BAD REQUEST");
            throw new \Exception("Bad Request", 400);
        }

        $fromConfig = config('otp.' . config('otp.sms_driver') . '.sms_from');

        if (is_array($message)) {
            $this->to = $message['to'];
            $this->body = $message['body'];
            $this->from = isset($message['from']) && $message['from'] ? $message['from'] : $fromConfig;
        } else {
            $this->to = $message->to;
            $this->body = $message->body;
            $this->from = $message->from ?? $fromConfig;
        }
    }
}