@extends('frontend.layouts.app')

@php($contentClasses = 'wizard')

@section('content')
    <div class="content">
        @include('frontend.layouts.partials.app.loyalty-pages.content-header')
        <div class="content_main content_main_checkout w-full">
            <div class="content_box w-full rewards">
                <div class="points-info-block active">
                    <div class="points-info-block__title">
                        <h2>{{getInscriptions('rewards-earn-points',request()->path(),'Earn Points on Each Purchase Redeemable For Discounts')}}</h2>
                        <img src="{{ asset('assets/frontend/img/Down-black.svg') }}" alt="Arrow down icon">
                    </div>
                    <div class="points-info-block__content-wrapper">
                        <ul class="points-info-block__content">
                            <li class="points-info-block__item">
                                <div class="points-info-block__img">
                                    <img src="{{ asset('assets/frontend/img/points-info-img-1.png') }}"
                                         alt="Reward option info icon">
                                </div>
                                <p>
                                    Earn 10 points for every $1 spent. Points never expire. You earn ’em, you keep ’em.
                                </p>
                            </li>
                            <li class="points-info-block__item">
                                <div class="points-info-block__img">
                                    <img src="{{ asset('assets/frontend/img/points-info-img-2.png') }}"
                                         alt="Reward option info icon">
                                </div>
                                <p>Earn 100 points when you refer a friend and they complete their first order.</p>
                            </li>
                            <li class="points-info-block__item">
                                <div class="points-info-block__img">
                                    <img src="{{ asset('assets/frontend/img/points-info-img-3.png') }}"
                                         alt="Reward option info icon">
                                </div>
                                <p>
                                    For every 5,000 points earned, we’ll automatically add $10 to your account. You can
                                    redeem when you checkout.
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                @if($isAuthenticated)
                    <div class="rewards__title-wrapper">
                        <h2 class="rewards__title">
                            {{getInscriptions('rewards-title',request()->path(),'The Rewards')}}
                        </h2>
                        <p class="rewards__subtitle">
                            Current Points Balance:
                            <span class="rewards__point-btn">
                                <img src="{{ asset('assets/frontend/img/Refferals-box.svg') }}" alt="Gift icon">
                                {{ $userReward->unused_points ?? 0 }} pts.
                            </span>
                        </p>
                    </div>
                    <div class="rewards__points-all-info">
                        <div class="rewards__title-wrapper">
                            <h2 class="rewards__title">
                                {{getInscriptions('rewards-title',request()->path(),'The Rewards')}}
                            </h2>
                            <p class="rewards__subtitle">
                                Current Points Balance:
                                <span class="rewards__point-btn">
                                    <img src="{{ asset('assets/frontend/img/Refferals-box.svg') }}" alt="Gift icon">
                                    {{ $userReward->unused_points ?? 0 }} {{ \Illuminate\Support\Str::plural('pt', $userReward->unused_points ?? 0) }}.
                                </span>
                            </p>
                        </div>
                        <div class="poins-table">
                            <div class="poins-table__head">
                                <div class="poins-table__tr">
                                    <div class="poins-table__th">
                                        Points <span>earned</span>
                                    </div>
                                    <div class="poins-table__th">
                                        Date
                                    </div>
                                    <div class="poins-table__th">
                                        Order
                                    </div>
                                </div>
                            </div>
                            <div class="poins-table__body perfect_scroll">
                                @foreach($orders as $order)
                                    <div class="poins-table__tr">
                                        <div class="poins-table__td">
                                            <span>
                                                {{ $order->total_points }} {{ \Illuminate\Support\Str::plural('pt', $order->total_points) }}.
                                            </span>
                                        </div>
                                        <div class="poins-table__td">
                                            {{ $order->created_at->format('m/d/Y') }}
                                        </div>
                                        <div class="poins-table__td">
                                            <a href="{{ route('frontend.orders.show', $order->id) }}">
                                                #{{ $order->id }}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="rewards__points-charth">
                            <div id="pie" class="pie-title-center"
                                 data-percent="{{ (($userReward->unused_points ?? 0) * 100) / 5000 }}">
                                <div class="pie-value">
                                    <div class="rewards__points-charth-img-text">
                                        {{ $userReward->unused_points ?? 0 }}
                                        <span>
                                            {{ \Illuminate\Support\Str::plural('Point', $userReward->unused_points ?? 0) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            You’re {{ $userReward->points_left_to_get_the_award ?? 5000 }} points away from earning $10
                            in credit!
                        </div>
                    </div>
                @endif
                @include('frontend.layouts.partials.subscribe-left-aligned')
                @include('frontend.layouts.partials.app.footer')
            </div>
        </div>
@endsection

@section('mobile-popups')
    @include('frontend.layouts.partials.app.alerts.session-response-message', ['mobileView' => true])
@endsection

@section('popups')
    @include('frontend.layouts.partials.app.alerts.session-response-message', ['flash' => true])
@endsection
