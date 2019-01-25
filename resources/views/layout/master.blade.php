<!DOCTYPE html>
<html>
<head>
    <title>{{ 'Fronds' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script type="text/javascript" src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>
<div id="app">
    @include('layout.header')
    @yield('content')
    @include('layout.footer')
</div>
</body>
</html>
