<div class="vaimascertain">
    <div class="dascevaimas">
        <div class="order-menu-header dascevaimas-wrapper">
            <ul class="header__nav">
                <div class="kasetudsionud" id="kasetudsionud"></div>
                @foreach($categories as $menuCategory)
                    <li class="order-menu-heade__item"
                        data-category-id="{{ $menuCategory->id }}"
                        data-listener="{{ route('frontend.order-and-menu.remember-preferred-menu-type-selection') }}">
                        @empty($categoryId)
                            <a class="order-menu-heade__link {{ $menuCategory->id === $category->id ? 'active' : '' }}"
                               href="{{ route('frontend.order-and-menu.index', $menuCategory->name) }}">
                                {{ $menuCategory->name }}
                            </a>
                        @else
                            <a class="order-menu-heade__link {{ $categoryId === $menuCategory->id ? 'active' : '' }}"
                               href="{{ $categoryId === $menuCategory->id ? route('frontend.order-and-menu.index', $menuCategory->name) : '' }}">
                                {{ $menuCategory->name }}
                            </a>
                        @endempty
                    </li>
                @endforeach
            </ul>
            <div class="asenavi-gatgtudsion-menyu">
                <button class="dascevaimas-paddle-left icon-chevronleft" aria-hidden="true">
                    <img src="{{ asset('assets/frontend/img/menu-slider-icon.svg') }}" alt="Slider menu icon">
                </button>
                <button class="dascevaimas-paddle-right icon-chevronright" aria-hidden="true">
                    <img src="{{ asset('assets/frontend/img/menu-slider-icon.svg') }}" alt="Slider menu icon">
                </button>
            </div>
        </div>
    </div>
</div>
