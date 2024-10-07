$(function () {
    let $referralCode          = $('.referal-link-block__text > span');
    let $shareReferralCodeForm = $('#share-referral-code-form');

    /**
     * Toggle submit buttons status.
     */
    $('[name="code"]').on('input', function () {
        if ($(this).val() !== '') {
            $('[data-action="update-referral-code"]').removeClass('btn_disabled').addClass('btn-green');
        } else {
            $('[data-action="update-referral-code"]').removeClass('btn-green').addClass('btn_disabled');
        }
    });
    $('#share-referral-code-form input, #share-referral-code-form textarea').keyup(function () {
        let isFormFilled = true;

        $.each($('#share-referral-code-form').find('input:visible, textarea'), function (index, element) {
            if ($(element).val() === '' && isFormFilled) {
                isFormFilled = false;
            }
        });

        if (isFormFilled) {
            $('[data-action="submit-sharing-referral-code"]').removeClass('btn_disabled').addClass('btn-green');
        } else {
            $('[data-action="submit-sharing-referral-code"]').removeClass('btn-green').addClass('btn_disabled');
        }
    });

    /**
     * Update referral code.
     */
    $(document).on('click', '.btn-green[data-action="update-referral-code"]', function () {
        let $form = $('#update-referral-code-form');

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
                    }).then(() => {
                        $referralCode.text(response.data.referral_code);
                        $('div.copy-link').text(response.data.referral_code_url);
                        $('[data-action="share-via-facebook"]').data('url', response.data.referral_code_url);
                    });
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
     * Copy referral code to clipboard.
     */
    $('[data-action="copy-referral-code"]').click(function () {
        let $temp = $('<input>');

        $('body').append($temp);
        $temp.val($('.copy-link').text()).select();
        document.execCommand('copy');
        $temp.remove();
    });
    $('[data-action="copy-referral-link"]').click(function () {
        let $temp         = $('<input>');
        let $referralCode = $('.copy-link');

        $('body').append($temp);
        $temp.val($referralCode.text()).select();
        document.execCommand('copy');
        $(this).text('Copied');
        $temp.remove();
    });

    /**
     * Share via Facebook.
     */
    $('[data-action="share-via-facebook"]').click(function () {
        window.open(
            'https://www.facebook.com/sharer/sharer.php?u=' + $(this).data('url'),
            'facebook-share-dialog',
            "width=626, height=436"
        );
    });

    /**
     * Submit share referral code form.
     */
    $(document).on('click', '.btn-green[data-action="submit-sharing-referral-code"]', function () {
        $.ajax({
            url       : $shareReferralCodeForm.attr('action'),
            type      : $shareReferralCodeForm.attr('method'),
            data      : $shareReferralCodeForm.serialize(),
            beforeSend: function () {
                $shareReferralCodeForm.find('.input-wrapper').removeClass('error');
                $shareReferralCodeForm.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    let email = $shareReferralCodeForm.find('[name="email"]').val();

                    $shareReferralCodeForm.parents('.popup_wrpr').find('[data-action="close-popup"]').click();

                    Swal.fire({
                        title: 'Success!',
                        text : response.message,
                        icon : 'success',
                        timer: 1500,
                    }).then(() => {
                        $('#referrals-table tbody').prepend('<tr>\n' +
                            '                                    <td>' + email + '</td>\n' +
                            '                                    <td>\n' +
                            '                                        <div class="referals-table__wrapper">\n' +
                            '                                           Pending\n' +
                            '                                        </div>\n' +
                            '                                    </td>\n' +
                            '                                    <td>$0</td>\n' +
                            '                                </tr>');
                    });
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
     * Show login popup when join url is visited and user is not authenticated.
     */
    if (window.location.href.indexOf('loyalty/referrals/join') !== -1) {
        Swal.fire({
            title: 'Referral program!',
            text : 'Please log in or register new account to join our referral program.',
            icon : 'info',
            timer: 2000,
        }).then(() => {
            $('[data-popup-id="login-popup"]').click();
        });
    }
});
