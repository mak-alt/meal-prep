@extends('backend.auth.layouts.app')

@php
    $bodyClass = 'login-page';
@endphp

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('frontend.landing.index') }}"><b>{{ config('app.name') }}</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                @include('backend.layouts.partials.alerts.flash-messages', ['key' => 'status', 'alertClass' => 'alert-success'])
                @include('backend.layouts.partials.alerts.flash-messages')
                <p class="login-box-msg">Sign in to start your session as a admin</p>
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                               placeholder="Username" autocomplete="name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'name'])
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" value="{{ old('password') }}"
                               placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @include('backend.layouts.partials.alerts.input-error', ['name' => 'password'])
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        @include('backend.layouts.partials.alerts.input-error', ['name' => 'remember'])
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
                <p class="mb-1">
                    <a href="{{ route('backend.auth.password.request') }}">I forgot my password</a>
                </p>
            </div>
        </div>
    </div>
@endsection
