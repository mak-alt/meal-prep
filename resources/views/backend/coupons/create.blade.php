@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('backend.coupons.create') }}

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <form action="{{ route('backend.coupons.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    @include('backend.layouts.partials.alerts.flash-messages')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="name">Coupon name</label>
                                                <input type="text" class="form-control" name="coupon_name" id="name"
                                                       value="{{ old('coupon_name') }}"
                                                       placeholder="Coupon name..." required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'coupon_name'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="code">Coupon code</label>
                                                <input type="text" class="form-control" name="coupon_code" id="code"
                                                       value="{{ old('coupon_code') }}"
                                                       placeholder="Code...">
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'coupon_code'])
                                                <button type="button" class="btn btn-primary mt-2 generate-code">
                                                    Generate code
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="discount">Discount</label>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="discount_type"
                                                           id="discount-currency"
                                                           value="currency" {{ old('discount_type') === 'currency' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="discount-currency">$</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="discount_type"
                                                           id="discount-percent"
                                                           value="percent" {{ old('discount_type', 'percent') === 'percent' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="discount-percent">%</label>
                                                </div>
                                                <input type="number" name="discount_value" step="0.01"
                                                       class="form-control" id="discount"
                                                       placeholder="Discount..."
                                                       value="{{ old('discount_value') }}" required>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'discount_value'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" name="description" id="description"
                                                          placeholder="Description...">{{ old('description') }}</textarea>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'description'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="start-date">Start Date:</label>
                                                <div class="input-group date">
                                                    <input type="date" name="start_date" class="form-control"
                                                           value="{{ old('start_date') }}"
                                                           id="start-date" autocomplete="off">
                                                </div>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'start_date'])
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="end-date">Expiration Date:</label>
                                                <div class="input-group date">
                                                    <input type="date" name="expiration_date" class="form-control"
                                                           value="{{ old('end_date') }}"
                                                           id="end-date" autocomplete="off">
                                                </div>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'expiration_date'])
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="users-select">
                                                    Users
                                                </label>
                                                <select class="select2" id="users-select"
                                                        name="users[]"
                                                        data-placeholder="Select users..." multiple
                                                        style="width: 100%;">
                                                    @foreach($users as $user)
                                                        <option
                                                            value="{{ $user->id }}" {{ !old('all_users') && in_array($user->id, old('users', [])) ? 'checked' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @include('backend.layouts.partials.alerts.input-error', ['name' => 'users'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/backend/js/coupons.js') }}"></script>
@endpush
