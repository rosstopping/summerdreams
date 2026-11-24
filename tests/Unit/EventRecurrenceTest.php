<?php

namespace Tests\Unit;

use App\Models\Event;
use Tests\TestCase;

class EventRecurrenceTest extends TestCase
{
    public function test_partial_weeks_do_not_add_an_extra_occurrence(): void
    {
        $event = new Event;
        $event->forceFill([
            'start_date' => '2027-01-01 00:00:00',
            'end_date' => '2027-01-17 00:00:00',
            'repeat' => 'weekly',
            'extra_dates' => [],
            'exclude_dates' => [],
        ]);

        $this->assertSame(['2027-01-01', '2027-01-08'], $event->dates(null, null, true)->map->toDateString()->values()->all());
    }

    public function test_partial_days_do_not_add_an_extra_occurrence(): void
    {
        $event = new Event;
        $event->forceFill([
            'start_date' => '2027-01-01 00:00:00',
            'end_date' => '2027-01-03 12:00:00',
            'repeat' => 'daily',
            'repeat_exclude_days' => [],
            'extra_dates' => [],
            'exclude_dates' => [],
        ]);

        $this->assertSame(['2027-01-01', '2027-01-02'], $event->dates(null, null, true)->map->toDateString()->values()->all());
    }
}
