<div class="popup_wrpr login-popup" id="register-popup"
     data-intended-url="{{ $redirectUrl ?? redirect()->intended()->getTargetUrl() }}"
     data-executable-success-function="{{ $executableSuccessFunction ?? '' }}">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn">
                <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
            </a>
            <div class="popup_header">
                <h3 class="popup_title">Sign up</h3>
                <span>
                    Already have an account?
                    <a href="" class="login-link" data-action="show-popup" data-popup-id="login-popup">Log in here</a>
                </span>
            </div>
            <div class="popup-block-wrapper">
                <form action="{{ route('register') }}" method="POST" id="register-form">
                    @csrf
                    <div class="input-wrapper-inner">
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="first-name">First Name</label>
                            <div class="input-wrapper" style="margin-bottom: 0px">
                                <input type="text" name="first_name" class="input" id="first-name" autocomplete="first_name" required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'first_name'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                        </fieldset>
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="last-name">Last Name</label>
                            <div class="input-wrapper" style="margin-bottom: 0px">
                                <input type="text" name="last_name" class="input" id="last-name" autocomplete="last_name" required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'last_name'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                        </fieldset>
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="name">Username</label>
                            <div class="input-wrapper" style="margin-bottom: 0px">
                                <input type="text" name="name" class="input" id="name" autocomplete="name" required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'name'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                        </fieldset>
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="email">Email address</label>
                            <div class="input-wrapper" style="margin-bottom: 0px">
                                <input type="email" name="email" class="input" id="email" autocomplete="email" required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'email'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                        </fieldset>
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="password">Password</label>
                            <div class="input-wrapper" style="margin-bottom: 0px">
                                <input type="password" name="password" class="input" id="password" required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'password'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                        </fieldset>
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="password-conf">Confirmation</label>
                            <div class="input-wrapper" style="margin-bottom: 0px">
                                <input type="password" name="password_confirmation" class="input" id="password-conf" required>
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                            <div class="fieldset_additional">
                                <div class="module__check">
                                    <input type="checkbox" name="subscribe_to_updates" id="subscribe-to-updates"
                                           checked>
                                    <span class="check"></span>
                                    <label class="text" for="subscribe-to-updates">
                                        I want to receive updates about products & promotions.
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <a href="" class="btn btn_transparent" data-action="close-popup">Cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn-green" data-action="register">Sign up</button>
                </div>
            </div>
        </div>
    </div>
</div>
