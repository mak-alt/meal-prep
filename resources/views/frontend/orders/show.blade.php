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
    <div class="content">
        <div class="content_header wizard-header wizard-header-chekout">
            <div class="steps text-center">
                <div class="wizard-step {{ request()->is('shopping-cart') ? 'active' : '' }}"
                     data-redirect="{{ route('frontend.shopping-cart.index') }}">
                    <span class="desk_title active">{{getInscriptions('shopping-cart-tab','/orders','1. Shopping Cart')}}</span>
                    <span class="mob_title active">{{getInscriptions('shopping-cart-tab-mobile','/orders','1. Cart')}}</span>
                    @php(include 'assets/frontend/img/arrow-wizard.svg')
                </div>
                <div
                    class="wizard-step {{ request()->is('checkout') ? 'active' : '' }}"
                    {{ !session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['proceeded_to_checkout']) ? '' : 'data-redirect=' . route('frontend.checkout.index') }}
                    id="checkout-step">
            <span
                class="{{ !session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['proceeded_to_checkout']) ? '' : 'active' }}">
                {{getInscriptions('checkout-tab','/orders','2. Checkout')}}
            </span>
                    @php(include 'assets/frontend/img/arrow-wizard.svg')
                </div>
                <div class="wizard-step {{ request()->is('orders/*') ? 'active' : '' }}">
                    <span class="desk_title">{{getInscriptions('order-status-tab', '/orders' ,'3. Order Status')}}</span>
                    <span class="mob_title">{{getInscriptions('order-status-tab-mobile', '/orders', '3. Status')}}</span>
                </div>
            </div>
        </div>
        <div class="content_main perfect_scroll">
            <div class="content_box content_box_meal">
                <div class="order-menu">
                    <ul>
                        <li class="order-menu__item">
                            <div class="order-menu__header">
                                <div class="order-menu__header-block-flex">
                                    <div class="order-menu__title-wrapper">
                                        <h2 class="order-menu__title">
                                            Order from {{ $order->created_at->format('m/d/Y') }}
                                        </h2>
                                        <div class="order-menu__title-links">
                                            <a href="{{ route('frontend.orders.download-receipt', $order->id) }}"
                                               class="active-link">
                                                Download receipt
                                            </a>
                                            <a href="{{ route('frontend.orders.repeat', $order->id) }}"
                                               data-action="repeat-order">
                                                Repeat the same order
                                            </a>
                                        </div>
                                    </div>
                                    <div class="order-menu__price-wrapper">
                                        <span class="price">${{ $order->total_price }}</span>
                                        <span class="points">+{{ $order->total_points }} points</span>
                                    </div>
                                    <div class="order-menu__icon">
                                        <img src="{{ asset('assets/frontend/img/Up.svg') }}" alt="Arrow icon">
                                    </div>
                                </div>
                                <div class="order-menu__title-links order-menu__title-links-mobile">
                                    <a href="{{ route('frontend.orders.download-receipt', $order->id) }}"
                                       class="active-link">
                                        Download receipt
                                    </a>
                                    <a href="{{ route('frontend.orders.repeat', $order->id) }}"
                                       data-action="repeat-order">
                                        Repeat the same order
                                    </a>
                                </div>
                            </div>
                            <ul class="order-menu__dropdown">
                                @foreach($order->orderItems as $orderItem)
                                    <li>
                                        <div class="order-menu__header">
                                            <div class="order-menu__header-wrapper">
                                                <div class="order-menu__title-wrapper">
                                                    <h3 class="order-menu__dropdown-title">
                                                        {{ $orderItem->name }}
                                                    </h3>
                                                </div>
                                                <div class="order-menu__price-wrapper">
                                                    <span class="price">${{ $orderItem->total_price }}</span>
                                                </div>
                                                <div class="order-menu__icon">
                                                    <img src="{{ asset('assets/frontend/img/Up-small.svg') }}"
                                                         alt="Arrow icon">
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="order-menu__dropdown order-menu__food-info">
                                            @foreach($orderItem->orderItemables->whereNull('parent_id')->where('order_itemable_type', '!==', \App\Models\Addon::class) as $orderItemable)
                                                <li class="order-menu__food-info-item">
                                                    <div class="order-menu__food-info-head">
                                                        <p>{{ $orderItemable->orderItemable->name }}</p>
                                                        @if($orderItem->menu_id === null)
                                                            <span class="price">${{ $orderItemable->price }}</span>
                                                        @endif
                                                    </div>
                                                    @if($orderItemable->children->isNotEmpty())
                                                        <div class="order-menu__food-info-list">
                                                            @foreach($orderItemable->children as $orderItemableChild)
                                                                @if($orderItemableChild->orderItemable->status)
                                                                    <div>
                                                                        <p>
                                                                            <span>Side:</span>
                                                                            {{ $orderItemableChild->orderItemable->name }}
                                                                        </p>
                                                                        @if($orderItem->menu_id === null)
                                                                            <span class="price">
                                                                                ${{ $orderItemableChild->price }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    <div class="weekly-menu__info">
                                                        <div class="weekly-menu__info-item">
                                                            <img src="{{ asset('assets/frontend/img/fat.svg') }}"
                                                                 alt="Icon">
                                                            {{ $orderItemable->orderItemable->calories }}
                                                            <span>calories</span>
                                                        </div>
                                                        <div class="weekly-menu__info-item">
                                                            <img src="{{ asset('assets/frontend/img/calories.svg') }}"
                                                                 alt="Icon">
                                                            {{ $orderItemable->orderItemable->fats }}g
                                                            <span>fats</span>
                                                        </div>
                                                        <div class="weekly-menu__info-item">
                                                            <img src="{{ asset('assets/frontend/img/tree.svg') }}"
                                                                 alt="Icon">
                                                            {{ $orderItemable->orderItemable->carbs }}g
                                                            <span>carbs</span>
                                                        </div>
                                                        <div class="weekly-menu__info-item">
                                                            <img src="{{ asset('assets/frontend/img/fat-2.svg') }}"
                                                                 alt="Icon">
                                                            {{ $orderItemable->orderItemable->proteins }}g
                                                            <span>proteins</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="oredr-info-wrapper">
                    <div class="oredr-info-block">
                        <h2 class="section-title">
                            {{ $order->hasDeliveryOption() ? 'Delivery' : 'Pick-up' }}
                        </h2>
                        <div class="oredr-info-text">
                            <div class="oredr-info-text-icon">
                                <img src="{{ asset('assets/frontend/img/warning.svg') }}" alt="Warning icon">
                            </div>
                            <div>
                                @if($order->hasDeliveryOption())
                                    <p>
                                        Your order will be delivered on
                                        <span>{{ $order->delivery_date->format('l, F jS') }}</span> between
                                        <span>{{ $order->delivery_time_frame_value }}.</span>
                                    </p>
                                    <p>
                                        You will receive a message with confirmation a day prior to your delivery.
                                    </p>
                                @else
                                    <p>
                                        Your can pickup your order on
                                        <span>{{ $order->pickup_date->format('l, F jS') }}</span> between
                                        <span>{{ $order->pickup_time_frame_value }}.</span>
                                    </p>
                                    <p>
                                        You will receive a message with confirmation a day prior to your pickup.
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="oredr-info-contacts">
                            @if($order->hasPickupOption())
                                <div class="oredr-info-contacts-item">
                                    <h3>Address</h3>
                                    <p>{{ $order->pickup_location }}</p>
                                </div>
                            @endif
                            <div class="oredr-info-contacts-item">
                                <h3>Number</h3>
                                <a href="tel:{{ $supportPhoneNumber }}">{{ $supportPhoneNumber }}</a>
                            </div>
                            <div class="oredr-info-contacts-item">
                                <h3>Email</h3>
                                <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('frontend.orders.index', \App\Models\Order::STATUSES['upcoming']) }}"
                       class="btn btn-green">
                        {{getInscriptions('orders-see-history',request()->path(),'Go to my orders')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('mobile-popups')
    @include('frontend.layouts.partials.app.alerts.session-response-message', ['mobileView' => true])
@endsection

@section('popups')
    @include('frontend.layouts.partials.app.alerts.session-response-message', ['flash' => true])
@endsection

@push('js')
    <script src="{{ asset('assets/frontend/js/orders.js') }}"></script>
@endpush
