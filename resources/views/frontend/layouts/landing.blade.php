<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('seo:title', $seoData['title'] ?? '')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('seo:description', $seoData['description'] ?? '')">
    <meta name="keywords" content="@yield('seo:keywords', $seoData['keywords'] ?? '')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="favicon.ico">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="{{'https://www.googletagmanager.com/gtag/js?id=' . $googleAnalyticsID}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{$googleAnalyticsID}}');
    </script>

    @include('frontend.layouts.partials.landing.styles')
    @stack('css')
</head>
<body {{ $bodyClass ?? '' }}>

@include('frontend.layouts.partials.landing.header')
@yield('mobile-popups')
<main class="home">
    @yield('content')
    @yield('popups')


    @include('frontend.layouts.partials.landing.footer')
</main>

@include('frontend.layouts.partials.landing.scripts')
@stack('js')
</body>
</html>
