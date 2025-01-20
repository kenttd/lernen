<?php

use App\Livewire\Pages\Admin\Blogs\BlogCategories;
use App\Livewire\Pages\Admin\Blogs\Blogs;
use App\Livewire\Pages\Admin\Blogs\CreateBlog;
use App\Livewire\Pages\Admin\Blogs\UpdateBlog;
use App\Livewire\Pages\Admin\Bookings\Bookings;
use App\Livewire\Pages\Admin\EmailTemplates\EmailTemplates;
use App\Livewire\Pages\Admin\IdentityVerification\IdentityVerification;
use App\Livewire\Pages\Admin\Menu\ManageMenu;
use App\Livewire\Pages\Admin\Packages\ManagePackages;
use App\Livewire\Pages\Admin\Payments\CommissionSettings;
use App\Livewire\Pages\Admin\Payments\PaymentMethods;
use App\Livewire\Pages\Admin\Payments\WithdrawRequest;
use App\Livewire\Pages\Admin\Profile\AdminProfile;
use App\Livewire\Pages\Admin\Taxonomy\Languages;
use App\Livewire\Pages\Admin\Taxonomy\SubjectGroups;
use App\Livewire\Pages\Admin\Taxonomy\Subjects;
use App\Livewire\Pages\Admin\Insights\Insights;
use App\Livewire\Pages\Admin\Users\Users;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/insights', Insights::class)->name('insights');
    Route::get('/profile', AdminProfile::class)->name('profile');
    Route::get('/manage-menus', ManageMenu::class)->name('manage-menus');
    Route::get('/blogs', Blogs::class)->name('blog-listing');
    Route::get('/blogs/create', CreateBlog::class)->name('create-blog');
    Route::get('/blogs/update/{id}', UpdateBlog::class)->name('update-blog');
    Route::get('/blog-categories', BlogCategories::class)->name('blog-categories');
    Route::prefix('taxonomies')->name('taxonomy.')->group(function () {
        Route::get('languages', Languages::class)->name('languages');
        Route::get('subjects', Subjects::class)->name('subjects');
        Route::get('subject-groups', SubjectGroups::class)->name('subject-groups');
        Route::get('subjects', Subjects::class)->name('subjects');
        Route::get('subject-groups', SubjectGroups::class)->name('subject-groups');
    });
    Route::get('commission-settings',   CommissionSettings::class)->name('commission-settings');
    Route::get('payment-methods',       PaymentMethods::class)->name('payment-methods');
    Route::get('withdraw-requests',     WithdrawRequest::class)->name('withdraw-requests');

    Route::get('users',          Users::class)->name('users');
    Route::get('identity-verification',          IdentityVerification::class)->name('identity-verification');
    Route::get('bookings',          Bookings::class)->name('bookings');
    Route::get('email-settings', EmailTemplates::class)->name('email-settings');
    Route::get('users/approve-identity/{id}', [Users::class, 'approveUserIdentity'])->name('approve-user-identity');

    Route::post('update-sass-style',    [App\Http\Controllers\Admin\GeneralController::class, 'updateSaas']);
    Route::get('packages', ManagePackages::class)->name('packages');
});
