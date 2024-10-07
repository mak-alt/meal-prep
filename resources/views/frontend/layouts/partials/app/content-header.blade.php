@empty($hideOnMobile)
    <div class="content_header {{ $classes ?? '' }}">
        <h1 class="content_header_title">{{ $title ?? '' }}</h1>
    </div>
@else
    <div class="mobile-none">
        <div class="content_header {{ $classes ?? '' }}">
            <h1 class="content_header_title">{{ $title ?? '' }}</h1>
        </div>
    </div>
@endif
