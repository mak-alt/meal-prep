@foreach($meals as $meal)
    <div class="entry-item">
        <div class="entry-item__left">
            <div class="entry_item_food_img_wrapper">
                <img src="{{ asset($meal->thumb) }}" alt="Meal photo">
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
                   data-show-add-btn="0" data-show-sides="0" data-meal-id="{{ $meal->id }}"
                   data-listener="{{ route('frontend.order-and-menu.render-meal-details-popup', $meal->id) }}">
                    Info
                </a>
                <div class="entry-item__amount_picker flex items-center">
                    <a href="{{ route('frontend.order-and-menu.addons.toggle-meal-selection', $addon->id) }}"
                       class="btn {{ $selectedAddonMeals->contains('id', $meal->id) ? 'btn-green' : 'btn_disabled' }}"
                       data-action="toggle-addon-meal-selection" data-meal-id="{{ $meal->id }}"
                       data-operation="unselect">
                        <img src="{{ asset('assets/frontend/img/icon_minus.svg') }}" alt="Minus icon">
                    </a>
                    <span class="entry-item__amount_picker-digit">
                        {{ $selectedAddonMeals->where('id', $meal->id)->count() }}
                    </span>
                    <a href="{{ route('frontend.order-and-menu.addons.toggle-meal-selection', $addon->id) }}"
                       class="btn {{ $selectedAddonMeals->count() >= $addon->required_minimum_meals_amount ? 'btn_disabled' : 'btn-green' }}"
                       data-action="toggle-addon-meal-selection" data-meal-id="{{ $meal->id }}"
                       data-operation="select">
                        <img src="{{ asset('assets/frontend/img/icon_plus.svg') }}" alt="Plus icon">
                    </a>
                </div>
            </div>
            <div class="entry-item__price">
                +$
                <span>{{ $meal->pivot->price * $selectedAddonMeals->where('id', $meal->id)->count() }}</span>
            </div>
        </div>
    </div>
@endforeach
