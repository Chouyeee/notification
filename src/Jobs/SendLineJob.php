<?php

namespace Ichen\Notification\Jobs;

use Log;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendLineJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $lineBearer, $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $lineBearer, $message)
    {
        $this->lineBearer = $lineBearer;
        $this->message = $message;
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
            Log::info($prefix.'send line message: ', [
                'line_bearer' => $this->lineBearer,
                'message'=> $this->message
            ]);

            foreach ($this->lineBearer as $eachLineBearer) {
                Curl::to('https://notify-api.line.me/api/notify')
                    ->withHeader('Authorization: Bearer '.$eachLineBearer)
                    ->withContentType('application/x-www-form-urlencoded')
                    ->withData([ 'message' => $this->message ])
                    ->post();
            }
        } catch (\Exception $e) {
            Log::error($prefix.'line notification faill', [
                'current_file' => __FILE__,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return ;
        }

        Log::info($prefix.'send line notification done');
    }
}
