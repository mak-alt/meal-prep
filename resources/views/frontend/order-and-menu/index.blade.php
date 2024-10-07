@extends('frontend.layouts.app')

@php($contentClasses = 'order-menu-mobile')

@section('mobile-header')
    <div class="btn-back-to-home btn-back-to-home-inner" data-redirect="{{ route('frontend.landing.index') }}">
        <img src="{{ asset('assets/frontend/img/icon-arrow-left.svg') }}" alt="Arrow left icon">
        <span>Back to homepage</span>
    </div>
    <div class="mobile_top_notif success" style="display: none">
        <span class="response-text"></span>
    </div>
@endsection

@section('content')
    <div class="content right-sidebar">
        @include('frontend.order-and-menu.partials.content-header')
        <div class="content_box--padding-small content_box--order-menu">
            <div class="content_box_part">
                <h2 class="section-title mobile-display-none">
                    {{getInscriptions('selected-menu-title','order-and-menu/','Before adding to the cart, please review this week menu')}}
                </h2>
                <ul class="weekly-menu">
                    @foreach($meals as $meal)
                        @if($meal->status)
                            <li class="weekly-menu__item"
                                data-action="show-meal-details-popup"
                                data-show-add-btn="0" data-show-sides="1" data-menu-id="{{ $menu->id }}"
                                data-meal-id="{{ $meal->id }}"
                                data-listener="{{ route('frontend.order-and-menu.render-meal-details-popup', $meal->id) }}">
                                <span class="weekly-menu__item-before">Meal {{ $loop->iteration }}</span>
                                <a href=""
                                   class="weekly-menu__item-link">
                                    <div class="weekly-menu__img">
                                        <img src="{{ asset($meal->thumb) }}" alt="Meal photo">
                                    </div>
                                    <div class="weekly-menu__content">
                                        <h2 class="weekly-menu__title">{{ $meal->name }}</h2>
                                        @if(isset($meal->selected_sides) && is_array($meal->selected_sides) && !empty($meal->selected_sides))
                                            <div class="weekly-menu__text">
                                                @foreach($meal->selected_sides as $mealSide)
                                                    @php($side = \App\Models\Meal::find($mealSide))
                                                    @if($side->status)
                                                        <p>
                                                            <span>Side:</span> {{ $side->name }}
                                                        </p>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="weekly-menu__info">
                                            <div class="weekly-menu__info-item">
                                                <img src="{{ asset('assets/frontend/img/fat.svg') }}" alt="Icon">
                                                <span>
                                                    {{ $meal->calories }}
                                                    <span class="weekly-menu__info-item-title">calories</span>
                                                </span>
                                            </div>
                                            <div class="weekly-menu__info-item">
                                                <img src="{{ asset('assets/frontend/img/calories.svg') }}" alt="Icon">
                                                <span>
                                                    {{ $meal->fats }}g
                                                    <span class="weekly-menu__info-item-title">fats</span>
                                                </span>
                                            </div>
                                            <div class="weekly-menu__info-item">
                                                <img src="{{ asset('assets/frontend/img/tree.svg') }}" alt="Icon">
                                                <span>
                                                    {{ $meal->carbs }}g
                                                    <span class="weekly-menu__info-item-title">carbs</span>
                                                </span>
                                            </div>
                                            <div class="weekly-menu__info-item">
                                                <img src="{{ asset('assets/frontend/img/fat-2.svg') }}" alt="Icon">
                                                <span>
                                                    {{ $meal->proteins }}g
                                                    <span class="weekly-menu__info-item-title">proteins</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="bottom-gradient bottom-gradient-inner"></div>
        </div>
        @include('frontend.layouts.partials.subscribe-left-aligned')
        @include('frontend.layouts.partials.app.footer')
    </div>
    <div class="success-order-info success_order_info_in_content success">
        <span class="response-text"></span>
        <img src="{{ asset('assets/frontend/img/close-white.svg') }}" class="success-order-info__close"
             alt="Close icon"
             style="cursor: pointer;">
    </div>
    <div class="content_cart content_cart-fixed">
        <div class="content_cart__title">
            <a href="" class="btn-close-right-sidebar">
                <img src="{{ asset('assets/frontend/img/icon-arrow-left.svg') }}" alt="Arrow left icon">
                <span>{{getInscriptions('selected-menu-order-title','order-and-menu/','Your order')}}</span>
            </a>
        </div>
        <ul class="order-value">
            <li class="order-value_title">Calories in this menu</li>
            <li id="order-calories">
                <img src="{{ asset('assets/frontend/img/cart-icon-1.svg') }}" alt="Icon">
                <span>
                    {{ $mealsMicronutrientsData['calories'] + $selectedAddonsMicronutrientsData['calories'] }}
                </span>
                calories
            </li>
            <li id="order-fats">
                <img src="{{ asset('assets/frontend/img/cart-icon-2.svg') }}" alt="Icon">
                <span>
                    {{ $mealsMicronutrientsData['fats'] + $selectedAddonsMicronutrientsData['fats'] }}
                </span>
                g fats
            </li>
            <li id="order-carbs">
                <img src="{{ asset('assets/frontend/img/cart-icon-3.svg') }}" alt="Icon">
                <span>
                    {{ $mealsMicronutrientsData['carbs'] + $selectedAddonsMicronutrientsData['carbs'] }}
                </span>
                g carbs
            </li>
            <li id="order-proteins">
                <img src="{{ asset('assets/frontend/img/cart-icon-4.svg') }}" alt="Icon">
                <span>
                    {{ $mealsMicronutrientsData['proteins'] + $selectedAddonsMicronutrientsData['proteins'] }}
                </span>
                g proteins
            </li>
        </ul>
        <div class="content_cart__block mt-16" id="portion-selection-block"
             style="{{ count($portionSizes) < 1 ? 'display: none;' : '' }}">
            <div class="content_cart__block-title">Increase portion sizes</div>
            <ul class="portions flex">
                @foreach($portionSizes as $portionSize)
                    <li data-size="{{ $portionSize['size'] }}">
                        <a href=""
                           class="btn {{ $portionSize['size'] === $selectedPortionSize['size'] ? 'btn-green' : 'btn-white' }}"
                           data-action="select-portion-size"
                           data-listener="{{ route('frontend.order-and-menu.meal-creation.select-portion-size-menu', $category->id) }}"
                           data-size="{{ $portionSize['size'] }}"
                           data-percentage="{{ $portionSize['percentage'] }}">
                            {{ $portionSize['size'] }}oz
                        </a>
                        <span
                            class="{{ $portionSize['size'] === $selectedPortionSize['size'] ? 'active' : '' }}">
                            $<span>{{ calculatePercentageValueFromNumber($portionSize['percentage'], $totalPriceWithoutPortionSize) }}</span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
        @isset(optional(optional($menu)->category)->addons)
            @if(!optional(optional($menu)->category)->addons->isEmpty())
                <div class="content_cart__block mt-16">
                    <div class="content_cart__block-title">Add-ons</div>
                    <ul id="addons-list">
                        @foreach(optional(optional($menu)->category)->addons ?? [] as $addon)
                            <li class="add-ons__item flex {{ $selectedAddons->contains('id', $addon->id) ? 'active' : '' }}"
                                data-redirect="{{ route('frontend.order-and-menu.addons.show', $addon->id) }}">
                                    <span class="add-ons__item-img-wrapper">
                                        <img src="{{ asset('assets/frontend/img/icon-cherry.svg') }}"
                                             alt="Icon">
                                    </span>
                                <div class="add-ons__item-details">
                                    <span class="add-ons__item-details-title">Add {{ $addon->name }}</span>
                                    @if($selectedAddons->contains('id', $addon->id))
                                        <span>
                                            <span class="add-ons__item-details-item">
                                                +{{ $selectedAddonMeals->where('pivot.addon_id', $addon->id)->sum('pivot.points') }} points
                                            </span>
                                            <span class="add-ons__item-details-item">
                                                +${{ $selectedAddonMeals->where('pivot.addon_id', $addon->id)->sum('pivot.price') }}
                                            </span>
                                        </span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endisset
        <div class="content_cart_bottom">
            <div class="cart_sum">
                <h3 class="cart_sum_total">
                    Menu total:
                    <span>$</span>
                    <span class="meals-price">
                        {{ $totalPrice }}
                    </span>
                </h3>
                <h4 class="cart_sum_point">
                    +
                    <span class="points">
                        {{ $totalPoints }}
                    </span>
                    points for this order
                </h4>
            </div>
            @isset($menu)
                <button type="button" class="btn btn_transparent mb-6" id="duplicate-menu"
                        data-listener="{{ route('frontend.order-and-menu.menu.duplicate', $menu->id) }}">
                    {{getInscriptions('select-menu-duplicate','order-and-menu/','Duplicate')}}
                </button>
            @endisset
            <button id="wizard-next" type="button" class="btn {{ $menu ? 'btn-green' : 'btn_disabled' }}"
                    data-action="add-to-cart"
                    data-before="1"
                    data-listener="{{ route('frontend.shopping-cart.store') }}">
                Checkout
                <img src="{{ asset('assets/frontend/img/cart-icon-white.svg') }}" alt="Arrow right icon">
            </button>
        </div>
    </div>
@endsection

@section('popups')
    @include('frontend.order-and-menu.partials.popups.meal-details', ['empty' => true])
    @include('frontend.landing.partials.popups.login', ['redirectUrl' => url()->current()])
    @include('frontend.landing.partials.popups.register', ['redirectUrl' => url()->current()])
    @include('frontend.landing.partials.popups.forgot-password')
@endsection

@section('footer')
    @if($menu)
        <div class="mobile-add-to-card">
            <a href="" class="btn-open-right-sidebar">
                {{getInscriptions('selected-menu-add-to-cart-mobile','order-and-menu/','Add to cart')}}
                {{--<span class="button-prise-mobile">
                    $
                    <span>
                        {{ optional($menu)->price ?? $meals->sum('price') + $selectedAddonMeals->sum('pivot.price') }}
                    </span>
                </span>--}}
            </a>
        </div>
    @endif
@endsection

@push('js')
    <script src="{{ asset('assets/frontend/js/order-and-menu-index.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/landing.js') }}"></script>
@endpush
