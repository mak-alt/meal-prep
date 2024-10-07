@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.menus.prices') }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{route('backend.menus.price.update')}}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        @include('backend.layouts.partials.alerts.flash-messages')
                                        <div class="row border-bottom mb-1">
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label for="count">Average meal price</label>
                                                    <input type="number" class="form-control w-100 count-input"
                                                           name="avg_price"
                                                           placeholder="Price..."
                                                           value="{{ old("avg_price", $avg_price) }}"
                                                           required>
                                                    @include('backend.layouts.partials.alerts.input-error', ['name' => "avg_price"])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="addresses">
                                            @foreach($prices as $price)
                                                <div class="row add_price_block" data-number="{{ $loop->index }}">
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label for="count">Amount of meals</label>
                                                            <input type="number" class="form-control w-100 count-input" id="count"
                                                                   name="plan[{{ $loop->index }}][count]"
                                                                   placeholder="Count..."
                                                                   value="{{ old("plan.$loop->index.count", $price->count ?? '') }}"
                                                                   required>
                                                            @include('backend.layouts.partials.alerts.input-error', ['name' => "plan.$loop->index.count"])
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label for="price">Price</label>
                                                            <input type="text" class="form-control w-100 price-input" id="price"
                                                                   name="plan[{{ $loop->index }}][price]"
                                                                   placeholder="Price..."
                                                                   value="{{ old("plan.$loop->index.price", $price->price ?? '') }}"
                                                                   required>
                                                            @include('backend.layouts.partials.alerts.input-error', ['name' => "plan.$loop->index.price"])
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label for="price">Actions</label>
                                                            <button class="btn btn-sm btn-danger remove-price" data-id="{{ $loop->index }}">
                                                                <i class="fa fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button class="btn btn-sm btn-primary add_price_button">
                                            <i class="fa fa-plus"></i> Add new menu price
                                        </button>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/backend/js/menus.js') }}"></script>
@endpush
