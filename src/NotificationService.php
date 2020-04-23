<?php

namespace Ichen\Notification;

use Ichen\Notification\Jobs\SendSmsJob;
use Ichen\Notification\Jobs\SendMailJob;
use Ichen\Notification\Jobs\SendLineJob;

class NotificationService
{
    public function __construct()
    {
        $this->notification = config('notification');
    }

    public function mailNotification(array $mailTo, $subject, $message, array $filePath = [], array $ccTo = [])
    {
        $mailFrom = $this->notification['mail'];

        SendMailJob::dispatch($mailTo, $subject, $message, $filePath, $ccTo, $mailFrom);
    }

    public function lineNotification($message)
    {
        SendLineJob::dispatch($this->notification['line']['line_bearer'], $message);
    }

    public function smsNotification(array $phoneNumber, $message)
    {
        SendSmsJob::dispatch($phoneNumber, $message, $this->notification['nexmo']['username']);
    }
}
