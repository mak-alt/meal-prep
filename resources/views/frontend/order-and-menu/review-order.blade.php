@extends('frontend.layouts.app')

@section('content')
    <div class="content right-sidebar">
        <div class="vegan-select-header">
            <div class="vegan-select-header__left">
                <a href="{{ route('frontend.order-and-menu.select-meals', $mealsAmount) }}" class="back">
                    <img src="{{ asset('assets/frontend/img/arrow-right-blue.svg') }}" alt="Arrow right icon">
                </a>
            </div>
            <div class="vegan-select-header__block">
                <div class="vegan-select-header__title">Review order</div>
            </div>
        </div>
        <div class="content_box--padding2">
            <div class="content_box_part">
                <ul class="weekly-menu review-items">
                    @foreach($selectedMeals->sortBy('meal_number') as $selectedMeal)
                        @php($selectedMealSides = $selectedSides->where('entry_meal', $selectedMeal)->where('meal_number', $selectedMeal->meal_number))

                        <li class="weekly-menu__item">
                            <span class="weekly-menu__item-before">Meal {{ $loop->iteration }}</span>
                            <a href="{{ route('frontend.order-and-menu.select-meals', $loop->iteration) }}">
                                <div class="weekly-menu__content">
                                    <h2 class="weekly-menu__title">{{ $selectedMeal->name }}</h2>
                                    <div class="weekly-menu__text">
                                        @foreach($selectedMealSides as $selectedSide)
                                            <p>
                                                <span>Side:</span> {{ $selectedSide->name }}
                                            </p>
                                        @endforeach
                                    </div>
                                    <div class="weekly-menu__info">
                                        <div class="weekly-menu__info-item">
                                            <img src="{{ asset('assets/frontend/img/fat.svg') }}" alt="Icon">
                                            {{ $selectedMeal->calories + $selectedMealSides->sum('calories') }}
                                            <span> calories</span>
                                        </div>
                                        <div class="weekly-menu__info-item">
                                            <img src="{{ asset('assets/frontend/img/calories.svg') }}" alt="Icon">
                                            {{ $selectedMeal->fats + $selectedMealSides->sum('fats') }}g
                                            <span> fats</span>
                                        </div>
                                        <div class="weekly-menu__info-item">
                                            <img src="{{ asset('assets/frontend/img/tree.svg') }}" alt="Icon">
                                            {{ $selectedMeal->carbs + $selectedMealSides->sum('carbs') }}g
                                            <span> carbs</span>
                                        </div>
                                        <div class="weekly-menu__info-item">
                                            <img src="{{ asset('assets/frontend/img/fat-2.svg') }}" alt="Icon">
                                            {{ $selectedMeal->proteins + $selectedMealSides->sum('proteins') }}g
                                            <span> proteins</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                    @if(!empty($selectedAddonsArray))
                        @foreach($selectedAddonsArray  as $addon)
                            <li class="weekly-menu__item">
                                <span class="weekly-menu__item-before">Addon {{ $loop->iteration }}</span>
                                <a href="{{ route('frontend.order-and-menu.addons.show', $loop->iteration) }}">
                                    <div class="weekly-menu__content">
                                        <h2 class="weekly-menu__title">{{ $addon[0]->name }}</h2>
                                        <div class="weekly-menu__text">
                                            @foreach($addon['meals'] as $meal)
                                                <p>
                                                    <span>Meal:</span> {{ $meal->name }}
                                                </p>
                                            @endforeach
                                        </div>
                                        <div class="weekly-menu__info">
                                            <div class="weekly-menu__info-item">
                                                <img src="{{ asset('assets/frontend/img/fat.svg') }}" alt="Icon">
                                                {{ $addon[1]['calories'] }}
                                                <span> calories</span>
                                            </div>
                                            <div class="weekly-menu__info-item">
                                                <img src="{{ asset('assets/frontend/img/calories.svg') }}" alt="Icon">
                                                {{ $addon[1]['fats'] }}g
                                                <span> fats</span>
                                            </div>
                                            <div class="weekly-menu__info-item">
                                                <img src="{{ asset('assets/frontend/img/tree.svg') }}" alt="Icon">
                                                {{ $addon[1]['carbs'] }}g
                                                <span> carbs</span>
                                            </div>
                                            <div class="weekly-menu__info-item">
                                                <img src="{{ asset('assets/frontend/img/fat-2.svg') }}" alt="Icon">
                                                {{ $addon[1]['proteins'] }}g
                                                <span> proteins</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="bottom-gradient"></div>
        </div>
        <div class="mobile-add-to-card double">
            <button type="button" id="wizard-next"
                    class="btn btn-green w-full"
                    data-action="add-to-cart"
                    data-before="1"
                    data-listener="{{ route('frontend.shopping-cart.store') }}">
                Checkout
                <img src="{{ asset('assets/frontend/img/cart-icon-white.svg') }}" alt="Shopping cart icon">
            </button>
            {{--<button type="button" id="wizard-next"
                    class="btn btn-green w-full"
                    data-action="add-to-cart"
                    data-before="1"
                    data-listener="{{ route('frontend.shopping-cart.index') }}">
                Return to Cart
                --}}{{--<img src="{{ asset('assets/frontend/img/cart-icon-white.svg') }}" alt="Shopping cart icon">--}}{{--
            </button>--}}
        </div>
		
		@include('frontend.layouts.partials.subscribe-left-aligned')

    </div>
    <div class="content_cart content_cart-fixed content_cart-breakfast content_cart-mobile-next-step">
        <div class="content_cart_top">
            <ul class="order-value mobile-order-value" style="display: block">
                <li class="order-value_title">Total order value</li>
                <li>
                    <img src="{{ asset('assets/frontend/img/cart-icon-1.svg') }}" alt="Icon">
                    <span id="order-calories" class="pr-3px">
                                {{ $shoppingCartOrders->sum('micronutrients_data.calories') }}
                            </span>
                    calories
                </li>
                <li>
                    <img src="{{ asset('assets/frontend/img/cart-icon-2.svg') }}" alt="Icon">
                    <span id="order-fats">
                                {{ $shoppingCartOrders->sum('micronutrients_data.fats') }}
                            </span>
                    g fats
                </li>
                <li>
                    <img src="{{ asset('assets/frontend/img/cart-icon-3.svg') }}" alt="Icon">
                    <span id="order-carbs">
                                {{ $shoppingCartOrders->sum('micronutrients_data.carbs') }}
                            </span>
                    g carbs
                </li>
                <li>
                    <img src="{{ asset('assets/frontend/img/cart-icon-4.svg') }}" alt="Icon">
                    <span id="order-proteins">
                                {{ $shoppingCartOrders->sum('micronutrients_data.proteins') }}
                            </span>
                    g proteins
                </li>
            </ul>
        </div>
        <div class="content_cart_bottom">
            <div class="cart_sum mt-16">
                <h3 class="cart_sum_total">
                    Order total:
                    <span>$</span>
                    <span class="meals-price">
                                {{ $totalPrice }}
                            </span>
                </h3>
                <h4 class="cart_sum_point">
                    +
                    <span class="points">
                            {{$totalPoints}}
                        </span>
                    points for this order
                </h4>
            </div>
            <div class="wizard-button-group">
                <button type="button" id="wizard-next"
                        class="btn btn-green w-full"
                        data-action="add-to-cart"
                        data-before="1"
                        data-listener="{{ route('frontend.shopping-cart.store') }}">
                    Checkout
                    <img src="{{ asset('assets/frontend/img/cart-icon-white.svg') }}" alt="Shopping cart icon">
                </button>
                <button type="button" id="wizard-next"
                        class="btn btn-green w-full"
                        data-action="add-to-cart"
                        data-before="1"
                        data-listener="{{ route('frontend.shopping-cart.index') }}">
                    Return to Cart
                </button>
            </div>
        </div>
    </div>
@endsection

@section('popups')
    @include('frontend.order-and-menu.partials.popups.start-over-meals-creation')
@endsection

@push('js')
    <script src="{{ asset('assets/frontend/js/order-and-menu-select-meals.js') }}"></script>
@endpush
