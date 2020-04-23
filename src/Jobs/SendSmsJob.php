<?php

namespace Ichen\Notification\Jobs;

use Log;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phoneNumber, $message, $smsForm;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $phoneNumber, $message, $smsFrom)
    {
        $this->phoneNumber = $phoneNumber;
        $this->message = $message;
        $this->smsForm = $smsFrom;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $prefix = '<'.Str::random(6).'> ';

        try {
            Log::info($prefix.'send sms: ', [
                'phone_number' => $this->phoneNumber,
                'message' => $this->message
            ]);

            foreach ($this->phoneNumber as $eachPhoneNumber) {
                if ($eachPhoneNumber[0] == 0) {
                    $eachPhoneNumber = substr($eachPhoneNumber, 1);
                }

                Nexmo::message()->send([
                'to' => '886'.$eachPhoneNumber,
                'from' => $this->smsForm,
                'text' => $this->message,
                ]);
            }
        } catch (\Exception $e) {
            Log::error($prefix.'sms notification faill', [
                'current_file' => __FILE__,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return ;
        }

        Log::info($prefix.'send sms notification done');
    }
}
