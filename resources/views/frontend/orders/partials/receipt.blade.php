<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Order receipt</title>

    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 100%;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        h1 {
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            padding-bottom: 5px;
            margin: 0 0 20px 0;
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: right;
        }

        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<header class="clearfix">
    <h1>
        <div>
            <img src="{{ asset('assets/frontend/img/home__header-logo.svg') }}" alt="Logo">
        </div>
        Order receipt #{{ $order->id }}
    </h1>
    <div id="project">
        <div>
            <span>CLIENT</span> {{ optional($order->user)->full_name }}
        </div>
        <div>
            <span>TOTAL PRICE</span> ${{ $order->total_price }}
        </div>
        @if($order->created_at !== null)
        <div>
            <span>CREATED AT</span> {{ $order->created_at->format('m/d/Y H:i') }}
        </div>
        @endif
        <div>
            <span>{{ $order->delivery_date ? 'DELIVERY' : 'PICKUP'}} DATE</span> {{ ($order->delivery_date ?? $order->pickup_date)->format('m/d/Y') ?? '' }}
        </div>
        <div>
            <span>TIME FRAME</span> {{ $order->delivery_time_frame_value ?? $order->pickup_time_frame_value }}
        </div>
        <div>
            @if($order->delivery_date)
                @if(($order->delivery_company_name != '' || $order->billing_company_name != '') && ($order->delivery_address_opt != '' || $order->billing_address_opt != ''))
                    <span>ADDRESS</span> {{ ($order->delivery_country ?? $order->billing_country ?? '') . ', ' . ($order->delivery_state ?? $order->billing_state ?? '') . ', ' . ($order->delivery_city ?? $order->billing_city ?? '') . ', ' . ($order->delivery_street_address ?? $order->billing_street_address ?? '')  . ', ' . ($order->delivery_address_opt ?? $order->billing_address_opt ?? '') . ', ' . ($order->delivery_zip ?? $order->billing_zip ?? '')  . ', ' . ($order->delivery_company_name ?? $order->billing_company_name) }}
                @elseif(($order->delivery_address_opt != '' || $order->billing_address_opt != ''))
                    <span>ADDRESS</span> {{ ($order->delivery_country ?? $order->billing_country ?? '') . ', ' . ($order->delivery_state ?? $order->billing_state ?? '') . ', ' . ($order->delivery_city ?? $order->billing_city ?? '') . ', ' . ($order->delivery_street_address ?? $order->billing_street_address ?? '')  . ', ' . ($order->delivery_address_opt ?? $order->billing_address_opt ?? '') . ', ' . ($order->delivery_zip ?? $order->billing_zip ?? '') }}
                @else
                    <span>ADDRESS</span> {{ ($order->delivery_country ?? $order->billing_country ?? '') . ', ' . ($order->delivery_state ?? $order->billing_state ?? '') . ', ' . ($order->delivery_city ?? $order->billing_city ?? '') . ', ' . ($order->delivery_street_address ?? $order->billing_street_address ?? '') . ', ' . ($order->delivery_zip ?? $order->billing_zip ?? '') }}
                @endif
            @else
                <span>PICKUP LOCATION</span> {{ $order->pickup_location }}
            @endif
        </div>
        @if($order->delivery_order_notes !== null)
            <div>
                <span>ORDER NOTES</span> {{$order->delivery_order_notes}}
            </div>
        @endif
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th class="service">MENU NAME</th>
            <th class="service">ENTREE MEAL / ADDON</th>
            <th class="desc">SIDE MEALS / ADDON MEALS</th>
            <th>PRICE</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->orderItems as $orderItem)
            <tr>
                <td class="service">{{ $orderItem->portion_size != null ? $orderItem->name . " Size: $orderItem->portion_size oz" : $orderItem->name }}</td>
                <td class="service"></td>
                <td class="desc"></td>
                <td class="unit">${{ $orderItem->total_price }}</td>
            </tr>
            @foreach($orderItem->orderItemables->whereNull('parent_id') as $orderItemable)
                <tr>
                    <td class="service"></td>
                    <td class="service">{{ $orderItemable->orderItemable->name }}</td>
                    <td class="desc">
                        <ul>
                            @foreach($orderItemable->children as $orderItemableChild)
                                <li>{{ $orderItemableChild->orderItemable->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="unit">
                        @if($orderItem->menu_id === null || $orderItemable->order_itemable_type === \App\Models\Addon::class)
                            ${{ $orderItemable->price + $orderItemable->children->sum('price') }}
                        @endif
                    </td>
                </tr>
            @endforeach
        @endforeach
        <tr>
            <td colspan="3" class="grand total">TOTAL PRICE</td>
            <td class="grand total">${{ $order->total_price }}</td>
        </tr>
        @if(($order->total_price - ($order->orderItems->sum('total_price') - $order->discounts)) > 0)
            <tr>
                <td colspan="3" class="total">Delivery</td>
                <td class="total">${{ ($order->total_price - ($order->orderItems->sum('total_price') - $order->discounts)) }}</td>
            </tr>
        @endif
        @if($order->discounts > 0)
            <tr>
                <td colspan="3" class="total">Discounts</td>
                <td class="total">${{ $order->discounts }}</td>
            </tr>
        @endif
        </tbody>
    </table>
</main>
<footer>
    {{ config('app.name') }}
</footer>
</body>
</html>
