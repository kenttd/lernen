<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\SlotBooking;
use App\Models\User;
use App\Services\BookingService;
use App\Services\OrderService;
use App\Services\WalletService;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CompletePurchaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Order $order;
    protected BookingService $bookingService;
    protected OrderService $orderService;
    protected WalletService $walletService;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order            = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(BookingService $bookingService, OrderService $orderService, WalletService $walletService): void
    {
        try {
            $this->bookingService   = $bookingService;
            $this->orderService     = $orderService;
            $this->walletService    = $walletService;

            $tutorBookings = $tutorFunds = [];

            DB::beginTransaction();
            if (!empty($this->order->items)) {
                foreach($this->order->items as $item) {
                    if ($item->orderable instanceof SlotBooking) {

                        $this->bookingService->updateBooking($item->orderable, ['status' => 'active']);
                        $this->bookingService->addBookingLog($item->orderable, [
                            'activityable_id'   => $item->orderable->student_id,
                            'activityable_type' => User::class,
                            'type'              => 'active'
                        ]);

                        //Update platform fee in order_items table
                        $platformFee = number_format(getCommission($item->price), 2);
                        $this->orderService->updateOrderItem($item, ['platform_fee'=> $platformFee]);

                        //Calculate tutor funds
                        $tutorEarning = $item->price - $platformFee;
                        $tutorFunds[$item->orderable->bookee->id] = ($tutorFunds[$item->orderable->bookee->id]??0) + $tutorEarning ;

                        //Update tutorBookings
                        $tutorBookings[$item->orderable->bookee->id][] = $item;

                        $this->bookingService->createBookingEventGoogleCalendar($item->orderable);
                        $this->bookingService->createSlotEventGoogleCalendar($item->orderable);
                        $this->bookingService->createMeetingLink($item->orderable);
                        // Calculate delay until the end time of the booking
                        $endTime = $item->orderable->end_time;
                        $delay = now()->diffInSeconds($endTime, false);
                        if ($delay > 0) {
                            dispatch(new SendNotificationJob('bookingCompletionRequest',$item->orderable->booker, [
                                'tutorName'           => $item->orderable->tutor->full_name,
                                'userName'            => $item->orderable->student->full_name,
                                'sessionDateTime'     => $this->bookingService->getBookingTime($item->orderable, 'booker'),
                                'completeBookingLink' => route('student.complete-booking', $item->orderable->id),
                                'days'                => setting('_lernen.complete_booking_after_days') ?? 3    
                            ]))->delay($delay);
                        }

                        $completeBookingDelay = Carbon::parse($endTime)->addDays(setting('_lernen.complete_booking_after_days') ?? 3);
                        $completeBookingDelaySeconds = now()->diffInSeconds($completeBookingDelay, false);
                        
                        if ($completeBookingDelaySeconds > 0) {
                            dispatch(new CompleteBookingJob($item->orderable))->delay($completeBookingDelaySeconds);
                        }
                    }
                }

                if (!empty($tutorFunds)) {
                    foreach ($tutorFunds as $tutorId => $amount) {
                        $walletService->pendingAvailableFunds( $tutorId, $amount, $this->order->id);
                    }
                }

                //Tutor bookings
                if (!empty($tutorBookings)) {
                    foreach ($tutorBookings as $tutorId => $bookings) {
                        $emailData = [];
                        $emailData['tutorName'] = $bookings[0]->orderable->tutor->full_name;
                        $emailData['emailFor']  = 'tutor';
                        foreach($bookings as $booking) {
                            $emailData['bookings'][]=[
                                'studentName' => $booking->orderable->student->full_name,
                                'studentImg'  => $booking->orderable->student->image,
                                'subjectName' => $booking->options['subject_group'] . ' <br /> ' . $booking->options['subject'],
                                'sessionTime' => $this->bookingService->getBookingTime($item->orderable, 'bookee', true)
                            ];
                        }
                        dispatch(new SendNotificationJob('sessionBooking',$bookings[0]->orderable->bookee, $emailData));
                    }
                }

                //Student bookings
                $emailData = [];
                $emailData['studentName'] = $this->order->student->full_name;
                $emailData['emailFor']  = 'student';
                foreach ($this->order->items as $item) {
                    $emailData['bookings'][] = [
                        'tutorName'   => $item->orderable->tutor->full_name,
                        'tutorImg'    => $item->orderable->tutor->image,
                        'subjectName' => $item->options['subject_group'] . ' <br /> ' . $item->options['subject'],
                        'sessionTime' => $this->bookingService->getBookingTime($item->orderable, 'booker', true)
                    ];
                }
                dispatch(new SendNotificationJob('sessionBooking',$this->order->orderBy, $emailData));

                DB::commit();
            }


        } catch (Exception $ex) {
            throw new Exception($ex);
            DB::rollBack();
        }

    }
}
