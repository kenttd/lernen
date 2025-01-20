<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Jobs\CompleteBookingJob;
use App\Jobs\CompletePurchaseJob;
use App\Services\GoogleCalender;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;
use App\Livewire\Actions\Logout;
use App\Services\BookingService;
use App\Services\WalletService;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;
class SiteController extends Controller
{
    private $userService             = null;
    public  $googleSetToken          = null;
    private $googleCalenderService   = null;

    public function getGoogleToken(Request $request) {

        $this->googleCalenderService    = new GoogleCalender(Auth::user());
        $this->userService              = new UserService(Auth::user());
        $googleToken                    = $this->googleCalenderService->getAccessTokenInfo($request->get('code'));

        if(!empty($googleToken['error'])){
            return redirect()->route('tutor.profile.account-settings')->with('error',__('passwords.failed_retrieve_Google_token'));
        }

        $primaryCalendar         = $this->googleCalenderService->getUserPrimaryCalendar($googleToken['access_token']);
        $primaryCalendar['data']['minutes'] = 30;
        $this->userService->setAccountSetting(['google_access_token','google_calendar_info'],[$googleToken,$primaryCalendar['data']]);
        return redirect()->route(Auth::user()->role.'.profile.account-settings')->with('success',__('passwords.connect_calender'));
    }

    public function completeBooking($id, BookingService $bookingService) {
        $booking = $bookingService->getBookingById($id);
        if(empty($booking)) {
            return redirect()->route('student.bookings')->with('error',__('general.booking_not_found'));
        }
        if($booking->status != 'active' || Carbon::parse($booking->end_time)->isFuture()) {
            return redirect()->route('student.bookings')->with('error',__('calendar.unable_to_complete_booking'));
        }
        $bookingService->updateBooking($booking, ['status' => 'completed']);
        (new WalletService())->makePendingFundsAvailable($booking->tutor_id, ($booking->session_fee - $booking?->orderItem?->platform_fee), $booking?->orderItem?->order_id);
        dispatch(new CompleteBookingJob($booking));
        return redirect()->route('student.bookings')->with('success',__('calendar.booking_completed'));
    }

    public function processPayment($gateway){

        $paymentData = session('payment_data');
        if (empty($paymentData)) {
            return redirect()->route('checkout')->with('error',__('general.payment_cancelled_desc'));
        }

        $gatewayObj = getGatewayObject($gateway);
        if(!empty($gatewayObj)) {
            $response = $gatewayObj->chargeCustomer($paymentData);
            if(is_array($response) && array_key_exists('message', $response)){
                return redirect()->route('checkout')->with('error', $response['message']);
            }
            return $response;
        }
    }

    public function payfastWebhook(Request $request){
        header('HTTP/1.0 200 OK');
        flush();
        $gatewayObj = getGatewayObject('payfast');
        if(!empty($gatewayObj)) {
            $paymentData = $gatewayObj->paymentResponse($request->all());
            if (!empty($paymentData) && $paymentData['status'] == Response::HTTP_OK) {
                $this->paymentSuccess($paymentData);
            }
        }
    }

    public function paymentSuccess(Request $request) {
        $orderServices   = new OrderService();
        $gatewayObj = getGatewayObject($request['payment_method']);
        if(!empty($gatewayObj)) {
            $paymentData = $gatewayObj->paymentResponse($request->all());
            if (!empty($paymentData) && $paymentData['status'] == Response::HTTP_OK) {
                $orderDetail   = $orderServices->getOrderDetail($paymentData['data']['order_id']);
                $status = $orderServices->updateOrder($orderDetail ,['status'=>'complete','transaction_id'=>$paymentData['data']['transaction_id']]);
                if($status){
                    dispatch(new CompletePurchaseJob($orderDetail));
                    $request->session()->forget('payment_data');
                    Cart::clear();
                    return redirect()->route('thank-you', ['id' => $paymentData['data']['order_id']]);
                }
            } else {
                return redirect(route('checkout'))->with('error',__('general.payment_cancelled_desc'));
            }
        }
    }

    public function removeCart(Request $request)
    {
        try {
            $bookingService = new BookingService();
            $bookingService->removeReservedBooking($request->id);
            Cart::remove($request->id);
            $cartData = Cart::content();
            $total = Cart::total();
            $subTotal = Cart::subtotal();
            return response()->json([
                'success'       => true,
                'cart_data'     => $cartData,
                'total'         => $total,
                'subTotal'      => $subTotal,
            ]);
        } catch (\Exception $e) {
            Log::error('Error removing item from cart: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error removing item'], 500);
        }
    }

    public function logout(Logout $logout){
        $logout();
        return redirect('/login');
    }
}



