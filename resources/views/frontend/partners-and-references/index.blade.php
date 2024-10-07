@extends('frontend.layouts.app')

@section('content')
    <div class="content">
        @include('frontend.layouts.partials.app.content-header', ['classes' => 'content_header-about', 'title' => $page->title])
        <div class="content_main perfect_scroll">
            <div class="content-wrapper content-wrapper-about">
                <section class="local-partners">
                    <div class="row-custom row-custom-inner">
                        <div class="custom-col-2 px-15">
                            <h2 class="section-title">{{ $page->data['first_local_partners']['title'] }}</h2>
                            <div class="row-custom">
                                @foreach($page->data['first_local_partners']['items'] as $firstLocalPartner)
                                    <div class="custom-col-2 px-4">
                                        <div class="local-partners__item">
                                            <div class="local-partners__img">
                                                <img src="{{ asset((file_exists(public_path($firstLocalPartner['image'])) && !empty($firstLocalPartner['image'])) ? $firstLocalPartner['image'] : '/assets/frontend/img/empty.jpg' ) }}"
                                                     alt="Local partner">
                                            </div>
                                            <div class="local-partners__content">
                                                <p>{!! $firstLocalPartner['text'] !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="custom-col-2 px-15">
                            <h2 class="section-title">{{ $page->data['second_local_partners']['title'] }}</h2>
                            <div class="row-custom">
                                @foreach($page->data['second_local_partners']['items'] as $secondLocalPartner)
                                    <div class="custom-col-2 px-4">
                                        <div class="local-partners__item">
                                            <div class="local-partners__img">
                                                <img src="{{ asset((file_exists(public_path($secondLocalPartner['image'])) && !empty($secondLocalPartner['image'])) ? $secondLocalPartner['image'] : '/assets/frontend/img/empty.jpg' ) }}"
                                                     alt="Local partner">
                                            </div>
                                            <div class="local-partners__content">
                                                <p>{!! $secondLocalPartner['text'] !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
                <section class="partners-images py-30">
                    <h2 class="section-title">{{ $page->data['recipe_adaptation_references']['title'] }}</h2>
                    <div class="partners-images__wrapper">
                        @foreach($page->data['recipe_adaptation_references']['items'] as $recipeAdaptationReferences)
                            <a href="" class="partners-images__item">
                                <img src="{{ asset((file_exists(public_path($recipeAdaptationReferences['image'])) && !empty($recipeAdaptationReferences['image'])) ? $recipeAdaptationReferences['image'] : '/assets/frontend/img/empty.jpg' ) }}"
                                     alt="{{ $page->data['recipe_adaptation_references']['title'] }}">
                            </a>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
        @include('frontend.layouts.partials.subscribe-left-aligned')
        @include('frontend.layouts.partials.app.footer')
    </div>
@endsection

@section('popups')
    @include('frontend.landing.partials.popups.login', ['redirectUrl' => url()->current()])
    @include('frontend.landing.partials.popups.register', ['redirectUrl' => url()->current()])
    @include('frontend.landing.partials.popups.forgot-password')
    @include('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true])
@endsection
