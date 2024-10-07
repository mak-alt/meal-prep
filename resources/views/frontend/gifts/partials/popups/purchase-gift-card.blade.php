<div class="popup_wrpr mobile-full" id="purchase-gift-card-popup">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <div class="popup_heading">
                <a href="" class="close_popup_btn" data-action="close-popup">
                    <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
                    <img class="mob-close" src="{{ asset('assets/frontend/img/down-arrow.svg') }}"
                         alt="Arrow down icon">
                </a>
            </div>
            <div class="popup_header">
                <h3 class="popup_title">Specify the details about your gift card</h3>
            </div>
            <div class="popup_content popup_content_no-padding">
                <div class="home__wizzard__container home__meals-container">
                    <form action="{{ route('frontend.gifts.remember-gift-options') }}" method="POST"
                          id="gift-card-options-form">
                        @csrf
                        <div class="meals-calculate meals-calculate-inner">
                            <div class="meals-calculate__title">
                                Enter the gift amount
                            </div>
                            <div class="input-wrapper">
                                <input type="number" name="amount" class="input-check" min="1"
                                       data-min-allowed-value="1" required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'amount'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                            <div class="meals-calculate__picker">
                                <div class="meals-calculate__picker-row flex">
                                    <button type="button" class="meals-calculate__picker-button" data-value="25">
                                        $25
                                    </button>
                                    <button type="button" class="meals-calculate__picker-button" data-value="50">
                                        $50
                                    </button>
                                    <button type="button" class="meals-calculate__picker-button" data-value="100">
                                        $100
                                    </button>
                                    <button type="button" class="meals-calculate__picker-button" data-value="150">
                                        $150
                                    </button>
                                </div>
                            </div>
                            <div class="meals-calculate__title">
                                Select the delivery type
                            </div>
                            <div class="select-type">
                                <a href="" class="enter-massage-popup"
                                   data-delivery-channel="{{ \App\Models\Gift::DELIVERY_CHANNELS['email'] }}">
                                    <img src="{{ asset('assets/frontend/img/popup_mail.svg') }}" alt="Email icon">
                                    Email
                                </a>
                                <a href="" class="enter-massage-sms-popup"
                                   data-delivery-channel="{{ \App\Models\Gift::DELIVERY_CHANNELS['sms'] }}">
                                    <img src="{{ asset('assets/frontend/img/popup_sms.svg') }}" alt="SMS icon">
                                    SMS
                                </a>
                                <input type="hidden" name="delivery_channel">
                            </div>
                            @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_channel'])
                        </div>
                    </form>
                </div>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <a href="" class="btn btn_transparent" data-action="close-popup">Cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_disabled" data-action="submit-gift-card-options-form"
                            data-disabled-on-open="{{ true }}">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
