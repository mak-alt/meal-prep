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
        @include('frontend.layouts.partials.app.checkout-steps.content-header')
        <div class="ovh-x">
            <div class="wizard-body">
                <div class="step active">
                    <form action="{{ route('frontend.checkout.store') }}" method="POST" id="checkout-form">
                        @csrf
                        <div class="content_main content_main_checkout max_w-100percent">
                            <div class="content_box">

                                <div class="content_box_part_inner">
                                    <h2 class="section-title">
                                        {{ $page->data['delivery_and_pickup_timing']['title'] }}
                                    </h2>
                                    <div class="box_part_text_wrapp">
                                        @foreach($page->data['delivery_and_pickup_timing']['items'] as $time)
                                            <div class="box_part_text_item">
                                                <h2 class="section-title">{{ $time['title'] }}</h2>
                                                {!! $time['description'] !!}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="content_box_part">
                                    <div class="tabs">
                                        <ul class="tabs-nav mb15">
                                            <li class="delivery_tab">
                                                <a href="#tab1"
                                                   class="{{ !empty($checkoutData['pickup_location']) ? '' : 'active' }}"
                                                   data-listener="{{ route('frontend.checkout.calculate-total-price') }}">
                                                    @php(include 'assets/frontend/img/tab-delivery.svg')
                                                    {{getInscriptions('checkout-delivery-tab',request()->path(),'Delivery')}}
                                                </a>
                                            </li>
                                            @if(!empty($deliveryPickupLocationData['pickup_locations']['items']))
                                                <li>
                                                    <a href="#tab2"
                                                       class="{{ !empty($checkoutData['pickup_location']) ? 'active' : '' }}"
                                                       data-listener="{{ route('frontend.checkout.calculate-total-price') }}">
                                                        @php(include 'assets/frontend/img/tab-pick.svg')
                                                        {{getInscriptions('checkout-pickup-tab',request()->path(),'Pickup')}}
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                        <div class="tabs-items">
                                            <div id="tab1" class="tabs-item"
                                                 style="{{ empty($checkoutData['pickup_location']) ? '' : 'display: none;' }}">
                                                <div class="content_box_part">
                                                    <h2 class="content_box_title">{{getInscriptions('checkout-delivery-frame',request()->path(),'Select preferred delivery time')}}</h2>
                                                    <div class="box_part_wrapper mb50">
                                                        <div class="box_part_item">
                                                            <fieldset class="fieldset">
                                                                <label class="fieldset_sub_label" for="delivery-date">
                                                                    Delivery date<span>*</span>
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <input type="text" class="input input-delivery"
                                                                           id="delivery-date" name="delivery_date"
                                                                           value="{{ $closestDay }}"
                                                                           placeholder="MM/DD/YYYY"
                                                                           required
                                                                           autocomplete="off">
                                                                    @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_date'])
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="box_part_item">
                                                            <fieldset class="fieldset">
                                                                <label class="fieldset_sub_label" for="boxes_to_open">
                                                                    Time frame<span>*</span>
                                                                </label>
                                                                <input type="hidden" name="delivery_time_frame"
                                                                       value="{{ $checkoutData['delivery_time_frame'] ?? '' }}"
                                                                       required>
                                                                <div class="select-wrap input-wrapper">
                                                                    <div class="custom-select">
                                                                        <button name="boxes_to_open" id="boxes_to_open"
                                                                                class="boxes-select">
                                                                            {{ !empty($checkoutData['delivery_time_frame']) ? $checkoutData['delivery_time_frame'] : '' }}
                                                                        </button>
                                                                        <ul class="select_pag delivery_times">
                                                                            @foreach($deliveryTime as $key => $value)
                                                                                <li>
                                                                                    <a href=""
                                                                                       class="{{ !empty($checkoutData['delivery_time_frame']) && $checkoutData['delivery_time_frame'] === $value['since'] . ' - ' . $value['until'] ? 'active' : '' }}"
                                                                                       data-action="select-time-frame"
                                                                                       data-value="{{ $key }}">
                                                                                        {{ $value['since'] . '-' . $value['until'] }}
                                                                                    </a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                    @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_time_frame'])
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <h2 class="content_box_title">{{getInscriptions('checkout-set-address',request()->path(),'Specify your delivery address')}}</h2>
                                                    <div id="delivery-address-wrapper">
                                                        <div class="box_part_wrapper">
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label" for="country">
                                                                        Country / Region</label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" name="delivery_country"
                                                                               class="input"
                                                                               id="country"
                                                                               autocomplete="country-name"
                                                                               value="{{ optional($user->profile)->delivery_country ?? 'United States (US)' }}"
                                                                               required readonly>
                                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_country'])
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label"
                                                                           for="street-address">
                                                                        Street address<span>*</span>
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" id="street-address"
                                                                               name="delivery_street_address"
                                                                               class="input"
                                                                               autocomplete="street-address"
                                                                               value="{{ $checkoutData['delivery_street_address'] ?? optional($user->profile)->delivery_street_address }}"
                                                                               required>
                                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_street_address'])
                                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <div class="box_part_wrapper">
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label"
                                                                           for="street-address-opt">
                                                                        Apartment, suite, etc.
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" id="street-address-opt"
                                                                               name="delivery_address_opt"
                                                                               class="input"
                                                                               autocomplete="street-address-opt"
                                                                               value="{{ $checkoutData['delivery_address_opt'] ?? optional($user->profile)->delivery_address_opt }}">
                                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_address_opt'])
                                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label" for="city">
                                                                        Town / City<span>*</span>
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" id="city"
                                                                               name="delivery_city"
                                                                               class="input"
                                                                               autocomplete="address-level2"
                                                                               value="{{ $checkoutData['delivery_city'] ?? optional($user->profile)->delivery_city }}"
                                                                               required>
                                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_city'])
                                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <div class="box_part_wrapper">
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label" for="zip">
                                                                        ZIP<span>*</span>
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" id="zip" name="delivery_zip"
                                                                               class="input"
                                                                               autocomplete="postal-code"
                                                                               value="{{ $checkoutData['delivery_zip'] ?? optional($user->profile)->delivery_zip }}"
                                                                               required>
                                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_zip'])
                                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label" for="delivery_state">
                                                                        State<span>*</span>
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <select class="input" name="delivery_state" required>
                                                                            <option selected disabled>Select a state</option>
                                                                            @foreach($states as $state)
                                                                                <option value="{{$state}}" {{optional($user->profile)->delivery_state === $state ? 'selected' : ''}}>{{$state}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_state'])
                                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <div class="box_part_wrapper">
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label" for="company">
                                                                        Company (optional)
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" id="company"
                                                                               name="delivery_company_name"
                                                                               class="input"
                                                                               autocomplete="organization"
                                                                               value="{{ $checkoutData['delivery_company_name'] ?? optional($user->profile)->delivery_company_name }}">
                                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_company_name'])
                                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label"
                                                                           for="phone-number">
                                                                        Phone number<span>*</span>
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text"
                                                                               class="input input phone-number__mask"
                                                                               id="phone-number"
                                                                               name="delivery_phone_number"
                                                                               autocomplete="tel-local"
                                                                               value="{{ $checkoutData['delivery_phone_number'] ?? optional($user->profile)->delivery_phone_number }}">
                                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_phone_number'])
                                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <div class="box_part_wrapper">
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label"
                                                                           for="order-notes">
                                                                        Order notes
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" class="input"
                                                                               id="order-notes"
                                                                               name="delivery_order_notes"
                                                                               value="{{ $checkoutData['delivery_order_notes'] ?? '' }}"
                                                                               maxlength="255">
                                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_order_notes'])
                                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <div class="box_part_wrapper">
                                                            <div class="box_part_item full">
                                                                <div class="module_check_wrapper">
                                                                    <div class="module__check">
                                                                        <input type="checkbox"
                                                                               name="use_billing_as_delivery"
                                                                               id="use-billing-as-delivery">
                                                                        <span class="check"></span>
                                                                        <label class="text"
                                                                               for="use-billing-as-delivery">
                                                                            Use this address as my billing address
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!empty($deliveryPickupLocationData['pickup_locations']['items']))
                                                <div id="tab2" class="tabs-item"
                                                     style="{{ !empty($checkoutData['pickup_location']) ? '' : 'display: none;' }}">
                                                    <h2 class="section-title">{{getInscriptions('checkout-set-pickup-location',request()->path(),'Select pickup location')}}</h2>
                                                    <div class="location-info-wrapper">
                                                        <div class="location-info-buttons pickup">
                                                            @foreach($deliveryPickupLocationData['pickup_locations']['items'] as $pickupLocation)
                                                                <a href="#{{ strtolower($pickupLocation['name']) }}"
                                                                   class="{{ $loop->first ? 'active' : '' }}"
                                                                   data-pickup-location="{{ $pickupLocation['address'] }}">
                                                                    {{ ucfirst($pickupLocation['name']) }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                        @foreach($deliveryPickupLocationData['pickup_locations']['items'] as $pickupLocation)
                                                            <div
                                                                class="location-info-block {{ $loop->first ? 'active' : '' }}"
                                                                id="{{ strtolower($pickupLocation['name']) }}">
                                                                <p>
                                                                    <img
                                                                        src="{{ asset('assets/frontend/img/Location.svg') }}"
                                                                        alt="Location icon">
                                                                    {{ $pickupLocation['address'] }}
                                                                </p>
                                                                <iframe
                                                                    src="https://maps.google.com/maps?hl=en&amp;q={{ urlencode($pickupLocation['address']) }}&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                                                                    height="450" allowfullscreen
                                                                    loading="lazy" style="border: 0;"></iframe>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <h2 class="content_box_title">{{getInscriptions('checkout-pickup-frame',request()->path(),'Select preferred pickup time')}}</h2>
                                                    <div class="box_part_wrapper mb50">
                                                        <div class="box_part_item">
                                                            <fieldset class="fieldset">
                                                                <label class="fieldset_sub_label" for="delivery-date">
                                                                    Pickup date<span>*</span>
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <input type="text" class="input input-delivery"
                                                                           id="pickup-date" name="pickup_date"
                                                                           value="{{ $closestDay }}"
                                                                           placeholder="MM/DD/YYYY"
                                                                           required>
                                                                    @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'pickup_date'])
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="box_part_item">
                                                            <fieldset class="fieldset">
                                                                <label class="fieldset_sub_label" for="boxes_to_open_1">
                                                                    Time frame<span>*</span>
                                                                </label>
                                                                <input type="hidden" name="pickup_time_frame"
                                                                       value="{{ $checkoutData['pickup_time_frame'] ?? '' }}"
                                                                       required>
                                                                <div class="select-wrap input-wrapper">
                                                                    <div class="custom-select">
                                                                        <button name="boxes_to_open"
                                                                                id="boxes_to_open_1"
                                                                                class="boxes-select">
                                                                            {{ !empty($checkoutData['pickup_time_frame']) ? $checkoutData['pickup_time_frame'] : '' }}
                                                                        </button>
                                                                        <ul class="select_pag decatur">
                                                                            @foreach($pickupTime as $key => $value)
                                                                                <li>
                                                                                    <a href=""
                                                                                       class="{{ !empty($checkoutData['pickup_time_frame']) && $checkoutData['pickup_time_frame'] === $key ? 'active' : '' }}"
                                                                                       data-action="select-time-frame"
                                                                                       data-value="{{ $key }}">
                                                                                        {{ $value['since'] . '-' . $value['until'] }}
                                                                                    </a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                        <ul class="select_pag brookhaven" style="display: none;">
                                                                            @foreach($pickupTimeB as $key => $value)
                                                                                <li>
                                                                                    <a href=""
                                                                                       class="{{ !empty($checkoutData['pickup_time_frame']) && $checkoutData['pickup_time_frame'] === $key ? 'active' : '' }}"
                                                                                       data-action="select-time-frame"
                                                                                       data-value="{{ $key }}">
                                                                                        {{ $value['since'] . '-' . $value['until'] }}
                                                                                    </a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                    @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'pickup_time_frame'])
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="content_box_part">
                                    <h2 class="content_box_title">{{getInscriptions('checkout-set-billing-address',request()->path(),'Specify your billing address')}}</h2>
                                    <div id="delivery-address-wrapper">
                                        <div class="box_part_wrapper">
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label" for="country">
                                                        Country / Region</label>
                                                    <div class="input-wrapper">
                                                        <input type="text" name="billing_country"
                                                               class="input"
                                                               id="country"
                                                               autocomplete="country-name"
                                                               value="{{ optional($user->profile)->billing_country ?? 'United States (US)' }}"
                                                               required readonly>
                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_country'])
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label"
                                                           for="street-address">
                                                        Street address<span>*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text" id="street-address"
                                                               name="billing_street_address"
                                                               class="input"
                                                               autocomplete="street-address"
                                                               value="{{ $checkoutData['billing_street_address'] ?? optional($user->profile)->billing_street_address }}"
                                                               required>
                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_street_address'])
                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="box_part_wrapper">
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label"
                                                           for="street-address-opt">
                                                        Apartment, suite, etc.
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text" id="street-address-opt"
                                                               name="billing_address_opt"
                                                               class="input"
                                                               autocomplete="street-address-opt"
                                                               value="{{ $checkoutData['billing_address_opt'] ?? optional($user->profile)->billing_address_opt }}">
                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_address_opt'])
                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label" for="city">
                                                        Town / City<span>*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text" id="city"
                                                               name="billing_city"
                                                               class="input"
                                                               autocomplete="address-level2"
                                                               value="{{ $checkoutData['billing_city'] ?? optional($user->profile)->billing_city }}"
                                                               required>
                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_city'])
                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="box_part_wrapper">
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label" for="zip">
                                                        ZIP<span>*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text" id="zip" name="billing_zip"
                                                               class="input"
                                                               autocomplete="postal-code"
                                                               value="{{ $checkoutData['billing_zip'] ?? optional($user->profile)->billing_zip }}"
                                                               required>
                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_zip'])
                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label" for="billing-state">
                                                        State<span>*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <select class="input" name="billing_state" id="billing-state" required>
                                                            <option selected disabled>Select a state</option>
                                                            @foreach($states as $state)
                                                                <option value="{{$state}}" {{optional($user->profile)->billing_state === $state ? 'selected' : ''}}>{{$state}}</option>
                                                            @endforeach
                                                        </select>
                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_state'])
                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="box_part_wrapper">
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label" for="company">
                                                        Company (optional)
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text" id="company"
                                                               name="billing_company_name"
                                                               class="input"
                                                               autocomplete="organization"
                                                               value="{{ $checkoutData['billing_company_name'] ?? optional($user->profile)->billing_company_name }}">
                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_company_name'])
                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label"
                                                           for="phone-number">
                                                        Phone number<span>*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text"
                                                               class="input input phone-number__mask"
                                                               id="phone-number"
                                                               name="billing_phone_number"
                                                               autocomplete="tel-local"
                                                               value="{{ $checkoutData['billing_phone_number'] ?? optional($user->profile)->billing_phone_number }}">
                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_phone_number'])
                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="box_part_wrapper">
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label" for="billing-email">
                                                        Email address<span>*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="email" id="billing-email" name="billing_email_address"
                                                               class="input"
                                                               autocomplete="email"
                                                               value="{{ optional($user->profile)->billing_email_address ?? $user->email }}" required>
                                                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_email_address'])
                                                        @include('frontend.layouts.partials.app.icons.clear-input')
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="box_part_wrapper">
                                            <div class="box_part_item full">
                                                <div class="module_check_wrapper">
                                                    <div class="module__check">
                                                        <input type="checkbox"
                                                               name="send_updates_and_promotions"
                                                               id="send-updates-and-promotions" {{ !empty($checkoutData['send_updates_and_promotions']) ? 'checked' : '' }}>
                                                        <span class="check"></span>
                                                        <label class="text"
                                                               for="send-updates-and-promotions">
                                                            Send me updates about products & promotions
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="content_box_part hide-payment-info">
                                    <div class="checkout_list_coupon box_part_item mb-15"
                                        style="{{ $totalPriceWithDiscounts < 0 ? 'display: none;' : '' }}">
                                        <div id="coupon" class="row-checkout center">
                                            <div class="input-wrapper80">
                                                <input type="text" name="coupon" class="input" placeholder="Your coupon">
                                                <div class="mb-15">
                                                    @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'coupon_code'])
                                                </div>
                                            </div>
                                            <a href="{{ route('frontend.checkout.coupon.apply') }}"
                                               class="btn btn-green button-coupon"
                                               data-action="apply-coupon">
                                                {{getInscriptions('checkout-coupon-apply',request()->path(),'Apply')}}
                                            </a>
                                        </div>
                                    </div>
                                    <h2 class="content_box_title" style="display: none;">{{getInscriptions('checkout-select-payment-method',request()->path(),'Select preferred payment method ')}}</h2>
                                    <div class="tabs" style="display: none;">
                                        <ul class="tabs-nav pay mb15">
                                            <li>
                                                <a href="#tab1-2" class="active">
                                                    @php(include 'assets/frontend/img/tab-pp.svg')
                                                    <span>{{getInscriptions('checkout-paypal-tab',request()->path(),'Pay with PayPal')}}</span>
                                                    <span class="tabs-nav_mob">{{getInscriptions('checkout-paypal-tab-mobile',request()->path(),'PayPal')}}</span>
                                                </a>
                                            </li>
                                            {{--<li>
                                                <a href="#tab1-1">
                                                    @php(include 'assets/frontend/img/tab-cart.svg')
                                                    <span>{{getInscriptions('checkout-card-tab',request()->path(),'Pay with card')}}</span>
                                                    <span class="tabs-nav_mob">{{getInscriptions('checkout-card-tab-mobile',request()->path(),'Card')}}</span>
                                                </a>
                                            </li>--}}
                                        </ul>
                                        <input type="hidden" name="is_within_perimeter_of_i_285" value=false>
                                        <div class="tabs-items cc-margin">
                                            <div id="tab1-1" class="tabs-item">
                                                <div class="content_box_part">
                                                    <div class="box_part_wrapper">
                                                        <div class="card-info">
                                                            <div id="user-cards"
                                                                 style="{{ $user->paymentProfiles->isEmpty() ? 'display: none;' : '' }}">
                                                                @foreach($user->paymentProfiles->sortBy('created_at') as $paymentProfile)
                                                                    <div class="card-info_top mb15" id="stored-cards">
                                                                        <fieldset class="fieldset">
                                                                            @if($loop->first)
                                                                                <label class="fieldset_sub_label">
                                                                                    Primary payment method
                                                                                </label>
                                                                            @endif
                                                                            <input type="hidden"
                                                                                   name="payment_profile_id"
                                                                                   value="{{ $paymentProfile->id }}"
                                                                                {{ $loop->first ? '' : 'disabled' }}>
                                                                            <input type="text"
                                                                                   class="input cursor-pointer {{ $loop->first ? 'input-card__selected' : '' }}"
                                                                                   value="{{ '•••• •••• •••• ' . substr($paymentProfile->card_number, -4) }}"
                                                                                   readonly>
                                                                        </fieldset>
                                                                    </div>
                                                                @endforeach
                                                                <div class="card-info_bottom">
                                                                    <button type="button" class="btn btn_transparent"
                                                                            data-action="use-another-card">
                                                                        Use another card
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            {{--<div
                                                                id="use-another-card"
                                                                style="{{ $user->paymentProfiles->isNotEmpty() ? 'display: none;' : '' }}">
                                                                <div class="card-info_top">
                                                                    <fieldset class="fieldset">
                                                                        <label class="fieldset_sub_label"
                                                                               for="name_on_card">
                                                                            Credit Card Name<span>*</span>
                                                                        </label>
                                                                        <div class="input-wrapper">
                                                                            <input type="text"
                                                                                   name="name_on_card"
                                                                                   class="input"
                                                                                   placeholder="John Doe"
                                                                                   required>
                                                                            @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'name_on_card'])
                                                                            @include('frontend.layouts.partials.app.icons.clear-input')
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset class="fieldset">
                                                                        <label class="fieldset_sub_label"
                                                                               for="card-number">
                                                                            Card Number<span>*</span>
                                                                        </label>
                                                                        <div class="input-wrapper">
                                                                            <input type="text"
                                                                                   name="card_number"
                                                                                   class="input card-number__mask"
                                                                                   id="card-number"
                                                                                   placeholder="•••• •••• •••• ••••"
                                                                                   autocomplete="cc-number" required>
                                                                            @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'card_number'])
                                                                            @include('frontend.layouts.partials.app.icons.clear-input')
                                                                        </div>
                                                                        <div class="pay">
                                                                            <div class="pay_item">
                                                                                <img
                                                                                    src="{{ asset('assets/frontend/img/pay-1.svg') }}"
                                                                                    alt="Payment option icon">
                                                                            </div>
                                                                            <div class="pay_item">
                                                                                <img
                                                                                    src="{{ asset('assets/frontend/img/pay-2.svg') }}"
                                                                                    alt="Payment option icon">
                                                                            </div>
                                                                            <div class="pay_item">
                                                                                <img
                                                                                    src="{{ asset('assets/frontend/img/pay-3.svg') }}"
                                                                                    alt="Payment option icon">
                                                                            </div>
                                                                            <div class="pay_item">
                                                                                <img
                                                                                    src="{{ asset('assets/frontend/img/pay-4.svg') }}"
                                                                                    alt="Payment option icon">
                                                                            </div>
                                                                            <div class="pay_item">
                                                                                <img
                                                                                    src="{{ asset('assets/frontend/img/pay-5.svg') }}"
                                                                                    alt="Payment option icon">
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="card-info_bottom">
                                                                    <div class="card-info_bottom_item">
                                                                        <div class="input-wrapper">
                                                                            <fieldset class="fieldset">
                                                                                <label class="fieldset_sub_label"
                                                                                       for="card-expiration">
                                                                                    Expiration<span>*</span>
                                                                                </label>
                                                                                <input type="text" id="card-expiration"
                                                                                       name="expiration"
                                                                                       class="input card-expiration__mask"
                                                                                       placeholder="MM/YY"
                                                                                       autocomplete="cc-exp" required>
                                                                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'expiration'])
                                                                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'expiration_month'])
                                                                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'expiration_year'])
                                                                            </fieldset>
                                                                        </div>
                                                                        <div class="input-wrapper">
                                                                            <fieldset class="fieldset">
                                                                                <label class="fieldset_sub_label"
                                                                                       for="csc">
                                                                                    Security Code<span>*</span>
                                                                                </label>
                                                                                <input type="password"
                                                                                       name="csc"
                                                                                       class="input card-csc__mask"
                                                                                       id="csc"
                                                                                       autocomplete="cc-csc"
                                                                                       placeholder="CVV" required>
                                                                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'csc'])
                                                                            </fieldset>
                                                                        </div>
                                                                    </div>
                                                                    --}}{{--<div class="module_check_wrapper">
                                                                        <div class="module__check">
                                                                            <input type="checkbox"
                                                                                   name="securely_save_to_account"
                                                                                   id="securely-store-to-account">
                                                                            <span class="check"></span>
                                                                            <label class="text"
                                                                                   for="securely-store-to-account">
                                                                                Securely Save to Account
                                                                            </label>
                                                                        </div>
                                                                    </div>--}}{{--
                                                                </div>
                                                            </div>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="tab1-2" class="tabs-item">
                                                <p class="failed-pay">
                                                    After placing your order you'll be redirected to the PayPal payment
                                                    flow
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="content_cart_bottom cart_bottom_checkout desktop-only" style="width: 320px">
                                    <a href="" class="btn btn_disabled btn_checkout">{{getInscriptions('checkout-place-order',request()->path(),'Place order')}}</a>
                                    {{--
                                    <div class="paypal-checkout__wrapper">
                                        <a href="" class="btn btn_disabled btn_checkout">{{getInscriptions('checkout-place-order-paypal',request()->path(),'Place order')}}</a>
                                        <div id="paypal-checkout"></div>
                                    </div>
                                    --}}
                                </div>
                            </div>
                            <div class="content_cart_checkout content_cart content_cart-fixed sticky min_w-320">
                                <a href="" class="btn-close-right-sidebar">
                                    <img src="{{ asset('assets/frontend/img/icon-arrow-left.svg') }}"
                                         alt="Arrow left icon">
                                    <span>{{getInscriptions('checkout-order-summary-title-mobile',request()->path(),'Order summary')}}</span>
                                </a>
                                <div class="content_cart_checkout_inner">
                                    <h3 class="">{{getInscriptions('checkout-order-summary-title',request()->path(),'Order summary')}}</h3>
                                    <ul class="checkout_list">
                                        @foreach($shoppingCartOrders as $uuid => $shoppingCartOrder)
                                            <li>
                                                <div class="checkout_list_item">
                                                    <div class="checkout_list_title">
                                                        <span class="title">
                                                            {{ $shoppingCartOrder['menu'] ? $shoppingCartOrder['menu']->name : 'Custom meal plan' }}
                                                        </span>
                                                        <span>{{ $shoppingCartOrder['meals_amount'] ?? '' }} meals</span>
                                                    </div>
                                                    <span class="checkout_list_price">
                                                        ${{ $shoppingCartOrder['total_price'] }}
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                        <li class="checkout_list_delivery price-block" id="delivery-price-block"
                                            style="{{ $deliveryFees !== null ? '' : 'display: none;' }}">
                                            <div class="checkout_list_item">
                                                <div class="checkout_list_title">
                                                    Delivery
                                                </div>
                                                <span class="checkout_list_price">
                                                    $<span>{{ $deliveryFees }}</span>
                                                </span>
                                            </div>
                                        </li>
                                        @if($applicablePointsDiscount)
                                            <li class="checkout_list_delivery">
                                                <div class="checkout_list_item">
                                                    <div class="checkout_list_title">
                                                        Points discount
                                                    </div>
                                                    <span class="checkout_list_price">
                                                        - $<span>{{ $applicablePointsDiscount }}</span>
                                                    </span>
                                                </div>
                                            </li>
                                        @endif
                                        @if($applicableGiftsDiscount)
                                            <li class="checkout_list_delivery">
                                                <div class="checkout_list_item">
                                                    <div class="checkout_list_title">
                                                        Gift certificate discount
                                                    </div>
                                                    <span class="checkout_list_price">
                                                        - $<span>{{ $applicableGiftsDiscount }}</span>
                                                    </span>
                                                </div>
                                            </li>
                                        @endif
                                        @if($referralFirstOrderDiscount)
                                            <li class="checkout_list_delivery">
                                                <div class="checkout_list_item">
                                                    <div class="checkout_list_title">
                                                        Referral user discount
                                                    </div>
                                                    <span class="checkout_list_price">
                                                        - $<span>{{ $referralFirstOrderDiscount }}</span>
                                                    </span>
                                                </div>
                                            </li>
                                        @endif
                                        @if($applicableReferralInviterDiscount)
                                            <li class="checkout_list_delivery">
                                                <div class="checkout_list_item">
                                                    <div class="checkout_list_title">
                                                        Referral inviter discount
                                                    </div>
                                                    <span class="checkout_list_price">
                                                        - $<span>{{ $applicableReferralInviterDiscount }}</span>
                                                    </span>
                                                </div>
                                            </li>
                                        @endif
                                        <li class="checkout_list_delivery applied-coupon" style="display: none;">
                                            <div class="checkout_list_item">
                                                <input type="hidden" name="coupon_id" value="">
                                                <div class="checkout_list_title"></div>
                                                <span class="checkout_list_price coupon__right-section">
                                                    <div>
                                                        <span class="span-for-discount"></span>
                                                        <span class="coupon-discount"></span>
                                                    </div>
                                                    <span>
                                                        <a href="{{ route('frontend.checkout.coupon.remove') }}"
                                                           data-action="remove-coupon">
                                                            Delete
                                                        </a>
                                                    </span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="checkout_list_total">
                                            <h4>
                                                Total: $<span class="total-price">{{ $totalPriceWithDiscounts }}</span>
                                            </h4>
                                        </li>
                                    </ul>

                                    <div id="map"></div>

                                    <div class="checkout_sum">
                                        <h4>
                                            Total: $<span class="total-price">{{ $totalPriceWithDiscounts }}</span>
                                        </h4>
                                    </div>
                                </div>
								{{--
                                <div class="content_cart_bottom cart_bottom_checkout">
                                    <a href="" class="btn btn_disabled btn_checkout">{{getInscriptions('checkout-place-order',request()->path(),'Place order')}}</a>
                                    <div class="paypal-checkout__wrapper">
                                        <a href="" class="btn btn_disabled btn_checkout">{{getInscriptions('checkout-place-order-paypal',request()->path(),'Place order')}}</a>
                                        <div id="paypal-checkout"></div>
                                    </div>
                                </div>
								--}}
                            </div>
                        </div>
                    </form>
                    <div class="mobile-add-to-card double">
                        <a href="" class="btn btn_transparent summary-popup-button">{{getInscriptions('checkout-summary-button',request()->path(),'Summary')}}</a>
                        <a href="" class="btn btn_disabled btn_checkout">{{getInscriptions('checkout-place-order-mobile',request()->path(),'Place order')}}</a>
                        <div class="paypal-checkout__wrapper">
                            <a href="" class="btn btn_disabled btn_checkout">{{getInscriptions('checkout-place-order-paypal-mobile',request()->path(),'Place order')}}</a>
                            <div id="paypal-checkout-mobile"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('mobile-popups')
    @if(session()->has('response-message'))
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['mobileView' => true])
    @else
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['mobileView' => true, 'fromFrontendResponse' => true])
    @endif
    @include('frontend.checkout.summary-popup')
@endsection

@section('popups')
    @if(session()->has('response-message'))
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['flash' => true])
    @else
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['flash' => true, 'fromFrontendResponse' => true])
    @endif
@endsection

@push('js')
    <script>
        let timeframesLink = '{{route('frontend.checkout.timeframes')}}';
    </script>
    <script
        src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID') }}&disable-funding=credit,card"
        data-namespace="paypalSdk"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=geometry"></script>

    <script src="{{ asset('assets/frontend/js/checkout.js') }}"></script>

@endpush
