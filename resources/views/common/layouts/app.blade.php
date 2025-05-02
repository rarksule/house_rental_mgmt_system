<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @include('common.layouts.styles')
</head>

<body class="font-sans text-black-900 antialiased">

    @if (app_preloader_status == 1)
        <div id="preloader">
            <div id="preloaderInner"><img src="{{ getSettingImage('app_preloader') }}" alt="img"></div>
        </div>
    @endif

    <div id="layout-wrapper">
        @include('common.layouts.header')

        @if(!isTenant())
            @include('common.layouts.sidebar')
        @endif
        {{-- @yield('content') --}}
        {{ $slot }}
    </div>
    @if (!isAdminPanel())
        @include('common.layouts.footer')
    @endif

     @include('common.layouts.script') 
    @stack('script')
</body>

</html>
