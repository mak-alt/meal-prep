@extends('frontend.layouts.app')

@php($contentClasses = 'wizard')

@section('content')
    <div class="content" style="display: flex; flex-direction: column;">
        <div class="content_header wizard-header wizard-header-inner history">
            <div class="steps text-center">
                <div class="wizard-step {{ request()->is('loyalty/gifts*') ? 'active' : '' }}">
                    <span>
                        <a href="{{ route('frontend.gifts.index') }}">Gift Certificate</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="content_main perfect_scroll">
            <div class="empty-page gift">
                <div class="empty-page_logo">
                    <img src="{{ asset('assets/frontend/img/atlantaMeal.png') }}" alt="Gift card icon">
                </div>
                <h1 class="empty-page_h1"></h1>
                <div class="empty-page-btn-wrapp">
                    <a href="" class="btn btn-green" data-action="show-popup" data-popup-id="purchase-gift-card-popup">
                        Purchase a Gift Card
                    </a>
                    @if($isAuthenticated)
                        <a href="" class="btn btn_transparent" data-action="show-popup"
                           data-popup-id="redeem-gift-card-popup">
                            Redeem a Gift Card
                        </a>
                    @else
                        <a href="" class="btn btn_transparent" data-action="show-popup"
                           data-popup-id="login-popup">
                            Redeem a Gift Card
                        </a>
                    @endif
                </div>
            </div>
        </div>

		@include('frontend.layouts.partials.subscribe-left-aligned')
        @include('frontend.layouts.partials.app.footer')
    </div>
@endsection

@section('popups')
    @include('frontend.gifts.partials.popups.make-payment-with-credit-card')
    @include('frontend.gifts.partials.popups.payment-failed')
    @include('frontend.gifts.partials.popups.purchase-gift-card')
    @include('frontend.gifts.partials.popups.send-via-email')
    @include('frontend.gifts.partials.popups.send-via-sms')
    @include('frontend.gifts.partials.popups.redeem-gift-card')
    @include('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true])
    @include('frontend.landing.partials.popups.login', ['redirectUrl' => route('frontend.gifts.index')])
    @include('frontend.landing.partials.popups.register', ['redirectUrl' => route('frontend.gifts.index')])
    @include('frontend.landing.partials.popups.forgot-password')
@endsection

@push('js')
    <script src="{{ asset('assets/frontend/js/gifts.js') }}"></script>
@endpush
