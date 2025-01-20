<main class="am-main">
    <div class="am-checkout_section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-checkout_title">
                        @slot('title')
                            {{ __('checkout.checkout') }}
                        @endslot
                        <strong class="am-checkout_logo">
                            <x-application-logo />
                        </strong>
                        <h2>{{ __('checkout.you_almost_there') }}</h2>
                        <p>{{ __('checkout.fill_details_mentioned_below_purchase_courses') }}</p>
                        <ul class="am-checkout_steptab">
                            <li class="am-checkout_steptab_checked">
                                <span><i class="am-icon-user-05"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em> </span>
                                {{ __('checkout.select_best_tutor') }}
                            </li>
                            <li class="am-checkout_steptab_active">
                                <span><i class="am-icon-lock-close"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em></span>
                                {{ __('checkout.add_checkout_details') }}
                            </li>
                            <li>
                                <span><i class="am-icon-flag-02"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em></span>
                                {{ __('checkout.you_done') }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-xl-10 offset-xl-1" x-data="{
                    form:@entangle('form'),
                    charLeft:500,
                    init(){
                        this.updateCharLeft();
                    },
                    tutorInfo:{},
                    updateCharLeft() {
                        let maxLength = 500;
                        if (this.form.dec.length > maxLength) {
                            this.form.dec = this.form.dec.substring(0, maxLength);
                        }
                        this.charLeft = maxLength - this.form.dec.length;
                    }
                }">
                    <div class="am-checkout_box">
                        <div class="am-checkout_methods">
                            <div class="am-checkout_methods_title">
                                <h3>{{ __('checkout.payment_methods') }} </h3>
                                <p>{{ __('checkout.secure_and_convenient_payment_purchase') }}</p>
                            </div>
                            @if($available_payment_methods)
                                <div class="am-checkout_accordion">
                                    @foreach ($available_payment_methods as $method => $available_method)
                                    @if ($available_method['status'] == 'on')
                                        <div class="accordion-item">
                                            <div class="am-radiowrap">
                                                <div class="am-radio">
                                                    <input wire:model="form.paymentMethod"  {{ $form->paymentMethod == $method ? 'checked' : '' }}  type="radio" id="payment-{{$method}}" name="payment" value={{$method}} >
                                                    <label for="payment-{{$method}}">
                                                        {{__("settings." .$method. "_title")}}
                                                        <figure class="am-radiowrap_img">
                                                            <img src="{{asset('images/payment_methods/'.$method. '.png')}}" alt="{{__("settings." .$method. "_title")}}">
                                                        </figure>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @endforeach
                                </div>
                            @endif
                            <div class="am-checkout_perinfo">
                                <span> <i class="am-icon-lock-close"></i> </span>
                                <p>{{ __('checkout.personal_data') }}</p>
                            </div>
                            <x-input-error field_name="form.paymentMethod" />
                            <form class="am-themeform am-checkout_form">
                                <fieldset>
                                    <div class="form-group">
                                        <legend>{{ __('checkout.billing_details') }}</legend>
                                    </div>
                                    <div @class(['form-group form-group-half', 'am-invalid' => $errors->has('form.firstName')])>
                                        <input wire:model="form.firstName" type="text" class="form-control"  placeholder="Add first name">
                                        <x-input-error field_name="form.firstName" />

                                    </div>
                                    <div  @class(['form-group form-group-half', 'am-invalid' => $errors->has('form.lastName')])>
                                        <input wire:model="form.lastName" type="text" class="form-control"  placeholder="Add last name">
                                        <x-input-error field_name="form.lastName" />
                                    </div>
                                    <div @class(['form-group', 'am-invalid' => $errors->has('form.company')]) class="">
                                        <input wire:model="form.company" type="text" class="form-control"  placeholder="Add company title">
                                    </div>
                                    <div  @class(['form-group form-group-half', 'am-invalid' => $errors->has('form.email')]) class="">
                                        <input wire:model="form.email" type="text" class="form-control"  placeholder="Add email">
                                        <x-input-error field_name="form.email" />
                                    </div>
                                    <div  @class(['form-group form-group-half', 'am-invalid' => $errors->has('form.phone')])>
                                        <input wire:model="form.phone" type="text" class="form-control"  placeholder="Add phone number">
                                        <x-input-error field_name="form.phone" />
                                    </div>
                                    <div class="form-group">
                                        <x-input-label for="country" :value="__('profile.country')" />
                                        <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.country')])>
                                             <span class="am-select" wire:ignore>
                                                <select class="am-select2" data-componentid="@this" data-live="true" data-searchable="true" id="country" data-wiremodel="form.country">
                                                    <option value="">{{ __('profile.select_a_country') }}</option>
                                                    @foreach ($countries as $item)
                                                        <option value="{{ $item->id }}" {{ $item->id == $form->country ? 'selected' : '' }} >{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                        </div>
                                        <x-input-error field_name="form.country" />
                                    </div>
                                    <div  @class(['form-group form-group-3half', 'am-invalid' => $errors->has('form.city')])>
                                        <input wire:model="form.city" type="text" class="form-control"  placeholder="Add town/city">
                                        <x-input-error field_name="form.city" />
                                    </div>
                                    <div @class(['form-group form-group-3half', 'am-invalid' => $errors->has('form.state')])>
                                        <input wire:model="form.state" type="text" class="form-control"  placeholder="Add state/country">
                                        <x-input-error field_name="form.state" />
                                    </div>
                                    <div @class(['form-group form-group-3half', 'am-invalid' => $errors->has('form.zipcode')])>
                                        <input wire:model="form.zipcode" type="text" class="form-control"  placeholder="Add postcode/zip">
                                        <x-input-error field_name="form.zipcode" />
                                    </div>
                                </fieldset>
                            </form>
                            <form class="am-themeform am-checkout_form">
                                <fieldset>
                                    <div class="form-group">
                                        <legend>{{ __('checkout.additional_information') }}</legend>
                                    </div>
                                    <div class="form-group">
                                        <textarea wire:model='form.dec' class="form-control" placeholder="{{ __('checkout.note_about_your_order') }}" x-on:input="updateCharLeft" ></textarea>
                                        <span class="am-charleft" x-text="charLeft + ' {{ __('general.char_account') }}'"></span>
                                        <x-input-error field_name="form.dec" />
                                    </div>
                                    @if ($walletBalance)
                                    <div class="form-group">
                                        <div class="am-checkbox ">
                                            <input wire:model.live="useWalletBalance" id="remember_me" type="checkbox" name="remember">
                                            <label for="remember_me">
                                                <strong><span>{{ __('general.wallet_balance') }}</span><sup>{{ getCurrencySymbol() }}</sup>{{  $walletBalance }}</strong>
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group form-groupbtns">
                                        <x-primary-button wire:click="updateInfo" wire:target="updateInfo" type=button wire:loading.class="am-btn_disable" >Pay {{ $payAmount > 0 ? getCurrencySymbol() . number_format($payAmount, 2) : '' }}<i class="am-icon-arrow-right"></i></x-primary-button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        @if ($content->count() > 0)
                            <div class="am-ordersummary">
                                <div class="am-ordersummary_title">
                                    <h3>{{ __('checkout.order_summary') }}</h3>
                                </div>
                                <ul class="am-ordersummary_list">
                                    @foreach ($content as $item)
                                    <li>
                                        @if (!empty($item['options']['image']) && Storage::disk('public')->exists($item['options']['image']))
                                        <figure class="am-ordersummary_list_img">
                                            <img src="{{ resizedImage($item['options']['image'],34,34) }}" alt="{{$item['options']['image']}}" />
                                        </figure>
                                        @else
                                        <figure class="am-ordersummary_list_img">
                                            <img src="{{ resizedImage('placeholder.png',34,34) }}" alt="{{ $item['options']['image']}}" />
                                        </figure>
                                        @endif
                                        <div class="am-ordersummary_list_title">
                                            <div class="am-ordersummary_list_info">
                                                <span>{{$item['options']['session_time']}}</span>
                                                <h3><a href="javascript:void(0);">{{ $item['name'] }}</a></h3>
                                                <span>{{$item['options']['subject_group']}}</span>
                                            </div>
                                            <div class="am-ordersummary_list_action">
                                                <strong><sup>{{ getCurrencySymbol() }}</sup>{{ $item['price'] }}<span>/{{ __('checkout.session') }}</span></strong>
                                                <a wire:click="removeCart({{ $item['id'] }})" href="#">{{ __('checkout.remove') }}</a>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                <ul class="am-ordersummary_price">
                                    <li>
                                        <span>{{ __('checkout.subtotal') }}</span>
                                        <strong><sup>{{ getCurrencySymbol() }}</sup>{{ number_format($subTotal, 2) }}</strong>
                                    </li>
                                    <li class="am-ordersummary_price_total">
                                        <span>{{ __('checkout.grand_total') }}</span>
                                        <strong><sup>{{ getCurrencySymbol() }}</sup>{{ number_format($totalAmount, 2) }}</strong>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@if(session()->get('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.dispatch('showAlertMessage', {
            type: 'error',
            message: "{{ session()->get('error') }}"
        });
    });
</script>
@endif

