<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Discount $discount)
    {
        session(['discount' => $discount->code]);

        return redirect('/make-reservation');
    }
}
