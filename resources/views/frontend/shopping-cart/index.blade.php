@extends('frontend.layouts.app')

@section('mobile-header')
    <header
        class="mobile_header {{ session()->has('response-message') && is_string(session()->get('response-message')) ? 'active' : '' }}">
        <a href="" class="mobile_header_menu">
            <img src="{{ asset('assets/frontend/img/burger-menu-icon.svg') }}" alt="Menu icon">
        </a>
        <a href="{{ route('frontend.landing.index') }}" class="header_logo">
            <img src="{{ asset('assets/frontend/img/logo.svg') }}" alt="Logo">
        </a>
        <a class="mobile_header_cart_btn">
        </a>
    </header>
@endsection

@php($contentClasses = 'wizard')

@section('content')
    <div class="content content-scroll">
        @include('frontend.layouts.partials.app.checkout-steps.content-header')
        @includeWhen($isShoppingCartEmpty, 'frontend.shopping-cart.partials.content-types.empty')
        @includeWhen(!$isShoppingCartEmpty, 'frontend.shopping-cart.partials.content-types.not-empty')
    </div>
@endsection

@section('popups')
    @if(session()->has('response-message'))
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['flash' => true])
    @else
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true])
    @endif
    @include('frontend.shopping-cart.partials.popups.delete-order')
    @include('frontend.shopping-cart.partials.popups.delete-addon')
    @include('frontend.shopping-cart.partials.popups.order-complete')
    @if($isShoppingCartEmpty)
        @include('frontend.landing.partials.popups.login', ['redirectUrl' => route('frontend.shopping-cart.index')])
        @include('frontend.landing.partials.popups.register', ['redirectUrl' => route('frontend.shopping-cart.index')])
    @else
        @include('frontend.landing.partials.popups.login', ['redirectUrl' => route('frontend.shopping-cart.index'), 'executableSuccessFunction' => 'proceedToCheckout'])
        @include('frontend.landing.partials.popups.register', ['redirectUrl' => route('frontend.shopping-cart.index'), 'executableSuccessFunction' => 'proceedToCheckout'])
    @endif
    @include('frontend.landing.partials.popups.forgot-password')
    @include('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true])
@endsection

@push('js')
    <script src="{{ asset('assets/frontend/js/shopping-cart.js') }}"></script>
@endpush
