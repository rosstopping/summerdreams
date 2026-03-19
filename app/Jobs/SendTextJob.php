<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendTextJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $mobile,
        public $message
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /**
         * Change api endpoint based on environment
         */
        $api = 'https://api.webexinteract.com/v1/sms/test';

        if (app()->environment('production')) {
            $api = 'https://api.webexinteract.com/v1/sms';
        }
    
        $phoneNumber = '+447' . substr($this->mobile, 2);

        $response = Http::withHeaders([
            'X-AUTH-KEY' => config('sms.api_key'),
        ])->post($api, [
            'from' => config('sms.sender_id'),
            'message_body' => $this->message,
            'to' => [
                [
                    'phone' => [$phoneNumber]
                ]
            ],
        ]);
    }
}
