<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


$roleInfo = getUserRole();

$role = !empty($roleInfo) ? $roleInfo['roleName'] : '';

Breadcrumbs::for('tutor.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push(__('general.dashboard'), route('tutor.dashboard'));
    $trail->push(__('general.my_earnings'), route('tutor.dashboard'));
});

Breadcrumbs::for($role.'.profile', function (BreadcrumbTrail $trail) use ($role): void {
    $trail->push(__('general.profile_settings'), route($role.'.profile.personal-details'));
});

Breadcrumbs::for($role.'.profile.personal-details', function (BreadcrumbTrail $trail) use ($role): void {
    $trail->parent($role.'.profile');
    $trail->push(__('profile.personal_details'), route($role.'.profile.personal-details'));
});

Breadcrumbs::for($role.'.profile.account-settings', function (BreadcrumbTrail $trail) use ($role): void {
    $trail->parent($role.'.profile');
    $trail->push(__('profile.account_settings'), route($role.'.profile.account-settings'));
});

Breadcrumbs::for('tutor.profile.resume.education', function (BreadcrumbTrail $trail) {
    $trail->parent('tutor.profile');
    $trail->push(__('education.title'), route('tutor.profile.resume.education'));
});

Breadcrumbs::for('tutor.profile.resume.experience', function (BreadcrumbTrail $trail) {
    $trail->parent('tutor.profile');
    $trail->push(__('experience.title'), route('tutor.profile.resume.experience'));
});

Breadcrumbs::for('tutor.profile.resume.certificate', function (BreadcrumbTrail $trail) {
    $trail->parent('tutor.profile');
    $trail->push(__('certificate.certificate_wards'), route('tutor.profile.resume.certificate'));
});

Breadcrumbs::for($role.'.profile.identification', function (BreadcrumbTrail $trail) use($role){
    $trail->parent($role.'.profile');
    $trail->push(__('identity.title'), route($role.'.profile.identification'));
});


Breadcrumbs::for('tutor.bookings', function (BreadcrumbTrail $trail) {
    $trail->push(__('general.manage_bookings'), route('tutor.bookings.subjects'));
});

Breadcrumbs::for('student.tuition-settings', function (BreadcrumbTrail $trail) {
    $trail->push(__('sidebar.tuition_settings'), route('student.tuition-settings'));
});

Breadcrumbs::for('tutor.bookings.subjects', function (BreadcrumbTrail $trail) {
    $trail->parent('tutor.bookings');
    $trail->push(__('subject.subject_title'), route('tutor.bookings.subjects'));
});

Breadcrumbs::for('tutor.bookings.tuition-settings', function (BreadcrumbTrail $trail) {
    $trail->parent('tutor.bookings');
    $trail->push(__('sidebar.tuition_settings'), route('tutor.bookings.tuition-settings'));
});

Breadcrumbs::for('tutor.bookings.manage-sessions', function (BreadcrumbTrail $trail) {
    $trail->parent('tutor.bookings');
    $trail->push(__('calendar.title'), route('tutor.bookings.manage-sessions'));
});

Breadcrumbs::for('tutor.bookings.upcoming-bookings', function (BreadcrumbTrail $trail) {
    $trail->parent('tutor.bookings');
    $trail->push(__('sidebar.upcomming_bookings'), route('tutor.bookings.upcoming-bookings'));
});

Breadcrumbs::for('tutor.bookings.session-detail', function (BreadcrumbTrail $trail) {
    $trail->parent('tutor.bookings');
    $trail->push(__('calendar.title'), route('tutor.bookings.manage-sessions'));
});

Breadcrumbs::for('student.billing-detail', function (BreadcrumbTrail $trail) {
    $trail->push(__('sidebar.billing_detail'), route('student.billing-detail'));
});

Breadcrumbs::for('student.bookings', function (BreadcrumbTrail $trail) {
    $trail->push(__('sidebar.bookings'), route('student.bookings'));
});
Breadcrumbs::for('student.invoices', function (BreadcrumbTrail $trail) {
    $trail->push(__('sidebar.invoices'), route('student.invoices'));
});

Breadcrumbs::for('student.favourites', function (BreadcrumbTrail $trail) {
    $trail->push(__('sidebar.favourites'), route('student.favourites'));
});
Breadcrumbs::for('student.reschedule-session', function (BreadcrumbTrail $trail) {
    $trail->push(__('sidebar.bookings'), route('student.bookings'));
    $trail->push(__('calendar.reschedule_session'));
});

Breadcrumbs::for('laraguppy.messenger', function (BreadcrumbTrail $trail) use ($role) {
    $trail->push(__('general.dashboard'), route('tutor.dashboard'));
    $trail->push(__('sidebar.messages'), route('laraguppy.messenger'));
});

Breadcrumbs::for('tutor.payouts', function (BreadcrumbTrail $trail) use ($role) {
    $trail->push(__('general.dashboard'), route('tutor.dashboard'));
    $trail->push(__('tutor.payouts_history'), route('tutor.payouts'));
});


