<?php

namespace App\Livewire\Frontend;

use Amentotech\LaraPayEase\Facades\PaymentDriver;
use App\Livewire\Forms\Frontend\OrderForm;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use App\Facades\Cart;
use App\Services\ProfileService;
use App\Jobs\CompletePurchaseJob;
use App\Services\SiteService;
use Illuminate\Support\Str;
use App\Models\SlotBooking;
use App\Services\BillingService;
use App\Services\BookingService;
use App\Services\OrderService;
use App\Services\WalletService;
use Livewire\Component;

class Checkout extends Component
{
    public OrderForm $form;

    public $user;
    public $methods             = [];
    public $address;
    public $content;
    public $countries           = [];
    public $payAmount;
    public $totalAmount         = '';
    public $walletBalance       = '';
    public $billingDetail;
    public $payment_methods     = [];
    public $useWalletBalance    = false;
    public $orderDetail;

    public  $available_payment_methods           = [];
    private ?OrderService $orderService   = null;
    private ?WalletService $walletService   = null;
    private ?BillingService $billingService = null;
    private ?ProfileService $profileService = null;
    private ?SiteService $siteService = null;
    public function boot() {
        $this->user            = Auth::user();
        $this->orderService   = new OrderService();
        $this->siteService   = new SiteService();
        $this->profileService   = new ProfileService(Auth::user()?->id);
        $this->walletService   = new WalletService();
        $this->billingService   = new BillingService(Auth::user());

    }

    public function mount()
    {
        $this->dispatch('initSelect2', target: '.am-select2' );
        $order_id = session('order_id') ?? '';
        if($order_id){
            $this->orderDetail      = $this->orderService->getOrderDetail($order_id);
        } else {
            $this->billingDetail      = $this->billingService->getBillingDetail();
            $this->address            = $this->billingService->getUserAddress();    
        }
        $gateways                   = $this->rearrangeArray(PaymentDriver::supportedGateways());
        $this->methods              = array_merge($this->methods, $gateways);
        $this->walletBalance        = $this->walletService->getWalletAmount(Auth::user()->id);
        $this->countries            = $this->siteService->getCountries();
        $this->totalAmount          = Cart::total(false);
        $this->form->totalAmount    = $this->totalAmount;
        $this->payAmount            = $this->totalAmount;

        if(!empty($this->orderDetail)){
            $billingData = (object) [
                "first_name"        => $this->orderDetail->first_name ?? '',
                "last_name"         => $this->orderDetail->last_name ?? '',
                "company"           => $this->orderDetail->company ?? '',
                "phone"             => $this->orderDetail->phone ?? '',
                "description"       => $this->orderDetail->description ?? '',
                "payment_method"    => $this->orderDetail->payment_method ?? '',
                "email"             => $this->orderDetail->email ?? ''
            ];

            $address = (object) [
                "country_id"        => $this->orderDetail->country ?? '',
                "state"             => $this->orderDetail->state ?? '',
                "zipcode"           => $this->orderDetail->postal_code ?? '',
                "city"              => $this->orderDetail->city ?? ''
            ];

            $this->form->setInfo($billingData);
            $this->form->setUserAddress($address);

        } elseif(!empty($this->billingDetail) && !empty($this->address)) {

            $this->form->setInfo($this->billingDetail);
            $this->form->setUserAddress($this->address,false);
            $this->form->paymentMethod = setting('admin_settings.default_payment_method') ?? '';
        } else {
            $this->address            = $this->profileService->getUserAddress();
            $profileData = (object) [
                "first_name"        => $this->user->profile->first_name ?? '',
                "last_name"         => $this->user->profile->last_name ?? '',
                "description"       => $this->user->profile->description ?? '',
                "email"             => $this->user->email ?? ''
            ];
            $state = $this->siteService->getState($this->address?->state_id);
            $addressData = (object) [
                "country_id"        => $this->address?->country_id ?? '',
                "state"             => $state->name ?? '',
                "zipcode"           => $this->address?->zipcode ?? '',
                "city"              => $this->address?->city ?? ''
            ];
            $this->form->setInfo($profileData);
            $this->form->setUserAddress($addressData);
        }

        $this->getavailablePaymentMethods();
    }

    public function getAvailablePaymentMethods()
    {
        $payment_methods = setting('admin_settings.payment_method');
        if (!is_array($payment_methods)) {
            $payment_methods = [];
        }
        if (!empty($payment_methods)) {
            foreach ($payment_methods as $type => $value) {
                if (array_key_exists($type, $this->methods)) {
                    $this->available_payment_methods[$type] = $value;
                }
            }
        }
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        $this->form->walletBalance      = $this->walletBalance;
        $this->form->useWalletBalance   = $this->useWalletBalance;
        $this->content                  = Cart::content();
        $subTotal                       = Cart::subtotal(false);

        if ($this->content->count() == 0) {
            redirect()->route('find-tutors');
        }
        return view('livewire.frontend.checkout', compact('subTotal'));
    }

    public function updatedUseWalletBalance($value)
    {
        if($value){
            $this->payAmount =  $this->totalAmount - $this->walletBalance ;
        } else {
            $this->payAmount = $this->totalAmount;
        }
    }

    public function rearrangeArray($array) {
        return array_map(function($details) {
            if (isset($details['keys'])) {
                $details = array_merge($details, $details['keys']);
                unset($details['keys']);
            }
            if (isset($details['ipn_url_type'])) {
                unset($details['ipn_url_type']);
            }
            return $details;
        }, $array);
    }

    public function updateInfo()
    {
        $orderItems = [];
        $data = $this->form->updateInfo();
        if(!empty($this->orderDetail)){
            $orderDetail = $this->orderService->updateOrder($this->orderDetail,$data);
        } else {
            $orderDetail = $this->orderService->createOrder($data);
        }
        session(['order_id' => $orderDetail->id]);

        foreach ($this->content as $item) {
            $orderItems[] = [
                'order_id'       => $orderDetail->id,
                'title'          => $item['name'],
                'quantity'       => $item['qty'],
                'options'        => $item['options'],
                'price'          => $item['price'],
                'total'          => $this->totalAmount,
                'orderable_id'   => $item['id'],
                'orderable_type' => SlotBooking::class,
            ];
        }

        $orderItems = $this->orderService->storeOrderItems($orderDetail->id,$orderItems);
        if ($this->useWalletBalance) {
            $this->walletService->deductFunds(Auth::user()->id, $this->totalAmount, 'deduct_booking', $orderDetail->id);
        }
        if($this->useWalletBalance && ($this->walletBalance >= $this->totalAmount) ){

           $orderDetail = $this->orderService->updateOrder($orderDetail,['status'=>'complete']);
           dispatch(new CompletePurchaseJob($orderDetail));
            Cart::clear();
            redirect()->route('thank-you', ['id' => $orderDetail->id]);
        } else{
            $ipnUrl = PaymentDriver::getIpnUrl($this->form->paymentMethod);
            session(['payment_data' =>  [
                'amount'        => $this->payAmount,
                'title'         => 'Session Booking',
                'description'   => 'Lernen Session Booking Confirmation',
                'ipn_url'       => !empty($ipnUrl) ? route($ipnUrl, ['payment_method' => $this->form->paymentMethod]) : url('/'),
                'order_id'      => $orderDetail->id,
                'track'         => Str::random(36),
                'cancel_url'    => route('checkout'),
                'success_url'   => route('thank-you',['id' => $orderDetail->id]),
                'email'         => $orderDetail->email,
                'name'          => $orderDetail->first_name,
                'payment_type'  => $this->form->paymentMethod,
            ]]);
            return redirect()->route('payment.process', ['gateway' => $this->form->paymentMethod]);
        }

    }

    public function removeCart($id)
    {
        (new BookingService($this->user))->removeReservedBooking($id);
        Cart::remove($id);
    }
}
