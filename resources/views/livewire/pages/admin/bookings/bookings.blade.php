<main class="tb-main">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('general.all_booking') .' ('. $orders->total() .')'}}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control" data-searchable="false" data-live='true' id="status" data-wiremodel="status" >
                                            <option value="" {{ $status == '' ? 'selected' : '' }} >{{ __('booking.all_bookings')  }}</option>
                                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }} >{{ __('booking.pending')  }}</option>
                                            <option value="complete" {{ $status == 'complete' ? 'selected' : '' }} >{{ __('booking.complete')  }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2" data-live='true' data-searchable="true" id="subject" data-wiremodel="selectedSubject">
                                            <option value="">{{ __('booking.select_subject')  }}</option>
                                            @foreach ($subjects as $subject)
                                            <option value="{{ $subject->name }}" {{ $subject->name == $selectedSubject ? 'selected' : '' }}>{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2" data-live='true' data-searchable="true" id="subject_group" data-wiremodel="selectedSubGroup">
                                            <option value="">{{ __('booking.select_subject_group')  }}</option>
                                            @foreach ($subjectGroups as $subjectGroup)
                                                <option value="{{ $subjectGroup->name }}" {{ $subjectGroup->name == $selectedSubGroup ? 'selected' : '' }}>{{ $subjectGroup->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control" data-searchable="false" data-live='true' id="sort_by" data-wiremodel="sortby" >
                                            <option value="asc" {{ $sortby == 'asc' ? 'selected' : '' }} >{{ __('general.asc')  }}</option>
                                            <option value="desc" {{ $sortby == 'desc' ? 'selected' : '' }} >{{ __('general.desc')  }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search"  autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                @if( !$orders->isEmpty() )
                    <table class="table tb-table tb-dbholder @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                        <thead>
                            <tr>
                                <th>{{ __('booking.id') }}</th>
                                <th>{{ __('booking.transaction_id') }}</th>
                                <th>{{ __('booking.subject') }}</th>
                                <th>{{ __('booking.student_name') }}</th>
                                <th>{{ __('booking.tutor_name') }}</th>
                                <th>{{ __('booking.amount') }}</th>
                                <th>{{ __('booking.tutor_payout') }}</th>
                                <th>{{ __('booking.status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                @php
                                   $options = $order?->options ?? [];
                                   $subject = $options['subject'] ?? '';
                                   $image   = $options['image'] ?? '';
                                   $subjectGroup = $options['subject_group'];
                                   $adminCommission =  setting('admin_settings.commission_setting');
                                   $tutor_payout = $order?->price - (($adminCommission['percentage']['value'] / 100) * $order?->price);
                                @endphp
                                <tr>
                                    <td data-label="{{ __('booking.id') }}"><span>{{ $order?->order_id }}</span></td>
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
                                            <span>{{ $subject }}<br><small>{{ $subjectGroup }}</small></span>
                                        </div>
                                    </td>
                                    <td data-label="{{ __('booking.student_name' )}}">
                                        <div class="tb-varification_userinfo">
                                            <strong class="tb-adminhead__img">
                                                @if (!empty($order?->orderable?->student?->image) && Storage::disk('public')->exists($order?->orderable?->student?->image))
                                                <img src="{{ resizedImage($order?->orderable?->student?->image,34,34) }}" alt="{{$order?->orderable?->student?->image}}" />
                                                @else
                                                    <img src="{{ resizedImage('placeholder.png',34,34) }}" alt="{{ $order?->orderable?->student?->image }}" />
                                                @endif
                                            </strong>
                                            <span>{{ $order?->orderable?->student?->first_name . ' ' . $order->orderable?->student?->last_name  }}</span>
                                        </div>
                                    </td>
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
                                    <td data-label="{{ __('booking.tutor_payout') }}">

                                        <span>{!! getCurrencySymbol() !!}{{ number_format( $tutor_payout, 2) }}</span>
                                    </td>
                                    <td data-label="{{ __('booking.status' )}}">
                                        <em class="tk-project-tag {{ $order?->orders?->status == 'complete' ? 'tk-hourly-tag' : 'tk-fixed-tag' }}">{{ $order?->orders?->status}}</em>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        {{ $orders->links('pagination.custom') }}
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
