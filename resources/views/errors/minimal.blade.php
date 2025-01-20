<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite([
    'public/css/bootstrap.min.css',
    'public/css/fonts.css',
    'public/css/main.css',
    'public/css/icomoon/style.css',
    ])
    <x-favicon />
    @stack('styles')
    @stack('scripts')
</head>

<body class="am-bodywrap">
    <x-front.header :page="null" />
    <main class="am-main am-404">
        <div class="tk-errorpage">
            <div class="tk-errorpage_content">
                <h1>{{ __('general.status_404') }}</h1>
                <div class="tk-errorpage_title">
                    <h2>{{ __('general.went_wrong') }}</h2>
                    <p>{{ __('general.went_wrong_dec') }}</p>
                    <a href="{{ url('/') }}" class="am-btn">{{ __('general.go_to_home') }}</a>

                    <!-- <h2>@yield('message')</h2>
                    @hasSection('message_desc')
                    <p>@yield('message_desc')
                    <p>
                        @endif
                        <em>{{ __('general.error_text_desc') }}</em>
                        <a href="{{ url('/') }}" class="am-btn">{{ __('general.go_to_home_link') }}</a> -->
                </div>
            </div>
        </div>
    </main>
    @livewireScripts()
    <script defer src="{{ asset('js/jquery.min.js') }}"></script>
    <script defer src="{{ asset('js/main.js') }}"></script>
    <x-popups />
    <x-front.footer :page="null" />
</body>

</html>