<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        // Get all events first to help determine smart defaults
        $events = Event::where('hidden', false)
            ->where('hidden_from_calendar', false)
            ->get();
        
        // Smart default: if no parameters provided, find the best starting point
        $hasParams = $request->has('month') || $request->has('year') || $request->has('week');
        
        if (!$hasParams) {
            $smartDefaults = $this->getSmartDefaults($events);
            $month = $smartDefaults['month'];
            $year = $smartDefaults['year'];
            $weekIndex = $smartDefaults['week'];
        } else {
            $month = $request->get('month', now()->month);
            $year = $request->get('year', now()->year);
            $weekIndex = $request->get('week', 0);
        }
        
        $currentDate = Carbon::create($year, $month, 1);
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();
        
        // Navigation dates
        $prevMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();
        
        // Collect all event dates for the current month
        // Get a wider range to ensure we capture all dates in the weeks displayed
        $calendarStart = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        $calendarEnd = $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY);
        
        $eventDates = [];
        foreach ($events as $event) {
            $dates = $event->dates($calendarStart, $calendarEnd);
            foreach ($dates as $date) {
                $dateKey = $date->format('Y-m-d');
                if (!isset($eventDates[$dateKey])) {
                    $eventDates[$dateKey] = [];
                }
                $eventDates[$dateKey][] = [
                    'event' => $event,
                    'date' => $date,
                ];
            }
        }
        
        // Get weeks for the month (Monday to Sunday)
        $weeks = $this->getWeeksForMonth($startOfMonth, $endOfMonth);
        
        // Ensure weekIndex is valid
        $weekIndex = max(0, min($weekIndex, count($weeks) - 1));
        $currentWeek = $weeks[$weekIndex];
        
        // Calculate previous and next week indices
        $prevWeek = $weekIndex > 0 ? $weekIndex - 1 : null;
        $nextWeek = $weekIndex < count($weeks) - 1 ? $weekIndex + 1 : null;
        
        // SEO
        seo()->title('Event Calendar - VVIP Events Zante');
        seo()->description('Browse all upcoming VVIP Events in Zante. View our complete event calendar with dates and details for all parties and club nights.');
        
        return view('calendar.index', compact('eventDates', 'currentWeek', 'currentDate', 'events', 'prevMonth', 'nextMonth', 'weekIndex', 'prevWeek', 'nextWeek'));
    }
    
    public function show(Event $event, $date)
    {
        try {
            $eventDate = Carbon::createFromFormat('Y-m-d', $date);
        } catch (\Exception $e) {
            abort(404);
        }
        
        // Verify this event happens on this date (include_sold_out = true to verify date exists)
        $eventDates = $event->dates($eventDate->copy()->startOfDay(), $eventDate->copy()->endOfDay(), true);
        
        if ($eventDates->isEmpty()) {
            abort(404, 'This event does not occur on the specified date.');
        }
        
        // SEO
        seo()->title($event->name . ' - ' . $eventDate->format('l, F j, Y') . ' - VVip Events Zante');
        seo()->description('Book tickets for ' . $event->name . ' on ' . $eventDate->format('l, F j, Y') . '. ' . strip_tags($event->excerpt ?? ''));
        
        if ($event->getFirstMedia('images')) {
            seo()->image($event->getFirstMedia('images')->getUrl());
        }
        
        return view('calendar.event-date', compact('event', 'eventDate'));
    }
    
    private function getWeeksForMonth($startOfMonth, $endOfMonth)
    {
        $weeks = [];
        $currentWeekStart = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        
        while ($currentWeekStart <= $endOfMonth) {
            $weekDays = [];
            for ($i = 0; $i < 7; $i++) {
                $day = $currentWeekStart->copy()->addDays($i);
                $weekDays[] = $day;
            }
            $weeks[] = $weekDays;
            $currentWeekStart->addWeek();
        }
        
        return $weeks;
    }
    
    private function getSmartDefaults($events)
    {
        $today = now();
        $currentWeekStart = $today->copy()->startOfWeek(Carbon::MONDAY);
        $currentWeekEnd = $today->copy()->endOfWeek(Carbon::SUNDAY);
        
        // Check if there are events this week
        $hasEventsThisWeek = false;
        foreach ($events as $event) {
            $dates = $event->dates($currentWeekStart, $currentWeekEnd);
            if ($dates->isNotEmpty()) {
                $hasEventsThisWeek = true;
                break;
            }
        }
        
        // If there are events this week, use current week
        if ($hasEventsThisWeek) {
            $targetDate = $today;
        } else {
            // Find the first future event
            $firstFutureEventDate = null;
            $searchEnd = $today->copy()->addYear(); // Search up to 1 year ahead
            
            foreach ($events as $event) {
                $dates = $event->dates($today, $searchEnd);
                foreach ($dates as $date) {
                    if ($date >= $today && ($firstFutureEventDate === null || $date < $firstFutureEventDate)) {
                        $firstFutureEventDate = $date;
                    }
                }
            }
            
            // If we found a future event, use that date; otherwise, use today
            $targetDate = $firstFutureEventDate ?? $today;
        }
        
        // Calculate the month, year, and week index for the target date
        $targetMonth = $targetDate->month;
        $targetYear = $targetDate->year;
        
        // Create Carbon instance for the target month
        $monthStart = Carbon::create($targetYear, $targetMonth, 1)->startOfMonth();
        $monthEnd = Carbon::create($targetYear, $targetMonth, 1)->endOfMonth();
        
        // Get all weeks for the target month
        $weeks = $this->getWeeksForMonth($monthStart, $monthEnd);
        
        // Find which week contains the target date
        $targetWeekIndex = 0;
        foreach ($weeks as $index => $week) {
            $weekStart = $week[0];
            $weekEnd = $week[6];
            
            if ($targetDate >= $weekStart && $targetDate <= $weekEnd) {
                $targetWeekIndex = $index;
                break;
            }
        }
        
        return [
            'month' => $targetMonth,
            'year' => $targetYear,
            'week' => $targetWeekIndex,
        ];
    }
}
