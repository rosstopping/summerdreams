<?php

namespace App\Actions;

use Exception;

class MakePayment
{
    /**
     * Get the action data
     */
    public function __construct(
        private $model,
        private array $user,
        private int $amount,
        private array $card
    ){
        $this->pay();
    }

    public function pay() {
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $customer = $stripe->customers->create([
            'name' => data_get($this->user, 'name'),
            'email' => data_get($this->user, 'email')
        ]);

        try {
            $payment = $stripe->paymentIntents->create([
                'customer' => data_get($customer, 'id'),
                'amount' => $this->amount * 100,
                'currency' => 'gbp',
                'payment_method_types' => ['card'],
                'payment_method_data' => [
                    'type' => 'card',
                    'card' => [
                        'number' => data_get($this->card, 'number'),
                        'exp_month' => data_get($this->card, 'month'),
                        'exp_year' => data_get($this->card, 'year'),
                        'cvc' => data_get($this->card, 'cvc')
                    ]
                ],
                'payment_method_options' => [
                    'card' => [
                        'moto' => true
                    ]
                ],
                'confirm' => true
            ]);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }

        if (isset($payment) && data_get($payment, 'status') === 'succeeded') {
            $this->model->payments()->create([
                'amount' => $this->amount,
                'reference' => data_get($payment, 'id', 'N/A'),
                'metadata' => $payment,
                'confirmed_at' => now()
            ]);
        }
    }
}