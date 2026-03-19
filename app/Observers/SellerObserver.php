<?php

namespace App\Observers;

use App\Models\Seller;

class SellerObserver
{
    /**
     * Handle the Seller "created" event.
     */
    public function creating(Seller $seller): void
    {
        $seller->code = mt_rand(100000, 999999);
    }
}
