@extends('frontend.layouts.app')

@section('mobile-header')
    <div class="btn-back-to-home btn-back-to-home-inner" data-redirect="{{ route('frontend.landing.index') }}">
        <img src="{{ asset('assets/frontend/img/icon-arrow-left.svg') }}" alt="Arrow left icon">
        <span>{{$page->name ?? ''}}</span>
    </div>
@endsection

@section('content')
    <div class="content">
        @include('frontend.layouts.partials.app.content-header', ['classes' => 'content_header-about', 'hideOnMobile' => true, 'title' => $page->name ?? ''])
        <div class="content_main perfect_scroll">
            <div class="content_box content_box_weekly">
                    <div class="content_box_part">
                        <h2 class="section-title">Entrees</h2>
                        <p>Entrees {{ $defaultPortionSize['size'] }} oz portion</p>
                        <ul class="weekly-menu">
                            @foreach($meals as $meal)
                                <li class="weekly-menu__item"
                                    data-action="show-meal-details-popup"
                                    data-show-add-btn="0" data-show-sides="1"
                                    data-meal-id="{{ $meal->id }}"
                                    data-listener="{{ route('frontend.order-and-menu.render-meal-details-popup', $meal->id) }}">
                                    <a href=""
                                       class="weekly-menu__item-link">
                                        <div class="weekly-menu__img">
                                            <img src="{{ asset($meal->thumb) }}" alt="Meal photo">
                                        </div>
                                        <div class="weekly-menu__content">
                                            <h2 class="weekly-menu__title">{{ $meal->name }}</h2>
                                            <div class="weekly-menu__text">
                                                <p>
                                                    <span>Contains:</span>
                                                    {{ $meal->ingredients->implode('name', ', ') }}
                                                </p>
                                            </div>
                                            <div class="weekly-menu__info">
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/fat.svg') }}" alt="Icon">
                                                    <span>
                                                {{ $meal->calories }}
                                                <span class="weekly-menu__info-item-title">calories</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/calories.svg') }}" alt="Icon">
                                                    <span>
                                                {{ $meal->fats }}g
                                                <span class="weekly-menu__info-item-title">fats</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/tree.svg') }}" alt="Icon">
                                                    <span>
                                                {{ $meal->carbs }}g
                                                <span class="weekly-menu__info-item-title">carbs</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/fat-2.svg') }}" alt="Icon">
                                                    <span>
                                                {{ $meal->proteins }}g
                                                <span class="weekly-menu__info-item-title">proteins</span>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <br />
                        <h2 class="section-title">Sides</h2>
                        <ul class="weekly-menu">
                            @foreach($sides as $side)
                                <li class="weekly-menu__item"
                                    data-action="show-meal-details-popup"
                                    data-show-add-btn="0" data-show-sides="1"
                                    data-meal-id="{{ $side->id }}"
                                    data-listener="{{ route('frontend.order-and-menu.render-meal-details-popup', $side->id) }}">
                                    <a href=""
                                       class="weekly-menu__item-link">
                                        <div class="weekly-menu__img">
                                            <img src="{{ asset($side->thumb) }}" alt="Meal photo">
                                        </div>
                                        <div class="weekly-menu__content">
                                            <h2 class="weekly-menu__title">{{ $side->name }}</h2>
                                            <div class="weekly-menu__text">
                                                <p>
                                                    <span>Contains:</span>
                                                    {{ $side->ingredients->implode('name', ', ') }}
                                                </p>
                                            </div>
                                            <div class="weekly-menu__info">
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/fat.svg') }}" alt="Icon">
                                                    <span>
                                                {{ $side->calories }}
                                                <span class="weekly-menu__info-item-title">calories</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/calories.svg') }}" alt="Icon">
                                                    <span>
                                                {{ $side->fats }}g
                                                <span class="weekly-menu__info-item-title">fats</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/tree.svg') }}" alt="Icon">
                                                    <span>
                                                {{ $side->carbs }}g
                                                <span class="weekly-menu__info-item-title">carbs</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/fat-2.svg') }}" alt="Icon">
                                                    <span>
                                                {{ $side->proteins }}g
                                                <span class="weekly-menu__info-item-title">proteins</span>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <br />
                        <h2 class="section-title">Add-Ons/Breakfast/Snacks</h2>
                        <ul class="weekly-menu">
                            @foreach($other as $item)
                                <li class="weekly-menu__item"
                                    data-action="show-meal-details-popup"
                                    data-show-add-btn="0" data-show-sides="1"
                                    data-meal-id="{{ $item->id }}"
                                    data-listener="{{ route('frontend.order-and-menu.render-meal-details-popup', $item->id) }}">
                                    <a href=""
                                       class="weekly-menu__item-link">
                                        <div class="weekly-menu__img">
                                            <img src="{{ asset($item->thumb) }}" alt="Meal photo">
                                        </div>
                                        <div class="weekly-menu__content">
                                            <h2 class="weekly-menu__title">{{ $item->name }}</h2>
                                            <div class="weekly-menu__text">
                                                <p>
                                                    <span>Contains:</span>
                                                    {{ $item->ingredients->implode('name', ', ') }}
                                                </p>
                                            </div>
                                            <div class="weekly-menu__info">
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/fat.svg') }}" alt="Icon">
                                                    <span>
                                                {{ $item->calories }}
                                                <span class="weekly-menu__info-item-title">calories</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/calories.svg') }}" alt="Icon">
                                                    <span>
                                                {{ $item->fats }}g
                                                <span class="weekly-menu__info-item-title">fats</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/tree.svg') }}" alt="Icon">
                                                    <span>
                                                {{ $item->carbs }}g
                                                <span class="weekly-menu__info-item-title">carbs</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/fat-2.svg') }}" alt="Icon">
                                                    <span>
                                                {{ $item->proteins }}g
                                                <span class="weekly-menu__info-item-title">proteins</span>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                    </div>
            </div>
            @include('frontend.layouts.partials.subscribe-left-aligned')
            @include('frontend.layouts.partials.app.footer')
        </div>
    </div>
@endsection

@section('popups')
    @include('frontend.order-and-menu.partials.popups.meal-details', ['empty' => true])
    @include('frontend.landing.partials.popups.login', ['redirectUrl' => url()->current()])
    @include('frontend.landing.partials.popups.register', ['redirectUrl' => url()->current()])

    @include('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true])@include('frontend.landing.partials.popups.forgot-password')
@endsection

@section('footer')
    <div class="mobile-add-to-card">
        <a href="{{ route('frontend.landing.index') }}" class="btn btn-green btn-start">
            Start shopping
        </a>
    </div>
@endsection
