<div class="popup_wrpr popup-success popup-success-inner mobile-full" id="send-gift-via-sms-popup">
    <div class="popup_wrpr_inner">
        <div class="popup popup_style2">
            <div class="popup_heading">
                <a href="#" class="close_popup_btn" data-action="close-popup">
                    <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
                    <img class="mob-close" src="{{ asset('assets/frontend/img/down-arrow.svg') }}" alt="Close icon">
                </a>
                <h3>Share via SMS</h3>
            </div>
            <div class="popup_content ">
                <h3>Share via SMS</h3>
                <div class="popup-block-wrapper">
                    <form action="{{ route('frontend.gifts.remember-gift-contacts-info') }}"
                          method="POST" id="gift-card-contacts-form-sms">
                        @csrf
                        <div class="input-wrapper input-wrapper-inner">
                        <label>To:</label>
                        <div class="input-wrapper">
                            <input class="input phone-number__mask" type="text" name="sent_to" placeholder="(404) 805 4726" id="sms_number">
                            @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'sms_number'])
                            @include('frontend.layouts.partials.app.icons.clear-input')
                        </div>
                        <label for="share-via-email-from">From:</label>
                        <div class="input-wrapper">
                            <input type="text" name="sender_name" class="input" id="share-via-email-from"
                                   data-initial-data="{{ $isAuthenticated ? auth()->user()->name : '' }}"
                                   autocomplete="name" value="{{ $isAuthenticated ? auth()->user()->name : '' }}"
                                   required>
                            @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'sender_name'])
                            @include('frontend.layouts.partials.app.icons.clear-input')
                        </div>
                        <label>Message:</label>
                            <textarea name="message" id="share-via-sms-message" class="input" cols="30"
                                      data-initial-data="{{ \App\Models\Gift::getDefaultGiftSMS(session()->get('gift.amount')) }}"
                                      rows="8">{{ \App\Models\Gift::getDefaultGiftSMS(session()->get('gift.amount')) }}</textarea>
                            @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'message'])
                    </div>
                    </form>
                </div>
            </div>
            <div class="popup_btn_wrpr btn-mob-full">
                <div class="popup_btn_wrpr_item">
                    <a href="#" class="btn btn_transparent" data-action="back-to-amount">Back to Amount</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <a href="" class="btn btn_disabled" data-action="submit-gift-card-contacts-form-sms"
                       data-disabled-on-open="{{ true }}">SUBMIT</a>
                </div>
            </div>
        </div>
    </div>
</div>
