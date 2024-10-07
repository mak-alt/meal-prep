@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.dashboard') }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $completedOrders }}</h3>
                                <p>Completed Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('backend.orders.index') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $upcomingOrders }}</h3>
                                <p>Upcoming Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('backend.orders.index') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $users }}</h3>
                                <p>Users</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('backend.users.index') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger" style="height: 143px;">
                            <div class="inner">
                                <h3>{{ $countVisitors }}</h3>
                                <p>Unique Visitors / day</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Weekly menu</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-striped table-valign-middle m-0">
                                    <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Price</th>
                                        <th>Meals</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($weeklyMenu as $menu)
                                        <tr>
                                            <td>
                                                {{ $menu->name }}
                                            </td>
                                            <td>${{ $menu->price }}</td>
                                            <td>{{ $menu->meals->implode('name', ', ') }}</td>
                                            <td>
                                                <a href="{{ route('backend.menus.edit', $menu->id) }}"
                                                   class="btn btn-primary">
                                                    Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                <a href="{{ route('backend.menus.index') }}"
                                   class="btn btn-sm btn-secondary float-right">
                                    View All Menus
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Latest Orders</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-striped table-valign-middle m-0">
                                    <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>User</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Receipt</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($latestOrders as $order)
                                        <tr>
                                            <td>
                                                <a href="{{ route('backend.orders.show', $order->id) }}">Order {{ $order->id }}</a>
                                            </td>
                                            <td>{{ $order->receiver_first_name }}</td>
                                            <td>{{ $order->total_price }}</td>
                                            <td>
                                                @if($order->status === \App\Models\Order::STATUSES['upcoming'])
                                                    <span class="badge bg-primary">Upcoming</span>
                                                @elseif($order->status === \App\Models\Order::STATUSES['completed'])
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($order->status === \App\Models\Order::STATUSES['failed'])
                                                    <span class="badge bg-danger">Failed</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('backend.orders.show-receipt', $order->id) }}">
                                                    <i class="fa fa-file-alt"></i> View
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('backend.orders.show', $order->id) }}" target="_blank"
                                                   class="btn btn-primary">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                <a href="{{ route('backend.orders.index') }}"
                                   class="btn btn-sm btn-secondary float-right">
                                    View All Orders
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div class="row col-6">
                    <form method="post" action="{{route('backend.dashboard.pay')}}">
                        @csrf
                        <div class="row">
                            <input type="text" style="width: 100%"
                                   name="card_number" value="4012 0000 3333 0026"
                                   class="input card-number__mask" maxlength="16"
                                   id="card-number"
                                   placeholder="•••• •••• •••• ••••"
                                   autocomplete="cc-number" required>
                        </div>
                        <div class="row mt-2">
                            <input type="text" id="card-expiration"
                                   name="expiration" style="width: 70px"
                                   class="input card-expiration__mask"
                                   placeholder="MM/YY" value="10/22"
                                   autocomplete="cc-exp" required>
                            <input type="password" style="width: 70px"
                                   name="csc"
                                   class="input card-csc__mask"
                                   id="csc" value="002"
                                   autocomplete="cc-csc"
                                   placeholder="•••" required>
                            <button type="submit">Submit</button>
                        </div>
                    </form>
                </div>--}}
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
