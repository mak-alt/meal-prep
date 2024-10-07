<div class="popup_wrpr" id="update-password-popup">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn" data-action="close-popup">
                <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
            </a>
            <div class="popup_header">
                <h3 class="popup_title">Change password</h3>
            </div>
            <div class="popup_content">
                <form action="{{ route('frontend.profile.update.password') }}" method="POST" id="update-password-form">
                    @csrf
                    @method('PATCH')
                    <div class="popup_content_item">
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="current-password">Current password</label>
                            <div class="input-wrapper">
                                <input type="password" class="input" name="current_password" id="current-password"
                                       autocomplete="off"
                                       required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'current_password'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                        </fieldset>
                    </div>
                    <div class="popup_content_item">
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="new-password">Enter new password</label>
                            <p class="fieldset-tooltip">
                                Must include upper and lower case letters, numbers and symbols like ! " ? $ % ^ &
                            </p>
                            <div class="input-wrapper">
                                <input type="password" class="input" name="password" id="new-password"
                                       autocomplete="off"
                                       required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'password'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                        </fieldset>
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="new-password-confirmation">Confirm new password</label>
                            <div class="input-wrapper">
                                <input type="password" class="input" name="password_confirmation" id="new-password-confirmation"
                                       autocomplete="off"
                                       required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'password_confirmation'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
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
                    <button type="button" class="btn btn_disabled ignore_button" data-action="update-password">
                        Update <span>password</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
