<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if( !empty(setting('_general.enable_rtl')) ) dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $siteTitle = setting('_general.site_name');
    @endphp
    @if( !empty($page->title) )
        <title>{!! $page->title !!}</title>
    @elseif( !empty($pageTitle) )
        <title>{{ $siteTitle }} | {!! $pageTitle !!}</title>
    @else
        <title>{{ $siteTitle }} | {{ __('tutor.tutors_tutors') }}</title>
    @endif

    @if( !empty($pageDescription) )
        <meta name="description" content="{{ $pageDescription }}" />
    @endif
    @vite([
    'public/css/bootstrap.min.css',
    'public/css/fonts.css',
    'public/css/icomoon/style.css',
    'public/css/select2.min.css',
    'public/css/splide.min.css',
    'public/css/main.css',

    ])
    <x-favicon />
    @if( !empty(setting('_general.enable_rtl')) )
        <link rel="stylesheet" type="text/css" href="{{ asset('css/rtl.css') }}">
    @endif
    @stack('styles')
</head>

<body class="am-bodywrap @if( !empty(setting('_general.enable_rtl')) ) am-rtl @endif">
    <x-front.header :page="$page?? null"/>
    <main class="am-main">
        @yield('content')
        {{ $slot ?? '' }}
    </main>
    <x-popups />
    <x-front.footer :page="$page?? null" />
    @livewireScripts()
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script defer src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script defer src="{{ asset('js/select2.min.js') }}"></script>
    <script defer src="{{ asset('js/splide.min.js') }}"></script>
    <script defer src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.on('remove-cart', (event) => {
                const currentRoute = '{{ request()->route()->getName() }}';

                const { index, id } = event.params;
                if (currentRoute != 'tutor-detail') {
                    fetch('/remove-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ index, id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const event = new CustomEvent('cart-updated', {
                            detail: {
                                cart_data: data.cart_data,
                                total: data.total,
                                subTotal: data.subTotal,
                                toggle_cart: data.toggle_cart
                            }
                        });
                        window.dispatchEvent(event);
                    } else {
                        console.error('Failed to update cart:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
                }
            });
        });
    </script>
</body>

</html>
