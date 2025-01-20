<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if( !empty(setting('_general.enable_rtl')) ) dir="rtl" @endif>
@php
    $siteTitle  = setting('_general.site_name') ?: env('APP_NAME');
@endphp
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> {{ __('general.adminpanel_title') }} | {{$siteTitle}}</title>
        <x-favicon />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite([
            'public/css/bootstrap.min.css',
            'public/admin/css/themify-icons.css',
            'public/admin/css/fontawesome/all.min.css',
            'public/css/select2.min.css',
            'public/css/mCustomScrollbar.min.css',
            'public/admin/css/feather-icons.css',
            'public/admin/css/main.css'
        ])
        @stack('styles')
        @if( !empty(setting('_general.enable_rtl')) )
            <link rel="stylesheet" type="text/css" href="{{ asset('css/rtl.css') }}">
        @endif
        @livewireStyles
    </head>
    <body class="tb-bodycolor @if( !empty(setting('_general.enable_rtl')) ) am-rtl @endif">
        <div class="tb-mainwrapper">
            <livewire:admin.sidebar />
            <div class="tb-subwrapper">
                <div class="tb-adminwrapper">
                    <div class="container-fluid">
                        @yield('content')
                        @if(!empty($slot))
                        {{ $slot }}
                        @endif
                        <x-admin.footer />
                    </div>
                </div>
            </div>
            <x-popups />
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                jQuery(document).on("click", '.update-section-settings, .reset-section-settings', function(event){
                    if(jQuery(this).attr('data-form') != '_theme-form') {
                        return false;
                    }
                    setTimeout(function() {
                        $.ajaxSetup({
                            headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{ url('admin/update-sass-style') }}",
                            method: 'post',
                            success: function(data){
                            }
                        });
                    }, 300);         
                });
            });
        </script>
        @livewireScripts
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script defer src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script defer src="{{ asset('js/select2.min.js') }} "></script>
        <script defer src="{{ asset('js/mCustomScrollbar.min.js') }}"></script>
        <script defer src="{{ asset('js/main.js')}}"></script>
        <script defer src="{{ asset('js/admin-app.js')}}"></script>
        @stack('scripts')
    </body>
    </html>



