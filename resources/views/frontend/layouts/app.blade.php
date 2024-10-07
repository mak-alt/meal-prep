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

    @include('frontend.layouts.partials.app.styles')
    @stack('css')
</head>
<body {{ $bodyClasses ?? '' }}>
    @sectionMissing('mobile-header')
        @sectionMissing('mobile-popups')
            @include('frontend.layouts.partials.app.header')
        @else
            @include('frontend.layouts.partials.app.header', ['classes' => 'mobile_header_notif'])
        @endif
    @endif

    @yield('mobile-popups')
    @yield('mobile-header')

    <main>
        <div class="module__dashboard {{ $contentClasses ?? '' }}">
            @if(empty($noSidebar))
            @include('frontend.layouts.partials.app.left-sidebar')
            @endif

            @yield('content')
            @yield('popups')
        </div>

        @yield('footer')
    </main>

    @include('frontend.layouts.partials.app.scripts')
    @stack('js')
</body>
</html>
