<div class="am-dbbox am-invoicelist_wrap" wire:init="loadData">
    @if($isLoading)
        @include('skeletons.invoices')
    @else
        <div class="am-dbbox_content am-invoicelist">
            <div class="am-dbbox_title">
                @slot('title')
                    {{ __('invoices.invoices') }}
                @endslot
                <h2>{{ __('invoices.invoices') }}</h2>
                <div class="am-dbbox_title_sorting">
                    <em>{{ __('invoices.filter_by') }}</em>
                    <span class="am-select" wire:ignore>
                        <select data-componentid="@this" data-live="true" class="am-select2" id="status"
                            data-wiremodel="status">
                            <option value="" {{ $status == '' ? 'selected' : '' }}>{{ __('invoices.all_invoices') }}</option>
                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>{{ __('invoices.pending') }}</option>
                            <option value="complete" {{ $status == 'complete' ? 'selected' : '' }}>{{ __('invoices.complete') }}</option>
                        </select>
                    </span>
                </div>
            </div>
            <div class="am-invoicetable">
                <table class="am-table @if(setting('_general.table_responsive') == 'yes') am-table-responsive @endif">
                    <thead>
                        <tr>
                            <th>{{ __('booking.id') }}</th>
                            <th>{{ __('booking.date') }}</th>
                            <th>{{ __('booking.transaction_id') }}</th>
                            <th>{{ __('booking.subject') }}</th>
                            @role('tutor')
                                <th>{{ __('booking.student_name') }}</th>
                                <th>{{ __('booking.amount') }}</th>
                                <th>{{ __('booking.tutor_payout') }}</th>
                            @elserole('student')
                                <th>{{ __('booking.tutor_name') }}</th>
                                <th>{{ __('booking.amount') }}</th>
                            @endrole
                            <th>{{ __('booking.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$orders->isEmpty())
                        @foreach($orders as $order)
                                        @php
                                        $options        = $order?->options;
                                        $subject        = $options['subject'];
                                        $image          = $options['image'];
                                        $subjectGroup   = $options['subject_group'];
                                        $adminCommission=  setting('admin_settings.commission_setting');
                                        $tutor_payout   = $order?->price - (($adminCommission['percentage']['value'] / 100) * $order?->price);
                                        @endphp
                                        <tr>
                                            <td data-label="{{ __('booking.id') }}"><span>{{ $order?->order_id }}</span></td>
                                            <td data-label="{{ __('booking.date') }}"><span>{{ $order?->created_at->format('F j, Y') }}</span></td>
                                            <td data-label="{{ __('booking.transaction_id') }}"><span>{{$order?->orders?->transaction_id }}</span></td>
                                            <td data-label="{{ __('booking.subject' )}}">
                                                <div class="tb-varification_userinfo">
                                                    <strong class="tb-adminhead__img">
                                                        @if (!empty($image) && Storage::disk('public')->exists($image))
                                                        <img src="{{ resizedImage($image,34,34) }}" alt="{{$image}}" />
                                                        @else
                                                            <img src="{{ resizedImage('placeholder.png',34,34) }}" alt="{{ $image }}" />
                                                        @endif
                                                    </strong>
                                                    <span>{{ $subject  }}<small>{{ $subjectGroup }}</small></span>
                                                </div>
                                            </td>
                                            @role('student')
                                                <td data-label="{{ __('booking.tutor_name' )}}">
                                                    <div class="tb-varification_userinfo">
                                                        <strong class="tb-adminhead__img">
                                                            @if (!empty($order?->orderable?->tutor?->image) && Storage::disk('public')->exists($order?->orderable?->tutor?->image))
                                                            <img src="{{ resizedImage($order?->orderable?->tutor?->image,34,34) }}" alt="{{$order?->orderable?->tutor?->image}}" />
                                                            @else
                                                                <img src="{{ resizedImage('placeholder.png',34,34) }}" alt="{{ $order?->orderable?->tutor?->image }}" />
                                                            @endif
                                                        </strong>
                                                        <span>{{ $order?->orderable?->tutor?->first_name }}</span>
                                                    </div>
                                                </td>
                                                <td data-label="{{ __('booking.amount') }}">
                                                    <span>{!! getCurrencySymbol() !!}{{ number_format($order?->price, 2) }}</span>
                                                </td>
                                            @elserole('tutor')
                                                <td data-label="{{ __('booking.student_name' )}}">
                                                    <div class="tb-varification_userinfo">
                                                        <strong class="tb-adminhead__img">
                                                            @if (!empty($order?->orderable?->student?->image) && Storage::disk('public')->exists($order?->orderable?->student?->image))
                                                            <img src="{{ resizedImage($order?->orderable?->student?->image,34,34) }}" alt="{{$order?->orderable?->student?->image}}" />
                                                            @else
                                                                <img src="{{ resizedImage('placeholder.png',34,34) }}" alt="{{ $order?->orderable?->student?->image }}" />
                                                            @endif
                                                        </strong>
                                                        <span>{{ $order?->orderable?->student?->first_name }}</span>
                                                    </div>
                                                </td>
                                                <td data-label="{{ __('booking.amount') }}">
                                                    <span>{!! getCurrencySymbol() !!}{{ number_format($order?->price, 2) }}</span>
                                                </td>
                                                <td data-label="{{ __('booking.tutor_payout') }}">
                                                    <span>{!! getCurrencySymbol() !!}{{ number_format($tutor_payout, 2) }}</span>
                                                </td>
                                            @endrole
                                            <td data-label="{{ __('booking.status' )}}">
                                                <em class="tk-project-tag-two {{ $order?->orders?->status == 'complete' ? 'tk-hourly-tag' : 'tk-fixed-tag' }}">{{ $order?->orders?->status}}</em>
                                            </td>

                                        </tr>
                                    @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @if ($orders->isEmpty())
            <x-no-record :image="asset('images/payouts.png')" :title="__('general.no_record_title')"
            :description="__('general.no_records_available')"  />
            @else
            {{ $orders->links('pagination.pagination') }}
            @endif
        </div>
    @endif
</div>
@push('scripts' )
<script type="text/javascript" data-navigate-once>
    var component = '';
    document.addEventListener('livewire:navigated', function() {
            component = @this;
    },{ once: true });
    document.addEventListener('loadPageJs', (event) => {
        component.dispatch('initSelect2', {target:'.am-select2'});
    })
</script>
@endpush
