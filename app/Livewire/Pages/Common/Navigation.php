<?php

namespace App\Livewire\Pages\Common;

use App\Jobs\SendNotificationJob;
use App\Livewire\Actions\Logout;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\PayoutService;
use Livewire\Attributes\On;
use App\Services\WalletService;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Navigation extends Component
{

    public $menuItems = [];
    public $activeRoute = [];
    public $user ;
    public $amount ;
    public $role ;
    public $balance;
    public $userPayoutMethod ;

    private ?PayoutService $payoutService   = null;
    private ?WalletService $walletService   = null;



    public function boot(){
        $this->walletService   = new WalletService();
        $this->payoutService   = new PayoutService();

    }


    #[On('reload-balances')]
    public function reload()
    {

    }

    public function mount()
    {
        $roleInfo = getUserRole();
        $this->user                     = Auth::user();

        $this->activeRoute              = Route::currentRouteName();
        $this->role                     = $roleInfo['roleName'];
        $this->menuItems    = [
            [
                'route' => 'tutor.dashboard',
                'onActiveRoute' => ['tutor.dashboard'],
                'title' => __('sidebar.dashboard'),
                'icon'  => '<i class="am-icon-layer-01"></i>',
                'accessibility' => ['tutor'],
            ],
            [
                'route' => 'student.bookings',
                'onActiveRoute' => ['student.bookings','student.reschedule-session'],
                'title' => __('sidebar.bookings'),
                'icon'  => '<i class="am-icon-calender-day"></i>',
                'accessibility' => ['student'],
            ],
            [
                'route' => $this->role.'.profile.personal-details',
                'onActiveRoute' => [ 'tutor.profile.resume',$this->role.'.profile.account-settings','tutor.profile.resume.education','tutor.profile.resume.experience','tutor.profile.resume.certificate', 'student.profile.contacts', $this->role.'.profile.personal-details', $this->role.'.profile.identification'],
                'title' => __('sidebar.profile_settings'),
                'icon'  => '<i class="am-icon-user-01"></i>',
                'accessibility' => ['tutor','student'],
            ],
            // [
            //     'route' => 'student.tuition-settings',
            //     'onActiveRoute' => ['student.tuition-settings'],
            //     'title' => __('sidebar.tuition_settings'),
            //     'icon'  => '<i class="am-navigation_icon">
            //                 <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            //                     <path d="M0.833334 0.833379L1.25 0.833328V0.833328C2.48316 0.833358 3.5669 1.65084 3.90567 2.83655L4.04762 3.33338M4.04762 3.33338L5.34044 7.85826C5.81584 9.52214 6.05353 10.3541 6.5388 10.9716C6.96711 11.5166 7.52972 11.941 8.17145 12.2031C8.89851 12.5 9.76374 12.5 11.4942 12.5H12.5096C13.5593 12.5 14.0842 12.5 14.5438 12.3899C15.6412 12.1268 16.5764 11.4125 17.1189 10.423C17.3462 10.0086 17.4843 9.50218 17.7605 8.48943V8.48943C18.0969 7.25573 18.2652 6.63888 18.2326 6.13842C18.154 4.93154 17.3584 3.88988 16.2147 3.4965C15.7404 3.33338 15.1011 3.33338 13.8223 3.33338H4.04762ZM10 16.6667C10 17.5871 9.25381 18.3333 8.33333 18.3333C7.41286 18.3333 6.66667 17.5871 6.66667 16.6667C6.66667 15.7462 7.41286 15 8.33333 15C9.25381 15 10 15.7462 10 16.6667ZM16.6667 16.6667C16.6667 17.5871 15.9205 18.3333 15 18.3333C14.0795 18.3333 13.3333 17.5871 13.3333 16.6667C13.3333 15.7462 14.0795 15 15 15C15.9205 15 16.6667 15.7462 16.6667 16.6667Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            //                 </svg>
            //             </i>',
            //     'accessibility' => ['student'],
            // ],
            [
                'route' => 'tutor.bookings.subjects',
                'onActiveRoute' => ['tutor.bookings', 'tutor.bookings.subjects', 'tutor.bookings.session-detail', 'tutor.bookings.manage-sessions', 'tutor.bookings.upcoming-bookings'],
                'title' => __('sidebar.manage_bookings'),
                'icon'  => '<i class="am-icon-shopping-basket-04"></i>',
                'accessibility' => ['tutor'],
            ],
            [
                'route' => 'tutor.payouts',
                'onActiveRoute' => ['tutor.payouts'],
                'title' => __('Payouts'),
                'icon'  => '<i class="am-icon-dollar"></i>',
                'accessibility' => ['tutor'],
            ],
            [
                'route' => 'student.billing-detail',
                'onActiveRoute' => ['student.billing-detail'],
                'title' => __('sidebar.billing_detail'),
                'icon'  => '<i class="am-icon-shopping-basket-01"></i>',
                'accessibility' => ['student'],
            ],
            [
                'route' => 'student.favourites',
                'onActiveRoute' => ['student.favourites'],
                'title' => __('sidebar.favourites'),
                'icon'  => '<i class="am-icon-heart-01"></i>',
                'accessibility' => ['student'],
            ],

            [
                'route' => 'find-tutors',
                'onActiveRoute' => ['find-tutors'],
                'title' => __('sidebar.find_tutors'),
                'icon'  => '<i class="am-icon-book-1"></i>',
                'accessibility' => ['student'],
                'disableNavigate' => true,
            ],
            [
                'route' => $this->role.'.invoices',
                'onActiveRoute' => ['student.invoices','tutor.invoices'],
                'title' => __('sidebar.invoices'),
                'icon'  => '<i class="am-icon-file-02"></i>',
                'accessibility' => ['student', 'tutor'],
            ],
            [
                'route' => 'laraguppy.messenger',
                'onActiveRoute' => ['laraguppy.messenger'],
                'title' => __('sidebar.messages'),
                'icon'  => '<i class="am-icon-chat-03"></i>',
                'accessibility' => ['student', 'tutor'],
                'disableNavigate' => true,
            ],
        ];

        //Additional menues
        if (!empty(config('courses.'. $this->role. '_menu'))) {
            $this->menuItems = array_merge($this->menuItems, config('courses.'. $this->role. '_menu'));
        }

        if (isActivePackage('upcertify')) {
            if($this->role == 'tutor'){
                $this->menuItems[] = [
                    'route' => 'upcertify.certificate-list',
                    'onActiveRoute' => ['upcertify.update', 'upcertify.certificate-list'],
                    'title' => __('sidebar.certificates'),
                    'icon'  => '<i class="am-icon-certificate"> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.45455C6.38421 3.45455 3.45455 6.38421 3.45455 10C3.45455 13.6158 6.38421 16.5455 10 16.5455H15.5169L10.9953 12.0238C10.4954 12.3271 9.90884 12.5018 9.28145 12.5018C7.4547 12.5018 5.97382 11.0209 5.97382 9.19418C5.97382 7.36742 7.4547 5.88655 9.28145 5.88655C11.1082 5.88655 12.5891 7.36742 12.5891 9.19418C12.5891 9.86686 12.3883 10.4926 12.0434 11.0148L16.5455 15.5169V10C16.5455 6.38421 13.6158 3.45455 10 3.45455ZM2 10C2 5.58088 5.58088 2 10 2C14.4191 2 18 5.58088 18 10V18H10C5.58088 18 2 14.4191 2 10ZM9.28145 7.34109C8.25802 7.34109 7.42836 8.17075 7.42836 9.19418C7.42836 10.2176 8.25802 11.0473 9.28145 11.0473C10.3049 11.0473 11.1345 10.2176 11.1345 9.19418C11.1345 8.17075 10.3049 7.34109 9.28145 7.34109Z" fill="#585858"/></svg> </i>',
                    'accessibility' => ['tutor'],
                ];
            } else {
                $this->menuItems[] = [
                    'route' => 'student.certificate-list',
                    'onActiveRoute' => ['certificate-list'],
                    'title' => __('sidebar.my_certificates'),
                    'icon'  => '<i class="am-icon-certificate"> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.45455C6.38421 3.45455 3.45455 6.38421 3.45455 10C3.45455 13.6158 6.38421 16.5455 10 16.5455H15.5169L10.9953 12.0238C10.4954 12.3271 9.90884 12.5018 9.28145 12.5018C7.4547 12.5018 5.97382 11.0209 5.97382 9.19418C5.97382 7.36742 7.4547 5.88655 9.28145 5.88655C11.1082 5.88655 12.5891 7.36742 12.5891 9.19418C12.5891 9.86686 12.3883 10.4926 12.0434 11.0148L16.5455 15.5169V10C16.5455 6.38421 13.6158 3.45455 10 3.45455ZM2 10C2 5.58088 5.58088 2 10 2C14.4191 2 18 5.58088 18 10V18H10C5.58088 18 2 14.4191 2 10ZM9.28145 7.34109C8.25802 7.34109 7.42836 8.17075 7.42836 9.19418C7.42836 10.2176 8.25802 11.0473 9.28145 11.0473C10.3049 11.0473 11.1345 10.2176 11.1345 9.19418C11.1345 8.17075 10.3049 7.34109 9.28145 7.34109Z" fill="#585858"/></svg> </i>',
                    'accessibility' => ['student'],
                ];
            }
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $this->balance                  = $this->walletService->getWalletAmount($this->user->id);
        $this->userPayoutMethod         = $this->payoutService->activePayoutMethod($this->user->id);
        return view('livewire.pages.common.navigation');
    }

    public function addWithdarwals(){

        $rules = [
        'amount' => 'required|numeric|min:100|max:' . $this->balance,
        ];
        $messages = [
            'amount.min' => 'The amount must be at least $100.',
            'amount.max' => 'The amount may not be greater than $' . number_format($this->balance, 2) . '.',
        ];

        $this->validate($rules, $messages);
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            $this->dispatch('toggleModel', id:'amount', action:'hide');
            return;
        }
        $withdrawalBalance    = $this->payoutService->updateWithDrawals($this->user->id,$this->amount);
        if($withdrawalBalance){
           $this->walletService->deductFunds($this->user->id, $this->amount, 'deduct_withdrawn');
           dispatch(new SendNotificationJob('withdrawWalletAmountRequest',User::admin(), ['name' => Auth::user()->profile->full_name, 'amount' => $this->amount, ]));
           $this->dispatch('refresh-payouts');
        }
        $this->reset('amount');
        $this->dispatch('toggleModel', id:'amount', action:'hide');
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('general.success_withdrawal_message'));
    }

    public function openModel(){
        $this->reset('amount');
        $this->resetErrorBag();
        $this->dispatch('toggleModel', id:'amount', action:'show');
    }

    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/login');
    }
}
