<style>
    * {
        font-size: 12px;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: auto;
        margin-top: auto;
    }

    td, th{
        border: 1px solid #ddd;
        padding: 5px;
    }

    dl {
        margin-top: -2px;
        margin-bottom: -3px;
    }

    .table td, th  {
        border: 1px solid #ddd;
    }

    tr > th {
        text-align: left;
    }

    th{
        width: 200px;
    }

    .page-break{
        page-break-after: avoid;
    }

    .mb-5{
        margin-bottom: 5px;
    }
    .meals-block  {
          border-left: 1px solid #ddd;
          border-right: 1px solid #ddd;
          border-bottom: 1px solid #ddd;
          width: 100%;
          display: block;
          position: relative;
          margin-top: -2px;
    }
</style>
<div>
    <img src="{{ asset('assets/frontend/img/home__header-logo.svg') }}" alt="Logo">
</div>

<table>
    <tr>
        <th>SUBMITTED ON</th>
        <td colspan="2">{{ $order->created_at->format('m/d/Y') }}</td>
    </tr>
    <tr>
        <th>YOUR ORDER</th>
        <td colspan="2">{{ $order->id }}</td>
    </tr>
    <tr>
        <th>FIRST NAME</th>
        <td colspan="2">{{ $order->user->first_name }}</td>
    </tr>
    <tr>
        <th>LAST NAME</th>
        <td colspan="2">{{ $order->user->last_name }}</td>
    </tr>
    <tr>
        <th>EMAIL</th>
        <td colspan="2">{{ $order->user->email }}</td>
    </tr>
    @if($order->delivery_date)
        <tr>
            <th>ADDRESS</th>
            @if(($order->delivery_company_name != '' || $order->billing_company_name != '') && ($order->delivery_address_opt != '' || $order->billing_address_opt != ''))
                <td colspan="2">{{ ($order->delivery_country ?? $order->billing_country ?? '') . ', ' . ($order->delivery_state ?? $order->billing_state ?? '') . ', ' . ($order->delivery_city ?? $order->billing_city ?? '') . ', ' . ($order->delivery_street_address ?? $order->billing_street_address ?? '')  . ', ' . ($order->delivery_address_opt ?? $order->billing_address_opt ?? '') . ', ' . ($order->delivery_zip ?? $order->billing_zip ?? '')  . ', ' . ($order->delivery_company_name ?? $order->billing_company_name) }}</td>
            @elseif(($order->delivery_address_opt != '' || $order->billing_address_opt != ''))
                <td colspan="2">{{ ($order->delivery_country ?? $order->billing_country ?? '') . ', ' . ($order->delivery_state ?? $order->billing_state ?? '') . ', ' . ($order->delivery_city ?? $order->billing_city ?? '') . ', ' . ($order->delivery_street_address ?? $order->billing_street_address ?? '')  . ', ' . ($order->delivery_address_opt ?? $order->billing_address_opt ?? '') . ', ' . ($order->delivery_zip ?? $order->billing_zip ?? '') }}</td>
            @else
                <td colspan="2">{{ ($order->delivery_country ?? $order->billing_country ?? '') . ', ' . ($order->delivery_state ?? $order->billing_state ?? '') . ', ' . ($order->delivery_city ?? $order->billing_city ?? '') . ', ' . ($order->delivery_street_address ?? $order->billing_street_address ?? '') . ', ' . ($order->delivery_zip ?? $order->billing_zip ?? '') }}</td>
            @endif
        </tr>
    @else
        <tr>
            <th>PICKUP LOCATION</th>
            <td colspan="2">{{ $order->pickup_location }}</td>
        </tr>
    @endif
    <tr>
        <th>PHONE</th>
        <td colspan="2">{{ $order->delivery_phone_number ?? $order->billing_phone_number ?? '' }}</td>
    </tr>
    <tr>
        <th>{{ $order->delivery_date ? 'DELIVERY' : 'PICKUP'}} DATE</th>
        <td colspan="2">{{ ($order->delivery_date ?? $order->pickup_date)->format('m/d/Y') ?? '' }}</td>
    </tr>
    <tr>
        <th>TIME FRAME</th>
        <td colspan="2">{{ $order->delivery_time_frame_value ?? $order->pickup_time_frame_value ?? '' }}</td>
    </tr>
    <tr>
        <th>TOTAL PRICE</th>
        <td colspan="2">{{ $order->total_price }}$</td>
    </tr>
    <tr>
        <th>TOTAL POINTS</th>
        <td colspan="2">{{ $order->total_points }}</td>
    </tr>
    <tr>
        <th>DISCOUNTS</th>
        <td colspan="2">{{ $order->discounts ?? 0 }}$</td>
    </tr>
    <tr>
        <th>COUPON CODE</th>
        <td colspan="2">{{ $couponCode ?? '' }}</td>
    </tr>
    <tr>
        <th>ORDER NOTES</th>
        <td colspan="2">{{$order->delivery_order_notes ?? ''}}</td>
    </tr>
</table>
 <div class="meals-block">
     <dl style="padding: 5px">
         <h2>MEAL NAMES</h2>
         @foreach($order->orderItems as $orderItem)
             <dt><b>{{ $orderItem->portion_size != null ? $orderItem->name . " Size: $orderItem->portion_size oz" : $orderItem->name }}</b></dt>
             @foreach($orderItem->orderItemables->whereNull('parent_id') as $orderItemable)
                 <dd> {{ $orderItemable->orderItemable->name }}</dd>
                 @foreach($orderItemable->children as $orderItemableChild)
                     <dd> -{{ $orderItemableChild->orderItemable->name }}</dd>
                 @endforeach
                 <br>
             @endforeach
         @endforeach
     </dl>
 </div>
<div class="page-break"></div>
<table id="vertical-1" class="table">
    <tr>
        <th>Entries count</th>
        <td>
            @foreach($entry as $item)
                <p>{{$item['count'] === 1 ? '' : $item['count']}} {{$item['name']}}</p>
            @endforeach
        </td>
    </tr>
    <tr>
        <th>Sides count</th>
        <td>
            @foreach($sides as $item)
                <p>{{$item['count'] === 1 ? '' : $item['count']}} {{$item['name']}}</p>
            @endforeach
        </td>
    </tr>
</table>
