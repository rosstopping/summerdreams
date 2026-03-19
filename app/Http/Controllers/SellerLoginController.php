<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SellerLoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $seller = Seller::where('code', $request->code)->first();

        if ($seller) {
            session()->put('seller_code', $request->code);

            return redirect('tickets');
        }

        return back()->withErrors('Incorrect login code.');
    }
}
