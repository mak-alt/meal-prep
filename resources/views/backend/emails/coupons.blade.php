@component('mail::message')
    # You received a coupon - {{ $coupon->coupon_code }}
    Discount - {{ $coupon->discount_value }} {{ $discountType }}
    Coupon validity period - {{ Carbon\Carbon::parse($coupon->start_date)->format('d/m/Y') }} - {{ Carbon\Carbon::parse($coupon->expiration_date)->format('d/m/Y') }}

    {!! $coupon->description !!}

    Thanks,
    {{ config('app.name') }}
@endcomponent
