<?php

namespace App\Livewire\Pages\Common\Bookings;

use App\Jobs\CompleteBookingJob;
use App\Livewire\Forms\Student\Booking\RatingForm;
use App\Models\Day;
use App\Services\BookingService;
use App\Services\SubjectService;
use App\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class UserBooking extends Component
{

    public $currentDate, $showBy, $days, $startOfWeek;
    public $disablePrevious, $isCurrent = false;
    public $dateRange = [];
    public $subjectGroups, $upcomingBookings, $currentBooking;
    public $filter = [];
    public RatingForm $form;
    public $activeRoute;

    protected $bookingService, $subjectService;
    public function boot() {
        $this->bookingService = new BookingService(Auth::user());
        $this->subjectService  = new SubjectService(Auth::user());
    }

    public function mount() {
        $this->showBy   = 'daily';
        $this->startOfWeek = (int) (setting('_lernen.start_of_week') ?? Carbon::SUNDAY);
        $this->currentDate = parseToUserTz(Carbon::now());
        $this->days = Day::get($this->startOfWeek);
        $this->getRange();
        $this->subjectGroups = $this->subjectService->getSubjectsByUserRole();
        $this->dispatchSessionMessages();
        $this->activeRoute = Route::currentRouteName();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $this->upcomingBookings = $this->bookingService->getUserBookings($this->dateRange, $this->showBy, $this->filter);
        return view('livewire.pages.common.bookings.user-booking');
    }

    protected function dispatchSessionMessages() {
        if (session('error')) {
            $this->dispatch('showAlertMessage', type: 'error',  message: session('error'));
        }
        if (session('success')) {
            $this->dispatch('showAlertMessage', type: 'success', message: session('success'));
        }
        if (session('rescheduled_msg')) {
            $this->dispatch('showAlertMessage', type: 'success' , message: session('rescheduled_msg'));
        }
    }

    public function switchShow($showBy) {
        $this->showBy = $showBy;
        $this->currentDate = parseToUserTz(Carbon::now());
        $this->filter = [];
        $this->getRange();
        $this->dispatch('initCalendarJs', showBy: $showBy, currentDate: $this->getDateFormat());
    }

    public function jumpToDate($date=null) {
        if (!empty($date)) {
            if (in_array($this->showBy, ['daily', 'weekly'])) {
                $format = 'Y-m-d';
            } else {
                $format = 'd F, Y';
                $date = "01 $date";
            }
            $this->currentDate = Carbon::createFromFormat($format, $date, getUserTimezone());
        } else {
            $this->currentDate = parseToUserTz(Carbon::now());
        }
        $this->getRange();
        $this->dispatch('initCalendarJs', showBy: $this->showBy, currentDate: $this->getDateFormat());
    }

    #[On('complete-booking')]
    public function completeBooking($params) {
        $id = $params['id'];
        $booking = $this->bookingService->getBookingById($id);
        if($booking->status != 'active' || Carbon::parse($booking->end_time)->isFuture()) {
            $this->dispatch('showAlertMessage', type: 'error',  message: __('calendar.unable_to_complete_booking'));
        }
        $this->bookingService->updateBooking($booking, ['status' => 'completed']);
        (new WalletService())->makePendingFundsAvailable($booking->tutor_id, ($booking->session_fee - $booking?->orderItem?->platform_fee), $booking?->orderItem?->order_id);
        dispatch(new CompleteBookingJob($booking));
        $this->dispatch('showAlertMessage', type: 'success',  message: __('calendar.booking_completed'));
    }

    public function nextBookings() {
        if ($this->showBy == 'daily') {
            $this->currentDate->addDay();
        } elseif ($this->showBy == 'weekly') {
            $this->currentDate->addWeek();
        } else {
            $this->currentDate->addMonth();
        }
        $this->getRange();
        $this->dispatch('initCalendarJs', showBy: $this->showBy, currentDate: $this->getDateFormat());
    }

    public function previousBookings() {
        if ($this->showBy == 'daily') {
            $this->currentDate->subDay();
        } elseif ($this->showBy == 'weekly') {
            $this->currentDate->subWeek();
        } else {
            $this->currentDate->subMonth();
        }
        $this->getRange();
        $this->dispatch('initCalendarJs', showBy: $this->showBy, currentDate: $this->getDateFormat());
    }

    public function showBookingDetail($id) {
        $this->currentBooking = $this->bookingService->getBookingDetail($id);
        $this->dispatch('toggleModel', id: 'session-detail', action: 'show');
    }

    public function syncWithGoogleCalendar() {
        if (Auth::user() && Auth::user()->role == 'tutor') {
            $sucess = $this->bookingService->createSlotEventGoogleCalendar(booking: $this->currentBooking, updateMeetingLink: true);
            [$type, $message] = $sucess ? ['success', __('calendar.sync_success')] : ['error', __('calendar.sync_error')];
        } elseif (Auth::user() && Auth::user()->role == 'student') {
            $sucess = $this->bookingService->createBookingEventGoogleCalendar($this->currentBooking);
            [$type, $message] = $sucess ? ['success', __('calendar.sync_success')] : ['error', __('calendar.sync_error')];
        } else {
            [$type, $message] = ['error', __('general.not_allowed')];
        }
        $this->dispatch('toggleModel', id: 'session-detail', action: 'hide');
        $this->dispatch('showAlertMessage', type: $type,  message: $message);
    }

    public function submitReview() {
        $this->form->validateData();
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $reviewAdded = $this->bookingService->addBookingReview($this->form->bookingId, $this->form->only(['rating', 'comment']));
        if ($reviewAdded) {
            $this->dispatch('showAlertMessage', type: 'success',  message: __('general.alert_success_msg'));
        } else {
            $this->dispatch('showAlertMessage', type: 'error',  message: __('general.error_msg'));
        }
        $this->dispatch('toggleModel', id: 'review-modal', action: 'hide');
    }

    protected function getRange(){
        $start = $end = null;
        $this->disablePrevious = $this->isCurrent = false;
        $now = Carbon::now(getUserTimezone());
        if ($this->showBy == 'daily') {
            $start = $this->currentDate->toDateString()." 00:00:00";
            $end = $this->currentDate->toDateString()." 23:59:59";
            if ($this->currentDate->isSameDay($now)) {
                if (Auth::user()->role == 'tutor') {
                    $this->disablePrevious = true;
                }
                $this->isCurrent = true;
            }
        } elseif ($this->showBy == 'weekly') {
            $start = $this->currentDate->copy()->startOfWeek($this->startOfWeek)->toDateString()." 00:00:00";
            $end = $this->currentDate->copy()->endOfWeek(getEndOfWeek($this->startOfWeek))->toDateString()." 23:59:59";
            if ($this->currentDate->isSameWeek($now)) {
                if (Auth::user()->role == 'tutor') {
                    $this->disablePrevious = true;
                }
                $this->isCurrent = true;
            }
        } else {
            $start = $this->currentDate->copy()->firstOfMonth()->startOfWeek($this->startOfWeek)->toDateString()." 00:00:00";
            $end = $this->currentDate->copy()->lastOfMonth()->endOfWeek(getEndOfWeek($this->startOfWeek))->toDateString()." 23:59:59";
            if ($this->currentDate->isSameMonth($now)) {
                if (Auth::user()->role == 'tutor') {
                    $this->disablePrevious = true;
                }
                $this->isCurrent = true;
            }
        }
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $start, getUserTimezone());
        $endDate   = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $end, getUserTimezone());
        $this->dateRange['start_date']  = parseToUTC($startDate);
        $this->dateRange['end_date']    = parseToUTC($endDate);
    }

    protected function getDateFormat() {
        if ($this->showBy == 'daily') {
           return $this->currentDate->toDateString();
        } elseif ($this->showBy == 'weekly') {
            $start = $this->currentDate->copy()->startOfWeek($this->startOfWeek);
            $end = $this->currentDate->copy()->endOfWeek(getEndOfWeek($this->startOfWeek));
            return $start->format('F') . " ". $start->format('d') . " - " . $end->format('F') . " ". $end->format('d') . " " . $end->format('Y');
        } else {
            return $this->currentDate->format('F, Y');
        }
    }

}
