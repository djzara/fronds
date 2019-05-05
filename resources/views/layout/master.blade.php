<!DOCTYPE html>
<html>
<head>
    <title>{{ $pageTitle ?? __('page.title') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script type="text/javascript" src="{{ mix('js/app.js') }}" defer async></script>
</head>
<body>
<div id="app">
    @includeWhen(!Auth::check(), 'layout.header')
    <div class="fronds-main-section col-12 fronds-row">
        <div class="fronds-left-gutter col-md-2">
            @yield('left-gutter')
        </div>
        <div class="fronds-content-area col-md-8">
            @yield('content')
        </div>
        <div class="fronds-right-gutter col-md-2">
            @yield('right-gutter')
        </div>
    </div>
    @includeWhen(!Auth::check(), 'layout.footer')
</div>
</body>
</html>
