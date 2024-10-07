@extends('backend.auth.layouts.app')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('frontend.landing.index') }}"><b>{{ config('app.name') }}</b></a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">
                    You are only one step a way from your new password, recover your password now
                </p>

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{ request()->route('token') }}">

                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                               autocomplete="email" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @include('backend.layouts.partials.app.alerts.input-error', ['name' => 'email'])
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @include('backend.layouts.partials.app.alerts.input-error', ['name' => 'password'])
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password_confirmation"
                               placeholder="Confirm Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @include('backend.layouts.partials.app.alerts.input-error', ['name' => 'password_confirmation'])
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Change password</button>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('backend.auth.login') }}">Login</a>
                </p>
            </div>
        </div>
    </div>
@endsection
