@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.orders.index') }}
        <div class="content">
            <div class="container-fluid">
                {{--<div class="d-flex justify-content-between">
                    <div></div>
                    <div>
                        <a href="{{route('backend.orders.export')}}"
                            class="btn btn-green" id="export">
                            Export
                        </a>
                        <button data-href="{{route('backend.orders.export.pdf')}}"
                           class="btn btn-primary" id="pdf-export">
                            Print
                        </button>
                    </div>
                </div>--}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="search-area row">
                                <div class="col-md-3">
                                    <input type="text" name="search" placeholder="Search..." class="form-control" id="search-field"
                                    value="{{Request::has('search') ? Request::get('search') : ''}}" >
                                </div>
                                <button class="btn btn-primary mr-5px" id="order-date-picker">Order Date</button>
                                <button class="btn btn-primary mr-5px" id="delivery-date-picker">Pickup/ Delivery Date</button>
                                <button class="btn btn-gray" id="clear-filters">X</button>
                            </div>
                            <div class="card-body table-responsive-sm">
                                <table class="table table-bordered table-striped table-normal" style="display: block; overflow-x: auto; white-space: nowrap;">
                                    <thead>
                                    <tr>
                                        <th>Submitted On</th>
                                        <th>Your Order</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Delivery Address</th>
                                        <th>Zipcode</th>
                                        <th>Phone</th>
                                        <th>Delivery/Pickup Day</th>
                                        <th>Type</th>
                                        <th>Delivery Time</th>
                                        <th>Notes</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if($orders->total() === 0)
                                        <tr id="empty_row">
                                            <td colspan="16">No orders were found.</td>
                                        </tr>
                                    @else
                                        @foreach($orders as $order)
                                            @php
                                                $entry = [];
                                                $sides = [];
                                                foreach ($order->orderItems as $orderItem){
                                                    foreach ($orderItem->orderItemables->whereNull('parent_id') as $orderItemable){
                                                        if  (array_key_exists($orderItemable->order_itemable_id, $entry)){
                                                            $entry[$orderItemable->order_itemable_id]['count']++;
                                                        }
                                                        else{
                                                            $entry[$orderItemable->order_itemable_id] = [
                                                                'name' => $orderItemable->orderItemable->name,
                                                                'count' => 1,
                                                            ];
                                                        }
                                                        foreach ($orderItemable->children as $orderItemableChild){
                                                            if  (array_key_exists($orderItemableChild->order_itemable_id, $sides)){
                                                                $sides[$orderItemableChild->order_itemable_id]['count']++;
                                                            }
                                                            else{
                                                                $sides[$orderItemableChild->order_itemable_id] = [
                                                                    'name' => $orderItemableChild->orderItemable->name,
                                                                    'count' => 1,
                                                                ];
                                                            }
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{$order->created_at->format('m/d/Y') ?? ''}}</td>
                                                <td>
                                                    {{$order->id}}
                                                </td>
                                                <td>{{$order->user->first_name}}</td>
                                                <td>{{$order->user->last_name}}</td>
                                                <td>{{$order->user->email}}</td>
                                                <td>{{ $order->delivery_city ?? $order->billing_city ?? '' }}</td>
                                                <td>{{ $order->delivery_state ?? $order->billing_state ?? '' }}</td>
                                                <td>{{ $order->delivery_country ?? $order->billing_country ?? '' }}</td>
                                                <td>{{ $order->delivery_street_address ?? $order->pickup_location ?? '' }}</td>
                                                <td>{{ $order->delivery_zip ?? $order->billing_zip ?? '' }}</td>
                                                <td>{{ $order->delivery_phone_number ?? $order->billing_phone_number ?? '' }}</td>
                                                <td>{{ ($order->delivery_date ?? $order->pickup_date)->format('m/d/Y') ?? '' }}</td>
                                                <td>{{ $order->delivery_date ? 'Delivery' : 'Pickup'}}</td>
                                                <td>{{ $order->delivery_time_frame_value ?? $order->pickup_time_frame_value ?? '' }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit($order->delivery_order_notes ?? '', 60) }}</td>
                                                <td>
                                                    <div class="table_actions_btns">
                                                        <a href="{{ route('backend.orders.show', $order->id) }}"
                                                           class="btn btn-block btn-primary">
                                                            View
                                                        </a>
                                                        <a href="{{ route('backend.orders.destroy', $order->id) }}"
                                                           class="btn btn-block btn-danger" data-action="delete-record">
                                                            Delete
                                                        </a>
                                                        <a href="{{ route('backend.orders.print.pdf', $order->id) }}"
                                                           class="btn btn-block btn-primary">
                                                            Print
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/backend/js/orders.js')}}"></script>
@endpush
