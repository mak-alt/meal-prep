<div class="popup_wrpr popup-success popup-success-inner mobile-full reset-all-popup-forms"
     id="send-gift-via-email-popup">
    <div class="popup_wrpr_inner">
        <div class="popup popup_style2">
            <div class="popup_heading">
                <a href="#" class="close_popup_btn" data-action="close-popup">
                    <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
                    <img class="mob-close" src="{{ asset('assets/frontend/img/down-arrow.svg') }}" alt="Close icon">
                </a>
                <h3>Share via Email</h3>
            </div>
            <div class="popup_content">
                <h3>Share via Email</h3>
                <div class="popup-block-wrapper">
                    <form action="{{ route('frontend.gifts.remember-gift-contacts-info') }}"
                          method="POST" id="gift-card-contacts-form">
                        @csrf
                        <div class="input-wrapper-inner">
                            <label for="share-via-email-to">To:</label>
                            <div class="input-wrapper">
                                <input type="email" name="sent_to" class="input" id="share-via-email-to"
                                       autocomplete="email" required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'sent_to'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                            <label for="share-via-email-from">From:</label>
                            <div class="input-wrapper">
                                <input type="email" name="sender_name" class="input" id="share-via-email-from"
                                       data-initial-data="{{ $isAuthenticated ? auth()->user()->name : '' }}"
                                       autocomplete="email" value="{{ $isAuthenticated ? auth()->user()->name : '' }}"
                                       required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'sender_name'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                            <label for="share-via-email-date">Delivery Date:</label>
                            <div class="input-wrapper">
                                <input type="text" name="delivery_date" id="share-via-email-date"
                                       data-initial-data="{{ now()->format('m/d/Y') }}"
                                       value="{{ now()->format('m/d/Y') }}"
                                       class="input input-delivery" placeholder="{{ now()->format('m/d/Y') }}">
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_date'])
                            </div>
                            <label for="share-via-email-message">Message:</label>
                            <div class="input-wrapper">
                                <textarea name="message" id="share-via-email-message" class="input" cols="30"
                                          data-initial-data="{{ \App\Models\Gift::getDefaultGiftMessage(session()->get('gift.amount')) }}"
                                          rows="8">{{ \App\Models\Gift::getDefaultGiftMessage(session()->get('gift.amount')) }}</textarea>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'message'])
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_transparent" data-action="back-to-amount">
                        Back to Amount
                    </button>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_disabled" data-action="submit-gift-card-contacts-form"
                            data-disabled-on-open="{{ true }}">
                        Buy a gift card
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
