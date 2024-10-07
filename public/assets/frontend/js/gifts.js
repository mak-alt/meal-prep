$(function () {
    let $deliveryChannelHiddenInput       = $('[name="delivery_channel"]');
    let $deliveryChannelOptions           = $('[data-delivery-channel]');
    let $purchaseGiftCardPopup            = $('#purchase-gift-card-popup');
    let $sendViaEmailPopup                = $('#send-gift-via-email-popup');
    let $sendViaSmsPopup                  = $('#send-gift-via-sms-popup');
    let $submitGiftCardOptionsFormButton  = $('[data-action="submit-gift-card-options-form"]');
    let $submitGiftCardContactsFormButton = $('[data-action="submit-gift-card-contacts-form"]');
    let $submitGiftCardContactsFormButtonSMS = $('[data-action="submit-gift-card-contacts-form-sms"]');
    let $amountInput                      = $('[name="amount"]');
    let $submitRedeemGiftCardButton       = $('[data-action="redeem-gift-card"]');

    $('.input-delivery').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minDate: new Date(),
        autoUpdateInput: true,
    });

    /**
     * Select delivery type.
     */
    $deliveryChannelOptions.click(function () {
        let $this = $(this);

        $deliveryChannelHiddenInput.val($this.data('delivery-channel'));
        $deliveryChannelOptions.removeClass('active');
        $this.addClass('active');

        if ($amountInput.val() >= 1) {
            $submitGiftCardOptionsFormButton.removeClass('btn_disabled').addClass('btn-green');
        } else {
            $submitGiftCardOptionsFormButton.removeClass('btn-green').addClass('btn_disabled');
        }
    });

    /**
     * Toggle gift popup submit buttons status.
     */
    $amountInput.on('input', function () {
        if (parseInt($(this).val()) >= 1 && $deliveryChannelHiddenInput.val() !== '') {
            $submitGiftCardOptionsFormButton.removeClass('btn_disabled').addClass('btn-green');
        } else {
            $submitGiftCardOptionsFormButton.removeClass('btn-green').addClass('btn_disabled');
        }
    });
    $('#gift-card-contacts-form input, #gift-card-contacts-form textarea').keyup(function () {
        if (
            $('#gift-card-contacts-form [name="sent_to"]').val() !== '' &&
            $('#gift-card-contacts-form [name="sender_name"]').val() !== '' &&
            $('#gift-card-contacts-form [name="message"]').val() !== ''
        ) {
            $submitGiftCardContactsFormButton.removeClass('btn_disabled').addClass('btn-green');
        } else {
            $submitGiftCardContactsFormButton.removeClass('btn-green').addClass('btn_disabled');
        }
    });
    $('#gift-card-contacts-form-sms input, #gift-card-contacts-form-sms textarea').keyup(function () {
        if (
            $('#gift-card-contacts-form-sms [name="sent_to"]').val().length === 14 &&
            $('#gift-card-contacts-form-sms [name="sender_name"]').val() !== '' &&
            $('#gift-card-contacts-form-sms [name="message"]').val() !== ''
        ) {
            $submitGiftCardContactsFormButtonSMS.removeClass('btn_disabled').addClass('btn-green');
        } else {
            $submitGiftCardContactsFormButtonSMS.removeClass('btn-green').addClass('btn_disabled');
        }
    });
    $('[name="code"]').on('input', function () {
        if ($(this).val() !== '') {
            $submitRedeemGiftCardButton.removeClass('btn_disabled').addClass('btn-green');
        } else {
            $submitRedeemGiftCardButton.removeClass('btn-green').addClass('btn_disabled');
        }
    });

    /**
     * Validate gift card details form.
     */
    $(document).on('click', '.btn-green[data-action="submit-gift-card-options-form"]', function () {
        let $form = $('#gift-card-options-form');

        $.ajax({
            url       : $form.attr('action'),
            type      : $form.attr('method'),
            data      : $form.serialize(),
            beforeSend: function () {
                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    $purchaseGiftCardPopup.removeClass('active');

                    if ($deliveryChannelHiddenInput.val() === 'email') {
                        $sendViaEmailPopup.addClass('active');
                    } else {
                        $sendViaSmsPopup.addClass('active');
                    }
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    Swal.fire({
                        title: 'Validation error!',
                        icon : 'error',
                        timer: 1000,
                    });

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text : JSON.parse(response.responseText).message,
                        icon : 'error',
                        timer: 1500,
                    });
                }
            }
        });
    });

    /**
     * Back to amount.
     */
    $('[data-action="back-to-amount"]').click(function () {
        $sendViaEmailPopup.removeClass('active');
        $sendViaSmsPopup.removeClass('active');
        $purchaseGiftCardPopup.addClass('active');
    });

    /**
     * Submit gif card contacts form.
     */
    $(document).on('click', '.btn-green[data-action="submit-gift-card-contacts-form"]', function () {
        let $form = $('#gift-card-contacts-form');

        $.ajax({
            url       : $form.attr('action'),
            type      : $form.attr('method'),
            data      : $form.serialize(),
            beforeSend: function () {
                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    window.location.href = response.data.redirect;
                    // $form.parents('.popup_wrpr').find('[data-action="close-popup"]').click();
                    // $('#make-gift-payment').addClass('active');
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    Swal.fire({
                        title: 'Validation error!',
                        icon : 'error',
                        timer: 1000,
                    });

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text : JSON.parse(response.responseText).message,
                        icon : 'error',
                        timer: 1500,
                    });
                }
            }
        });
    });

    /**
     * Submit gif card payment form.
     */
/*    $(document).on('click', '.btn-green[data-action="make-payment"]', function () {
        let $form  = $('#gift-payment-form');
        let $popup = $form.parents('.popup_wrpr');

        $.ajax({
            url       : $form.attr('action'),
            type      : $form.attr('method'),
            data      : $form.serialize(),
            beforeSend: function () {
                $popup.find('[data-action="make-payment"]').removeClass('btn-green').addClass('btn_disabled');
                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                $popup.find('[data-action="make-payment"]').removeClass('btn_disabled').addClass('btn-green');

                if (response.status === 'success') {
                    $form.parents('.popup_wrpr').find('[data-action="close-popup"]').click();

                    Swal.fire({
                        title: 'Success!',
                        text : response.message,
                        icon : 'success',
                        timer: 1500,
                    });
                }
            },
            error     : function (response) {
                $popup.find('[data-action="make-payment"]').removeClass('btn_disabled').addClass('btn-green');

                if (response.status === 422) {
                    Swal.fire({
                        title: 'Validation error!',
                        icon : 'error',
                        timer: 1000,
                    });

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else if (response.status === 402) {
                    $('#make-gift-payment').removeClass('active');

                    $('#payment-error').addClass('active');
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text : JSON.parse(response.responseText).message,
                        icon : 'error',
                        timer: 1500,
                    });
                }
            }
        });
    });*/

    $(document).on('click', '.btn-green[data-action="make-payment"]', function () {
        let $form  = $('#gift-payment-form');
        let $popup = $form.parents('.popup_wrpr');

        $.ajax({
            url       : $form.attr('action'),
            type      : $form.attr('method'),
            data      : $form.serialize(),
            beforeSend: function () {
                // $popup.find('[data-action="make-payment"]').removeClass('btn-green').addClass('btn_disabled');
                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                $popup.find('[data-action="make-payment"]').removeClass('btn_disabled').addClass('btn-green');

                window.location.href = response.data.redirect;
            },
            error     : function (response) {
                $popup.find('[data-action="make-payment"]').removeClass('btn_disabled').addClass('btn-green');

                if (response.status === 422) {
                    Swal.fire({
                        title: 'Validation error!',
                        icon : 'error',
                        timer: 1000,
                    });

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else if (response.status === 402) {
                    $('#make-gift-payment').removeClass('active');

                    $('#payment-error').addClass('active');
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text : JSON.parse(response.responseText).message,
                        icon : 'error',
                        timer: 1500,
                    });
                }
            }
        });
    });


    /**
     * Back to gift payment details.
     */
    $('[data-action="back-to-card-details"]').click(function () {
        $('#payment-error').removeClass('active');
        $('#make-gift-payment').addClass('active');
    });

    /**
     * Retry failed payment.
     */
    $(document).on('click', '.btn-green[data-action="retry-payment"]', function () {
        let $this      = $(this);
        let $form      = $('#gift-payment-form');
        let $formPopup = $form.parents('.popup_wrpr');

        $.ajax({
            url       : $this.data('listener'),
            type      : 'POST',
            data      : $form.serialize(),
            beforeSend: function () {
                $this.removeClass('btn-green').addClass('btn_disabled');
                $formPopup.find('[data-action="make-payment"]').removeClass('btn-green').addClass('btn_disabled');
                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                $this.removeClass('btn_disabled').addClass('btn-green');
                $formPopup.removeClass('btn_disabled').addClass('btn-green');

                if (response.status === 'success') {
                    $this.parents('.popup_wrpr').find('[data-action="close-popup"]').click();

                    Swal.fire({
                        title: 'Success!',
                        text : response.message,
                        icon : 'success',
                        timer: 1500,
                    });
                }
            },
            error     : function (response) {
                $this.removeClass('btn_disabled').addClass('btn-green');
                $formPopup.find('[data-action="make-payment"]').removeClass('btn_disabled').addClass('btn-green');

                if (response.status === 422) {
                    Swal.fire({
                        title: 'Validation error!',
                        icon : 'error',
                        timer: 1000,
                    });

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else if (response.status === 402) {
                    $('#make-gift-payment').removeClass('active');

                    $('#payment-error').addClass('active');
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text : JSON.parse(response.responseText).message,
                        icon : 'error',
                        timer: 1500,
                    });
                }
            }
        });
    });

    /**
     * Submit redeem gift card form.
     */
    $(document).on('click', '.btn-green[data-action="redeem-gift-card"]', function () {
        let $form = $('#redeem-gift-card-form');

        $.ajax({
            url       : $form.attr('action'),
            type      : $form.attr('method'),
            data      : $form.serialize(),
            beforeSend: function () {
                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    $form.parents('.popup_wrpr').find('[data-action="close-popup"]').click();

                    Swal.fire({
                        title: 'Success!',
                        text : response.message,
                        icon : 'success',
                        timer: 1500,
                    });
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text : JSON.parse(response.responseText).message,
                        icon : 'error',
                        timer: 1500,
                    });
                }
            }
        });
    });

    $(document).on('click', '.btn-green[data-action="submit-gift-card-contacts-form-sms"]', function (e) {
        e.preventDefault();
        let $form = $('#gift-card-contacts-form-sms');
        $.ajax({
            url       : $form.attr('action'),
            type      : $form.attr('method'),
            data      : $form.serialize(),
            beforeSend: function () {
                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    window.location.href = response.data.redirect;
/*                    $form.parents('.popup_wrpr').find('[data-action="close-popup"]').click();

                    $('#make-gift-payment').addClass('active');*/
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    Swal.fire({
                        title: 'Validation error!',
                        icon : 'error',
                        timer: 1000,
                    });

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text : JSON.parse(response.responseText).message,
                        icon : 'error',
                        timer: 1500,
                    });
                }
            }
        });
    });
});
