@extends('frontend.layouts.app')

@php($contentClasses = 'order-menu-mobile')
@section('content')
    <div class="content right-sidebar">
        <div class="content_header meals-header">
            @include('frontend.order-and-menu.partials.select-meals-content-header')
        </div>
        <div class="content_main perfect_scroll">
            <div class="content_box_part content_box--padding-small content_box--order-menu">
                <ul class="open-menu {{ $currentSelectedEntryMeal ? 'step1_selected' : '' }}">
                    <li class="open-menu__item active">
                        <div
                            class="order-step order-step__1 open-menu__header {{ $hasEntryMealWarning && !$currentSelectedEntryMeal ? 'warning' : '' }}">
                            <span class="order-step__title">
                                <img src="{{ asset('assets/frontend/img/Yes.svg') }}"
                                     class="order-step__selected-icon check"
                                     alt="Success icon" style="{{ $currentSelectedEntryMeal ? '' : 'display: none;' }}">
                                <img src="{{ asset('assets/frontend/img/Warning-meals.svg') }}"
                                     class="order-step__selected-icon warning"
                                     alt="Warning icon"
                                     style="{{ $hasEntryMealWarning && !$currentSelectedEntryMeal ? '' : 'display: none;' }}">
                                {{getInscriptions('select-meals-step-1','order-and-menu/select-meals','Step 1. Select entree meal')}}
                            </span>
                            <span>
                                <img src="{{ asset('assets/frontend/img/arrow-up-blue.svg') }}"
                                     class="open-menu__item-icon" alt="Arrow up icon">
                            </span>
                        </div>
                        <ul class="open-menu__item__dropdown">
                            <li class="open-menu__item">
                                <div class="order-panel flex justify-between">
                                    <div class="order-panel__left">
                                        <div class="order-panel__title">{{getInscriptions('select-meals-entry-name','order-and-menu/select-meals','Entree meal')}}</div>
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
                                            <ul class="sort-categories__list sort-options__wrapper"
                                                style="display: none;">
                                                <li>
                                                    <a href="{{ route('frontend.order-and-menu.select-meals', $mealNumber) }}"
                                                       data-action="sort" data-sort-column="calories"
                                                       data-sort-direction="ASC"
                                                       data-items-wrapper-id="meals">
                                                        Less calories
                                                        <img
                                                            src="{{ asset('assets/frontend/img/icon-check-filter.svg') }}"
                                                            class="sort-icon__checked"
                                                            alt="Check icon" style="display: none">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('frontend.order-and-menu.select-meals', $mealNumber) }}"
                                                       data-action="sort" data-sort-column="calories"
                                                       data-sort-direction="DESC"
                                                       data-items-wrapper-id="meals">
                                                        More calories
                                                        <img
                                                            src="{{ asset('assets/frontend/img/icon-check-filter.svg') }}"
                                                            class="sort-icon__checked"
                                                            alt="Check icon" style="display: none">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="" class="sort-link" data-action="show-popup"
                                           data-popup-id="filter-by-tags">
                                            Filter diets
                                            <img class="sort-link__icon"
                                                 src="{{ asset('assets/frontend/img/icon-filter.svg') }}"
                                                 alt="Filter icon">
                                        </a>
                                    </div>
                                </div>
                                <div class="entry_scroll" id="meals">
                                    @include('frontend.order-and-menu.partials.entry-meals-items')
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="open-menu">
                    <li class="open-menu__item active">
                        <div id="side-meals-wrapper"
                             style="{{ ($currentSelectedEntryMeal && $currentSelectedEntryMeal->sides_count > 0) || $hasEntryMealWarning ? '' : 'display: none;' }}">
                            <div
                                class="order-step order-step__2 open-menu__header {{ $hasSidesWarning ? 'warning' : '' }}">
                                <span class="order-step__title">
                                    <img class="order-step__selected-icon check"
                                         src="{{ asset('assets/frontend/img/Yes.svg') }}"
                                         alt="Success icon"
                                         style="{{ $currentSelectedSides->count() >= 2 ? '' : 'display: none;' }}">
                                    <img src="{{ asset('assets/frontend/img/Warning-meals.svg') }}"
                                         class="order-step__selected-icon warning"
                                         alt="Warning icon" style="{{ $hasSidesWarning ? '' : 'display: none;' }}">
                                    {{getInscriptions('select-meals-step-2','order-and-menu/select-meals','Step 2. Select side dishes')}}
                                </span>
                                <span>
                                    <img src="{{ asset('assets/frontend/img/arrow-up-blue.svg') }}"
                                         class="open-menu__item-icon" alt="Arrow up icon">
                                </span>
                            </div>
                            <div class="flex justify-between mb-15">
                                <div></div>
                                <div>
                                    <a href="" class="sort-link" data-action="show-popup"
                                        data-popup-id="filter-sides-by-tags">
                                        Filter diets
                                        <img class="sort-link__icon"
                                             src="{{ asset('assets/frontend/img/icon-filter.svg') }}"
                                             alt="Filter icon">
                                    </a>
                                </div>
                            </div>
                            <ul class="open-menu__item__dropdown">
                                <li class="open-menu__item">
                                    <div id="sides" class="entry_scroll entry_scroll-sides">
                                        @include('frontend.order-and-menu.partials.side-meals-items', ['sides' => ($hasEntryMealWarning || $hasSidesWarning) && $currentSelectedSides->isNotEmpty() ? $currentSelectedSides->merge(optional($currentSelectedEntryMeal)->sidesActive ?? collect())->unique('id') : optional($currentSelectedEntryMeal)->sidesActive ?? [], 'entry' => $currentSelectedEntryMeal ?? []])
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="bottom-gradient bottom-gradient-inner"></div>
        </div>
{{----}}
        <div class="mobile-add-to-card" id="mobileConfirm" style="{{ ($currentSelectedSides->count() >= ($currentSelectedEntryMeal->side_count ?? 2) || (isset($currentSelectedEntryMeal) && $currentSelectedEntryMeal->sides->count() === 0)) ? '' : 'display: none;' }}">
            <a href="" class="btn btn-green btn-start btn-open-right-sidebar">
                {{getInscriptions('select-meals-mobile-confirm','order-and-menu/select-meals','Confirm')}}
            </a>
        </div>

		@include('frontend.layouts.partials.subscribe-left-aligned')
        @include('frontend.layouts.partials.app.footer')
    </div>
    @include('frontend.layouts.partials.app.alerts.session-response-message', ['flash' => true])
    @if(!$allMealsSelected)
        <div class="content_cart content_cart-fixed content_cart-breakfast content_cart-mobile-next-step">
            <div class="content_cart_top">
                <a href="" class="btn-close-right-sidebar">
                    <img src="{{ asset('assets/frontend/img/icon-arrow-left.svg') }}" alt="Arrow left icon">
                    <span>Review your meal</span>
                </a>
                <div class="content_cart__title">
                    Your meal plan
                </div>
                <div class="order-selection">
                    <div class="order-selection__title">
                        Selection
                    </div>
                    <ul id="entry-selection">
                        <li class="order-selection__list-title">Entry:</li>
                        @if($currentSelectedEntryMeal !== null)
                        <li class="order-selection__item" data-meal-number="{{ $mealNumber }}">
                            {{ $currentSelectedEntryMeal->name }}
                        </li>
                        @endif
                    </ul>
                    <ul class="mt-16" id="sides-selection">
                        <li class="order-selection__list-title">Sides:</li>
                        @foreach($currentSelectedSides as $currentSelectedSide)
                            <li class="order-selection__item" data-side-id="{{ $currentSelectedSide->id }}"
                                data-meal-number="{{ $mealNumber }}">
                                {{ $currentSelectedSide->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <ul class="order-value">
                    <li class="order-value_title">Calories in this meal</li>
                    <li class="order-calories">
                        <img src="{{ asset('assets/frontend/img/cart-icon-1.svg') }}" alt="Icon">
                        <span class="pr-3px">
                            {{--{{ $mealsAndSidesMicronutrientsData['calories'] + $selectedAddonsMicronutrientsData['calories'] }}--}}
                            {{ $mealsAndSidesMicronutrientsData['calories'] }}
                        </span>calories
                    </li>
                    <li class="order-fats">
                        <img src="{{ asset('assets/frontend/img/cart-icon-2.svg') }}" alt="Icon">
                        <span>
                            {{--{{ $mealsAndSidesMicronutrientsData['fats'] + $selectedAddonsMicronutrientsData['fats'] }}--}}
                            {{ $mealsAndSidesMicronutrientsData['fats'] }}
                        </span>g fats
                    </li>
                    <li class="order-carbs">
                        <img src="{{ asset('assets/frontend/img/cart-icon-3.svg') }}" alt="Icon">
                        <span>
                            {{--{{ $mealsAndSidesMicronutrientsData['carbs'] + $selectedAddonsMicronutrientsData['carbs'] }}--}}
                            {{ $mealsAndSidesMicronutrientsData['carbs'] }}
                        </span>g carbs
                    </li>
                    <li class="order-proteins">
                        <img src="{{ asset('assets/frontend/img/cart-icon-4.svg') }}" alt="Icon">
                        <span>
                            {{--{{ $mealsAndSidesMicronutrientsData['proteins'] + $selectedAddonsMicronutrientsData['proteins'] }}--}}
                            {{ $mealsAndSidesMicronutrientsData['proteins'] }}
                        </span>g proteins
                    </li>
                </ul>
                <div class="your-meal-hide" style="display: none">
                    <div class="content_cart__block mt-16" id="portion-selection-block"
                         data-listener="{{ route('frontend.order-and-menu.meal-creation.refresh-portion-sizes-values') }}"
                         style="{{ count($portionSizes) < 1 ? 'display: none;' : '' }}">
                        <div class="content_cart__block-title">Increase portion sizes</div>
                        <ul class="portions flex">
                            @foreach($portionSizes as $portionSize)
                                <li data-size="{{ $portionSize['size'] }}">
                                    <a href=""
                                       class="btn {{ $portionSize['size'] === $selectedPortionSize['size'] ? 'btn-green' : 'btn-white' }}"
                                       data-action="select-portion-size"
                                       data-listener="{{ route('frontend.order-and-menu.meal-creation.select-portion-size') }}"
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
                    <div class="content_cart__block mt-16">
                        <div class="content_cart__block-title">Add-ons</div>
                        <ul id="addons-list">
                            @foreach($addons ?? [] as $addon)
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
                                        @else
                                            <span>
                                                <span class="add-ons__item-details-item">
                                                    +100 points
                                                </span>
                                                <span class="add-ons__item-details-item">
                                                    +$10
                                                </span>
                                            </span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn btn_transparent mt-16" id="discard-all" data-action="show-popup"
                        data-popup-id="discard-meal-creation" data-popup-with-confirmation="{{ true }}"
                        data-popup-data="{{ json_encode(['name' => optional($currentSelectedEntryMeal)->name ?? 'entry']) }}"
                        style="{{ empty($currentSelectedEntryMeal) && (!$hasEntryMealWarning && !$hasSidesWarning) ? 'display: none;' : '' }}">
                    {{getInscriptions('select-meals-delete','order-and-menu/select-meals','Delete meal')}}
                </button>
                @if($selectedMeals->isNotEmpty() && $selectedSides->isNotEmpty())
                    <button type="button" class="btn btn_transparent mt-16 mb-6" id="start-over"
                            data-action="show-popup"
                            data-popup-id="start-over-meals-creation" data-popup-with-confirmation="{{ true }}">
                        {{getInscriptions('select-meals-refresh','order-and-menu/select-meals','Start over')}}
                    </button>
                @endif
                <div class="cart_sum mt-16">
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
                            {{$totalPoints}}
                        </span>
                        points for this order
                    </h4>
                </div>
            </div>
            <div class="content_cart_bottom">
                <div class="wizard-button-group">
                    @if($mealNumber === (int)$mealsAmount)
                        <a href="{{ route('frontend.order-and-menu.review-order-selection') }}"
                           class="btn btn_transparent mb-6" id="review-order" style="display: none">
                            {{getInscriptions('select-meals-review','order-and-menu/select-meals','Review order')}}
                        </a>
                    @else
                        <button type="button" class="btn btn_transparent mb-6" id="duplicate"
                                data-listener="{{ route('frontend.order-and-menu.meal-creation.render-duplicate-meals-popup', $mealNumber) }}"
                                style="{{ $currentSelectedEntryMeal && (!$currentSelectedEntryMeal->sides()->exists() || $currentSelectedSides->count() >= 2) ? '' : 'display: none;' }}">
                            {{getInscriptions('select-meals-duplicate','order-and-menu/select-meals','Duplicate')}}
                        </button>
                    @endif
                    @if($mealNumber === (int)$mealsAmount)
                        <button type="button" id="wizard-next"{{----}}
                                class="btn {{ (session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealNumber") === true) || (!empty($currentSelectedEntryMeal) && (!$currentSelectedEntryMeal->sides()->exists() || $currentSelectedSides->count() >= ($currentSelectedEntryMeal->side_count ?? 2))) ? 'btn-green' : 'btn_disabled' }}"
                                data-action="add-to-cart"
                                data-before="1"
                                data-listener="{{ route('frontend.shopping-cart.store') }}">
                            {{--{{getInscriptions('select-meals-continue',request()->path(),'Continue')}}--}}
                            Checkout
                            <img src="{{ asset('assets/frontend/img/cart-icon-white.svg') }}" alt="Shopping cart icon">
                        </button>
                    @else
                        <button id="wizard-next" type="button"
                                class="btn {{ !empty($currentSelectedEntryMeal) && (!$currentSelectedEntryMeal->sides()->exists() || $currentSelectedSides->count() >= 2) ? 'btn-green' : 'btn_disabled' }}"
                                data-action="validate-meal-creation-step"
                                data-listener="{{ route('frontend.order-and-menu.meal-creation.validate-step', $mealNumber) }}"
                                data-meal-number="{{ $mealNumber }}"
                                data-wanted-meal-number="{{ $mealNumber + 1 }}">
                            {{getInscriptions('select-meals-next','order-and-menu/select-meals','Next meal')}}
                            <img src="{{ asset('assets/frontend/img/icon-arrow-long-right.svg') }}" alt="Arrow right icon">
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="content_cart content_cart-fixed content_cart-breakfast content_cart-mobile-next-step">
            <div class="content_cart_top">
                <a href="" class="btn-close-right-sidebar">
                    <img src="{{ asset('assets/frontend/img/icon-arrow-left.svg') }}" alt="Arrow left icon">
                    <span>Before you go</span>
                </a>
                <div class="content_cart__title">
                    Before you go
                </div>
                <div class="order-selection" style="display: none">
                    <div class="order-selection__title">
                        Selection
                    </div>
                    <ul id="entry-selection">
                        <li class="order-selection__list-title">Entry:</li>
                        @if($currentSelectedEntryMeal !== null)
                            <li class="order-selection__item" data-meal-number="{{ $mealNumber }}">
                                {{ $currentSelectedEntryMeal->name }}
                            </li>
                        @endif
                    </ul>
                    <ul class="mt-16" id="sides-selection">
                        <li class="order-selection__list-title">Sides:</li>
                        @foreach($currentSelectedSides as $currentSelectedSide)
                            <li class="order-selection__item" data-side-id="{{ $currentSelectedSide->id }}"
                                data-meal-number="{{ $mealNumber }}">
                                {{ $currentSelectedSide->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <ul class="order-value" style="display: none">
                    <li class="order-value_title">Calories in this meal</li>
                    <li class="order-calories">
                        <img src="{{ asset('assets/frontend/img/cart-icon-1.svg') }}" alt="Icon">
                        <span class="pr-3px">
                            {{--{{ $mealsAndSidesMicronutrientsData['calories'] + $selectedAddonsMicronutrientsData['calories'] }}--}}
                            {{ $mealsAndSidesMicronutrientsData['calories'] }}
                        </span>calories
                    </li>
                    <li class="order-fats">
                        <img src="{{ asset('assets/frontend/img/cart-icon-2.svg') }}" alt="Icon">
                        <span>
                            {{--{{ $mealsAndSidesMicronutrientsData['fats'] + $selectedAddonsMicronutrientsData['fats'] }}--}}
                            {{ $mealsAndSidesMicronutrientsData['fats'] }}
                        </span>g fats
                    </li>
                    <li class="order-carbs">
                        <img src="{{ asset('assets/frontend/img/cart-icon-3.svg') }}" alt="Icon">
                        <span>
                            {{--{{ $mealsAndSidesMicronutrientsData['carbs'] + $selectedAddonsMicronutrientsData['carbs'] }}--}}
                            {{ $mealsAndSidesMicronutrientsData['carbs'] }}
                        </span>g carbs
                    </li>
                    <li class="order-proteins">
                        <img src="{{ asset('assets/frontend/img/cart-icon-4.svg') }}" alt="Icon">
                        <span>
                            {{--{{ $mealsAndSidesMicronutrientsData['proteins'] + $selectedAddonsMicronutrientsData['proteins'] }}--}}
                            {{ $mealsAndSidesMicronutrientsData['proteins'] }}
                        </span>g proteins
                    </li>
                </ul>
                <div class="your-meal-hide" style="display: block">
                    <div class="content_cart__block mt-16" id="portion-selection-block"
                         data-listener="{{ route('frontend.order-and-menu.meal-creation.refresh-portion-sizes-values') }}"
                         style="{{ count($portionSizes) < 1 ? 'display: none;' : '' }}">
                        <div class="content_cart__block-title">Increase portion sizes</div>
                        <ul class="portions flex">
                            @foreach($portionSizes as $portionSize)
                                <li data-size="{{ $portionSize['size'] }}">
                                    <a href=""
                                       class="btn {{ $portionSize['size'] === $selectedPortionSize['size'] ? 'btn-green' : 'btn-white' }}"
                                       data-action="select-portion-size"
                                       data-listener="{{ route('frontend.order-and-menu.meal-creation.select-portion-size') }}"
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
                    <div class="content_cart__block mt-16">
                        <div class="content_cart__block-title">Add-ons</div>
                        <ul id="addons-list">
                            @foreach($addons ?? [] as $addon)
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
                                        @else
                                            <span>
                                                <span class="add-ons__item-details-item">
                                                    +100 points
                                                </span>
                                                <span class="add-ons__item-details-item">
                                                    +$10
                                                </span>
                                            </span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn btn_transparent mt-16" id="discard-all" data-action="show-popup"
                        data-popup-id="discard-meal-creation" data-popup-with-confirmation="{{ true }}"
                        data-popup-data="{{ json_encode(['name' => optional($currentSelectedEntryMeal)->name ?? 'entry']) }}"
                        style="{{ empty($currentSelectedEntryMeal) && (!$hasEntryMealWarning && !$hasSidesWarning) ? 'display: none;' : '' }}">
                    {{getInscriptions('select-meals-delete','order-and-menu/select-meals','Delete meal')}}
                </button>
                {{--@if($selectedMeals->isNotEmpty() && $selectedSides->isNotEmpty())
                    <button type="button" class="btn btn_transparent mt-16 mb-6" id="start-over"
                            data-action="show-popup"
                            data-popup-id="start-over-meals-creation" data-popup-with-confirmation="{{ true }}">
                        {{getInscriptions('select-meals-refresh',request()->path(),'Start over')}}
                    </button>
                @endif--}}
                <div class="cart_sum mt-16">
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
                            {{--{{ $selectedMeals->sum('points') + $selectedSides->sum('pivot.points') + $selectedAddonMeals->sum('pivot.points') }}--}}
                            {{$totalPoints}}
                        </span>
                        points for this order
                    </h4>
                </div>
            </div>
            <div class="content_cart_bottom">
                <div class="wizard-button-group">
                    <a href="{{ route('frontend.order-and-menu.review-order-selection') }}"
                       class="btn btn_transparent mb-6" id="review-order" style="display: block">
                        {{getInscriptions('select-meals-review','order-and-menu/select-meals','Review order')}}
                    </a>
                    <button type="button" id="wizard-next"
                            class="btn {{ (session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealNumber") === true) || (!empty($currentSelectedEntryMeal) && (!$currentSelectedEntryMeal->sides()->exists() || $currentSelectedSides->count() >= 2)) ? 'btn-green' : 'btn_disabled' }}"
                            data-action="add-to-cart"
                            data-before="1"
                            data-listener="{{ route('frontend.shopping-cart.store') }}">
                        Checkout
                        <img src="{{ asset('assets/frontend/img/cart-icon-white.svg') }}" alt="Shopping cart icon">
                    </button>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('mobile-popups')
    @include('frontend.layouts.partials.app.alerts.session-response-message', ['mobileView' => true, 'fromFrontendResponse' => true])
@endsection

@section('popups')
    @include('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true])
    @include('frontend.order-and-menu.partials.popups.meal-details', ['empty' => true])
    @include('frontend.order-and-menu.partials.popups.filter-by-tags', ['tags' => $tags])
    @include('frontend.order-and-menu.partials.popups.filter-sides-by-tags', ['tags' => $tags])
    @include('frontend.order-and-menu.partials.popups.discard-meal-creation')
    @include('frontend.order-and-menu.partials.popups.start-over-meals-creation')
    @include('frontend.order-and-menu.partials.popups.add-meals')
    @include('frontend.order-and-menu.partials.popups.duplicate-meal-step-selection', ['empty' => true])
    @include('frontend.landing.partials.popups.login', ['redirectUrl' => url()->current()])
    @include('frontend.landing.partials.popups.register', ['redirectUrl' => url()->current()])
    @include('frontend.landing.partials.popups.forgot-password')
@endsection

@push('js')
    <script src="{{ asset('assets/frontend/js/order-and-menu-select-meals.js') }}"></script>
@endpush
