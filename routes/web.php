<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Frontend\SearchController;
use App\Livewire\Frontend\Checkout;
use App\Livewire\Frontend\ThankYou;

use App\Livewire\Pages\Student\CertificateList;
use App\Livewire\Frontend\BlogDetails;
use App\Livewire\Frontend\Blogs;
use App\Livewire\Pages\Common\Bookings\UserBooking;
use App\Livewire\Pages\Student\Favourite\Favourites;
use App\Livewire\Pages\Common\ProfileSettings\Resume;
use App\Livewire\Pages\Tutor\ManageSessions\MyCalendar;
use App\Livewire\Pages\Tutor\ManageAccount\ManageAccount;
use App\Livewire\Pages\Tutor\ManageSessions\SessionDetail;
use App\Livewire\Pages\Student\BillingDetail\BillingDetail;
use App\Livewire\Pages\Tutor\ManageSessions\ManageSubjects;
use App\Livewire\Pages\Common\ProfileSettings\AccountSettings;
use App\Livewire\Pages\Common\ProfileSettings\PersonalDetails;
use App\Livewire\Pages\Common\ProfileSettings\IdentityVerification;
use App\Livewire\Pages\Student\Invoices;
use App\Livewire\Pages\Student\RescheduleSession;
use App\Livewire\Payouts;

Route::get('find-tutors', [SearchController::class, 'findTutors'])->name('find-tutors');
Route::get('/blogs', Blogs::class)->name('blogs');
Route::get('/blog/{slug}', BlogDetails::class)->name('blog-details');


Route::middleware(['auth', 'verified', 'onlineUser'])->group(function () {
    Route::post('favourite-tutor', [SearchController::class, 'favouriteTutor'])->name('favourite-tutor');
    Route::get('logout', [SiteController::class, 'logout'])->name('logout');
    Route::get('user/identity-confirmation/{id}', [PersonalDetails::class, 'confirmParentVerification'])->name('confirm-identity');
    Route::get('google/callback', [SiteController::class, 'getGoogleToken']);
    Route::middleware('role:student')->get('checkout', Checkout::class)->name('checkout');
    Route::middleware('role:student')->get('thank-you/{id}', ThankYou::class)->name('thank-you');
    Route::middleware('role:tutor')->prefix('tutor')->name('tutor.')->group(function () {
        Route::get('dashboard', ManageAccount::class)->name('dashboard');
        Route::get('payouts', Payouts::class)->name('payouts');
        Route::get('profile', fn() => redirect('tutor.profile.personal-details'))->name('profile');

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('personal-details', PersonalDetails::class)->name('personal-details');
            Route::get('account-settings',  AccountSettings::class)->name('account-settings');
            Route::prefix('resume')->name('resume.')->group(function () {
                Route::get('education', Resume::class)->name('education');
                Route::get('experience', Resume::class)->name('experience');
                Route::get('certificate', Resume::class)->name('certificate');
            });
            Route::get('identification', IdentityVerification::class)->name('identification');
        });
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('manage-subjects',       ManageSubjects::class)->name('subjects');
            Route::get('manage-sessions',       MyCalendar::class)->name('manage-sessions');
            Route::get('session-detail/{date}', SessionDetail::class)->name('session-detail');
            Route::get('upcoming-bookings',     UserBooking::class)->name('upcoming-bookings');
        });
        Route::get('invoices', Invoices::class)->name('invoices');
    });

    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('profile', fn() => redirect('tutor.profile.personal-details'))->name('profile');
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('personal-details', PersonalDetails::class)->name('personal-details');
            Route::get('account-settings',  AccountSettings::class)->name('account-settings');
            Route::get('identification', IdentityVerification::class)->name('identification');
        });
        Route::get('bookings', UserBooking::class)->name('bookings');
        Route::get('invoices', Invoices::class)->name('invoices');
        Route::get('billing-detail', BillingDetail::class)->name('billing-detail');
        Route::get('favourites', Favourites::class)->name('favourites');
        Route::get('reschedule-session/{id}', RescheduleSession::class)->name('reschedule-session');
        Route::get('complete-booking/{id}', [SiteController::class, 'completeBooking'])->name('complete-booking');
        Route::get('certificates', CertificateList::class)->name('certificate-list');
    });
});

Route::post('/remove-cart', [SiteController::class, 'removeCart']);

Route::get('tutor/{slug}', [SearchController::class, 'tutorDetail'])->name('tutor-detail');
Route::get('{gateway}/process/payment', [SiteController::class, 'processPayment'])->name('payment.process');
Route::get('checkout/cancel',            fn() => redirect()->route('invoices')->with('payment_cancel', __('general.payment_cancelled_desc')))->name('checkout.cancel');
Route::post('payfast/webhook',          [Checkout::class, 'payfastWebhook'])->name('payfast.webhook');
Route::post('payment/success',                      [SiteController::class, 'paymentSuccess'])->name('post.success');
Route::get('payment/success',                       [SiteController::class, 'paymentSuccess'])->name('get.success');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/optionbuilder.php';
require __DIR__ . '/pagebuilder.php';
