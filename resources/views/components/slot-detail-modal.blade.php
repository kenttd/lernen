@props(['currentSlot', 'cartItems' => [], 'id'=> 'slot-detail', 'user' => null, 'timezone' => null])

<div class="modal fade am-session-detail-modal_two" id="{{ $id }}" aria-hidden="true">
    @php
        $cartItemIds = array_column(array_column($cartItems?->toArray() ?? [], 'options'), 'slot_id');
    @endphp
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="am-session-detail">
            <div class="am-session-detail_sidebar">
                <div class="am-session-detail_content">
                    <span>
                        <i class="am-icon-book-1"></i>
                        <span>{{ $currentSlot?->subjectGroupSubjects?->userSubjectGroup?->group?->name }}</span>
                    </span>
                    <i class="am-closepopup" data-bs-dismiss="modal">
                        <i class="am-icon-multiply-01"></i>
                    </i>
                    <h4>{{ $currentSlot?->subjectGroupSubjects?->subject->name }}</h4>
                </div>
                <ul class="am-session-duration">
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-blue">
                                <i class="am-icon-calender-minus"></i>
                            </em>
                            <span>{{ __('general.date') }}</span>
                        </div>
                        <strong>{{ parseToUserTz($currentSlot?->start_time)->format(setting('_general.date_format') ?? 'F j, Y') }}</strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-purple">
                                <i class="am-icon-time"></i>
                            </em>
                            <span>{{ __('calendar.time') }}</span>
                        </div>
                        <strong>
                            {{ parseToUserTz($currentSlot?->start_time, $timezone)->format('h:i a') }} -
                            {{ parseToUserTz($currentSlot?->end_time, $timezone)->format('h:i a') }}
                        </strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-red">
                                <i class="am-icon-layer-01"></i>
                            </em>
                            <span>{{ __('calendar.type') }}</span>
                        </div>
                        <strong>
                            {{ $currentSlot?->spaces > 1 ? __('calendar.group') : __('calendar.one') }}
                        </strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-orange">
                                <i class="am-icon-user-group"></i>
                            </em>
                            <span>{{ __('calendar.total_enrollment') }}</span>
                        </div>
                        <strong>{{ __('calendar.booked_students', ['count' => $currentSlot?->bookings_count ?? 0]) }}</strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-green">
                                <i class="am-icon-dollar"></i>
                            </em>
                            <span>{{ __('calendar.session_fee') }}</span>
                        </div>
                        <strong> {{ formatAmount($currentSlot?->session_fee) }}<em>{{ __('calendar.person') }}</em></strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <figure>
                                @if(!empty($user?->profile->image) && Storage::disk('public')->exists($user?->profile?->image))
                                    <img src="{{ resizedImage($user?->profile?->image, 24, 24) }}" alt="{{ $user?->profile?->full_name }}">
                                @else
                                    <img src="{{ resizedImage('placeholder.png', 24, 24) }}" alt="{{ $user?->profile?->full_name }}">
                                @endif
                            </figure>
                            <span><em>{{ __('calendar.session_tutor') }}</em></span>
                        </div>
                        <strong>
                            {{ $user->profile?->full_name }}
                        </strong>
                    </li>
                </ul>
                @role('student')
                <div class="am-session-start">
                    @if( !in_array($currentSlot?->id, $cartItemIds))
                        <div class="am-sessionstart-btn">
                            <button class="am-btn" wire:click.prevent="bookSession({{ $currentSlot?->id }})">
                                {{ __('calendar.book_session') }}
                            </button>
                        </div>
                    @endif
                </div>
                @endrole
            </div>
            <div class="am-session-detail-modal_body">
                @if(!empty($currentSlot?->subjectGroupSubjects?->image) && Storage::disk('public')->exists($currentSlot?->subjectGroupSubjects?->image))
                <figure>
                    <img src="{{ resizedImage($currentSlot?->subjectGroupSubjects?->image, 700, 360) }}" alt="{{ $currentSlot?->subjectGroupSubjects?->subject?->name }}">
                </figure>
                @endif
                <div class="am-session-content">
                    {!! $currentSlot?->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
