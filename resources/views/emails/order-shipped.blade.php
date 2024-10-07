@component('mail::message')
    <h2>Order Confirmation:</h2>
    <p style="margin-bottom: -24px">
        {{$user->full_name}}.<br>
        {{ $order->delivery_date ? 'Delivery' : 'Pickup'}} Date: {{($order->delivery_date ?? $order->pickup_date)->format('m/d/Y')}}.<br>
        {{ $order->delivery_date ? 'Delivery Address:' : 'Pickup Location:'}}<br>
        @if($order->delivery_date)
            @if(($order->delivery_company_name != '' || $order->billing_company_name != '') && ($order->delivery_address_opt != '' || $order->billing_address_opt != ''))
                {{ ($order->delivery_country ?? $order->billing_country ?? '') . ', ' . ($order->delivery_state ?? $order->billing_state ?? '') . ', ' . ($order->delivery_city ?? $order->billing_city ?? '') . ', ' . ($order->delivery_street_address ?? $order->billing_street_address ?? '')  . ', ' . ($order->delivery_address_opt ?? $order->billing_address_opt ?? '') . ', ' . ($order->delivery_zip ?? $order->billing_zip ?? '')  . ', ' . ($order->delivery_company_name ?? $order->billing_company_name) }}.<br>
            @elseif(($order->delivery_address_opt != '' || $order->billing_address_opt != ''))
                {{ ($order->delivery_country ?? $order->billing_country ?? '') . ', ' . ($order->delivery_state ?? $order->billing_state ?? '') . ', ' . ($order->delivery_city ?? $order->billing_city ?? '') . ', ' . ($order->delivery_street_address ?? $order->billing_street_address ?? '')  . ', ' . ($order->delivery_address_opt ?? $order->billing_address_opt ?? '') . ', ' . ($order->delivery_zip ?? $order->billing_zip ?? '') }}.<br>
            @else
                {{ ($order->delivery_country ?? $order->billing_country ?? '') . ', ' . ($order->delivery_state ?? $order->billing_state ?? '') . ', ' . ($order->delivery_city ?? $order->billing_city ?? '') . ', ' . ($order->delivery_street_address ?? $order->billing_street_address ?? '') . ', ' . ($order->delivery_zip ?? $order->billing_zip ?? '') }}.<br>
            @endif
        @else
            {{ $order->pickup_location }}.<br>
        @endif
        Email: {{$user->email}}.<br>
        Phone: {{ $order->delivery_phone_number ?? $order->billing_phone_number ?? '' }}
    </p>
    <div class="meals-block">
        <dl style="padding-top: 5px; margin-bottom: 0">
            <h2 style="margin-bottom: 0">Order details</h2>
            @foreach($order->orderItems as $orderItem)
                <dt><b>{{ $orderItem->portion_size != null ? $orderItem->name . " Size: $orderItem->portion_size oz" : $orderItem->name }}</b></dt>
                @foreach($orderItem->orderItemables->whereNull('parent_id') as $orderItemable)
                    <dd style="margin-top: 5px"> {{ $orderItemable->orderItemable->name }}</dd>
                    @foreach($orderItemable->children as $orderItemableChild)
                        <dd> -{{ $orderItemableChild->orderItemable->name }}</dd>
                    @endforeach
                @endforeach
            @endforeach
        </dl>
    </div>
    <p>
        Order Total Price: {{number_format($order->total_price, 2)}}$.<br>
        @if($order->discounts > 0)
            Discounts: {{number_format($order->discounts,2)}}$.<br>
        @endif
        Please see our contact info below for order inquiries:<br>
        <a href="mailto:{{$supportEmail}}">{{$supportEmail}}</a><br>
        {{$supportPhoneNumber}}.<br>
    </p>
@endcomponent
