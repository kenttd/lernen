@php
    if(!empty(auth()?->user()?->profile->image) && Storage::disk('public')->exists(auth()?->user()?->profile?->image)) {
        $userImage = resizedImage(auth()?->user()?->profile?->image, 36, 36);
    } else {
        $userImage = resizedImage('placeholder.png', 36, 36);
    }
@endphp
<div class="am-header_user">
    @role('student')
        <div
            class="am-orderwrap"
            x-data="{
                showCart: false,
                cartData: @js(App\Facades\Cart::content()),
                total: @js(App\Facades\Cart::total()),
                subTotal: @js(App\Facades\Cart::subtotal()),
                removeItem(index, id){
                    this.cartData.splice(index, 1);
                    Livewire.dispatch('remove-cart', { params: {index, id}})
                }
            }"
            x-on:cart-updated.window="
                cartData = $event.detail.cart_data;
                total = $event.detail.total;
                subTotal = $event.detail.subTotal;
                let menue = jQuery('.am-ordersummary').addClass('am-bookcartopen');
                if($event.detail.toggle_cart == 'open'){
                    menue.slideDown();
                } else {
                    menue.slideUp();
                }
            ">
            <a href="#" class="am-header_user_noti cart-bag" >
                <template x-if="cartData.length > 0">
                    <em x-text="cartData.length"></em>
                </template>
                <i class="am-icon-shopping-basket-04"></i>
            </a>
            <div class="am-ordersummary" :class="{
                'am-emptyorder': cartData.length == 0,
                }">
                <template x-if="cartData.length > 0">
                    <div class="am-ordersummary_title">
                        <h3>{{ __('tutor.order_summary') }}</h3>
                        <a href="javascript:void(0);" class="am-ordersummary_close" @click="jQuery('.am-ordersummary').removeClass('am-bookcartopen');">
                            <i class="am-icon-multiply-02"></i>
                        </a>
                    </div>
                </template>
                <template x-if="cartData.length > 0">
                    <div class="am-ordersummary_content">
                        <ul class="am-ordersummary_list">
                            <template x-for="(item, index) in cartData">
                                <li>
                                    <div class="am-ordersummary_list_title">
                                        <div class="am-ordersummary_list_info">
                                            <span x-text="item.options.session_time"></span>
                                            <h3><a href="#" x-text="item.options.subject"></a></h3>
                                            <span x-text="item.options.subject_group"></span>
                                        </div>
                                        <div class="am-ordersummary_list_action">
                                            <strong>
                                                <sup x-text="item.options.currency_symbol"></sup>
                                                <span x-text="item.options.price" class="am-cardprice"></span>
                                                <span>{{ __('tutor.per_session') }}</span>
                                            </strong>
                                            <a href="#" @click.prevent="removeItem(index, item.id)">
                                                {{ __('general.remove') }}
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </template>
                        </ul>
                        <ul class="am-ordersummary_price">
                            <li>
                                <span>{{ __('general.subtotal') }}</span>
                                <strong><span x-text="subTotal"></span></strong>
                            </li>
                            <li class="am-ordersummary_price_total">
                                <span>{{ __('general.grand_total') }}</span>
                                <strong><span x-text="total"></span></strong>
                            </li>
                        </ul>
                        <div class="am-checkoutorder">
                            <a href="{{ route('checkout') }}" wire:navigate.remove class="am-btn" >{{ __('general.proceed_order') }}</a>
                            <div class="am-checkout_perinfo">
                                <span> <i class="am-icon-lock-close"></i> </span>
                                <p>{{ __('general.proceed_order_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </template>
                <template x-if="cartData.length == 0">
                    <div class="am-emptyview_cart">
                        <a href="javascript:void(0);" class="am-ordersummary_close" @click="jQuery('.am-ordersummary').removeClass('am-bookcartopen');">
                            <i class="am-icon-multiply-01"></i>
                        </a>
                        <h5>{{ __('general.cart_empty') }}</h5>
                        <span>{{ __('general.cart_empty_desc') }}</span>
                    </div>
                </template>
            </div>
        </div>
    @endrole
    @hasanyrole('tutor|student')
    <a href="{{ route('laraguppy.messenger') }}" class="am-header_user_chat">
        <i class="am-icon-chat-03"></i>
        @php
            $message = getUnreadMsgsCount();
        @endphp
        @if($message > 0)
            <span>{{ $message }}</span>
        @endif
    </a>
    @endhasanyrole
    <div class="am-header_user_menu">
        <a href="javascript:void(0);">
            <figure class="am-shimmer userImg">
                <img x-cloak src="{{ $userImage }}" alt="{{ auth()?->user()?->profile?->full_name }}">
            </figure>
        </a>
        <ul>
            <li>
                <div class="am-user_info">
                    <figure>
                        @if(auth()->user()->hasRole('tutor'))
                            <a href={{ route('tutor.dashboard') }}><img src="{{ $userImage }}" alt="{{ auth()?->user()?->profile?->full_name }}"></a>
                        @elseif(auth()->user()->hasRole('student'))
                            <a href="{{ route('student.bookings') }}"><img src="{{ $userImage }}" alt="{{ auth()?->user()?->profile?->full_name }}"></a>
                        @else
                            <a href="{{ auth()->user()->redirect_after_login }}"><img src="{{ $userImage }}" alt="{{ auth()?->user()?->profile?->full_name }}"></a>
                        @endif
                    </figure>
                    <div class="am-user_name">
                        <h6>
                            <a href={{ url(auth()->user()->redirect_after_login) }}>{{ auth()?->user()?->profile?->full_name }}</a>
                            @if(auth()->user()->hasRole('tutor'))
                                <a href="{{ route('tutor-detail',['slug' => auth()?->user()?->profile?->slug]) }}" class="am-custom-tooltip">
                                    <span class="am-tooltip-text">
                                        <span>{{ __('general.visit_profile') }}</span>
                                    </span>
                                    <i class="am-icon-external-link-02"></i>
                                </a>
                            @endif
                        </h6>
                        <span>{{ auth()?->user()?->email }}</span>
                    </div>
                </div>
            </li>
            @role('student')
                <li>
                    <a href="{{ route('student.profile.personal-details') }}">
                        <i class="am-icon-user-01"></i>
                        {{ __('sidebar.profile_settings') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.bookings') }}">
                        <i class="am-icon-calender-day"></i>
                        {{ __('sidebar.bookings') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.billing-detail') }}">
                        <i class="am-icon-shopping-basket-01"></i>
                        {{ __('sidebar.billing_detail') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.favourites') }}">
                        <i class="am-icon-heart-01"></i>
                        {{ __('sidebar.favourites') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('find-tutors') }}" >
                        <i class="am-icon-book-1"></i>
                        {{__('sidebar.find_tutors') }}
                    </a>
                </li>
            @elserole('tutor')
                <li>
                    <a href="{{ route('tutor.profile.personal-details') }}"><i class="am-icon-user-01"></i>{{ __('sidebar.profile_settings') }}</a>
                </li>
                <li>
                    <a href="{{ route('tutor.bookings.subjects') }}">
                        <i class="am-icon-calender-day"></i>
                        {{ __('sidebar.bookings') }}
                    </a>
                </li>
            @endrole
            @hasanyrole('tutor|student')
            <li>
                <a href="{{ route('laraguppy.messenger') }}">
                    <i class="am-icon-chat-03"></i>
                    {{ __('sidebar.messages') }}</a>
            </li>
            @endhasanyrole
            @role('admin')
                <li>
                    <a href="{{ auth()->user()->redirect_after_login }}">
                        <i class="am-icon-layer-01"></i>
                        {{ __('sidebar.insights') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.profile') }}"><i class="am-icon-user-01"></i>{{ __('sidebar.profile_settings') }}</a>
                </li>
            @endrole
            <li class="am-header_user_signout">
                <a href="{{ route('logout') }}">
                    <i class="am-icon-sign-out-02"></i>
                    {{ __('general.sign_out') }}</a>
            </li>
        </ul>
    </div>
</div>
