@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.coupons.index') }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Coupon name</th>
                                        <th>Code</th>
                                        <th>Discount</th>
                                        <th>Start date</th>
                                        <th>Expiration date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($coupons as $coupon)
                                        <tr>
                                            <td>{{ $coupon->id }}</td>
                                            <td>{{ $coupon->coupon_name }}</td>
                                            <td>{{ $coupon->coupon_code }}</td>
                                            <td>{{ $coupon->discount_value }} {{ $coupon->discount_type === 'currency' ? '$' : '%' }}</td>
                                            <td>
                                                @if($coupon->start_date === null)
                                                    Ageless
                                                @else
                                                    {{ \Carbon\Carbon::parse($coupon->start_date)->format('d/m/Y') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($coupon->expiration_date === null)
                                                    Ageless
                                                @else
                                                    {{ \Carbon\Carbon::parse($coupon->expiration_date)->format('d/m/Y')  }}
                                                @endif

                                            </td>
                                            <td>
                                                @if($coupon->start_date === null || $coupon->expiration_date === null)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    @if(now() > \Carbon\Carbon::parse($coupon->start_date) && now() < \Carbon\Carbon::parse($coupon->expiration_date))
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Expired</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <div class="table_actions_btns">
                                                    <a href="{{ route('backend.coupons.edit', $coupon->id) }}"
                                                       class="btn btn-block btn-primary">
                                                        Edit
                                                    </a>
                                                    <a href="{{ route('backend.coupons.destroy', $coupon->id) }}"
                                                       class="btn btn-block btn-danger"
                                                       data-action="delete-record">
                                                        Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $coupons->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
