@php($noSidebar = true)
@php($contentClasses = 'password-reset')

@extends('frontend.layouts.app')

@section('content')
    <div class="content_main perfect_scroll">
        <div class="content_box">
            <div class="content_box_part">
                <form action="{{ route('password.update') }}" method="POST">
                    <input type="hidden" name="token" value="{{request()->route('token')}}">
                    <input type="hidden" name="email" value="{{request()->email}}">
                    @csrf
                    <h2 class="content_box_title">Your new password</h2>
                    <div class="box_part_wrapper">
                        <div class="box_part_item">
                            <fieldset class="fieldset">
                                <label class="fieldset_label" for="password">Password</label>
                                <div class="input-wrapper">
                                    <input type="password" name="password" class="input" id="password" required style="min-width: 250px">
                                    @error('password')
                                    <p class="error-text error-input-text active">
                                        {{$message}}
                                    </p>
                                    @enderror
                                    @include('frontend.layouts.partials.app.icons.clear-input')
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="box_part_wrapper">
                        <div class="box_part_item">
                            <fieldset class="fieldset">
                                <label class="fieldset_label" for="password-confirmation">Password Confirmation</label>
                                <div class="input-wrapper">
                                    <input type="password" name="password_confirmation" class="input" id="password-confirmation" required style="min-width: 250px">
                                    @error('password_confirmation')
                                    <p class="error-text error-input-text active">
                                        {{$message}}
                                    </p>
                                    @enderror
                                    @include('frontend.layouts.partials.app.icons.clear-input')
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="box_part_wrapper">
                        <div class="box_part_item">
                            <button type="submit" class="btn btn-green btn_save">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('popups')

@endsection

