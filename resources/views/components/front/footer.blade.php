@props(['page'=> null])
@php
    $footerVariations = setting('_front_page_settings.footer_variation_for_pages');
    $footerVariation  = '';
    if (!empty($footerVariations)) {
        foreach ($footerVariations as $key => $variation) {
           if($variation['page_id'] == $page?->id) {
                $footerVariation = $variation['footer_variation'];
                break;
           }
        }
    }
@endphp

@if($footerVariation != 'am-footer_three')
    <footer @class(['am-footer', $footerVariation])>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-footer_wrap">
                        <div class="am-footer_logoarea">
                            <strong class="am-flogo">
                                <x-application-logo :variation="'white'" />
                            </strong>
                            @if(!empty(setting('_front_page_settings.footer_paragraph')))
                                <p>{!! setting('_front_page_settings.footer_paragraph') !!}</p>
                            @endif
                            <ul class="am-footer_contact">
                                <li>
                                    <a href="tel:+13165550116"><i class="am-icon-audio-03"></i>{!! setting('_front_page_settings.footer_contact') !!}</a>
                                </li>
                                <li>
                                    <a href="mailto:hello@gmail.com"><i class="am-icon-email-01"></i>{!! setting('_front_page_settings.footer_email') !!}</a>
                                </li>
                                <li>
                                    <address><i class="am-icon-location"></i>{!! setting('_front_page_settings.footer_address') !!}</address>
                                </li>
                            </ul>
                            @if (
                                !empty( setting('_general.fb_link')) ||
                                !empty( setting('_general.insta_link')) ||
                                !empty(setting('_general.linkedin_link')) ||
                                !empty(setting('_general.yt_link')) ||
                                !empty(setting('_general.tiktok_link'))
                                )
                                <ul class="am-socialmedia">
                                    @if ( !empty( setting('_general.fb_link')))
                                    <li>
                                        <a href="{{ setting('_general.fb_link') }}">
                                            <i class="am-icon-facebook"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if ( !empty( setting('_general.insta_link')))
                                    <li>
                                        <a href="{{ setting('_general.insta_link') }}">
                                            <i class="am-icon-instagram"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if ( !empty( setting('_general.linkedin_link')))
                                    <li>
                                        <a href="{{ setting('_general.linkedin_link') }}">
                                            <i class="am-icon-linkedin"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if ( !empty( setting('_general.yt_link')))
                                    <li>
                                        <a href="{{ setting('_general.yt_link') }}">
                                            <i class="am-icon-youtube"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if ( !empty( setting('_general.tiktok_link')))
                                    <li>
                                        <a href="{{ setting('_general.tiktok_link') }}">
                                            <i class="am-icon-tiktok"></i>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            @endif
                             @if(!empty(setting('_front_page_settings.footer_button_text')))
                            <a href="{{ !empty(setting('_front_page_settings.footer_button_url')) ? url(setting('_front_page_settings.footer_button_url'))  : '#' }}"
                                class="am-btn">{{ setting('_front_page_settings.footer_button_text') }}</a>
                            @endif
                        </div>
                        <div class="am-fnavigation_wrap">
                            <nav class="am-fnavigation">
                                <div class="am-fnavigation_title">
                                    <h3>{{ setting('_front_page_settings.quick_links_heading') }}</h3>
                                </div>
                                @if (!empty(getMenu('footer', 'Footer menu 1')))
                                <ul>
                                    @foreach (getMenu('footer', 'Footer menu 1') as $item)
                                        <x-menu-item :menu="$item" />
                                    @endforeach
                                </ul>
                                @endif
                            </nav>
                            <nav class="am-fnavigation">
                                 <div class="am-fnavigation_title">
                                    <h3>{{ setting('_front_page_settings.tutors_by_country_heading') }}</h3>
                                </div>
                                @if (!empty(getMenu('footer', 'Footer menu 2')))
                                <ul>
                                    @foreach (getMenu('footer', 'Footer menu 2') as $item)
                                        <x-menu-item :menu="$item" /> 
                                    @endforeach
                                </ul>
                                @endif
                            </nav>
                            <nav class="am-fnavigation">
                               <div class="am-fnavigation_title">
                                    <h3>{{ setting('_front_page_settings.our_services_heading') }}</h3>
                                </div>
                                <ul>
                                    @if (!empty(getMenu('footer', 'Footer menu 3')))
                                        @foreach (getMenu('footer', 'Footer menu 3') as $item)
                                            <x-menu-item :menu="$item" /> 
                                        @endforeach
                                    @endif
                                </ul>
                            </nav>
                            <nav class="am-fnavigation">
                               <div class="am-fnavigation_title">
                                    <h3>{{ setting('_front_page_settings.one_on_one_sessions_heading') }}</h3>
                                </div>
                                <ul>
                                    @if (!empty(getMenu('footer', 'Footer menu 4')))
                                        @foreach (getMenu('footer', 'Footer menu 4') as $item)
                                            <x-menu-item :menu="$item" /> 
                                        @endforeach
                                    @endif
                                </ul>
                            </nav>
                            <nav class="am-fnavigation">
                               <div class="am-fnavigation_title">
                                    <h3>{{ setting('_front_page_settings.group_sessions_heading') }}</h3>
                                </div>
                                <ul>
                                    @if (!empty(getMenu('footer', 'Footer menu 5')))
                                        @foreach (getMenu('footer', 'Footer menu 5') as $item)
                                            <x-menu-item :menu="$item" /> 
                                        @endforeach
                                    @endif
                                </ul>
                            </nav>
                            @if (
                            !empty( setting('_front_page_settings.app_section_heading')) ||
                            !empty(setting('_front_page_settings.app_section_description')) ||
                            !empty(setting('_general.android_app_logo')) || !empty(setting('_general.ios_app_logo'))
                            )
                            <div class="am-fnavigation">
                                @if (!empty( setting('_front_page_settings.app_section_heading')))
                                <div class="am-fnavigation_title">
                                    <h3>{{ setting('_front_page_settings.app_section_heading') }}</h3>
                                </div>
                                @endif
                                @if (!empty( setting('_front_page_settings.app_section_description')))
                                <p>{{ setting('_front_page_settings.app_section_description') }}</p>
                                @endif
                                @if (
                                !empty(setting('_general.ios_app_logo')) ||
                                !empty(setting('_general.android_app_logo'))
                                )
                                <div class="am-fnavigation_app">
                                    @if (!empty(!empty(setting('_general.ios_app_logo'))))
                                    <a href="{{ setting('_general.app_ios_link') }}"><img
                                            src="{{ url(Storage::url(setting('_general.ios_app_logo')[0]['path'])) }}"
                                            alt="img description">
                                    </a>
                                    @endif
                                    @if (!empty(!empty(setting('_general.android_app_logo'))))
                                    <a href="{{ setting('_general.app_android_link') }}"><img
                                            src="{{ url(Storage::url(setting('_general.android_app_logo')[0]['path'])) }}"
                                            alt="img description">
                                    </a>
                                    @endif

                                </div>
                                @endif
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="am-footer_bottom"> --}}
            {{-- <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="am-footer_wrap">
                            <div class="am-footer_logoarea">
                                <strong class="am-flogo">
                                    <x-application-logo :variation="'white'" />
                                </strong>
                                @if(!empty(setting('_front_page_settings.footer_paragraph')))
                                <p>{!! setting('_front_page_settings.footer_paragraph') !!}</p>
                                @endif
                                <ul class="am-footer_contact">
                                    <li>
                                        <a href="tel:+13165550116"><i class="am-icon-audio-03"></i>{!! setting('_front_page_settings.footer_contact') !!}</a>
                                    </li>
                                    <li>
                                        <a href="mailto:hello@gmail.com"><i class="am-icon-email-01"></i>{!! setting('_front_page_settings.footer_email') !!}</a>
                                    </li>
                                    <li>
                                        <address><i class="am-icon-location"></i>{!! setting('_front_page_settings.footer_address') !!}</address>
                                    </li>
                                </ul>
                                @if (
                                !empty( setting('_general.fb_link')) ||
                                !empty( setting('_general.insta_link')) ||
                                !empty(setting('_general.linkedin_link')) ||
                                !empty(setting('_general.yt_link')) ||
                                !empty(setting('_general.tiktok_link'))
                                )
                                <ul class="am-socialmedia">
                                    @if ( !empty( setting('_general.fb_link')))
                                    <li>
                                        <a href="{{ setting('_general.fb_link') }}">
                                            <i class="am-icon-facebook"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if ( !empty( setting('_general.insta_link')))
                                    <li>
                                        <a href="{{ setting('_general.insta_link') }}">
                                            <i class="am-icon-instagram"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if ( !empty( setting('_general.linkedin_link')))
                                    <li>
                                        <a href="{{ setting('_general.linkedin_link') }}">
                                            <i class="am-icon-linkedin"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if ( !empty( setting('_general.yt_link')))
                                    <li>
                                        <a href="{{ setting('_general.yt_link') }}">
                                            <i class="am-icon-youtube"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if ( !empty( setting('_general.tiktok_link')))
                                    <li>
                                        <a href="{{ setting('_general.tiktok_link') }}">
                                            <i class="am-icon-tiktok"></i>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                                @endif

                                @if(!empty(setting('_front_page_settings.footer_button_text')))
                                <a href="{{ !empty(setting('_front_page_settings.footer_button_url')) ? url(setting('_front_page_settings.footer_button_url'))  : '#' }}"
                                    class="am-btn">{{ setting('_front_page_settings.footer_button_text') }}</a>
                                @endif
                            </div>
                            <div class="am-fnavigation_wrap">
                                <nav class="am-fnavigation">
                                    <div class="am-fnavigation_title">
                                        <h3>{{ setting('_front_page_settings.quick_links_heading') }}</h3>
                                    </div>
                                    @if (!empty($menu['Footer menu 1']))
                                    <ul>

                                        @foreach ($menu['Footer menu 1']->menuItems as $item)
                                        <li>
                                            <a href="{{ url($item->route) }}">{{ $item->label }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </nav>
                                <nav class="am-fnavigation">
                                    <div class="am-fnavigation_title">
                                        <h3>{{ setting('_front_page_settings.tutors_by_country_heading') }}</h3>
                                    </div>
                                    @if (!empty($menu['Footer menu 2']))
                                    <ul>
                                        @foreach ($menu['Footer menu 2']->menuItems as $item)
                                        <li>
                                            <a href="{{ url($item->route) }}">{{ $item->label }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </nav>
                                <nav class="am-fnavigation">
                                    <div class="am-fnavigation_title">
                                        <h3>{{ setting('_front_page_settings.our_services_heading') }}</h3>
                                    </div>
                                    <ul>
                                        @if (!empty($menu['Footer menu 3']))
                                        @foreach ($menu['Footer menu 3']->menuItems as $item)
                                        <li>
                                            <a href="{{ url($item->route) }}">{{ $item->label }}</a>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </nav>
                                <nav class="am-fnavigation">
                                    <div class="am-fnavigation_title">
                                        <h3>{{ setting('_front_page_settings.one_on_one_sessions_heading') }}</h3>
                                    </div>
                                    <ul>
                                        @if (!empty($menu['Footer menu 4']))
                                        @foreach ($menu['Footer menu 4']->menuItems as $item)
                                        <li>
                                            <a href="{{ url($item->route) }}">{{ $item->label }}</a>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </nav>
                                <nav class="am-fnavigation">
                                    <div class="am-fnavigation_title">
                                        <h3>{{ setting('_front_page_settings.group_sessions_heading') }}</h3>
                                    </div>
                                    <ul>
                                        @if (!empty($menu['Footer menu 5']))
                                        @foreach ($menu['Footer menu 5']->menuItems as $item)
                                        <li>
                                            <a href="{{ url($item->route) }}">{{ $item->label }}</a>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </nav>
                                @if (
                                !empty( setting('_front_page_settings.app_section_heading')) ||
                                !empty(setting('_front_page_settings.app_section_description')) ||
                                !empty(setting('_general.android_app_logo')) || !empty(setting('_general.ios_app_logo'))
                                )
                                <div class="am-fnavigation">
                                    @if (!empty( setting('_front_page_settings.app_section_heading')))
                                    <div class="am-fnavigation_title">
                                        <h3>{{ setting('_front_page_settings.app_section_heading') }}</h3>
                                    </div>
                                    @endif
                                    @if (!empty( setting('_front_page_settings.app_section_description')))
                                        <p>{{ setting('_front_page_settings.app_section_description') }}</p>
                                    @endif
                                    @if (
                                    !empty(setting('_general.ios_app_logo')) ||
                                    !empty(setting('_general.android_app_logo'))
                                    )
                                    <div class="am-fnavigation_app">
                                        @if (!empty(!empty(setting('_general.ios_app_logo'))))
                                        <a href="{{ setting('_front_page_settings.app_ios_link') }}"><img
                                                src="{{ url(Storage::url(setting('_general.ios_app_logo')[0]['path'])) }}"
                                                alt="img description">
                                        </a>
                                        @endif
                                        @if (!empty(!empty(setting('_general.android_app_logo'))))
                                        <a href="{{ setting('_front_page_settings.app_android_link') }}"><img
                                                src="{{ url(Storage::url(setting('_general.android_app_logo')[0]['path'])) }}"
                                                alt="img description">
                                        </a>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="am-footer_bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="am-footer_info">
                                <p>
                                    {{ __('general.copyright_txt',['year' => date('Y')]) }}
                                </p>
                                <nav>
                                    <ul>
                                        <li><a href="{{ url('terms-condition') }}">{{ __('general.terms_of_use') }}</a></li>
                                        <li><a href="{{ url('privacy-policy') }}">{{ __('general.privacy_policy') }}</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="am-clicktop" href="#"><i class="am-icon-arrow-up"></i></a>
            </div>
        {{-- </div> --}}
    </footer>
@else
    <footer class="am-footer-v4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-footer-content">
                        @if(!empty(setting('_front_page_settings.footer_heading')))
                            <h2 data-aos="fade-up"  data-aos-duration="400" data-aos-easing="ease">{!! setting('_front_page_settings.footer_heading') !!}</h2>
                        @endif
                        @if(!empty(setting('_front_page_settings.footer3_paragraph')))
                            <p data-aos="fade-up"  data-aos-duration="500" data-aos-easing="ease">{!! setting('_front_page_settings.footer3_paragraph') !!}</p>
                        @endif
                        @if(!empty(setting('_front_page_settings.primary_button_url')) 
                            || !empty(setting('_front_page_settings.primary_button_text'))
                            || !empty(setting('_front_page_settings.secondary_button_url')) 
                            || !empty(setting('_front_page_settings.secondary_button_text')))
                            <div class="am-actions" data-aos="fade-up"  data-aos-duration="600" data-aos-easing="ease">
                                @if(!empty(setting('_front_page_settings.primary_button_url')) || !empty(setting('_front_page_settings.primary_button_text')))
                                    <a href="{!! setting('_front_page_settings.primary_button_url') !!}" class="am-getstarted-btn">{!! setting('_front_page_settings.primary_button_text') !!}</a>
                                @endif
                                @if(!empty(setting('_front_page_settings.secondary_button_url')) || !empty(setting('_front_page_settings.secondary_button_text')))
                                    <a href="{!! setting('_front_page_settings.secondary_button_url') !!}" class="am-outline-btn">{!! setting('_front_page_settings.secondary_button_text') !!}</a>
                                @endif
                            </div>
                        @endif
                        @if(!empty(setting('_front_page_settings.tutor_link_heading')) || !empty(setting('_front_page_settings.join_lernen_link_url')) || !empty(setting('_front_page_settings.join_lernen_link')))
                            <p class="am-join-lernen" data-aos="fade-up"  data-aos-duration="1000" data-aos-easing="ease">{!! setting('_front_page_settings.tutor_link_heading') !!} <a href="{!! setting('_front_page_settings.join_lernen_link_url') !!}">{!! setting('_front_page_settings.join_lernen_link') !!}</a></p>
                        @endif
                        <ul class="am-footer-nav">
                            <li><a href="{{ url('about-us') }}">{{ __('general.about') }}</a></li>
                            <li><a href="{{ url('terms-condition') }}">{{ __('general.terms_of_use') }}</a></li>
                            <li><a href="{{ url('privacy-policy') }}">{{ __('general.privacy_policy') }}</a></li>
                            <li><a href="{{ url('#') }}">{{ __('general.contact_us') }}</a></li>
                            <li><a href="{{ url('faq') }}">{{ __('general.faqs') }}</a></li>
                            <li><a href="{{ url('#') }}">{{ __('general.blog') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endif












 











