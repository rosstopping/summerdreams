<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'arrival_date' => ['required'],
            'name' => ['required'],
            'reference' => ['required'],
        ]);

        $reference = Str::of($request->reference)->replace('VVIP', '');

        $booking = Booking::query()
            ->where('reference', $reference)
            ->where('name', 'LIKE', '%'.$request->name.'%')
            ->where('arrival_date', $request->arrival_date)
            ->confirmed()
            ->first();

        if (!$booking) return back()->withErrors('We could not find a booking with those details.');
        
        session()->put('booking', $booking);

        return redirect('account');
    }

    public function logout()
    {
        session()->forget('booking');

        return redirect('/');
    }
}
