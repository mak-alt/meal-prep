@php($minimumRequiredMealsAmount = (session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['amount_of_meals_selection']) ?? 5) + 1)

<div class="popup_wrpr mobile-full" id="add-meals">
    <div class="popup_wrpr_inner">
        <div class="popup popup_style2 popup_style3">
            <div class="popup_heading">
                <a href="" class="close_popup_btn" data-action="close-popup">
                    <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
                    <img class="mob-close" src="{{ asset('assets/frontend/img/down-arrow.svg') }}" alt="Close icon">
                </a>
                <h3>Amount of meals</h3>
            </div>
            <div class="popup_header">
                <h3 class="popup_title">How many meals would you like in total?</h3>
            </div>
            <div class="popup_content popup_content_no-padding">
                <div class="home__wizzard__container home__meals-container" id="meals-amount-selection">
                    <div class="meals-calculate">
                        <div class="meals-calculate__title">
                            Enter the amount of meals
                        </div>
                        <div class="meals-calculate__subtitle">
                            {{ $minimumRequiredMealsAmount }} is a minimum amount you can order
                        </div>
                        <div class="input-wrapper">
                            <input type="number" class="input-check" id="meal-amount-input"
                                   min="{{ $minimumRequiredMealsAmount }}" data-href="{{route('frontend.landing.prices')}}"
                                   data-min-allowed-value="{{ $minimumRequiredMealsAmount }}" required>
                            @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'positionAbsolute' => false, 'name' => 'amount'])
                            @include('frontend.layouts.partials.app.icons.clear-input')
                        </div>
                        <div class="meals-calculate__title meals-calculate__picker-title">Or use a shortcut</div>
                        <div class="meals-calculate__picker">
                            <div class="meals-calculate__picker-row flex">
                                <button
                                    class="meals-calculate__picker-button {{ $minimumRequiredMealsAmount >= 5 ? 'btn_disabled' : '' }}"
                                    data-value="5" {{ $minimumRequiredMealsAmount >= 5 ? 'disabled' : '' }}>
                                    5 meals
                                </button>
                                <button
                                    class="meals-calculate__picker-button {{ $minimumRequiredMealsAmount >= 10 ? 'btn_disabled' : '' }}"
                                    data-value="10" {{ $minimumRequiredMealsAmount >= 10 ? 'disabled' : '' }}>
                                    10 meals
                                </button>
                                <button
                                    class="meals-calculate__picker-button {{ $minimumRequiredMealsAmount >= 15 ? 'btn_disabled' : '' }}"
                                    data-value="15" {{ $minimumRequiredMealsAmount >= 15 ? 'disabled' : '' }}>
                                    15 meals
                                </button>
                            </div>
                            <div class="meals-calculate__picker-row flex">
                                <button
                                    class="meals-calculate__picker-button {{ $minimumRequiredMealsAmount >= 20 ? 'btn_disabled' : '' }}"
                                    data-value="20" {{ $minimumRequiredMealsAmount >= 20 ? 'disabled' : '' }}>
                                    20 meals
                                </button>
                                <button
                                    class="meals-calculate__picker-button {{ $minimumRequiredMealsAmount >= 25 ? 'btn_disabled' : '' }}"
                                    data-value="25" {{ $minimumRequiredMealsAmount >= 25 ? 'disabled' : '' }}>
                                    25 meals
                                </button>
                                <button
                                    class="meals-calculate__picker-button {{ $minimumRequiredMealsAmount >= 30 ? 'btn_disabled' : '' }}"
                                    data-value="30" {{ $minimumRequiredMealsAmount >= 30 ? 'disabled' : '' }}>
                                    30 meals
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="meals-calculate__total meals-calculate__total-inner">
                Total: $<span id="meal-price">{{$totalPrice}}</span>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <a href="" class="btn btn_transparent" data-action="close-popup">Cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn-meal disable" data-action="update-amount-of-meals"
                            data-listener="{{ route('frontend.order-and-menu.update-amount-of-meals') }}">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
