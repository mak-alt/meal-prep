@foreach($meals as $meal)
    <div class="entry-item"
         data-meal-id="{{ $meal->id }}"
         style="{{ empty($currentSelectedEntryMeal) ? '' : ($currentSelectedEntryMeal->id === $meal->id ? '' : 'display: none;') }}">
        <div class="entry-item__left">
            <div class="entry-item__food-icon-wrapper">
                <span>
                <img src="{{ asset($meal->thumb) }}" alt="Meal photo">
                </span>
                @if($meal->sides->isEmpty())
                    <div class="entry-item__food-option">
                        <img src="{{ asset('assets/frontend/img/green-close-icon-white-bg.svg') }}" alt="Icon">
                        No sides
                    </div>
                @endif
            </div>
            <div class="entry-item__info">
                <div class="entry-item__title">
                    {{ $meal->name }}
                </div>
                <div class="weekly-menu__info">
                    <div class="weekly-menu__info-item">
                        <img src="{{ asset('assets/frontend/img/fat.svg') }}" alt="Icon">
                        {{ $meal->calories }} calories
                    </div>
                    <div class="weekly-menu__info-item">
                        <img src="{{ asset('assets/frontend/img/calories.svg') }}" alt="Icon">
                        {{ $meal->fats }}g fats
                    </div>
                    <div class="weekly-menu__info-item">
                        <img src="{{ asset('assets/frontend/img/tree.svg') }}" alt="Icon">
                        {{ $meal->carbs }}g carbs
                    </div>
                    <div class="weekly-menu__info-item">
                        <img src="{{ asset('assets/frontend/img/fat-2.svg') }}" alt="Icon">
                        {{ $meal->proteins }}g proteins
                    </div>
                </div>
            </div>
        </div>
        <div class="entry-item__right">
            <div class="entry-item__btn-wrpr flex">
                <a href="" class="btn btn_transparent" data-action="show-meal-details-popup"
                   data-show-add-btn="0" data-show-sides="0" data-meal-id="{{ $meal->id }}" data-meal-number="{{ $mealNumber }}"
                   data-listener="{{ route('frontend.order-and-menu.render-meal-details-popup', $meal->id) }}">
                    Info
                </a>
                @if(optional($currentSelectedEntryMeal)->id === $meal->id)
                    <button type="button" class="btn btn_transparent btn-select" data-action="toggle-entry-meal-selection"
                            data-listener="{{ route('frontend.order-and-menu.toggle-entry-meal-selection', $meal->id) }}"
                            data-meal-id="{{ $meal->id }}"
                            data-meal-number="{{ $mealNumber }}"
                            data-has-entry-meal-warning="{{ $hasEntryMealWarning ? 1 : 0 }}"
                            data-operation="unselect">
                        Unselect
                    </button>
                @else
                    <button type="button" class="btn btn-green btn-select" data-action="toggle-entry-meal-selection"
                            data-listener="{{ route('frontend.order-and-menu.toggle-entry-meal-selection', $meal->id) }}"
                            data-meal-id="{{ $meal->id }}"
                            data-meal-number="{{ $mealNumber }}"
                            data-has-entry-meal-warning="{{ $hasEntryMealWarning ? 1 : 0 }}"
                            data-operation="select">
                        Select
                    </button>
                @endif
            </div>
            <div class="entry-item__price">
                {{ ((int)$meal->price !== 0) ? '+$ ' . $meal->price : '' }}
            </div>
        </div>
    </div>
@endforeach
