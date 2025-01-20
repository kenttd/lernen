@props(['page'=> null])
@php
    $headerVariations = setting('_front_page_settings.header_variation_for_pages');
    $headerVariation  = '';
    if (!empty($headerVariations)) {
        foreach ($headerVariations as $key => $variation) {
           if($variation['page_id'] == $page?->id) {
                $headerVariation = $variation['header_variation'];
                break;
           }
        }
    }
@endphp
@if ($headerVariation != 'am-header_four')  
    <header @class([
        'am-header_two', $headerVariation,
        'am-header-bg' => (empty($page) && !in_array(request()->route()->getName(), ['find-tutors','tutor-detail'])) || in_array($page?->slug, ['about-us', 'how-it-works', 'faq', 'terms-condition', 'privacy-policy'])
    ])>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="am-header_two_wrap">
                        <strong class="am-logo">
                            <x-application-logo />
                        </strong>
                        <nav class="am-navigation navbar-expand-xl">
                            <div class="am-navbar-toggler">
                                <div  class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#tenavbar" aria-expanded="false" aria-label="Toggle navigation" role="button">

                                </div>
                                <input type="checkbox" id="checkbox">
                                <label for="checkbox" class="toggler-menu">
                                    <span class="menu-bars" id="menu-bar1"></span>
                                    <span class="menu-bars" id="menu-bar2"></span>
                                    <span class="menu-bars" id="menu-bar3"></span>
                                </label>
                            </div>
                            <ul id="tenavbar" class="collapse navbar-collapse">
                            @if (!empty(getMenu('header')))
                                @foreach (getMenu('header') as $item)
                                    <x-menu-item :menu="$item" />
                                @endforeach
                            @endif
                            </ul>
                        </nav>
                        @auth
                        <x-frontend.user-menu />
                        @endauth
                        @guest
                        <div class="am-loginbtns">
                            <a href="{{ route('login') }}" class="am-btn">{{ __('general.login') }}</a>
                            <a href="{{ route('register') }}" class="am-white-btn">{{ __('general.get_started') }}</a>
                        </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </header>
@else
    <header class="am-header_four">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-header_two_wrap am-header-bg">
                        <strong class="am-logo">
                            <x-application-logo :variation="isset($page) && $page->slug === 'home-four' ? 'purple' : 'default'"/>
                        </strong>
                        <nav class="am-navigation navbar-expand-xl">
                            <div class="am-navbar-toggler">
                                <div  class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#tenavbar" aria-expanded="false" aria-label="Toggle navigation" role="button">
                                </div>
                                <input type="checkbox" id="checkbox">
                                <label for="checkbox" class="toggler-menu">
                                    <span class="menu-bars" id="menu-bar1"></span>
                                    <span class="menu-bars" id="menu-bar2"></span>
                                    <span class="menu-bars" id="menu-bar3"></span>
                                </label>
                            </div>
                            <ul id="tenavbar" class="collapse navbar-collapse">
                            @if (!empty(getMenu('header')))
                                @foreach (getMenu('header') as $item)
                                    <x-menu-item :menu="$item" />
                                @endforeach
                            @endif
                            </ul>
                        </nav>
                        @auth
                            <x-frontend.user-menu />
                        @endauth
                        @guest
                            <div class="am-loginbtns">
                                <a href="{{ route('register') }}" class="am-white-btn">{{ __('general.join_now') }}</a>
                                <a href="{{ route('login') }}" class="am-btn">{{ __('general.get_started') }}</a>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </header>
@endif