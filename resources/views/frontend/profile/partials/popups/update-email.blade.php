<div class="popup_wrpr" id="update-email-popup">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn" data-action="close-popup">
                <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
            </a>
            <div class="popup_header">
                <h3 class="popup_title">Change email address</h3>
            </div>
            <form action="{{ route('frontend.profile.update.email') }}" method="POST" id="update-email-form">
                @csrf
                @method('PATCH')
                <div class="popup_content">
                    <div class="popup_content_item">
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="current-email">Current email address</label>
                            <input type="email" class="input" id="current-email" value="{{ auth()->user()->email }}"
                                   autocomplete="email" data-initial-data="{{ auth()->user()->email }}" disabled>
                        </fieldset>
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="email">New email address</label>
                            <div class="input-wrapper">
                                <input type="email" name="email" class="input email-update-input" id="email" autocomplete="email" required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'email'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                        </fieldset>
                    </div>
                    <div class="popup_content_item">
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="update-email-password">Enter your password</label>
                            <div class="input-wrapper">
                                <input type="password" name="password" class="input" id="update-email-password"
                                       autocomplete="off"
                                       required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'password'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                        </fieldset>
                    </div>
                </div>
            </form>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <a href="" class="btn btn_transparent" data-action="close-popup">Cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_disabled" data-action="update-email">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>
