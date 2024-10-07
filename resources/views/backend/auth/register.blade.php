@extends('backend.auth.layouts.app')

@php
    $bodyClass = 'register-page';
@endphp

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('frontend.landing.index') }}"><b>{{ config('app.name') }}</b></a>
        </div>
        <div class="card">
            <div class="card-body register-card-body">
                @include('backend.layouts.partials.alerts.flash-messages')
                <p class="login-box-msg">Register new admin account</p>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                               placeholder="Name" autocomplete="name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'name'])
                    {{--<div class="input-group mb-3">
                        <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"
                               placeholder="First name" autocomplete="first_name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'first_name'])
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="last_name" value="{{ old('name') }}"
                               placeholder="Name" autocomplete="name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'name'])--}}
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                               autocomplete="email" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'email'])
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'password'])
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password_confirmation"
                               placeholder="Confirm password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'password_confirmation'])
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </div>
                </form>
                <a href="{{ route('backend.auth.login') }}" class="text-center">
                    I already have an account
                </a>
            </div>
        </div>
    </div>
@endsection
