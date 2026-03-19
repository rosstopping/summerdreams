<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Event;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Livewire\Attributes\Validate;

class SellerBook extends Component
{
    public $events;
    public $dates = [];

    #[Validate('required')]
    public $event = null;
    
    #[Validate('required')]
    public $date = null;
    
    #[Validate('required')]
    public $payment_method = 'card';

    #[Validate('required_if:payment_method,cash')]
    public $currency = 'gbp';

    // #[Validate('required_if:additional_details,false')]
    // public $customer_name;

    // #[Validate('required_if:customer_name,null')]
    // public $additional_details = false;

    public $url = null;
    public $qrcode = null;

    public function mount()
    {
        $this->events = Event::where('seller_bookable', true)->get();
    }

    public function updatedEvent()
    {
        $this->date = null;
        $this->dates = Event::find($this->event)->dates();
    }

    public function createBooking()
    {
        $this->validate();

        if ($this->payment_method === 'card') $this->currency = 'gbp';

        $this->url = route('seller.book', [session('seller')->id, $this->event, $this->date, $this->payment_method, $this->currency]);

        $this->qrcode = (string) QrCode::size(500)->generate($this->url);
    }

    public function render()
    {
        return view('livewire.seller-book');
    }
}
