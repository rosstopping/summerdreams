<?php

namespace App\Jobs;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class PaymentReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $scheduled_payments = Payment::query()
            ->whereHas('booking', fn ($booking) => $booking->confirmed())
            ->whereNotNull('scheduled_at')
            ->whereNotNull('customer_id')
            ->whereNotNull('payment_method_id')
            ->whereNull('confirmed_at')
            ->whereNull('reminder_sent_at')
            ->where('scheduled_at', now()->addHours(24)->seconds(0))
            ->get();
    
        foreach ($scheduled_payments as $payment) {
            $payment->reminder_sent_at = now();
            $payment->save();
            
            if ($payment->booking->mobile) {
                /**
                 * Change api endpoint based on environment
                 */
                $api = 'https://api.webexinteract.com/v1/sms/test';

                if (app()->environment('production')) {
                    $api = 'https://api.webexinteract.com/v1/sms';
                }
            
                $phoneNumber = '+447' . substr($payment->booking->mobile, 2);

                $response = Http::withHeaders([
                    'X-AUTH-KEY' => config('sms.api_key'),
                ])->post($api, [
                    'from' => config('sms.sender_id'),
                    'message_body' => 'This is a reminder that your payment of £'.$payment->amount.' will be taken tomorrow. Thank you for booking with Summer Dreams.',
                    'to' => [
                        [
                            'phone' => [$phoneNumber]
                        ]
                    ],
                ]);
            }
        }
    }
}
