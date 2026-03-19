<?php

namespace App\Http\Controllers;

use App\Jobs\MailchimpJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use MailchimpMarketing\ApiClient;

class NewsletterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email'
        ]);

        if (config('app.env') === 'production' && data_get($validated, 'email')) {
            MailchimpJob::dispatch(data_get($validated, 'email'));
        }

        if (setting('newsletter_redirect') === '') return redirect()->back()->withSuccess(setting('newsletter_success_message', 'Thanks for signing up!'));

        return redirect(setting('newsletter_redirect', '/zante-event-packages'))->withSuccess(setting('newsletter_success_message', 'Thanks for signing up!'));
    }
}
