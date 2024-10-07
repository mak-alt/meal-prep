@extends('frontend.layouts.app')

@section('content')
    <div class="content">
        @include('frontend.layouts.partials.app.content-header', ['classes' => 'content_header-about', 'title' => $page->title])
        <div class="content_main perfect_scroll">
            <div class="content-wrapper content-wrapper-about">
                <section class="gallery">
                    <h2 class="section-title">{{ $page->data['gallery']['title'] }}</h2>
                    <div class="row-custom">
                        @foreach($page->data['gallery']['items'] as $gallery)
                            <div class="custom-col-4 px-4">
                                <div class="gallery-item">
                                    <img src="{{ asset((file_exists(public_path($gallery['image'])) && !empty($gallery['image'])) ? $gallery['image'] : '/assets/frontend/img/empty.jpg' ) }}"
                                         alt="Gallery item photo">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
                <section class="reviews py-30">
                    <h2 class="section-title">{{ $page->data['reviews']['title'] }}</h2>
                    <div class="row-custom">
                        @foreach($page->data['reviews']['items'] as $review)
                            <div class="custom-col-3 px-4 px-4">
                                <div class="reviews-item">
                                    <img src="{{ asset((file_exists(public_path($review['image'])) && !empty($review['image'])) ? $review['image'] : '/assets/frontend/img/empty.jpg' ) }}" alt="Review photo">
                                </div>
                            </div>
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
    @include('frontend.landing.partials.popups.forgot-password')
    @include('frontend.landing.partials.popups.login', ['redirectUrl' => url()->current()])
    @include('frontend.landing.partials.popups.register', ['redirectUrl' => url()->current()])
    @include('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true])
@endsection
