<?php

namespace Ichen\Notification\Jobs;

use Log;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $mailTo, $ccTo, $subject, $content, $filePath, $mailFrom;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailTo, $subject, $content, $filePath, $ccTo, $mailFrom)
    {
        $this->mailTo = $mailTo;
        $this->subject = $subject;
        $this->content = $content;
        $this->filePath = $filePath;
        $this->ccTo = $ccTo;
        $this->mailFrom = $mailFrom;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $prefix = '<'.Str::random(6).'> ';

        Log::info($prefix.' send mail: ', [
            'mail_to' => $this->mailTo,
            'subject' => $this->subject,
            'content' => $this->content,
            'file_path' => $this->filePath,
            'cc_to' => $this->ccTo,
            'mail_from' => $this->mailFrom,
        ]);

        try {
            Mail::raw($this->content, function ($message) {
                $message->from($this->mailFrom['mail_from_address'], $this->mailFrom['email_name']);
                $message->subject($this->subject);
                foreach ($this->mailTo as $eachMailTo) {
                    $message->to($eachMailTo);
                }
                foreach ($this->ccTo as $eachCcTo) {
                    $message->to($eachCcTo);
                }

                if ($this->filePath != []) {
                    foreach ($this->filePath as $eachfilePath) {
                        $message->attach($eachfilePath);
                    }
                }
            });
        } catch (\Exception $e) {
            Log::error($prefix.'send mail error ', [
                'current_file' => __FILE__,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return;
        }
        Log::info($prefix.'send mail done');
    }
}
