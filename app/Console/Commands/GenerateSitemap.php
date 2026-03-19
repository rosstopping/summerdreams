<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap including all event dates';

    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency('daily'))
            ->add(Url::create('/calendar')->setPriority(0.9)->setChangeFrequency('daily'));

        // Get all visible events with upcoming dates
        $events = Event::where('hidden', false)
            ->where('hidden_from_calendar', false)
            ->get();

        // Add calendar event URLs for the next 12 months
        $now = now();
        $endDate = $now->copy()->addMonths(12);

        foreach ($events as $event) {
            $eventDates = $event->dates($now->startOfMonth(), $endDate->endOfMonth());
            
            foreach ($eventDates as $date) {
                $sitemap->add(
                    Url::create("/calendar/event/{$event->slug}/{$date->format('Y-m-d')}")
                        ->setPriority(0.7)
                        ->setChangeFrequency('weekly')
                        ->setLastModificationDate($date)
                );
            }
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
        
        $this->info('Sitemap generated successfully!');
        return Command::SUCCESS;
    }
}
