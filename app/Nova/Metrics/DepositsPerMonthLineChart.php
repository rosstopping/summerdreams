<?php

namespace App\Nova\Metrics;

use App\Models\Booking;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Coroowicaksono\ChartJsIntegration\LineChart;
use Illuminate\Support\Facades\Date;

class DepositsPerMonthLineChart extends LineChart
{
    public function __construct()
    {
        parent::__construct();

        $depositsPerMonth2024_25 = Cache::remember('deposits_per_month_2024_25', 60 * 60, function () {
            $start = \Carbon\Carbon::parse('2024-09-01')->startOfMonth();
            $end = \Carbon\Carbon::parse('2025-08-31')->endOfMonth();
            
            // Query payments directly - group by when payment was actually confirmed
            $results = DB::table('payments')
                ->join('bookings', 'bookings.id', '=', 'payments.booking_id')
                ->whereNotNull('bookings.confirmed_at')
                ->whereNull('bookings.deleted_at')
                ->whereNotNull('payments.confirmed_at')
                ->whereBetween('payments.confirmed_at', [$start, $end])
                ->selectRaw('DATE_FORMAT(payments.confirmed_at, "%Y-%m") as month, ROUND(SUM(payments.amount) / 100, 2) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('total', 'month')
                ->toArray();
            
            // Ensure all months have a value (0 if no data)
            $months = ['2024-09', '2024-10', '2024-11', '2024-12', '2025-01', '2025-02', '2025-03', '2025-04', '2025-05', '2025-06', '2025-07', '2025-08'];
            return array_map(fn($month) => (float)($results[$month] ?? 0), $months);
        });

        $depositsPerMonth2025_26 = Cache::remember('deposits_per_month_2025_26', 60 * 60, function () {
            $start = \Carbon\Carbon::parse('2025-09-01')->startOfMonth();
            $end = \Carbon\Carbon::parse('2026-08-31')->endOfMonth();
            
            // Query payments directly - group by when payment was actually confirmed
            $results = DB::table('payments')
                ->join('bookings', 'bookings.id', '=', 'payments.booking_id')
                ->whereNotNull('bookings.confirmed_at')
                ->whereNull('bookings.deleted_at')
                ->whereNotNull('payments.confirmed_at')
                ->whereBetween('payments.confirmed_at', [$start, $end])
                ->selectRaw('DATE_FORMAT(payments.confirmed_at, "%Y-%m") as month, ROUND(SUM(payments.amount) / 100, 2) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('total', 'month')
                ->toArray();
            
            // Ensure all months have a value (0 if no data)
            $months = ['2025-09', '2025-10', '2025-11', '2025-12', '2026-01', '2026-02', '2026-03', '2026-04', '2026-05', '2026-06', '2026-07', '2026-08'];
            return array_map(fn($month) => (float)($results[$month] ?? 0), $months);
        });

        $this->title('Deposits Per Month')
            ->animations([
                'enabled' => true,
                'easing' => 'easeinout',
            ])
            ->series([
                [
                    'barPercentage' => 0.5,
                    'label' => '2024/25',
                    'borderColor' => '#f7a35c',
                    'data' => $depositsPerMonth2024_25,
                ],
                [
                    'barPercentage' => 0.5,
                    'label' => '2025/26',
                    'borderColor' => '#90ed7d',
                    'data' => $depositsPerMonth2025_26,
                ]
            ])
            ->options([
                'showTotal' => true,
                'xaxis' => [
                    'categories' => ['Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                ],
            ])
            ->width('full');
    }
}
