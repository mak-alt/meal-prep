@extends('backend.auth.layouts.app')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('frontend.landing.index') }}"><b>{{ config('app.name') }}</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                @include('backend.layouts.partials.alerts.flash-messages', ['key' => 'status', 'alertClass' => 'alert-success'])
                <p class="login-box-msg">Reset your password</p>
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
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
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Reset</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="{{ route('backend.auth.login') }}">
                        <i class="fa fa-arrow-circle-left"></i> Back to login page
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
