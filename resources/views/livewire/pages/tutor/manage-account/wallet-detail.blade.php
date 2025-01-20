<div class="am-userearningwrap" >
    <div class="am-title_wrap">
        <div class="am-title">
            <h2>{{ __('tutor.my_earning') }}</h2>
            <p>{{ __('tutor.description') }}</p>
        </div>
    </div>
    <div class="am-userearning">
        <div class="am-userearning_item">
            <img src="{{ asset('demo-content/shape.png') }}" class="am-userearning_item_bg" alt="img description">
            <div class="am-userearning_head">
                <span class="am-earn-income">
                    <i class="am-icon-time-3"></i>
                </span>
            </div>
            <div class="am-userearning_footer">
                <strong><sup>{!! getCurrencySymbol() !!}</sup>{{ number_format($earnedAmount,2)  }}</strong>
                <span>{{ __('tutor.earned_income') }}</span>
            </div>
        </div>
        <div class="am-userearning_item">
            <img src="{{ asset('demo-content/shape.png') }}" class="am-userearning_item_bg" alt="img description">
            <div class="am-userearning_head">
                <span class="am-fund-withdraw">
                    <i class="am-icon-invoices-01"></i>
                </span>
            </div>
            <div class="am-userearning_footer">
                <strong><sup>{!! getCurrencySymbol() !!}</sup>{{  number_format($withdrawalBalance['completed_withdrawals'],2)  }}</strong>
                <span>{{ __('tutor.funds_withdraw') }}</span>
            </div>
        </div>
        <div class="am-userearning_item">
            <img src="{{ asset('demo-content/shape.png') }}" class="am-userearning_item_bg" alt="img description">
            <div class="am-userearning_head">
                <span class="am-pending-amount">
                    <i class="am-icon-time-1"></i>
                </span>
            </div>
            <div class="am-userearning_footer">
                <strong><sup>{!! getCurrencySymbol() !!}</sup>{{number_format($pendingFunds,2)}}</strong>
                <span>{{ __('tutor.pending_amount') }}</span>
            </div>
        </div>
        <div class="am-userearning_item">
            <img src="{{ asset('demo-content/shape.png') }}" class="am-userearning_item_bg" alt="img description">
            <div class="am-userearning_head">
                <span class="am-wallet-funds">
                    <i class="am-icon-time-2"></i>
                </span>
            </div>
            <div class="am-userearning_footer">
                <strong><sup>{!! getCurrencySymbol() !!}</sup>{{ number_format($walletBalance,2)}}</strong>
                <span>{{ __('tutor.wallet_funds') }}</span>
            </div>
        </div>
        <div class="am-userearning_item">
            <img src="{{ asset('demo-content/shape.png') }}" class="am-userearning_item_bg" alt="img description">
            <div class="am-userearning_head">
                <span class="am-pending-withdraws">
                    <i class="am-icon-atm-card-01"></i>
                </span>
            </div>
            <div class="am-userearning_footer">
                <strong><sup>{!! getCurrencySymbol() !!}</sup>{{number_format($withdrawalBalance['pending_withdrawals'],2)}}</strong>
                <span>{{ __('tutor.pending_withdraw_amount') }}</span>
            </div>
        </div>
    </div>
</div>
