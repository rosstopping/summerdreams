<?php

namespace App\Nova\Actions;

use App\Jobs\NovaNotificationJob;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Notifications\NovaNotification;
use Laravel\Nova\URL;
use Maatwebsite\LaravelNovaExcel\Actions\QueuedExport;

class Export extends QueuedExport
{
    public function __construct()
    {
        $this->filename = Str::uuid();
        $this->disk = 'public';

        $this->onSuccess(function (ActionRequest $request, PendingDispatch $queue) {
            $queue
                ->allOnQueue('default')
                ->chain([
                    new NovaNotificationJob($request->user(), 'Your download is ready', URL::remote(Storage::disk('public')->url($this->getFilename()))),
                ]);

            return Action::message('Your export is queued!');
        })->onFailure(function (ActionRequest $request) {
            $request->user()->notify(
                NovaNotification::make()
                    ->message('Your requested export failed, please try again')
                    ->icon('error')
                    ->type('error')
            );
        });
    }
}
