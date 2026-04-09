<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Event;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Ross',
            'email' => 'ross@digizu.co.uk',
            'password' => Hash::make('password'),
        ]);

        /**
         * Settings
         */    
        \App\Models\Setting::create([
            'name' => 'Booking Fee',
            'key' => 'booking_fee',
            'value' => 2.95,
        ]);

        \App\Models\Setting::create([
            'name' => 'Current Year',
            'key' => 'year',
            'value' => '2024',
        ]);

        /**
         * Events
         */
        foreach (config('events') as $index => $event) {
            $eventModel = \App\Models\Event::create([
                'name' => $event['name'],
                'description' => $event['description'],
                'amount' => $event['amount'],
                'start_date' => $event['start_date'],
                'repeat' => $event['repeat'],
                'repeat_exclude_days' => data_get($event, 'repeat_exclude_days'),
                'created_at' => now()->addMinutes($index)
            ]);

            $eventModel
                ->addMediaFromUrl($event['image'])
                ->withResponsiveImages()
                ->toMediaCollection('images');
        }

        /**
         * Packages
         */
        foreach (config('packages') as $index => $package) {
            $packageModel = \App\Models\Package::create([
                'name' => $package['name'],
                'description' => $package['description'],
                'includes' => $package['includes'],
                'amount' => $package['amount'],
                'deposit' => $package['deposit'],
                'created_at' => now()->addMinutes($index)
            ]);

            foreach ($package['events'] as $event) {
                $packageModel->events()->attach(\App\Models\Event::where('name', $event)->firstOrFail());
            }
        }

        /**
         * Posts
         */
        foreach (config('posts') as $index => $post) {
            $postModel = \App\Models\Post::create([
                'title' => $post['title'],
                'excerpt' => $post['excerpt'],
                'content' => $post['content'],
                'created_at' => now()->addMinutes($index)
            ]);

            $postModel
                ->addMediaFromUrl($post['image'])
                ->withResponsiveImages()
                ->toMediaCollection('featured_image');
        }

        /**
         * Reviews
         */
        foreach (config('reviews') as $index => $review) {
            $reviewModel = \App\Models\Review::create([
                'name' => $review['name'],
                'subtitle' => $review['subtitle'],
                'content' => $review['content'],
                'created_at' => now()->addMinutes($index)
            ]);

            $reviewModel
                ->addMediaFromUrl($review['image'])
                ->withResponsiveImages()
                ->toMediaCollection('featured_image');
        }

        /**
         * Reviews
         */
        foreach (config('galleries') as $index => $gallery) {
            $galleryModel = \App\Models\Gallery::create([
                'name' => $gallery['title'],
                'created_at' => now()->addMinutes($index)
            ]);

            $galleryModel
                ->addMediaFromUrl($gallery['images'][0])
                ->withResponsiveImages()
                ->toMediaCollection('images');
        }

        /**
         * Videos
         */
        foreach (config('videos') as $index => $video) {
            $videoModel = \App\Models\Video::create([
                'title' => $video['title'],
                'video' => $video['video'],
                'description' => $video['description'],
                'created_at' => now()->addMinutes($index)
            ]);
        }

        /**
         * FAQS
         */
        foreach (config('faqs') as $index => $faq) {
            \App\Models\Faq::create([
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'created_at' => now()->addMinutes($index)
            ]);
        }

        /**
         * Home page
         */
        $page = \App\Models\Page::create([
            'title' => 'Home',
            'url' => '/',
        ]);

        $field = $page->fields()->create([
            'name' => 'Slider',
            'type' => 'images'
        ]);

        $field
            ->addMediaFromUrl('https://summerdreams.com/wp-content/uploads/2021/07/vvip-zante-boat-party-2022-2-1400x1000.jpeg')
            ->withResponsiveImages()
            ->toMediaCollection('images');

        $page
            ->addMediaFromUrl('https://summerdreams.com/wp-content/uploads/2019/03/vvip-sunset-yacht-party-1400x1000.jpg')
            ->withResponsiveImages()
            ->toMediaCollection('sunset_cruise');

        $page
            ->addMediaFromUrl('https://summerdreams.com/wp-content/uploads/2019/03/zante-yacht-party-1400x1000.jpg')
            ->withResponsiveImages()
            ->toMediaCollection('vip_tables');

        $page
            ->addMediaFromUrl('https://summerdreams.com/wp-content/uploads/2019/03/ramz-performing-on-vvip-zante-boat-party-2-1400x1000.jpg')
            ->withResponsiveImages()
            ->toMediaCollection('live_music');

        $page
            ->addMediaFromUrl('https://summerdreams.com/wp-content/uploads/2019/03/zante-boat-party-16-1400x1000.jpg')
            ->withResponsiveImages()
            ->toMediaCollection('champagne_showers');

        /**
         * Discounts page
         */
        $page = \App\Models\Page::create([
            'title' => 'Discounts',
            'url' => 'privilege-card',
            'description' => 'All VVIP ticket holders benefit from our complementary Privilege Zante wristband which saves you money at bars, clubs, restaurants and on the best daytime excursions you can enjoy in Zante.',
            'content' => [
                [
                    'type' => 'text-and-image',
                    'fields' => [
                        'title' => 'Zante Discount Wristband',
                        'content' => '<p><strong><span>If you pick your VVIP tickets up on your first day and start using your wristband straight away you can save at least 50 euro over your holiday, which makes booking a Fantasy Boat Party ticket even more of a no-brainer! Privilege has been running for many years in Zante and is well known and trusted.</span></strong></p>',
                        'image' => 'bMdGJwPI14z4AuzdNZQgxjrhbV9VZC8ijjC9bA9N.jpg'
                    ]
                ]
            ]
        ]);

        $page
            ->addMediaFromUrl('https://summerdreams.com/wp-content/uploads/2018/12/BOAT-PARTY-ZANTE-99.jpg')
            ->withResponsiveImages()
            ->toMediaCollection('header');



        /**
         * Discounts page
         */
        $page = \App\Models\Page::create([
            'title' => 'The Event',
            'url' => 'event-details',
            'description' => 'With the same crew in charge since 2013 and 100,000 + happy customers you’re in very safe hands onboard ‘Ikaros Palace’. VVIP goes off without fail – the combination of the venue, music and epic scenery is simply irresistible. Summer 2023 is going to be very busy, we recommend booking early.',
        ]);

        $page
            ->addMediaFromUrl('https://summerdreams.com/wp-content/uploads/2018/12/slider3.jpg')
            ->withResponsiveImages()
            ->toMediaCollection('header');


        /**
         * Contact page
         */
        $page = \App\Models\Page::create([
            'title' => 'Get in touch',
            'url' => 'contact'
        ]);

        $page
            ->addMediaFromUrl('https://summerdreams.com/wp-content/uploads/2018/12/slider3.jpg')
            ->withResponsiveImages()
            ->toMediaCollection('header');

        /**
         * Newsletter page
         */
        $page = \App\Models\Page::create([
            'title' => 'Thanks for signing up!',
            'url' => 'newsletter',
            'content' => [
                [
                    'type' => 'text-content',
                    'fields' => [
                        'title' => '',
                        'content' => '<p>We\'ve added you to the list.</p>'
                    ]
                ]
            ]
        ]);

        /**
         * Menus
         */
        DB::table('nova_menu_menus')->insert([
            'name' => 'Header',
            'slug' => 'header',
        ]);
        DB::table('nova_menu_menu_items')->insert(config('menus.header'));

        DB::table('nova_menu_menus')->insert([
            'name' => 'Footer One',
            'slug' => 'footer_one',
        ]);
        DB::table('nova_menu_menu_items')->insert(config('menus.footer_one'));

        DB::table('nova_menu_menus')->insert([
            'name' => 'Footer Two',
            'slug' => 'footer_two',
        ]);
        DB::table('nova_menu_menu_items')->insert(config('menus.footer_two'));

        DB::table('nova_menu_menus')->insert([
            'name' => 'Footer Three',
            'slug' => 'footer_three',
        ]);
        DB::table('nova_menu_menu_items')->insert(config('menus.footer_three'));
    }
}
