<div class="popup_wrpr popup-success reset-all-popup-forms" id="payment-error">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn" data-action="close-popup">
                <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
            </a>
            <div class="popup_content">
                <img src="{{ asset('assets/frontend/img/error-pass.png') }}" alt="Failed payment icon">
                <h3>Oops!</h3>
                <h4>Transaction wasn't successful. Should we try again?</h4>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_transparent" data-action="back-to-card-details">
                        Back to edit
                    </button>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn-green" data-action="retry-payment"
                       data-listener="{{ route('frontend.gifts.send') }}">
                        Try again
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
