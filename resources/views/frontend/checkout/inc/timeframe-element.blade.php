@if($type === 'delivery')
    @foreach($deliveryTime as $key => $value)
        <li>
            <a href=""
               class="{{ !empty($checkoutData['delivery_time_frame']) && $checkoutData['delivery_time_frame'] === $value['since'] . ' - ' . $value['until'] ? 'active' : '' }}"
               data-action="select-time-frame"
               data-value="{{ $key }}">
                {{ $value['since'] . '-' . $value['until'] }}
            </a>
        </li>
    @endforeach
@else
    @foreach($deliveryTime as $key => $value)
        <li>
            <a href=""
               class="{{ !empty($checkoutData['pickup_time_frame']) && $checkoutData['pickup_time_frame'] === $key ? 'active' : '' }}"
               data-action="select-time-frame"
               data-value="{{ $key }}">
                {{ $value['since'] . '-' . $value['until'] }}
            </a>
        </li>
    @endforeach
@endif
