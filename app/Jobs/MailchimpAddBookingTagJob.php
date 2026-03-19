<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use MailchimpMarketing\ApiClient;

class MailchimpAddBookingTagJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $email
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new ApiClient();
        $client->setConfig([
            'apiKey' => env('MAILCHIMP_API_KEY'),
            'server' => env('MAILCHIMP_SERVER_PREFIX'),
        ]);

        $subscriber_hash = md5(strtolower($this->email));

        $client->lists->updateListMemberTags(env('MAILCHIMP_LIST_ID'), $subscriber_hash, [
            "tags" => [
                [
                    'name' => 'booked',
                    'status' => 'active'
                ]
            ],
        ]);
    }
}
