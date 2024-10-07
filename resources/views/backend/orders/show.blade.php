@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.orders.show', $order) }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                @include('backend.layouts.partials.alerts.flash-messages')
                                <div class="row mb-5">
                                    <div class="col-lg-12">
                                        <h2>
                                            General Info
                                            @if($order->status === \App\Models\Order::STATUSES['upcoming'])
                                                <span class="badge bg-primary">Upcoming</span>
                                            @elseif($order->status === \App\Models\Order::STATUSES['completed'])
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($order->status === \App\Models\Order::STATUSES['failed'])
                                                <span class="badge bg-danger">Failed</span>
                                            @endif
                                        </h2>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="customer">Customer</label>
                                            <input type="text" class="form-control" id="customer"
                                                   value="{{ optional($order->user)->full_name }}" readonly>
                                            @if($order->user)
                                                <a href="{{ route('backend.users.edit', $order->user->id) }}"
                                                   class="btn-link">
                                                    <i class="fas fa-user-circle"></i> View details
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="created-at">Created at</label>
                                            <input type="text" class="form-control" id="created-at"
                                                   value="{{ $order->created_at->format('m/d/Y H:i') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="total-price">Total price ($)</label>
                                            <input type="text" class="form-control" id="total-price"
                                                   value="{{ $order->total_price }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="total-points">Points gained</label>
                                            <input type="text" class="form-control" id="total-points"
                                                   value="{{ $order->total_points }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="discounts">Discounts($)</label>
                                            <input type="text" class="form-control" id="discounts"
                                                   value="{{ $order->discounts ?? 0 }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="discounts">Coupon code</label>
                                            <input type="text" class="form-control" id="discounts"
                                                   value="{{ $couponCode ?? '' }}" readonly>
                                        </div>
                                    </div>
                                   {{-- <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="discounts">Gift</label>
                                            <input type="text" class="form-control" id="discounts"
                                                   value="{{ $couponCode ?? '' }}" readonly>
                                        </div>
                                    </div>--}}
                                    <div class="col-lg-6">
                                        <a href="{{ route('backend.orders.show-receipt', $order->id) }}" target="_blank"
                                           class="btn btn-info">
                                            <i class="fa fa-file-alt"></i> View receipt
                                        </a>
                                        @if($order->paymentHistory && $order->paymentHistory->isStripe())
                                            <a href="{{ $order->paymentHistory->receipt_url }}" target="_blank"
                                               class="btn btn-info">
                                                <i class="fab fa-cc-{{ $order->paymentHistory->isStripe() ? 'stripe' : 'paypal' }}"></i>
                                                View {{ $order->paymentHistory->isStripe() ? 'Stripe' : 'PayPal' }}
                                                receipt
                                            </a>
                                        @endif
                                        <a href="{{route('backend.orders.status.toggle', $order->id)}}">
                                            <input type="checkbox" name="status" {{$order->status  === 'completed' ? 'checked' : ''}} id="status">
                                            Toggle Order Status
                                        </a>

                                    </div>
                                </div>
                                @if($order->hasDeliveryOption())
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4>Delivery Info</h4>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group billing">
                                                <label for="delivery-date">Preferred delivery date</label>
                                                <input type="text" class="form-control" id="delivery-date"
                                                       value="{{ $order->delivery_date->format('m/d/Y') }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group billing">
                                                <label for="delivery-time-frame">Preferred delivery time frame</label>
                                                <input type="text" class="form-control" id="delivery-time-frame"
                                                       value="{{ $order->delivery_time_frame_value }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group billing">
                                                <label for="delivery-country">Country / Region</label>
                                                <input type="text" class="form-control" id="delivery-country"
                                                       value="{{ $order->delivery_country }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group billing">
                                                <label for="delivery-state">State</label>
                                                <input type="text" class="form-control" id="delivery-state"
                                                       value="{{ $order->delivery_state }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group billing">
                                                <label for="delivery-city">Town / City</label>
                                                <input type="text" class="form-control" id="delivery-city"
                                                       value="{{ $order->delivery_city }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group billing">
                                                <label for="delivery-street-address">Street address</label>
                                                <input type="text" class="form-control" id="delivery-street-address"
                                                       value="{{ $order->delivery_street_address }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group billing">
                                                <label for="delivery-address-opt">Optional address</label>
                                                <input type="text" class="form-control" id="delivery-address-opt"
                                                       value="{{ $order->delivery_address_opt ?? $order->billing_address_opt }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group billing">
                                                <label for="delivery-zip">ZIP</label>
                                                <input type="text" class="form-control" id="delivery-zip"
                                                       value="{{ $order->delivery_zip }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group billing">
                                                <label for="delivery-company-name">Company</label>
                                                <input type="text" class="form-control" id="delivery-company-name"
                                                       value="{{ $order->delivery_company_name }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-lg-6">
                                            <div class="form-group billing">
                                                <label for="delivery-phone-number">Phone number</label>
                                                <input type="text" class="form-control" id="delivery-phone-number"
                                                       value="{{ $order->delivery_phone_number }}" readonly>
                                                @if($order->delivery_phone_number)
                                                    <a href="tel:{{ $order->delivery_phone_number }}" class="btn-link">
                                                        <i class="fa fa-phone"></i> Call
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group billing">
                                                <label for="delivery-notes">Order Notes</label>
                                                <input type="text" class="form-control" id="delivery-notes"
                                                       value="{{ $order->delivery_order_notes }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row mb-5">
                                        <div class="col-lg-12">
                                            <h4>Pick-up Info</h4>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group billing">
                                                <label for="pickup-location">Location</label>
                                                <input type="text" class="form-control" id="pickup-location"
                                                       value="{{ $order->pickup_location }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group billing">
                                                <label for="pickup-date">Preferred pickup date</label>
                                                <input type="text" class="form-control" id="pickup-date"
                                                       value="{{ $order->pickup_date->format('m/d/Y') }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group billing">
                                                <label for="pickup-time-frame">Preferred pickup time frame</label>
                                                <input type="text" class="form-control" id="pickup-time-frame"
                                                       value="{{ $order->pickup_time_frame_value }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4>Order Items</h4>
                                    </div>
                                    <div class="col-lg-12 table-responsive-sm">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Menu name</th>
                                                <th>Entree meal / Addon</th>
                                                <th>Side meals / Addon meals</th>
                                                <th>Price</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order->orderItems as $orderItem)
                                                <tr>
                                                    <td>
                                                        @if($orderItem->menu_id)
                                                            <a href="{{ route('backend.menus.edit', $orderItem->menu_id) }}">
                                                                {{ $orderItem->portion_size != null ? $orderItem->name . " Size: $orderItem->portion_size oz" : $orderItem->name }}
                                                            </a>
                                                        @else
                                                            {{ $orderItem->name . " Size: $orderItem->portion_size oz" }}
                                                        @endif
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>${{ $orderItem->total_price }}</td>
                                                </tr>
                                                @foreach($orderItem->orderItemables->whereNull('parent_id') as $orderItemable)
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            @if($orderItemable->orderItemable)
                                                                <a href="{{ route("backend.{$orderItemable->orderItemable->getTable()}.edit", $orderItemable->order_itemable_id) }}"
                                                                   class="btn-link">
                                                                    {{ $orderItemable->orderItemable->name  }}
                                                                </a>
                                                            @else
                                                                {{ $orderItemable->orderItemable->name }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <ul>
                                                                @foreach($orderItemable->children as $orderItemableChild)
                                                                    <li>
                                                                        @if($orderItemableChild->orderItemable)
                                                                            <a href="{{ route("backend.{$orderItemableChild->orderItemable->getTable()}.edit", $orderItemableChild->order_itemable_id) }}"
                                                                               class="btn-link">
                                                                                {{ $orderItemableChild->orderItemable->name }}
                                                                            </a>
                                                                        @else
                                                                            {{ $orderItemableChild->orderItemable->name }}
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            @if($orderItem->menu_id === null || $orderItemable->order_itemable_type === \App\Models\Addon::class)
                                                                ${{ $orderItemable->price + $orderItemable->children->sum('price') }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4>Items Count</h4>
                                    </div>
                                    <div class="col-lg-6">
                                        <h5><b>Entries</b></h5>
                                        @foreach($entry as $item)
                                            <p>{{$item['count'] === 1 ? '' : $item['count']}} {{$item['name']}}</p>
                                        @endforeach
                                    </div>
                                    <div class="col-lg-6">
                                        <h5><b>Sides</b></h5>
                                        @foreach($sides as $item)
                                            <p>{{$item['count'] === 1 ? '' : $item['count']}} {{$item['name']}}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#status').on('click', function (e) {
            e.preventDefault();
        });
    </script>
@endpush
