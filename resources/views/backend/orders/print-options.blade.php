@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.orders.print-options') }}
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h2>Print out orders</h2>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select name="type" id="type" class="form-control">
                                                <option value="all" selected>Pickup and Delivery</option>
                                                <option value="pickup">Only Pickup</option>
                                                <option value="delivery">Only Delivery</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="{{route('backend.orders.export.pdf')}}?date=today" id="today-p" class="btn btn-primary" style="width: 180px">Print today orders</a>
                                        <a href="{{route('backend.orders.export.pdf')}}" id="all-p" class="btn btn-primary mt-2" style="width: 180px">Print All orders</a>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="form-group">
                                                <a href="{{route('backend.orders.export.pdf')}}" class="btn btn-primary" id="last-p" style="width: 180px; margin-top: -5px">Print orders for last</a>
                                                <input type="number" name="days" class="form-control" id="days"
                                                       placeholder="00" style="width: 80px; display: initial" min="0">
                                                <label for="days">Days</label>
                                                <p class="text-danger days"></p>
                                            </div>
                                            <div class="ml-2">
                                                <button data-href="{{route('backend.orders.export.pdf')}}"
                                                        class="btn btn-primary" id="pdf-export">
                                                    Date Range Print
                                                    <i class="fas fa-calendar-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h2>Export orders</h2>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="type-e">Type</label>
                                            <select name="type_e" id="type-e" class="form-control">
                                                <option value="all" selected>Pickup and Delivery</option>
                                                <option value="pickup">Only Pickup</option>
                                                <option value="delivery">Only Delivery</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="{{route('backend.orders.export')}}?date=today" id="today-e" class="btn btn-green" style="width: 180px">Export today orders</a>
                                        <a href="{{route('backend.orders.export')}}" id="all-e" class="btn btn-green mt-2" style="width: 180px">Export All orders</a>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="form-group">
                                                <a href="{{route('backend.orders.export')}}" class="btn btn-green" id="last-e" style="width: 180px;margin-top: -5px">Export orders for last</a>
                                                <input type="number" name="days-e" class="form-control" id="days-e"
                                                       placeholder="00" style="width: 80px; display: initial" min="0">
                                                <label for="days-e">Days</label>
                                                <p class="text-danger days-e"></p>
                                            </div>
                                            <div class="ml-2">
                                                <button data-href="{{route('backend.orders.export')}}"
                                                   class="btn btn-green" id="export">
                                                    Data Range Export
                                                    <i class="fas fa-calendar-alt"></i>
                                                </button>
                                            </div>
                                        </div>
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
    <script src="{{asset('assets/backend/js/orders.js')}}"></script>
@endpush
