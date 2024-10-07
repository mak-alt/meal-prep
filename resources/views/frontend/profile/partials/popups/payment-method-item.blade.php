<div class="payment-method-box">
    <fieldset class="fieldset">
        <div class="input-wrapper">
            @if(!empty($showLabel))
                <label class="fieldset_sub_label">
                    Primary payment method
                </label>
            @endif
            <input type="text" name="billing_email_address"
                   class="input"
                   value="{{ '•••• •••• •••• ' . substr($paymentProfile->card_number, -4) }}"
                   disabled>
        </div>
    </fieldset>
    <a href="{{ route('frontend.profile.destroy-payment-method', $paymentProfile->id) }}"
       class="btn btn_transparent btn_save" data-action="show-popup" data-popup-with-confirmation="{{ true }}"
       data-popup-id="delete-payment-method" data-request-type="DELETE">
        Delete
    </a>
</div>
