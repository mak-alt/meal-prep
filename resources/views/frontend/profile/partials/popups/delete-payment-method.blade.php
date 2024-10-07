<div class="popup_wrpr popup-success" id="delete-payment-method">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn" data-action="close-popup">
                <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
            </a>
            <div class="popup_content">
                <img src="{{ asset('assets/frontend/img/payment-successful.png') }}" alt="Credit card icon">
                <h3>Are you sure?</h3>
                <h4>
                    You're are about to delete your payment method. Make sure to add a new payment to streamline your
                    next checkout.
                </h4>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item" data-action="close-popup">
                    <a href="" class="btn btn_transparent">Cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn-green" data-action="submit-confirmation-popup">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
