<div class="popup_wrpr " id="verify-email-update-popup">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn" data-action="close-popup">
                <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
            </a>
            <div class="popup_header">
                <h3 class="popup_title">Change email address</h3>
            </div>
            <div class="popup_content">
                <form action="{{ route('frontend.profile.update.email') }}" method="POST" id="verify-email-update-form">
                    @csrf
                    @method('PATCH')
                    <div class="popup_content_item">
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="code">Enter the code</label>
                            <div class="fieldset_previous">
                                Go to your previous email address to find a verification code
                            </div>
                            <div class="input-wrapper">
                                <input type="number" name="code" class="input" id="code" autocomplete="off" required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'code'])
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
                    <button class="btn btn_disabled" data-action="verify-email-update">Verify</button>
                </div>
            </div>
        </div>
    </div>
</div>
