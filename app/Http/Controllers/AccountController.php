<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $booking = session('booking');

        $booking->load('extras');

        /**
         * Get extras that aren't already on our booking
         */
        $extras = Extra::all()->filter(fn ($extra) => !$booking->extras->contains($extra->id));

        return view('account.index', compact('booking', 'extras'));
    }
}
