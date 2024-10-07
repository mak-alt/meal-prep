@extends('frontend.layouts.app')

@section('content')
    <div class="content">
        @include('frontend.layouts.partials.app.content-header', ['title' => $page->title])
        <div class="content_main perfect_scroll">
            <div class="content_box">
                <div class="content_box_part_inner">
                    <h2 class="section-title">
                        {{ $page->data['delivery_and_pickup_timing']['title'] }}
                    </h2>
                    <div class="box_part_text_wrapp">
                        @foreach($page->data['delivery_and_pickup_timing']['items'] as $time)
                            <div class="box_part_text_item">
                                <h2 class="section-title">{{ $time['title'] }}</h2>
                                {!! $time['description'] !!}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="content_box_part_inner">
                    <h2 class="section-title">
                        {{ $page->data['delivery_fees']['title'] }}
                    </h2>
                    <p>{{ $page->data['delivery_fees']['description'] }}</p>
                    <div class="search-form">
                        <div class="input-wrapper">
                            <input class="input" type="text" name="search"
                                   placeholder="{{ $page->data['delivery_fees']['placeholder'] }}" required>
                            <button type="button" class="calear-form">
                                <img src="{{ asset('assets/frontend/img/delete-entry.svg') }}" alt="Delete icon">
                            </button>
                            <p class="error-text"></p>
                            <p class="res-text" style="display: none;">
                                FEE: <span></span>
                            </p>
                        </div>
                        <a href="" class="btn btn_disabled" id="search-button"
                           data-url="{{ route('frontend.delivery.calculate-delivery-fees') }}">
                            {{ $page->data['delivery_fees']['button'] }}
                        </a>
                    </div>
                </div>

                <div class="content_box_part_inner">
                    <h2 class="section-title">
                        {{ $page->data['pickup_locations']['title'] }}
                    </h2>
                    <p>{{ $page->data['pickup_locations']['description'] }}</p>
                    <div class="location-info-wrapper">
                        <div class="location-info-buttons pickup">
                            @foreach($page->data['pickup_locations']['items'] ?? [] as $key => $location)
                                <a class="{{ $loop->iteration === 1 ? 'active' : '' }}"
                                   href="loc-item-{{ $key }}">{{ $location['name'] }}</a>
                            @endforeach
                        </div>
                        @foreach($page->data['pickup_locations']['items'] ?? [] as $key => $location)
                            <div class="loc-item-{{ $key }} {{ $loop->iteration === 1 ? 'active' : '' }} locations">
                                <p>
                                    <img src="{{ asset('assets/frontend/img/Location.svg') }}" alt="Location icon">
                                    <span class="locations-address">{{ $location['address'] }}</span>
                                </p>
                                <iframe
                                    src="https://maps.google.com/maps?q={{ str_replace(" ", "%20", $location['address']) }}&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                    width="600" height="450" style="border:0;" allowfullscreen=""
                                    loading="lazy"></iframe>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="content_box_part_inner">
                    <h2 class="section-title">
                        {{ $page->data['contact_info']['title'] }}
                    </h2>
                    <div class="box_part_text_wrapp style-2">
                        <div class="box_part_text_contacts">
                            <h2 class="section-title">
                                Address
                            </h2>
                            <p>{!! $page->data['contact_info']['address'] !!}</p>
                        </div>
                        <div class="box_part_text_contacts">
                            <h2 class="section-title">
                                Email
                            </h2>
                            <a href="mailto:{{ $page->data['contact_info']['email'] }}">
                                {{ $page->data['contact_info']['email'] }}
                            </a>
                        </div>
                        <div class="box_part_text_contacts">
                            <h2 class="section-title">
                                Number
                            </h2>
                            <a href="tel:{{ $page->data['contact_info']['phone'] }}">
                                {{ $page->data['contact_info']['phone'] }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @include('frontend.layouts.partials.subscribe-left-aligned')
            @include('frontend.layouts.partials.app.footer')
        </div>
    </div>
@endsection

@section('popups')
    @include('frontend.landing.partials.popups.login', ['redirectUrl' => url()->current()])
    @include('frontend.landing.partials.popups.register', ['redirectUrl' => url()->current()])
    @include('frontend.landing.partials.popups.forgot-password')
    @include('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true])
@endsection

@push('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=geometry"></script>
    <script src="{{ asset('assets/frontend/js/delivery-and-pickup.js') }}"></script>
@endpush
