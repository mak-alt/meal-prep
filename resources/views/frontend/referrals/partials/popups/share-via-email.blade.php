<div class="popup_wrpr popup-success popup-success-inner mobile-full " id="share-via-email-popup">
    <div class="popup_wrpr_inner">
        <div class="popup popup_style2">
            <div class="popup_heading">
                <a href="" class="close_popup_btn" data-action="close-popup">
                    <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
                    <img class="mob-close" src="{{ asset('/assets/frontend/img/close-menu-icon.svg') }}" alt="Close icon">
                </a>
                <h3>Share via Email</h3>
            </div>
            <div class="popup_content">
                <h3>Share via Email</h3>
                <h4 class="mb-18">
                    Email will be sent from {{ \App\Models\Setting::getSupportEmail() }}
                </h4>
                <div class="popup-block-wrapper">
                    <form action="{{ route('frontend.referrals.send', \App\Models\Gift::DELIVERY_CHANNELS['email']) }}"
                          method="POST" id="share-referral-code-form">
                        @csrf
                        <div class="input-wrapper-inner">
                            <label for="share-via-email-to">To:</label>
                            <div class="input-wrapper">
                                <input type="email" name="email" class="input" id="share-via-email-to"
                                       autocomplete="email" required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'email'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                            <div class="input-wrapper">
                                <label for="share-via-email-subject">Subject:</label>
                                <input type="text" name="subject" class="input" id="share-via-email-subject"
                                       data-initial-data="{{ \App\Models\Referral::getDefaultInvitationSubject() }}"
                                       value="{{ \App\Models\Referral::getDefaultInvitationSubject() }}" required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'subject'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                            <div class="input-wrapper">
                                <label for="share-via-email-message">Message:</label>
                                <textarea name="message" id="share-via-email-message" class="input" cols="30"
                                          rows="8"
                                          data-initial-data="{{ \App\Models\Referral::getDefaultInvitationMessage() }}">{{ \App\Models\Referral::getDefaultInvitationMessage() }}</textarea>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'message'])
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <a href="" class="btn btn_transparent" data-action="close-popup">Cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_disabled" data-action="submit-sharing-referral-code">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
