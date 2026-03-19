<?php

namespace App\Http\Controllers;

use App\Jobs\MailchimpJob;
use App\Jobs\WhatsappJob;
use App\Mail\ContactFormMail;
use App\Models\ContactForm;
use App\Models\Page;
use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use MailchimpMarketing\ApiClient;

class ContactController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'key' => 'required',
        ]);

        $page = Page::where('content', 'LIKE', '%'.$request->key.'%')->first();

        if (!$page) $page = Popup::where('flexible_content', 'LIKE', '%'.$request->key.'%')->firstOrFail();

        $form = $page->flexibleContent->filter(fn ($field) => $field->key() === $request->key)->first();

        if (!$form) abort(404);

        $validate = [];

        foreach ($form->fields as $field) {
            /**
             * Add to validation
             */
            if ($field->attributes->type != 'boolean' && $field->attributes->required) {
                $validate[(string) Str::of($field->attributes->name)->snake()] = 'required';
            }
            elseif ($field->attributes->type === 'boolean') {
                $validate[(string) Str::of($field->attributes->name)->snake()] = 'boolean';
            }
            else {
                $validate[(string) Str::of($field->attributes->name)->snake()] = 'nullable';
            }
        }

        /**
         * Validate
         */
        $validated = $request->validate($validate);

        /**
         * Check for uploads
         */
        foreach ($form->fields as $field) {
            if (data_get($field, 'attributes.type') === 'file') {
                $name = (string) Str::of($field->attributes->name)->snake();
                $validated[$name] = url(str_replace('public/', 'storage/', $request->file($name)->store('public')));
            }
        }

        ContactForm::create([
            'site' => config('app.name'),
            'form_name' => $form->name ?: $page->slug,
            'name' => data_get($validated, 'name') ?: ' ',
            'email' => data_get($validated, 'email') ?: ' ',
            'message' => data_get($validated, 'message') ?: ' ',
            'data' => $validated
        ]);

        Mail::to($form->name === 'Popup' ? 'office@nakedzante.com' : config('mail.from.address'))
            ->queue(new ContactFormMail($validated, $form->name ?: $page->slug));

        if (config('app.env') === 'production' && data_get($validated, 'email')) {
            MailchimpJob::dispatch(data_get($validated, 'email'));

            if ($number = data_get($validated, 'mobile', data_get($validated, 'number'))) {
                if ($page->slug === '2026') {
                    WhatsappJob::dispatch([
                        'from' => [
                            'channel_id' => 'mc_GkjLTdrZOhT7CPwNpd7K4'
                        ],
                        'to' => [
                            ['identifier' => $number]
                        ],
                        'content' => [
                            'type' => 'whats_app_template',
                            'template_id' => 'tn_xiTugUIhnjtvj7s7vR7Xy'
                        ]
                    ])->delay(now()->addMinutes(1));
                }
                else {  
                    WhatsappJob::dispatch([
                        'from' => [
                            'channel_id' => 'mc_GkjLTdrZOhT7CPwNpd7K4'
                        ],
                        'to' => [
                            ['identifier' => $number]
                        ],
                        'content' => [
                            'type' => 'whats_app_template',
                            'template_id' => 'tn_sIL6EzBH2UPW3kkeICZtz'
                        ]
                    ])->delay(now()->addMinutes(1));
                }
            }
        }

        // Store form submission data for tracking
        $request->session()->put('contact_form_submission', [
            'email' => data_get($validated, 'email'),
            'phone' => data_get($validated, 'mobile', data_get($validated, 'number')),
            'conversion_type' => 'enquiry', // All contact form submissions are 'enquiry' type
            'form_name' => $form->name ?: $page->slug
        ]);

        return redirect()->to('contact/success');
    }
}
