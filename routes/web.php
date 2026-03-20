<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddExtraController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PayBalanceController;
use App\Http\Controllers\QrCodeCheckoutLinkController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SellerBookController;
use App\Http\Controllers\SellerLoginController;
use App\Http\Controllers\VideoController;
use App\Http\Middleware\AccountMiddleware;
use App\Http\Middleware\BookMiddleware;
use App\Http\Middleware\VerifySeller;
use App\Livewire\SellerBook;
use App\Mail\BookingBalanceMail;
use App\Mail\BookingConfirmationMail;
 use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Honeypot\ProtectAgainstSpam;
use Spatie\Sitemap\SitemapGenerator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('', 'home')->name('home');
Route::view('event', 'event')->name('event');

// Route::get('test', function () {
//     // \App\Jobs\PriorArrivalMailJob::dispatch();
//     return new \App\Mail\BookingPriorArrivalMail(\App\Models\Booking::confirmed()->first());
// });

Route::get('qrcode-checkout/{booking:id}/{amount}', QrCodeCheckoutLinkController::class)->name('qrcode-checkout');

/**
 * Account
 */
Route::view('login', 'account.login');
Route::post('login', LoginController::class);
Route::get('logout', [LoginController::class, 'logout']);

Route::middleware([AccountMiddleware::class])->group(function () {
    Route::get('account', AccountController::class)->name('account');
    Route::post('account/extra/{extra:id}', AddExtraController::class)->name('add-extra');
    Route::post('account/balance', PayBalanceController::class)->name('pay-balance');
    Route::get('account/balance-success', [PayBalanceController::class, 'success'])->name('balance-success');
});

/**
 * Seller
 */
Route::view('tickets/login', 'seller.login');
Route::post('tickets/login', SellerLoginController::class)->name('seller.login');
Route::get('tickets', SellerBook::class)->middleware(VerifySeller::class);
Route::get('tickets/{seller:id}/{event:id}/{date}/{payment_method}/{currency}', SellerBookController::class)->name('seller.book');
Route::post('tickets/{seller:id}/{event:id}/{date}/{payment_method}/{currency}', [SellerBookController::class, 'book'])->name('seller.book.submit');

/**
 * Book
 */
Route::get('book/package/{package:slug}', [BookController::class, 'bookPackage'])->name('book.package')->middleware('doNotCacheResponse', BookMiddleware::class);
Route::get('book/event/{event:slug}', [BookController::class, 'bookEvent'])->name('book.event')->middleware('doNotCacheResponse', BookMiddleware::class);
Route::post('book/{eventOrPackage}/submit', [BookController::class, 'submit'])->name('book.submit')->middleware('doNotCacheResponse');
Route::get('book/{eventOrPackage}/submit', fn() => redirect()->route('book'))->middleware('doNotCacheResponse');
Route::post('book/checkout', [BookController::class, 'checkout'])->name('book.checkout')->middleware('doNotCacheResponse', BookMiddleware::class);

Route::get('payment/success', [BookController::class, 'paymentSuccess'])->name('payment.success')->middleware('doNotCacheResponse', BookMiddleware::class);
Route::get('book/success', [BookController::class, 'success'])->name('book.success')->middleware('doNotCacheResponse', BookMiddleware::class);
Route::get('book/cancel', [BookController::class, 'cancel'])->name('book.cancel')->middleware('doNotCacheResponse', BookMiddleware::class);

Route::get('book/checkout', fn() => redirect()->route('book.cancel'))->middleware('doNotCacheResponse', BookMiddleware::class);
Route::get('book/package/{package:slug}/submit', fn($package) => redirect()->route('book.package', $package))->middleware('doNotCacheResponse', BookMiddleware::class);

Route::get('checkout/{booking:reference}', CheckoutController::class)->name('checkout')->middleware('doNotCacheResponse', BookMiddleware::class);

Route::get('book/{referral:slug}', ReferralController::class)->name('book.referral')->middleware('doNotCacheResponse', BookMiddleware::class);

Route::get('discount/{discount:code}', DiscountController::class)->name('discount');

// Route::view('book/success/enquiry', 'book.success-enquiry')->name('book.success-enquiry');
/**
 * Forms
 */
Route::post('newsletter', NewsletterController::class)->name('newsletter')->middleware(ProtectAgainstSpam::class);
Route::post('contact', ContactController::class)->name('contact')->middleware(ProtectAgainstSpam::class);

Route::get('book', BookController::class)->name('book');

// Route::get('zante-event-packages', EventController::class)->name('events');
Route::get('event/{event:slug}', [EventController::class, 'show'])->name('event.show');

Route::get('blog', BlogController::class)->name('blog');
// Route::get('post/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('gallery', GalleryController::class)->name('gallery');
Route::get('gallery/{gallery:slug}', [GalleryController::class, 'show'])->name('gallery.show');

Route::get('reviews', ReviewController::class)->name('reviews');

Route::get('video', VideoController::class)->name('videos');

Route::get('faqs', FaqController::class)->name('faqs');

Route::get('calendar', [CalendarController::class, 'index'])->name('calendar');
Route::get('calendar/event/{event:slug}/{date}', [CalendarController::class, 'show'])->name('calendar.event');

Route::get('{url}', PageController::class)->name('page')->where('url', '.*')->where('url', '^(?!admin|api|nova-api).*$');

Route::stripeWebhooks('webhook/stripe');