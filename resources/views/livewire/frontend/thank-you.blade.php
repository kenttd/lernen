<div class="am-checkout_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-checkout_title">
                    @slot('title')
                        {{ __('thank_you.thank_you_page') }}
                    @endslot
                   <strong class="am-checkout_logo">
                       <x-application-logo />
                   </strong>
                   <h2>{{ __('thank_you.thank_you') }}</h2>
                   <p>{{ __('thank_you.you_successfully_submitted') }}</p>
                   <ul class="am-checkout_steptab">
                        <li class="am-checkout_steptab_checked">
                            <span><i class="am-icon-user-05"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em> </span>
                            {{ __('thank_you.select_best_tutor') }}
                        </li>
                        <li class="am-checkout_steptab_checked">
                            <span><i class="am-icon-user-05"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em> </span>
                            {{ __('thank_you.add_checkout_details') }}
                        </li>
                        <li class="am-checkout_steptab_checked">
                            <span><i class="am-icon-user-05"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em> </span>
                            {{ __('thank_you.You_done') }}
                        </li>
                   </ul>
               </div>
            </div>
            <div class="col-12 col-xl-10 offset-xl-1">
                <div class="am-checkout_box">
                    <div class="am-checkout_methods">
                        <div class="am-reschudle-header am-order-confirmed">
                            <span>
                                <i class="am-icon-check-circle06"></i>
                            </span>
                            <h1>{{ __('thank_you.thank_You_for_your_order') }}
                                <strong>{{ __('thank_you.order_reference',['id' => $orderId]) }}</strong>
                            </h1>
                        </div>
                        <div class="am-checkout_perinfo">
                            <p>{{ __('thank_you.thanks_detail') }}</p>
                        </div>
                        <div class="am-checkout-details">
                            <a href="{{ route('student.bookings') }}" class="am-btn">{{ __('thank_you.continue_profile') }}</a>
                        </div>
                    </div>
                    <div class="am-ordersummary">
                        <div class="am-ordersummary_title">
                            <h3>{{ __('thank_you.order_summary') }}</h3>
                        </div>
                        <ul class="am-ordersummary_list">
                            @foreach ($orderItem as $item)
                            <li>
                                @if (!empty($item->options['image']) && Storage::disk('public')->exists($item->options['image']))
                                <figure class="am-ordersummary_list_img">
                                    <img src="{{ resizedImage($item->options['image'],34,34) }}" alt="{{$item->options['image']}}" />
                                </figure>
                                @else
                                <figure class="am-ordersummary_list_img">
                                    <img src="{{ resizedImage('placeholder.png',34,34) }}" alt="{{ $item->options['image']}}" />
                                </figure>
                                @endif
                                <div class="am-ordersummary_list_title">
                                    <div class="am-ordersummary_list_info">
                                        <h3><a href="#">{{ $item->title }}</a></h3>
                                        <span>{{$item->options['subject_group']}}</span>
                                    </div>
                                    <div class="am-ordersummary_list_action">
                                        <strong><sup>{!! getCurrencySymbol() !!}</sup>{{ number_format($item->price, 2) }}<span>/{{ __('checkout.session') }}</span></strong>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <ul class="am-ordersummary_price">
                            <li>
                                <span>{{ __('thank_you.subtotal') }}</span>
                                <strong><sup>{!! getCurrencySymbol() !!}</sup>{{ number_format($orderItem[0]->total,2)}}</strong>
                            </li>
                            <li class="am-ordersummary_price_total">
                                <span>{{ __('thank_you.grand_total') }}</span>
                                <strong><sup>{!! getCurrencySymbol() !!}</sup>{{ number_format($orderItem[0]->total,2) }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
