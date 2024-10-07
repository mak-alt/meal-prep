<div class="popup_wrpr popup-success mobile-full" id="edit-referral-popup">
    <div class="popup_wrpr_inner">
        <div class="popup popup_style2">
            <div class="popup_heading">
                <a href="" class="close_popup_btn" data-action="close-popup">
                    <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
                    <img class="mob-close" src="{{ asset('assets/frontend/img/down-arrow.svg') }}" alt="Close icon">
                </a>
                <h3>Edit Referral Code</h3>
            </div>
            <div class="popup_content">
                <h3>Edit Referral Code</h3>
                <form action="{{ route('frontend.referrals.update-code') }}" method="POST"
                      id="update-referral-code-form">
                    @csrf
                    @method('PATCH')
                    <div class="popup-block-wrapper input-wrapper input-wrapper-inner">
                        <h4>Edit your custom referral code</h4>
                        <div class="input-wrapper">
                            <input type="text" name="code" class="input" autocomplete="off" required>
                            @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'code'])
                            @include('frontend.layouts.partials.app.icons.clear-input')
                        </div>
                    </div>
                </form>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item" data-action="close-popup">
                    <a href="" class="btn btn_transparent">Cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_disabled" data-action="update-referral-code">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
