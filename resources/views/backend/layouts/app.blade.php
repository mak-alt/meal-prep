<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', config('app.name') . ' | Admin')</title>
    <link rel="icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('backend.layouts.partials.styles')
    @stack('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @include('backend.layouts.partials.navbar')
    @include('backend.layouts.partials.sidebar-new')

    @yield('content')
    @yield('popups')

    <footer class="main-footer">
        <strong>Copyright &copy; <a href="#" target="_blank">{{ config('app.name') }}</a>.</strong> All rights reserved.
    </footer>
</div>

@include('backend.layouts.partials.scripts')
@stack('js')
</body>
</html>
