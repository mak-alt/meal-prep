@extends('frontend.layouts.app')

@section('content')
    <div class="content right-sidebar">
        <div class="vegan-select-header">
            <div class="vegan-select-header__left">
                <a href="{{ empty($categoryId) ? route('frontend.order-and-menu.select-meals', session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection'])) : route('frontend.order-and-menu.index', $categories->where('id', $categoryId)->first()->name) }}"
                   class="back">
                    <img src="{{ asset('assets/frontend/img/arrow-right-blue.svg') }}" alt="Arrow right icon">
                </a>
            </div>
            <div class="vegan-select-header__block">
                <img src="{{ asset('assets/frontend/img/Yes.svg') }}" class="vegan-check-icon" alt="Success icon"
                     style="display: {{ $selectedAddonMeals->count() >= $addon->required_minimum_meals_amount ? 'block' : 'none' }}">
                <div class="vegan-select-header__title">Add {{ $addon->name }}</div>
            </div>
        </div>
        <div class="content_box--padding2">
            <div class="content_box_part content_box_part-no-border">
                <div class="order-panel flex justify-between">
                    <div class="order-panel__left">
                        <div class="order-panel__title">
                            Choose {{ $addon->required_minimum_meals_amount }} items
                        </div>
                        <div class="order-panel__right">
                            <div class="order-panel__title">
                                (<span
                                    class="addon-meals-selected">{{ $addonMealsSelectedAmount ?? 0 }}</span>/{{ $addon->required_minimum_meals_amount }}
                                selected)
                            </div>
                        </div>
                    </div>
                    <div class="order-panel__right flex items-center">
                        <div class="sort-categories">
                            <a href="" class="sort-link">
                                <span>Sort by</span>
                                <span>
                                    Calories
                                    <img class="sort-link__icon"
                                         src="{{ asset('assets/frontend/img/icon-down-little-black.svg') }}"
                                         alt="Arrow down icon">
                                </span>
                            </a>
                            <ul class="sort-categories__list sort-options__wrapper" style="display: none;">
                                <li>
                                    <a href="{{ route('frontend.order-and-menu.addons.show', $addon->id) }}"
                                       data-action="sort" data-sort-column="calories" data-sort-direction="DESC"
                                       data-items-wrapper-id="addons">
                                        Less calories
                                        <img src="{{ asset('assets/frontend/img/icon-check-filter.svg') }}"
                                             class="sort-icon__checked"
                                             alt="Check icon" style="display: none">
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.order-and-menu.addons.show', $addon->id) }}"
                                       data-action="sort" data-sort-column="calories" data-sort-direction="ASC"
                                       data-items-wrapper-id="addons">
                                        More calories
                                        <img src="{{ asset('assets/frontend/img/icon-check-filter.svg') }}"
                                             class="sort-icon__checked"
                                             alt="Check icon" style="display: none">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="addons">
                    @include('frontend.addons.partials.addon-meals-items', ['meals' => $addon->meals])
                </div>
                <div class="content_cart_bottom mobile">
                    <h3>Total meal value</h3>
                    <div class="weekly-menu__info">
                        <div class="weekly-menu__info-item order-calories">
                            <img src="{{ asset('assets/frontend/img/fat.svg') }}" alt="Icon">
                            <span>
                                {{ $mealsMicronutrientsData['calories'] + $addonMealsMicronutrientsData['calories'] }}
                            </span>
                            calories
                        </div>
                        <div class="weekly-menu__info-item order-fats">
                            <img src="{{ asset('assets/frontend/img/calories.svg') }}" alt="Icon">
                            <span>
                                {{ $mealsMicronutrientsData['fats'] + $addonMealsMicronutrientsData['fats'] }}
                            </span>
                            g fats
                        </div>
                        <div class="weekly-menu__info-item order-carbs">
                            <img src="{{ asset('assets/frontend/img/tree.svg') }}" alt="Icon">
                            <span>
                                {{ $mealsMicronutrientsData['carbs'] + $addonMealsMicronutrientsData['carbs'] }}
                            </span>
                            g carbs
                        </div>
                        <div class="weekly-menu__info-item order-proteins">
                            <img src="{{ asset('assets/frontend/img/fat-2.svg') }}" alt="Icon">
                            <span>
                                {{ $mealsMicronutrientsData['proteins'] + $addonMealsMicronutrientsData['proteins'] }}
                            </span>
                            g proteins
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-gradient"></div>
        </div>
        <div class="mobile-add-to-card">
            @if(\App\Services\SessionStorageHandlers\AddonsSessionStorageService::hasAddonId($addon->id))
                <a href="{{ route('frontend.order-and-menu.addons.toggle-add-to-cart', $addon->id) }}"
                   class="btn btn-start {{ $selectedAddonMeals->count() >= $addon->required_minimum_meals_amount ? 'btn-green' : 'btn_disabled' }}"
                   data-action="show-popup" data-popup-id="remove-addon-from-cart-confirmation"
                   data-popup-with-confirmation="{{ true }}" data-request-type="POST"
                   data-popup-data="{{ $addon->toJson() }}">
                    Remove from cart
                </a>
            @else
                <a href="{{ route('frontend.order-and-menu.addons.toggle-add-to-cart', $addon->id) }}"
                   class="btn btn-start {{ $selectedAddonMeals->count() >= $addon->required_minimum_meals_amount ? 'btn-green' : 'btn_disabled' }}"
                   data-action="add-to-cart" data-addon="{{ $addon->toJson() }}">
                    Add to cart
                </a>
            @endif
        </div>
    </div>
    <div class="content_cart content_cart-fixed">
        <a href="#" class="btn-close-right-sidebar">
            <img src="{{ asset('assets/frontend/img/icon-arrow-left.svg') }}" alt="Icon">
            <span>Review your meal</span>
        </a>
        <div class="content_cart__title">
            Your order
        </div>
        <ul class="order-value">
            <li class="order-calories">
                <img src="{{ asset('assets/frontend/img/cart-icon-1.svg') }}" alt="Icon">
                <span>{{ $mealsMicronutrientsData['calories'] + $addonMealsMicronutrientsData['calories'] }}</span>
                calories
            </li>
            <li class="order-fats">
                <img src="{{ asset('assets/frontend/img/cart-icon-2.svg') }}" alt="Icon">
                <span>{{ $mealsMicronutrientsData['fats'] + $addonMealsMicronutrientsData['fats'] }}</span>g
                fats
            </li>
            <li class="order-carbs">
                <img src="{{ asset('assets/frontend/img/cart-icon-3.svg') }}" alt="Icon">
                <span>{{ $mealsMicronutrientsData['carbs'] + $addonMealsMicronutrientsData['carbs'] }}</span>g
                carbs
            </li>
            <li class="order-proteins">
                <img src="{{ asset('assets/frontend/img/cart-icon-4.svg') }}" alt="Icon">
                <span>{{ $mealsMicronutrientsData['proteins'] + $addonMealsMicronutrientsData['proteins'] }}</span>g
                proteins
            </li>
        </ul>
        <div class="content_cart__block mt-16">
            <div class="content_cart__block-title">Points</div>
            <div class="content_cart__points">
                +<span class="points">{{ $selectedAddonMealsPoints ?? 0 }}</span>
            </div>
        </div>
        <div class="content_cart_bottom">
            <div class="cart_sum">
                <h3 class="cart_sum_total">
                    Menu total:
                    <span>
                        $
                        <span class="meals-price">
                            {{ $totalPrice }}
                        </span>
                    </span>
                </h3>
            </div>
            <a href="{{ route('frontend.order-and-menu.addons.toggle-add-to-cart', $addon->id) }}" id="wizard-next"
               class="btn {{ $selectedAddonMeals->count() >= $addon->required_minimum_meals_amount && !\App\Services\SessionStorageHandlers\AddonsSessionStorageService::hasAddonId($addon->id) ? 'btn-green' : 'btn_disabled' }}"
               data-action="add-to-cart" data-addon="{{ $addon->toJson() }}">
                Add to cart
            </a>
        </div>
    </div>
@endsection

@section('popups')
    @include('frontend.order-and-menu.partials.popups.meal-details', ['empty' => true])
    @include('frontend.addons.partials.popups.remove-from-cart', ['empty' => true])
@endsection

@push('js')
    <script src="{{ asset('assets/frontend/js/addons.js') }}"></script>
@endpush
