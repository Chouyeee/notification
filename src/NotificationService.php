<?php

namespace Ichen\Notification;

use Log;
use Mail;
use Exception;
use Illuminate\Support\Str;
use Ixudra\Curl\Facades\Curl;
use Nexmo\Laravel\Facade\Nexmo;

class NotificationService
{
    private $notification;

    public function __construct()
    {
        $this->notification = config('notification');
    }

    public function line($message)
    {
        $prefix = '<'.Str::random(6).'> ';

        $status = -1;

        try {
            Log::info($prefix.'line bearer: '.$this->notification['line']['line_bearer'].' message: '.$message);

            Curl::to('https://notify-api.line.me/api/notify')
            ->withHeader('Authorization: Bearer '.$this->notification['line']['line_bearer'])
            ->withContentType('application/x-www-form-urlencoded')
            ->withData([ 'message' => $message ])
            ->post();

            return $status = 0;
        } catch (Exception $e) {
            Log::error($prefix.'line notification faill', [
                'current_file' => __FILE__,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $status;
        }
    }

    public function sms($phoneNumber, $message)
    {
        $prefix = '<'.Str::random(6).'> ';

        $status = -1;

        try {
            Log::info($prefix.'phone number: '.$phoneNumber.' message: '.$message);

            if ($phoneNumber[0] == 0) {
                $phoneNumber = substr($phoneNumber, 1);
            }

            Nexmo::message()->send([
            'to' => '886'.$phoneNumber,
            'from' => $this->notification['nexmo']['username'],
            'text' => $message,
            ]);

            return $status = 0;
        } catch (Exception $e) {
            Log::error($prefix.'sms notification faill', [
                'current_file' => __FILE__,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return $status;
        }
    }
}
