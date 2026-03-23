<?php

namespace App\Http\Middleware;

use App\Models\Booking;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccountMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('booking')) return redirect('login');

        $booking = Booking::where('id', data_get(session('booking'), 'id'))->firstOrFail();

        /**
         * Check if booking is confirmed
         */
        if (!$booking->confirmed_at) {
            session()->forget('booking');

            return redirect('login');
        }

        session()->put('booking', $booking);
        
        return $next($request);
    }
}
