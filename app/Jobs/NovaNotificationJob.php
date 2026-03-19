<?php

namespace App\Jobs;

use App\Mail\DownloadReadyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Laravel\Nova\Notifications\NovaNotification;

class NovaNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public $user, public $message, public $url)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(
            NovaNotification::make()
                ->message($this->message)
                ->action('Download', $this->url)
                ->icon('download')
                ->type('info')
        );

        Mail::to($this->user->email)->send(new DownloadReadyMail($this->url));
    }
}
