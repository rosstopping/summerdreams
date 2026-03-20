<?php

namespace App\Providers;

use App\Observers\NovaEventObserver;
use Digizu\Calendar\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuGroup;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Mostafaznv\NovaLaraCache\NovaLaraCache;
use Auth;

class NovaServiceProvider extends NovaApplicationServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::footer(function ($request) {
            return Blade::render('');
        });

        Nova::initialPath(function ($request) {
            if ($request->user()?->referral) {
                return '/resources/referrals/' . $request->user()->referral->id;
            }

            return '/resources/bookings';
        });

        Nova::mainMenu(function (Request $request, Menu $menu) {

            /**
             * Build the enquiries filter url
             */
            $enquiriesFilter = base64_encode(json_encode([
                ['class' => \App\Nova\Filters\BookingStatusFilter::class, 'value' => 'enquiry']
            ]));

            $extras_menu_items = [];
            
            foreach (\App\Models\Extra::all() as $extra) {
                $count = \App\Models\Booking::confirmed()->whereHas('extras', fn ($extras) => $extras->where('extras.id', $extra->id))->count();

                $label = $count > 0 ? 'success' : 'danger';

                array_push($extras_menu_items, MenuItem::link($extra->name, 'resources/extras/' . $extra->id)->canSee(fn ($request) => $request->user()->master)->withBadge(''.$count, $label));
            }

            return [

                /**
                 * Links for referrals
                 */
                MenuSection::make('Menu', [
                    MenuItem::link('Bookings', 'resources/referrals/' . $request->user()->referral_id)->canSee(fn ($request) => $request->user()->referral),
                    MenuItem::link('Enquiries', 'resources/referrals/' . $request->user()->referral_id . '?bookings_filter='.urlencode($enquiriesFilter))->canSee(fn ($request) => $request->user()->referral),
                ])->canSee(fn ($request) => $request->user()->referral),

                /**
                 * Links for non-master
                 */
                MenuSection::make('Bookings', [
                    MenuItem::resource(\App\Nova\Booking::class)->canSee(fn ($request) => !$request->user()->master && !$request->user()->referral),
                    MenuItem::link('Enquiries', 'resources/bookings?bookings_filter='.urlencode($enquiriesFilter))->canSee(fn ($request) => !$request->user()->master && !$request->user()->referral),
                    MenuItem::resource(\App\Nova\Payment::class)->canSee(fn ($request) => !$request->user()->master && !$request->user()->referral),
                    MenuItem::link('Calendar', 'calendar')->canSee(fn ($request) => !$request->user()->master && !$request->user()->referral),
                    MenuItem::resource(\App\Nova\Referral::class)->canSee(fn ($request) => !$request->user()->master && !$request->user()->referral),
                    MenuItem::resource(\App\Nova\ContactForm::class)->canSee(fn ($request) => !$request->user()->master && !$request->user()->referral),
                ])->icon('users')->collapsable(),

                /**
                 * Links for master
                 */
                MenuSection::make('Dashboards', [
                    MenuItem::dashboard(\App\Nova\Dashboards\Main::class)->canSee(fn ($request) => $request->user()->master),
                    // MenuItem::link('Extras Overview', 'extras-overview'),
                    // MenuGroup::make('Agents', [
                    //     MenuItem::link('Agent Branches', 'resources/group-branches'),
                    // ]),
                ])->collapsable(),

                MenuSection::make('CRM', [
                    MenuItem::link('All Leads', 'resources/contact-forms/lens/crm-all')->withBadge(''.\App\Models\ContactForm::crm()->count(), 'info'),
                    MenuItem::link('New Leads', 'resources/contact-forms/lens/crm-new')->withBadge(''.\App\Models\ContactForm::crm()->where(fn ($query) => $query->where('crm->status', 'new')->orWhereNull('crm->status'))->count(), 'info'),
                    MenuItem::link('No Reply Leads', 'resources/contact-forms/lens/crm-no-reply')->withBadge(''.\App\Models\ContactForm::where('crm->status', 'no-reply')->count(), 'danger'),
                    MenuItem::link('In Conversation Leads', 'resources/contact-forms/lens/crm-in-conversation')->withBadge(''.\App\Models\ContactForm::where('crm->status', 'in-conversation')->count(), 'warning'),
                    MenuItem::link('Converted Leads', 'resources/contact-forms/lens/crm-converted')->withBadge(''.\App\Models\ContactForm::whereHas('booking')->count(), 'success'),
                    MenuItem::link('Cold Leads', 'resources/contact-forms/lens/crm-cold')->withBadge(''.\App\Models\ContactForm::notCrm()->count(), 'info'),
                ])->icon('chart-bar')->collapsable(),

                MenuSection::make('Enquiries', [
                    MenuItem::link('All Enquiries', 'resources/bookings/lens/enquiries-all')->withBadge(''.\App\Models\Booking::enquiry()->count(), 'info'),
                    MenuItem::link('New', 'resources/bookings/lens/enquiries-new')->withBadge(''.\App\Models\Booking::enquiry()->whereNull('enquiry_status')->count(), 'info'),
                    MenuItem::link('No Reply', 'resources/bookings/lens/enquiries-no-reply')->withBadge(''.\App\Models\Booking::enquiry()->where('enquiry_status', 'no-reply')->count(), 'danger'),
                    MenuItem::link('In Conversation', 'resources/bookings/lens/enquiries-in-conversation')->withBadge(''.\App\Models\Booking::enquiry()->where('enquiry_status', 'in-conversation')->count(), 'warning'),
                    MenuItem::link('Paying', 'resources/bookings/lens/enquiries-paying')->withBadge(''.\App\Models\Booking::enquiry()->where('enquiry_status', 'paying')->count(), 'success'),
                    // MenuItem::link('Call 2', 'resources/contact-forms/lens/call-2')->withBadge(''.\App\Models\ContactForm::where('status', 'Call 2')->where('company_id', 1)->count(), 'info'),
                    // MenuItem::link('Call 3', 'resources/contact-forms/lens/call-3')->withBadge(''.\App\Models\ContactForm::where('status', 'Call 3')->where('company_id', 1)->count(), 'info'),
                    // MenuItem::link('Call 4', 'resources/contact-forms/lens/call-4')->withBadge(''.\App\Models\ContactForm::where('status', 'Call 4')->where('company_id', 1)->count(), 'info'),
                    // MenuItem::link('Blowout', 'resources/contact-forms/lens/blowout')->withBadge(''.\App\Models\ContactForm::where('status', 'Blowout')->where('company_id', 1)->count(), 'danger'),
                    // MenuItem::link('Incomplete', 'resources/contact-forms/lens/incomplete')->withBadge(''.\App\Models\ContactForm::where('status', 'Incomplete')->whereNotNull('data->mobile')->where('company_id', 1)->count(), 'warning'),
                    // MenuItem::link('Converted', 'resources/contact-forms/lens/converted')->withBadge(''.\App\Models\ContactForm::where('status', 'Converted')->where('company_id', 1)->count(), 'success'),
                ])->icon('user')->collapsable(),

                MenuSection::make('Bookings', [
                    MenuItem::resource(\App\Nova\Booking::class)->canSee(fn ($request) => $request->user()->master),
                    // MenuItem::lens(\App\Nova\Booking::class, \App\Nova\Lenses\OnlineBookings::class)->canSee(fn ($request) => $request->user()->master),
                    // MenuItem::lens(\App\Nova\Booking::class, \App\Nova\Lenses\SellerBookings::class)->canSee(fn ($request) => $request->user()->master),
                    MenuItem::resource(\App\Nova\Payment::class)->canSee(fn ($request) => $request->user()->master),
                    MenuItem::link('Calendar', 'calendar')->canSee(fn ($request) => $request->user()->master),
                    MenuItem::resource(\App\Nova\Referral::class)->canSee(fn ($request) => $request->user()->master),
                    MenuItem::resource(\App\Nova\Seller::class)->canSee(fn ($request) => $request->user()->master),
                    MenuItem::resource(\App\Nova\ContactForm::class)->canSee(fn ($request) => $request->user()->master),
                ])->icon('users')->collapsable(),

                MenuSection::make('Extras Bookings', $extras_menu_items)->icon('users')->collapsable(),

                MenuSection::make('Content', [
                    MenuItem::resource(\App\Nova\Page::class),
                    MenuItem::resource(\App\Nova\Event::class),
                    MenuItem::resource(\App\Nova\Package::class),
                    MenuItem::resource(\App\Nova\SeasonalPricing::class),
                    MenuItem::resource(\App\Nova\Extra::class),
                    MenuItem::resource(\App\Nova\Gallery::class),
                    MenuItem::resource(\App\Nova\Video::class),
                    MenuItem::resource(\App\Nova\Review::class),
                    MenuItem::resource(\App\Nova\Faq::class),
                    MenuItem::resource(\App\Nova\Popup::class),
                ])->canSee(fn ($request) => $request->user()->master)->icon('pencil-alt')->collapsable(),

                MenuSection::make('Blog', [
                    MenuItem::resource(\App\Nova\Post::class),
                ])->canSee(fn ($request) => $request->user()->master)->icon('pencil')->collapsable(),

                MenuSection::make('Settings', [
                    MenuItem::resource(\App\Nova\Discount::class),
                    MenuItem::link('Menus', 'menus'),
                    MenuItem::resource(\App\Nova\Media::class),
                    MenuItem::resource(\App\Nova\Setting::class),
                    MenuItem::resource(\App\Nova\Redirect::class),
                    MenuItem::resource(\App\Nova\User::class),
                    // MenuItem::link('Cache', 'laracache'),
                ])->canSee(fn ($request) => $request->user()->master)->icon('cog')->collapsable(),
            ];
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return true;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new Calendar,
            \Outl1ne\MenuBuilder\MenuBuilder::make(),
            new NovaLaraCache
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Nova::report(function ($exception) {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($exception);
           }
       });
    }
}
