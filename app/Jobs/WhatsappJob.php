<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class WhatsappJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $data
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {          
        Http::withHeaders([
            'X-API-KEY' => '42e1e05a-d438-4764-990a-a3f0592ef8ea',
        ])->post('https://api.superchat.com/v1.0/messages', $this->data);
    }
}
