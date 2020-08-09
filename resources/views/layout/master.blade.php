<!DOCTYPE html>
<html>
<head>
    <title>{{ $pageTitle ?? __('page.title') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
    @auth
        <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/admin.css') }}">
    @endauth
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script type="text/javascript" src="{{ mix('js/app.js') }}" defer></script>
    <script type="text/javascript" src="{{ mix('js/theme/'.config('fronds.theme').'/fronds.js') }}" defer></script>
</head>
<body>
<div id="fronds" class="w-100">
    @includeWhen(!Auth::check(), 'layout.header')
    @includeWhen(Auth::check(), 'admin.layout.header')
    <div class="fronds-main-section col-12 fronds-row">
        <div class="fronds-content-area col-md-12">
            @yield('content')
        </div>
    </div>
    @includeWhen(!Auth::check(), 'layout.footer')
</div>
@stack('theme_scripts')
</body>
</html>
