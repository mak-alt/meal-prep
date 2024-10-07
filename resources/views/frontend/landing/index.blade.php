@extends('frontend.layouts.landing')

@section('content')
    <section class="section1">
        <div class="section1__left">
            <div class="home__wizzard__container" id="order-type-initial"
                 style="{{ (isset($addToCartProcess) && $addToCartProcess) ? 'display: none;' : '' }}">
                <div class="home__wizzard-title mb-40">
                    {{getInscriptions('landing-main-title',request()->path(),'Fresh, local & healthy meals delivered to your door.')}}
                </div>
                <div class="home__wizzard-sub-title mobile-none">Select how you want to order</div>
                <div
                    class="home__wizzard">
                    <div class="home__wizzard-item flex items-center justify-between"
                         data-action="free-meals-selection">
                        <div class="left flex items-center">
                            <div class="home__wizzard-item-img-wrapper">
                                <img src="{{ asset('assets/frontend/img/home__wizzard-item-icon-1.png') }}" alt="Icon">
                            </div>
                            <div>
                                <div class="home__wizzard-item-title">
                                    {{getInscriptions('landing-select-meals',request()->path(),'Choose your own meals')}}
                                </div>
                                <div class="home__wizzard-item-description">
                                    Select your own list of meals
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <img src="{{ asset('assets/frontend/img/icon-arrow-right.svg') }}" alt="Arrow right icon">
                        </div>
                    </div>
                    <div
                        class="home__wizzard-item flex items-center justify-between" data-action="show-menu-options">
                        <div class="left flex items-center">
                            <div class="home__wizzard-item-img-wrapper">
                                <img src="{{ asset('assets/frontend/img/home__wizzard-item-icon-2.png') }}" alt="Icon">
                            </div>
                            <div>
                                <div class="home__wizzard-item-title">
                                    {{getInscriptions('landing-select-menu',request()->path(),'Pre-selected meal plans')}}
                                </div>
                                <div class="home__wizzard-item-description">
                                    Predefined list of meals
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <img src="{{ asset('assets/frontend/img/icon-arrow-right.svg') }}" alt="Arrow right icon">
                        </div>
                    </div>
                </div>
            </div>
            <div class="home__wizzard__container home__wizzard__container--selects" id="order-type-menu-options"
                 style="display: none;">
                <div class="home__wizzard-title">
                    Select preferred menu type
                </div>
                <div class="home__wizzard-sub-title">
                    Each menu includes 5 meals
                    @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'positionAbsolute' => false, 'name' => 'category_id'])
                </div>
                <div class="home__wizzard home__wizzard--selects scroll450">
                    @foreach($categories as $category)
                        <div class="home__wizzard-item flex items-center justify-between"
                             data-category-id="{{ $category->id }}"
                             data-listener="{{ route('frontend.order-and-menu.remember-preferred-menu-type-selection') }}">
                            <div class="left flex items-center">
                                <div>
                                    <div class="home__wizzard-item-title">
                                        {{ $category->name }}
                                    </div>
                                    <div class="home__wizzard-item-description">
                                        {{ $category->description }}
                                    </div>
                                </div>
                            </div>
                            <div class="right flex">
                                @if($category->images()->count() > 0)
                                    @foreach($category->images as $image)
                                        <img class="home__wizzard-item__icon max_w48"
                                             src="{{ asset($image->img) }}">
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="btn--wizzard" data-action="back-to-order-type-selection">
                    <img src="{{ asset('assets/frontend/img/icon-arrow-left.svg') }}" alt="Arrow left icon">
                    {{getInscriptions('select-menu-back',request()->path(),'Back to order type')}}
                </div>
            </div>
            <div class="home__wizzard__container home__meals-container" id="meals-amount-selection"
                 style="{{ (isset($addToCartProcess) && $addToCartProcess) ? '' : 'display: none;' }}">
                <div class="home__meals-title">How many meals would you like in total?</div>
                <div class="meals-calculate">
                    <div class="meals-calculate__title">
                        Enter the amount of meals
                    </div>
                    <div class="meals-calculate__subtitle">
                        5 is a minimum amount you can order
                    </div>
                    <div class="input-wrapper">
                        <input type="number" class="input-check" id="meal-amount-input" min="5" data-href="{{route('frontend.landing.prices')}}"
                               data-min-allowed-value="5" required>
                        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'positionAbsolute' => false, 'name' => 'amount'])
                        @include('frontend.layouts.partials.app.icons.clear-input')
                    </div>
                    <div class="meals-calculate__title meals-calculate__picker-title">Or use a shortcut</div>
                    <div class="meals-calculate__picker">
                        <div class="meals-calculate__picker-row flex">
                            <button class="meals-calculate__picker-button" data-value="5">5 meals</button>
                            <button class="meals-calculate__picker-button" data-value="10">10 meals</button>
                            <button class="meals-calculate__picker-button" data-value="15">15 meals</button>
                        </div>
                        <div class="meals-calculate__picker-row flex">
                            <button class="meals-calculate__picker-button" data-value="20">20 meals</button>
                            <button class="meals-calculate__picker-button" data-value="25">25 meals</button>
                            <button class="meals-calculate__picker-button" data-value="30">30 meals</button>
                        </div>
                    </div>
                </div>

                <div class="meals-calculate__total">
                    Minimum Total: $
                    <span id="meal-price" data-min_meal_price="{{ $minMealPrice ?? \App\Models\Meal::min('price') }}">
                        0
                    </span>
                </div>
                <div class="meals-calculate__buttons-wrapper flex">
                    <a href="" class="btn-item btn btn-back" data-action="back-to-preferred-menu-type-selection">
                        <img src="{{ asset('assets/frontend/img/home-arrow-left.svg') }}" alt="Arrow left icon">
                        {{getInscriptions('select-meals-back',request()->path(),'Back')}}
                    </a>
                    <div class="btn-item btn-meal disable" id="proceed-free-meals-selection"
                         data-listener="{{ route('frontend.order-and-menu.remember-free-meals-selection') }}">
                        {{getInscriptions('select-meals-continue',request()->path(),'Proceed')}}
                        <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M1.18934 15.4393C0.603554 16.0251 0.603554 16.9749 1.18934 17.5607C1.77513 18.1464 2.72487 18.1464 3.31066 17.5607L10.8107 10.0607C11.3964 9.47487 11.3964 8.52513 10.8107 7.93934L3.31066 0.43934C2.72487 -0.146447 1.77513 -0.146447 1.18934 0.43934C0.603554 1.02513 0.603554 1.97487 1.18934 2.56066L7.62868 9L1.18934 15.4393Z"
                                  fill="#1A1A1A"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="section1__right">
            <img src="{{ asset($main_photo) }}" alt="Meal photo">
        </div>
    </section>
    <section class="section2">
        <div class="section2__container flex justify-between">
            <div class="section2__item">
                <img src="{{ asset('assets/frontend/img/home__section2-img1.png') }}" alt="Icon">
                <div class="section2__item-title">SEASONAL INGREDIENTS</div>
                <p class="section2__item-description">
                    Our menus are developed from seasonal ingredients and our recipes
                    are constantly evolving—giving you
                    variety and options in your meal plan.
                </p>
            </div>
            <div class="section2__item">
                <img src="{{ asset('assets/frontend/img/home__section2-img2.png') }}" alt="Icon">
                <div class="section2__item-title">SOMETHING FOR EVERYONE</div>
                <p class="section2__item-description">
                    We offer options to fit your needs—Paleo, Gluten-Free, 1200
                    Calorie, High Protein Diet, Vegan/Vegetarian, Keto, breakfast, snacks and more.
                </p>
            </div>
            <div class="section2__item">
                <img src="{{ asset('assets/frontend/img/home__section2-img3.png') }}" alt="Icon">
                <div class="section2__item-title">FREE DELIVERY</div>
                <p class="section2__item-description">
                    Each of our weekly plans come with complimentary delivery or
                    pickup inside the Atlanta Perimeter.
                </p>
            </div>
        </div>
    </section>
    <section class="section3">
        <h2 class="section3__title">{{getInscriptions('landing-scheme',request()->path(),'How It Works')}}</h2>
        <div class="process-graphic">
            <div class="process-item number">
                <img src="{{ asset('assets/frontend/img/process-graphic__flow_01.png') }}" alt="Icon" class="flow-img">
                <p>Choose number of people/meals</p>
            </div>
            <div class="process-item meals">
                <img src="{{ asset('assets/frontend/img/process-graphic__flow_02.png') }}" alt="Icon" class="flow-img">
                <p>Select entrees &amp; side options</p>
            </div>
            <div class="process-item payment">
                <img src="{{ asset('assets/frontend/img/process-graphic__flow_03.png') }}" alt="Icon" class="flow-img">
                <p>Make your secure payment</p>
            </div>
            <div class="process-item delivery">
                <img src="{{ asset('assets/frontend/img/process-graphic__flow_04.png') }}" alt="Icon"
                     class="flow-img-small">
                <p>Receive free delivery</p>
            </div>
            <div class="process-item enjoy">
                <img src="{{ asset('assets/frontend/img/process-graphic__flow_05.png') }}" alt="Icon" class="flow-img">
                <p>Heat &amp; enjoy at your convenience</p>
            </div>
        </div>
    </section>
    @include('frontend.layouts.partials.subscribe-centered')
@endsection

@section('mobile-popups')
    @if(session()->has('response-message'))
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['mobileView' => true])
    @else
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['mobileView' => true, 'fromFrontendResponse' => true])
    @endif
@endsection

@section('popups')
    @if(session()->has('response-message'))
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['flash' => true])
    @else
        @include('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true])
    @endif
    @include('frontend.landing.partials.popups.login')
    @include('frontend.landing.partials.popups.register')
    @include('frontend.landing.partials.popups.forgot-password')
@endsection

@push('js')
    <script>
        document.body.classList.add('home-page');
    </script>
@endpush
