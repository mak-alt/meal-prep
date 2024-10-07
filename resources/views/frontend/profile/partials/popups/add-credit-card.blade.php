<div class="popup_wrpr" id="add-credit-card-popup">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn" data-action="close-popup">
                <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
            </a>
            <div class="popup_header">
                <h3 class="popup_title">Add a credit card</h3>
            </div>
            <div class="popup_content">
                <form action="{{ route('frontend.profile.store-payment-method') }}" method="POST"
                      id="add-payment-method-form">
                    @csrf
                    <div class="popup_content_item">
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="card-number">Card Number<span>*</span></label>
                            <div class="input-wrapper">
                                <input type="text" class="input card-number__mask" name="card_number" id="card-number"
                                       autocomplete="cc-number"
                                       placeholder="•••• •••• •••• ••••" required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'card_number'])
                                @include('frontend.layouts.partials.app.icons.clear-input')
                            </div>
                        </fieldset>
                    </div>
                    <div class="popup_content_item popup_content_item_double">
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="expiration">Expiration<span>*</span></label>
                            <div class="input-wrapper">
                                <input type="text" class="input card-expiration__mask" name="expiration" id="expiration"
                                       autocomplete="cc-exp"
                                       placeholder="MM/YY"
                                       required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'expiration'])
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'expiration_month'])
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'expiration_year'])
                            </div>
                        </fieldset>
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="csc">Card Security Code<span>*</span></label>
                            <div class="input-wrapper">
                                <input type="password" class="input card-csc__mask" id="csc" name="csc"
                                       autocomplete="cc-csc"
                                       placeholder="•••"
                                       required>
                                @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'csc'])
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item" data-action="close-popup">
                    <a href="" class="btn btn_transparent">Cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_disabled ignore_button" data-action="add-payment-method"
                            data-disabled-on-open="{{ true }}">
                        Add <span>payment method</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
