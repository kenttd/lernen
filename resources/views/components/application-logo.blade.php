@props(['variation' => 'default'])
@php
    if ($variation == 'default') {
        $logo    = setting('_general.logo_default');
        $logoImg = !empty($logo[0]['path']) ? asset('storage/'.$logo[0]['path']) : asset('demo-content/logo-default.svg');
    } elseif($variation == 'blue') {
        $logoImg  = asset('images/blue-logo.svg');
    } elseif($variation == 'purple') {  
        $logoImg  = asset('images/purple-logo.svg'); 
    } elseif($variation == 'green') {  
        $logoImg  = asset('images/green-logo.svg'); 
    } else {
        $logo    = setting('_general.logo_white');
        $logoImg = !empty($logo[0]['path']) ? asset('storage/'.$logo[0]['path']) : asset('demo-content/logo-white.svg');
    }
@endphp
<a href="{{ url('/') }}">
    <img src="{{ $logoImg }}" alt="{{ setting('_site.name') ?? config('app.name', __('general.app_name')) }}" {{ $attributes }}>
</a>
