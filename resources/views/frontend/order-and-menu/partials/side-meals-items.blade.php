@php($currentSelectedSides = $currentSelectedSides ?? collect())
@php($entry = $entry->side_count ?? 2)

@foreach($sides as $side)
    <div class="entry-item" data-side-id="{{ $side->id }}" style="display:{{ ($currentSelectedSides->count() < $entry) ? 'show' : (($currentSelectedSides->contains('id', $side->id)) ? 'show' : 'none') }}">
        <div class="entry-item__left">
            <div class="entry-item__food-icon-wrapper">
                <span>
                    <img src="{{ asset($side->thumb) }}" alt="Side meal photo">
                </span>
            </div>
            <div class="entry-item__info">
                <div class="entry-item__title">{{ $side->name }}</div>
                <div class="weekly-menu__info">
                    <div class="weekly-menu__info-item">
                        <img src="{{ asset('assets/frontend/img/fat.svg') }}" alt="Icon">
                        {{ $side->calories }} calories
                    </div>
                    <div class="weekly-menu__info-item">
                        <img src="{{ asset('assets/frontend/img/calories.svg') }}" alt="Icon">
                        {{ $side->fats }}g fats
                    </div>
                    <div class="weekly-menu__info-item">
                        <img src="{{ asset('assets/frontend/img/tree.svg') }}" alt="Icon">
                        {{ $side->carbs }}g carbs
                    </div>
                    <div class="weekly-menu__info-item">
                        <img src="{{ asset('assets/frontend/img/fat-2.svg') }}" alt="Icon">
                        {{ $side->proteins }}g proteins
                    </div>
                </div>
            </div>
        </div>
        <div class="entry-item__right">
            <div class="entry-item__btn-wrpr flex">
                <a href="" class="btn btn_transparent" data-action="show-meal-details-popup" data-sel-side-id="{{$loop->index}}"
                   data-show-add-btn="0" data-show-sides="0" data-meal-id="{{ $side->id }}" data-meal-number="{{ $mealNumber }}"
                   data-listener="{{ route('frontend.order-and-menu.render-side-details-popup', $side->id) }}">
                    Info
                </a>
                <div class="entry-item__amount_picker flex items-center">
                    <a href="{{ route('frontend.order-and-menu.toggle-side-meal-selection', $side->id) }}"
                       class="btn btn-side-select {{ $currentSelectedSides->contains('id', $side->id) ? 'btn-green' : 'btn_disabled' }}"
                       data-action="toggle-side-meal-selection"
                       data-meal-number="{{ $mealNumber }}" data-operation="unselect">
                        -
                    </a>
                    <span class="entry-item__amount_picker-digit main-picker" data-sel-side-id="{{$loop->index}}">
                        {{ $currentSelectedSides->where('id', $side->id)->count() }}
                    </span>
                    <a href="{{ route('frontend.order-and-menu.toggle-side-meal-selection', $side->id) }}"
                       class="btn btn-side-unselect {{ $currentSelectedSides->count() >= $entry ? 'btn_disabled' : 'btn-green' }}"
                       data-action="toggle-side-meal-selection"
                       data-meal-number="{{ $mealNumber }}" data-operation="select">
                        +
                    </a>
                </div>
            </div>
            <div class="entry-item__price" style=" display: {{ $currentSelectedSides->where('id', $side->id)->count() === 0 ? 'none' : 'block' }}">
                {{ ((int)(optional($side->pivot)->price ?? $side->price) !== 0) ? '+$ ' : '' }}
                 <span class="side-price" style="display: {{ ((int)(optional($side->pivot)->price ?? $side->price) !== 0) ? 'block' : 'none' }};">{{ (optional($side->pivot)->price ?? $side->price) * $currentSelectedSides->where('id', $side->id)->count() }}</span>
            </div>
        </div>
    </div>
@endforeach
