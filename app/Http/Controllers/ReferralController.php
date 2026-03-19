<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function __invoke(Referral $referral, Request $request)
    {
        $request->session()->put('referral', $referral);

        return redirect()->route('book');
    }
}
