<?php

namespace Tests\Feature;

use App\Nova\Metrics\DepositsPerMonthLineChart;
use App\Nova\Metrics\GuestsPerMonthLineChart;
use App\Nova\Metrics\LeadsPerMonthLineChart;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SeasonalChartTest extends TestCase
{
    public function test_dashboard_charts_preserve_both_seasons_and_month_labels(): void
    {
        Cache::shouldReceive('remember')->andReturn(array_fill(0, 12, 2), array_fill(0, 12, 3));

        foreach ([GuestsPerMonthLineChart::class, LeadsPerMonthLineChart::class, DepositsPerMonthLineChart::class] as $class) {
            $chart = (new $class)->jsonSerialize();

            $this->assertSame('seasonal-line-chart', $chart['component']);
            $this->assertSame(['2024/25', '2025/26'], array_column($chart['series'], 'label'));
            $this->assertCount(12, $chart['series'][0]['data']);
            $this->assertCount(12, $chart['series'][1]['data']);
            $this->assertSame(['Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'], $chart['options']['xaxis']['categories']);
        }
    }
}
