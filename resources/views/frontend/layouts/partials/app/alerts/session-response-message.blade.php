@if(session()->has('response-message') && is_string(session()->get('response-message')) || !empty($fromFrontendResponse))
    @if(!empty($mobileView))
        <div class="mobile_top_notif {{ session()->get('response-message-style') ?? '' }}"
             style="{{ empty($fromFrontendResponse) ? '' : 'display: none;' }}">
            <span>{{ empty($fromFrontendResponse) ? session()->get('response-message') : '' }}</span>
        </div>
    @else
        <div
            class="success-order-info success_order_info_in_content {{ empty($fromFrontendResponse) ? 'active' : '' }} {{ session()->get('response-message-style') ?? '' }}">
            <span>{{ empty($fromFrontendResponse) ? session()->get('response-message') : '' }}</span>
            <img src="{{ asset('assets/frontend/img/close-white.svg') }}" class="success-order-info__close"
                 alt="Close icon"
                 style="cursor: pointer;">
        </div>
    @endif

    @if(!empty($flash))
        @php(session()->flash('response-message'))
    @endif
@endif
