<?php

namespace App\Nova\Metrics;

use App\Models\Booking;
use App\Models\ContactForm;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Coroowicaksono\ChartJsIntegration\LineChart;
use Illuminate\Support\Facades\Date;

class LeadsPerMonthLineChart extends LineChart
{
    public function __construct()
    {
        parent::__construct();

        $leadsPerMonth2024_25 = Cache::remember('leads_per_month_2024_25', 60 * 60, function () {
            $start = \Carbon\Carbon::parse('2024-09-01')->startOfMonth();
            $end = \Carbon\Carbon::parse('2025-08-31')->endOfMonth();
            
            // Get booking enquiries grouped by month
            $bookingResults = DB::table('bookings')
                ->whereNotNull('enquired_at')
                ->whereNull('deleted_at')
                ->whereBetween('enquired_at', [$start, $end])
                ->selectRaw('DATE_FORMAT(enquired_at, "%Y-%m") as month, COUNT(*) as total')
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();
            
            // Get contact form submissions grouped by month
            $contactResults = DB::table('contact_forms')
                ->whereBetween('created_at', [$start, $end])
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();
            
            // Combine and ensure all months have a value (0 if no data)
            $months = ['2024-09', '2024-10', '2024-11', '2024-12', '2025-01', '2025-02', '2025-03', '2025-04', '2025-05', '2025-06', '2025-07', '2025-08'];
            return array_map(fn($month) => (int)(($bookingResults[$month] ?? 0) + ($contactResults[$month] ?? 0)), $months);
        });

        $leadsPerMonth2025_26 = Cache::remember('leads_per_month_2025_26', 60 * 60, function () {
            $start = \Carbon\Carbon::parse('2025-09-01')->startOfMonth();
            $end = \Carbon\Carbon::parse('2026-08-31')->endOfMonth();
            
            // Get booking enquiries grouped by month
            $bookingResults = DB::table('bookings')
                ->whereNotNull('enquired_at')
                ->whereNull('deleted_at')
                ->whereBetween('enquired_at', [$start, $end])
                ->selectRaw('DATE_FORMAT(enquired_at, "%Y-%m") as month, COUNT(*) as total')
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();
            
            // Get contact form submissions grouped by month
            $contactResults = DB::table('contact_forms')
                ->whereBetween('created_at', [$start, $end])
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();
            
            // Combine and ensure all months have a value (0 if no data)
            $months = ['2025-09', '2025-10', '2025-11', '2025-12', '2026-01', '2026-02', '2026-03', '2026-04', '2026-05', '2026-06', '2026-07', '2026-08'];
            return array_map(fn($month) => (int)(($bookingResults[$month] ?? 0) + ($contactResults[$month] ?? 0)), $months);
        });

        $this->title('Leads Per Month')
            ->animations([
                'enabled' => true,
                'easing' => 'easeinout',
            ])
            ->series([
                [
                    'barPercentage' => 0.5,
                    'label' => '2024/25',
                    'borderColor' => '#f7a35c',
                    'data' => $leadsPerMonth2024_25,
                ],
                [
                    'barPercentage' => 0.5,
                    'label' => '2025/26',
                    'borderColor' => '#90ed7d',
                    'data' => $leadsPerMonth2025_26,
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
