@extends('layouts.frontend-app')
@section('content')
<div class="am-search-detail-banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ol class="am-breadcrumb">
                    <li><a href="{{ url('/') }}">{{ __('sidebar.home') }}</a></li>
                    <li><em>/</em></li>
                    <li><a href="{{ route('find-tutors') }}">{{  __('sidebar.find_tutor') }}</a></li>
                    <li><em>/</em></li>
                    <li class="active"><span>{{ $tutor?->profile?->full_name }}</span></li>
                </ol>
                <div class="am-searchdetail">
                    <div class="am-search-userdetail">
                        <div class="am-tutordetail_head">
                            <div class="am-tutordetail_user">
                                <figure class="am-tutorvone_img">
                                    @if (!empty($tutor->profile?->image) &&
                                    Storage::disk('public')->exists($tutor?->profile?->image))
                                    <img src="{{ resizedImage($tutor->profile?->image,80,80) }}"
                                        alt="{{$tutor?->profile?->full_name}}" />
                                    @else
                                    <img src="{{ resizedImage('placeholder.png',80,80) }}"
                                        alt="{{ $tutor->profile?->full_name }}" />
                                    @endif
                                    <span @class(['am-userstaus','am-userstaus_online'=> $tutor?->is_online])></span>
                                </figure>
                                <div class="am-tutordetail_user_name">
                                    <h3>
                                        {{ $tutor?->profile?->full_name }}
                                        @if($tutor?->profile?->verified_at)
                                            <x-frontend.verified-tooltip />
                                        @endif
                                        @if ($tutor?->address?->country?->short_code)
                                        <span
                                            class="flag flag-{{ strtolower($tutor?->address?->country?->short_code) }}"></span>
                                        @endif
                                    </h3>
                                    @if(!empty($tutor?->profile?->tagline))
                                    <span>{{ $tutor?->profile?->tagline }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="am-tutordetail_fee">
                                @php
                                $formattedValue = number_format($tutor->min_price, 2);
                                list($integerPart, $decimalPart) = explode('.', $formattedValue);
                                @endphp
                                <strong> <sup>{{ getCurrencySymbol() }}</sup>{{ $integerPart }}.<sub>{{ $decimalPart }}</sub><em>{{
                                        __('tutor.per_session') }}</em></strong>
                                <span>{{ __('tutor.starting_from') }}</span>
                            </div>
                        </div>
                        <div class="am-tutordetail-reviews">
                            <ul class="am-tutorreviews-list">
                                <li>
                                    <div class="am-tutorreview-item">
                                        <i class="am-icon-star-01"></i>
                                        <span class="am-uniqespace">{{ number_format($tutor->avg_rating, 1) }}<em>/5.0 ({{
                                                $tutor->total_reviews == 1 ? __('general.review_count') :
                                                __('general.reviews_count', ['count' => $tutor->total_reviews] )
                                                }})</em></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="am-tutorreview-item">
                                        <i class="am-icon-user-group"></i>
                                        <span>{{$tutor->active_students}} <em>
                                        {{ $tutor->active_students == '1' ? __('tutor.active_student') :
                                        __('tutor.active_students') }}</em></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="am-tutorreview-item">
                                        <i class="am-icon-menu-2"></i>
                                        <span>{{$totalSlots}} <em>{{ $totalSlots == 1 ? __('tutor.session') :
                                            __('tutor.sessions')
                                            }}</em></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="am-tutorreview-item">
                                        <i class="am-icon-watch-1"></i>
                                        <span>{{ __('tutor.time', ['time' => rand(2, 5)]) }} <em>{{
                                                __('tutor.response_time') }}</em></span>
                                    </div>
                                </li>
                            </ul>
                            <ul class="am-tutorskills-list">
                                <li>
                                    <div class="am-tutorskills-item">
                                        <i class="am-icon-book-1"></i>
                                        <span>{{ __('tutor.i_can_teach') }}</span>
                                    </div>
                                    <ul x-data="{ open: false }">
                                        @foreach ($tutor?->subjects as $index => $sub)
                                        @if ($index < 2) <li><span>{{ $sub->subject->name }}</span>
                                </li>
                                @else
                                <li x-show="open"><span>{{ $sub->subject->name }}</span></li>
                                @endif
                                @endforeach
                                @if ($tutor?->subjects->count() > 2)
                                <li>
                                    <a href="javascript:void(0);" @click="open = !open">
                                        <span x-show="!open">{{ __('tutor.more_item', ['count' =>
                                            $tutor?->subjects->count() - 2]) }}</span>
                                        <span x-show="open">{{ __('tutor.show_less') }}</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                            </li>
                            <li>
                                <div class="am-tutorskills-item">
                                    <i class="am-icon-megaphone-01"></i>
                                    <span>{{ __('tutor.i_can_speak') }}</span>
                                </div>
                                <div class="wa-tags-list">
                                    <p>{{ ucfirst($tutor->profile->native_language) }}<span>{{ __('tutor.native')}}</span></p>
                                    <ul>
                                        @foreach ($tutor?->languages->slice(0, 3) as $index => $lan)
                                        <li><span>{{ ucfirst( $lan->name )}}</span></li>
                                        @endforeach
                                    </ul>
                                    @if($tutor?->languages?->count() > 3)
                                    <div class="am-more am-custom-tooltip">
                                        <span class="am-tooltip-text">
                                            @php
                                            $tutorLanguages = $tutor?->languages->slice(3,
                                            $tutor?->languages?->count() - 1);
                                            @endphp
                                            @if (!empty($tutorLanguages))
                                            @foreach ($tutorLanguages as $lan)
                                            <span>{{ ucfirst( $lan->name )}}</span>
                                            @endforeach
                                            @endif
                                        </span>
                                        +{{ $tutor?->languages?->count() - 3 }}
                                    </div>
                                    @endif
                                </div>
                            </li>
                            </ul>
                        </div>
                        <div class="am-tutordetail-btns">
                            <livewire:pages.tutor.action.action :tutor="$tutor" :isFavourite="$isFavourite" :navigate="false"
                                :key="$tutor->id" />
                        </div>
                    </div>
                    <div class="am-detailuser_video am-detailuser_video_main">
                        @if(!empty($tutor?->profile?->intro_video))
                            <video class="video-js" data-setup='{}' preload="auto" wire:key="profile-video-{{ $tutor->id }}"
                                id="profile-video-{{ $tutor->id }}" width="320" height="240" controls>
                                <source
                                    src="{{ asset('storage/'.$tutor?->profile?->intro_video).'?key=short-video' }}#t=0.1"
                                    wire:key="profile-video-src-{{ $tutor->id }}" type="video/mp4">
                            </video>
                        @elseif(!empty($tutor?->profile?->image) &&
                            Storage::disk('public')->exists($tutor?->profile?->image))
                            <img src="{{ asset('storage/'.$tutor->profile->image) }}"
                                alt="{{$tutor->profile->full_name}}" />
                        @else
                            <img src="{{ resizedImage('placeholder-land.png',400,300) }}"
                                alt="{{ $tutor?->profile?->full_name }}" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="am-aboutuser_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="am-aboutuser_tab" x-data="{tab: 'about'}">
                    <li x-bind:class="tab == 'about' ? 'active' : ''">
                        <a href="#" @click="tab='about'" class="am-tabitem">{{ __('tutor.introduction') }}</a>
                    </li>
                    <li x-bind:class="tab == 'availability' ? 'active' : ''">
                        <a href="#availability" @click="tab='availability'" class="am-tabitem">{{
                            __('tutor.availability') }}</a>
                    </li>
                    <li x-bind:class="tab == 'highlights' ? 'active' : ''">
                        <a @click="tab='highlights'" href="#resume-highlights" class="am-tabitem">{{
                            __('tutor.resume_highlights') }}</a>
                    </li>
                    <li x-bind:class="tab == 'reviews' ? 'active' : ''">
                        <a @click="tab='reviews'" href="#reviews" class="am-tabitem">{{ __('tutor.reviews') }} <span>{{
                                $tutor->total_reviews }}</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="am-userinfo_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-userinfo_content">
                    <h3>{{ __('tutor.about_me') }}</h3>
                    <div class="am-toggle-text">
                        <div class="am-addmore">
                            @php
                                $fullDescription  = $tutor->profile->description;
                                $shortDescription = Str::limit(strip_tags($fullDescription), 460, preserveWords: true);
                            @endphp
                            @if (Str::length(strip_tags($fullDescription)) > 460)
                                <p class="short-description">
                                    {!! $shortDescription !!}
                                    <a href="javascript:void(0);" class="toggle-description">{{ __('general.show_more') }}</a>
                                </p>
                                <div class="full-description d-none">
                                    {!! $fullDescription !!}
                                    <a href="javascript:void(0);" class="toggle-description">{{ __('general.show_less') }}</a>
                                </div>
                            @else
                                <div class="full-description">
                                    {!! $fullDescription !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="am-tutor-detail">
    <div class="am-booking_section" id="availability">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <livewire:components.tutor-sessions :user="$tutor" />
                </div>
            </div>
        </div>
        <div class="am-howtobook">
            @if (!empty(setting('_lernen.enable_booking_tips')) && (
            !empty(setting('_lernen.tips_for_booking_image')) ||
            !empty(setting('_lernen.tips_for_booking_heading')) ||
            !empty(setting('_lernen.tips_for_booking_bullets')) ||
            !empty(setting('_lernen.tips_for_booking_sub_heading')) ||
            !empty(setting('_lernen.tips_for_booking_sub_heading'))
            ))
            <a href="javascript:void(0);">
                <i class="am-icon-exclamation-01"></i>
                <!-- <span>{{ __('general.how_it_work') }}</span> -->
            </a>
            <div class="am-howtobook_popup">
                @if (!empty(setting('_lernen.tips_for_booking_image')[0]['path']))
                <figure class="am-howtobook_img">
                    <img src="{{ url(Storage::url(setting('_lernen.tips_for_booking_image')[0]['path'])) }}"
                        alt="img description">
                    <a href="javascript:void(0);" class="am-howtobook_close">
                        <i class="am-icon-multiply-02"></i>
                    </a>
                </figure>
                @endif
                <div class="am-howtobook_content">
                    <div class="am-howtobook_info">
                        @if (!empty(setting('_lernen.tips_for_booking_heading')))
                        <h3>{{ setting('_lernen.tips_for_booking_heading') }}</h3>
                        @endif
                        @if (!empty(setting('_lernen.tips_for_booking_bullets')))
                        <ol>
                            @foreach (setting('_lernen.tips_for_booking_bullets') as $bullet)
                            <li>
                                <span>{!! $bullet['tips_for_booking_bullet'] !!}</span>
                            </li>
                            @endforeach
                        </ol>
                        @endif
                    </div>
                    <div class="am-howtobook_info">
                        @if (!empty(setting('_lernen.tips_for_booking_sub_heading')))
                        <h3>{{ setting('_lernen.tips_for_booking_sub_heading') }}</h3>
                        @endif
                        @if (!empty(setting('_lernen.tips_for_booking_sub_bullets')))
                        <ol>
                            @foreach (setting('_lernen.tips_for_booking_sub_bullets') as $sub_bullet)
                            <li>
                                <span>{!! addBaseUrl($sub_bullet['tips_for_booking_sub_bullet']) !!}</span>
                            </li>
                            @endforeach
                        </ol>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div id="resume-highlights">
        <livewire:components.tutor-resume lazy :user="$tutor" />
    </div>
    <div id="reviews">
        <livewire:components.students-reviews :user="$tutor" lazy />
    </div>
    <livewire:components.similar-tutors :user="$tutor" lazy />
</div>
@endsection


@push('styles')
@vite([
'public/css/flatpicker.css',
'public/css/videojs.css',
'public/css/flags.css'
])
@endpush

@push('scripts')
<script src="{{ asset('js/video.min.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", (event) => {

        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top    >= 0 &&
                rect.left   >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right  <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        jQuery(document).on('click', '.am-howtobook > a', function() {
            const popup = jQuery('.am-howtobook_popup');
            popup.slideToggle('slow').toggleClass('active');
        });

        jQuery(document).on('click', '.am-howtobook_close', function() {
            const popup = jQuery('.am-howtobook_popup');
            popup.slideUp('slow').removeClass('active');
        });

        $(document).on('click','.toggle-description', function() {
            var parentContainer = $(this).closest('.am-addmore');

            parentContainer.find('.short-description').toggleClass('d-none');
            parentContainer.find('.full-description').toggleClass('d-none');
            if (parentContainer.find('.short-description').hasClass('d-none')) {
                $(this).text('{{ __('general.show_more') }}');
            } else {
                $(this).text('{{ __('general.show_less') }}');
            }
        });
    });
</script>
@endpush


