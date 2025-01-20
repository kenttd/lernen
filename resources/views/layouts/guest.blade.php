<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if( !empty(setting('_general.enable_rtl')) ) dir="rtl" @endif>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @php
            $siteTitle = setting('_general.site_name');
        @endphp
        <title>{{ $siteTitle }} {{ !empty($title) ? ' | ' . $title : '' }}</title>
        @livewireStyles()
        @livewireScripts()
        <!-- Scripts -->
        @vite([
            'public/css/bootstrap.min.css',
            'public/css/fonts.css',
            'public/css/select2.min.css',
            'public/css/main.css',
            'public/css/icomoon/style.css',
            'public/css/videojs.css',
            'public/js/bootstrap.min.js',
            'public/js/video.min.js',
            'public/js/main.js',
        ])
        @if( !empty(setting('_general.enable_rtl')) )
            <link rel="stylesheet" type="text/css" href="{{ asset('css/rtl.css') }}">
        @endif
        <x-favicon />
    </head>
    <body class="font-sans text-gray-900 antialiased @if( !empty(setting('_general.enable_rtl')) ) am-rtl @endif">
        <main>
            {{ $slot }}
        </main>
        <x-popups />
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script defer src="{{ asset('js/select2.min.js') }}"></script>
        @stack('scripts')
    </body>
</html>