$(function () {
    let $firstNameInput                          = $('[name="first_name"]');
    let $lastNameInput                           = $('[name="last_name"]');
    let $displayNameInput                        = $('[name="display_name"]');
    let $submitPersonalDetailsFormButton         = $('#submit-personal-details-form-button');
    let $submitUpdateEmailFormButton             = $('[data-action="update-email"]');
    let $submitUpdateEmailVerificationFormButton = $('[data-action="verify-email-update"]');
    let $submitUpdatePasswordFormButton          = $('[data-action="update-password"]');

    /**
     * Toggle submit form button statuses.
     */
    if ($firstNameInput.val() === '') {
        $submitPersonalDetailsFormButton.removeClass('btn-green').addClass('btn_disabled');
    } else {
        $submitPersonalDetailsFormButton.removeClass('btn_disabled').addClass('btn-green');
    }
    $firstNameInput.add($lastNameInput).add($displayNameInput).on('input', function () {
        if ($firstNameInput.val() === '') {
            $submitPersonalDetailsFormButton.removeClass('btn-green').addClass('btn_disabled');
        } else {
            $submitPersonalDetailsFormButton.removeClass('btn_disabled').addClass('btn-green');
        }
    });
    $('.email-update-input').add($('#update-email-password')).on('input', function () {
        if ($('.email-update-input').val() === '' || $('#update-email-password').val() === '') {
            $submitUpdateEmailFormButton.removeClass('btn-green').addClass('btn_disabled');
        } else {
            $submitUpdateEmailFormButton.removeClass('btn_disabled').addClass('btn-green');
        }
    });
    $('[name="code"]').on('input', function () {
        if ($('[name="code"]').val() === '') {
            $submitUpdateEmailVerificationFormButton.removeClass('btn-green').addClass('btn_disabled');
        } else {
            $submitUpdateEmailVerificationFormButton.removeClass('btn_disabled').addClass('btn-green');
        }
    });
    $('#current-password, #new-password, #new-password-confirmation').on('input', function () {
        if ($('#current-password').val() !== '' && $('#new-password').val() !== '' && $('#new-password-confirmation').val() !== '') {
            $submitUpdatePasswordFormButton.removeClass('btn_disabled').addClass('btn-green');
        } else {
            $submitUpdatePasswordFormButton.removeClass('btn-green').addClass('btn_disabled');
        }
    });
    $('[name^="delivery_"]').on('input', function () {
        if (
            $('[name="delivery_country"]').val() !== '' &&
            $('[name="delivery_city"]').val() !== '' &&
            $('[name="delivery_state"]').val() !== '' &&
            $('[name="delivery_street_address"]').val() !== '' &&
            $('[name="delivery_zip"]').val() !== ''
        ) {
            if ($('[name="delivery_same_name_as_account_name"]').is(':checked')) {
                $('[data-action="save-delivery-address"]').removeClass('btn_disabled').addClass('btn-green');
            } else {
                if ($('[name="delivery_first_name"]').val() !== '' && $('[name="delivery_last_name"]').val() !== '') {
                    $('[data-action="save-delivery-address"]').removeClass('btn_disabled').addClass('btn-green');
                } else {
                    $('[data-action="save-delivery-address"]').removeClass('btn-green').addClass('btn_disabled');
                }
            }
        } else {
            $('[data-action="save-delivery-address"]').removeClass('btn-green').addClass('btn_disabled');
        }
    });
    $('[name^="billing_"]').on('input', function () {
        if (
            $('[name="billing_country"]').val() !== '' &&
            $('[name="billing_city"]').val() !== '' &&
            $('[name="billing_state"]').val() !== '' &&
            $('[name="billing_street_address"]').val() !== '' &&
            $('[name="billing_zip"]').val() !== '' &&
            $('[name="billing_email"]').val() !== ''
        ) {
            if ($('[name="billing_same_name_as_account_name"]').is(':checked')) {
                $('[data-action="save-billing-address"]').removeClass('btn_disabled').addClass('btn-green');
            } else {
                if ($('[name="billing_first_name"]').val() !== '' && $('[name="billing_last_name"]').val() !== '') {
                    $('[data-action="save-billing-address"]').removeClass('btn_disabled').addClass('btn-green');
                } else {
                    $('[data-action="save-billing-address"]').removeClass('btn-green').addClass('btn_disabled');
                }
            }
        } else {
            $('[data-action="save-billing-address"]').removeClass('btn-green').addClass('btn_disabled');
        }
    });

    /**
     * Submit personal details form.
     */
    $(document).on('click', '.btn-green#submit-personal-details-form-button', function () {
        let $form = $('#personal-details-form');

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
                    showNotificationWithText('Success! Personal details have been successfully saved.');
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    showNotificationWithText('Validation error!', 'error');

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else {
                    showNotificationWithText(JSON.parse(response.responseText).message, 'error');
                }
            }
        });
    });

    /**
     * Submit update email form.
     */
    $(document).on('click', '.btn-green[data-action="update-email"]', function () {
        let $form = $('#update-email-form');

        $.ajax({
            url       : $form.attr('action'),
            type      : $form.find('[name="_method"]').val(),
            data      : $form.serialize(),
            beforeSend: function () {
                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    $form.parents('.popup_wrpr').find('[data-action="close-popup"]').click();
                    $('#verify-email-update-popup').addClass('active');
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    showNotificationWithText('Validation error!', 'error');

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else if (response.status === 429) {
                    showNotificationWithText('Too many attempts!', 'error');
                } else {
                    showNotificationWithText(JSON.parse(response.responseText).message, 'error');
                }
            }
        });
    });

    /**
     * Submit update email verification form.
     */
    $(document).on('click', '.btn-green[data-action="verify-email-update"]', function () {
        let $form = $('#verify-email-update-form');

        $.ajax({
            url       : $form.attr('action'),
            type      : $form.find('[name="_method"]').val(),
            data      : $form.serialize(),
            beforeSend: function () {
                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    $form.parents('.popup_wrpr').find('[data-action="close-popup"]').click();

                    $('.current-email').text(response.data.email);
                    $('#current-email').val(response.data.email).data('initial-data', response.data.email);

                    showNotificationWithText(response.message);
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    showNotificationWithText('Validation error!', 'error');

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else if (response.status === 429) {
                    showNotificationWithText('Too many attempts!', 'error');
                } else {
                    showNotificationWithText(JSON.parse(response.responseText).message, 'error');
                }
            }
        });
    });

    /**
     * Submit update password form.
     */
    $(document).on('click', '.btn-green[data-action="update-password"]', function () {
        let $form = $('#update-password-form');

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

                    showNotificationWithText(response.message);
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    showNotificationWithText('Validation error!', 'error');

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else if (response.status === 429) {
                    showNotificationWithText('Too many attempts!', 'error');
                } else {
                    showNotificationWithText(JSON.parse(response.responseText).message, 'error');
                }
            }
        });
    });

    /**
     * Show delivery address info.
     */
    $(document).on('click', '[data-action="add-delivery-address"]', function (e) {
        e.preventDefault();

        $('#add-addresses-block').hide();
        $('#delivery-address-info').fadeIn();
    });

    /**
     * Show billing address info.
     */
    $(document).on('click', '[data-action="add-billing-address"]', function (e) {
        e.preventDefault();

        $('#add-addresses-block').hide();
        $('#billing-address-info').fadeIn();
    });

    /**
     * Show custom name fields.
     */
    $('[name="delivery_same_name_as_account_name"]').change(function () {
        let $inputs = $('#delivery-first-name, #delivery-last-name');

        $inputs.find('input').val('');

        if ($(this).is(':checked')) {
            if (
                $('[name="delivery_country"]').val() !== '' &&
                $('[name="delivery_city"]').val() !== '' &&
                $('[name="delivery_state"]').val() !== '' &&
                $('[name="delivery_street_address"]').val() !== '' &&
                $('[name="delivery_zip"]').val() !== ''
            ) {
                $('[data-action="save-delivery-address"]').removeClass('btn_disabled').addClass('btn-green');
            } else {
                $('[data-action="save-delivery-address"]').removeClass('btn-green').addClass('btn_disabled');
            }
            $inputs.hide();
        } else {
            $('[data-action="save-delivery-address"]').removeClass('btn-green').addClass('btn_disabled');
            $inputs.fadeIn();
        }
    });
    $('[name="billing_same_name_as_account_name"]').change(function () {
        let $inputs = $('#billing-first-name, #billing-last-name');

        $inputs.find('input').val('');

        if ($(this).is(':checked')) {
            if (
                $('[name="billing_country"]').val() !== '' &&
                $('[name="billing_city"]').val() !== '' &&
                $('[name="billing_state"]').val() !== '' &&
                $('[name="billing_street_address"]').val() !== '' &&
                $('[name="billing_zip"]').val() !== '' &&
                $('[name="billing_email"]').val() !== ''
            ) {
                $('[data-action="save-billing-address"]').removeClass('btn_disabled').addClass('btn-green');
            } else {
                $('[data-action="save-billing-address"]').removeClass('btn-green').addClass('btn_disabled');
            }
            $inputs.hide();
        } else {
            $('[data-action="save-billing-address"]').removeClass('btn-green').addClass('btn_disabled');
            $inputs.fadeIn();
        }
    });

    /**
     * Submit update delivery address form.
     */
    $(document).on('click', '.btn-green[data-action="save-delivery-address"]', function () {
        let $form = $('#update-delivery-address-form');

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
                    $('#delivery-address-info').fadeOut();
                    $('p.delivery-address').text(response.data.delivery_address);
                    $('[data-action="add-delivery-address"]').text('Edit address');

                    if (response.data.update_billing_address) {
                        $('p.billing-address').text(response.data.delivery_address);
                        $('[data-action="add-billing-address"]').text('Edit address');

                        $.each(response.data, function (name, value) {
                            if (name !== 'billing_same_name_as_account_name' && name !== 'billing_first_name' && name !== 'billing_last_name') {
                                $('input[name="' + name + '"]').val(value);
                            }
                        });

                        if ($('[name="billing_email_address"]').val() !== '') {
                            $('[data-action="save-billing-address"]').addClass('btn-green').removeClass('btn_disabled');
                        }
                    }
                    $('#add-addresses-block').fadeIn();

                    showNotificationWithText(response.message);
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    showNotificationWithText('Validation error!', 'error');

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else {
                    showNotificationWithText(JSON.parse(response.responseText).message, 'error');
                }
            }
        });
    });

    /**
     * Submit update billing address form.
     */
    $(document).on('click', '.btn-green[data-action="save-billing-address"]', function () {
        let $form = $('#update-billing-address-form');

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
                    $('#billing-address-info').fadeOut();
                    $('p.billing-address').text(response.data.billing_address);
                    $('[data-action="add-billing-address"]').text('Edit address');

                    if (response.data.update_delivery_address) {
                        $('p.delivery-address').text(response.data.billing_address);
                        $('[data-action="add-delivery-address"]').text('Edit address');

                        $.each(response.data, function (name, value) {
                            if (name !== 'delivery_same_name_as_account_name' && name !== 'delivery_first_name' && name !== 'delivery_last_name') {
                                $('input[name="' + name + '"]').val(value);
                            }
                        });

                        $('[data-action="save-delivery-address"]').addClass('btn-green').removeClass('btn_disabled');
                    }
                    $('#add-addresses-block').fadeIn();

                    showNotificationWithText(response.message);
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    showNotificationWithText('Validation error!', 'error');

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else {
                    showNotificationWithText(JSON.parse(response.responseText).message, 'error');
                }
            }
        });
    });

    /**
     * Submit add payment method form.
     */
    $(document).on('click', '.btn-green[data-action="add-payment-method"]', function () {
        let $form = $('#add-payment-method-form');

        $.ajax({
            url       : $form.attr('action'),
            type      : $form.attr('method'),
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data      : $form.serialize(),
            beforeSend: function () {
                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    $form.parents('.popup_wrpr').find('[data-action="close-popup"]').click();

                    $('p.no-payment-method').fadeOut();
                    $('#payments-block').append(response.data.payment_method_view);

                    showNotificationWithText(response.message);
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    showNotificationWithText('Validation error!', 'error');

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
                } else {
                    showNotificationWithText(JSON.parse(response.responseText).message, 'error');
                }
            }
        });
    });
});
