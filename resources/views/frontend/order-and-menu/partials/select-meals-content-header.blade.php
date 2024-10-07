<div class="vaimascertain">
    <div class="dascevaimas">
        <div class="order-menu-header dascevaimas-wrapper">
            <ul class="header__nav">
                <div class="kasetudsionud" id="kasetudsionud"></div>
                @for($i = 1; $i <= $mealsAmount; $i++)
                    <li class="order-menu-heade__item" data-meal-number="{{ $i }}">
                        <a href=""
                           class="order-menu-heade__link check {{ session()->has(\App\Models\Order::ONBOARDING_SESSION_KEYS['meal_creation_step_has_warning'] . ".$i") && !((session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$i") === true) || ($i === $mealNumber && !empty($currentSelectedEntryMeal) && (!$currentSelectedEntryMeal->sides()->exists() || $currentSelectedSides->count() >= 2))) ? 'warning' : '' }} {{ $i === $mealNumber ? 'active' : '' }}"
                           data-action="validate-meal-creation-step"
                           data-listener="{{ route('frontend.order-and-menu.meal-creation.validate-step', $mealNumber) }}"
                           data-meal-number="{{ $mealNumber }}"
                           data-wanted-meal-number="{{ $i }}">
                            <img src="{{ asset('assets/frontend/img/Yes.svg') }}" class="check" alt="Success icon"
                                 style="{{ (session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$i") === true) || ($i === $mealNumber && !empty($currentSelectedEntryMeal) && (!$currentSelectedEntryMeal->sides()->exists() || $currentSelectedSides->count() >= 2)) ? '' : 'display: none;' }}">
                            <img src="{{ asset('assets/frontend/img/Warning-meals.svg') }}" class="warning"
                                 alt="Warning icon">
                            Meal {{ $i }}
                        </a>
                    </li>
                @endfor
                <button type="button" class="btn btn-green meals-add-btn" data-action="show-popup"
                        data-popup-id="add-meals">
                    <img src="{{ asset('assets/frontend/img/add-icon_white.svg') }}" alt="Add icon">
                    Add
                </button>
            </ul>
            <div class="asenavi-gatgtudsion-menyu">
                <button class="dascevaimas-paddle-left icon-chevronleft" aria-hidden="true">
                    <img src="{{ asset('assets/frontend/img/menu-slider-icon.svg') }}" alt="Menu icon">
                </button>
                <button class="dascevaimas-paddle-right icon-chevronright" aria-hidden="true">
                    <img src="{{ asset('assets/frontend/img/menu-slider-icon.svg') }}" alt="Menu icon">
                </button>
            </div>
        </div>
    </div>
</div>
