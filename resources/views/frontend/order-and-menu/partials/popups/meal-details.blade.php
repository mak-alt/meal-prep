@php($empty = $empty ?? false)

<div class="popup_wrpr" id="popup-about-selected-meal">
    @unless($empty)
        <div class="popup_wrpr_inner">
            <div class="popup">
                <a href="" class="close_popup_btn" data-action="close-popup">
                    <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
                </a>
                <div class="popup_header">
                    <img src="{{ asset($meal->thumb) }}" alt="Meal photo">
                </div>
                <div class="popup-about-selected-meal__wrapper">
                    <div class="popup-about-selected-meal__title">
                        {{ $meal->name }}
                    </div>
                    @if(!empty($showSides) && !empty($menuId))
                        @foreach($meal->menuSides()->where('menu_id', $menuId)->get() as $mealMenuSide)
                            <div class="weekly-menu__text">
                                <p>
                                    <span>Side:</span> {{ $mealMenuSide->name }}
                                </p>
                            </div>
                        @endforeach
                    @endif
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
                    <p class="popup-about-selected-meal__description">
                        <span>Contains:</span>
                        {{ $meal->ingredients->implode('name', ', ') }}
                    </p>
                    <div class="popup_btn_wrpr">
                        <div class="popup_btn_wrpr_item">
                            <a href="" class="btn btn_transparent" data-action="close-popup">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endunless
</div>
