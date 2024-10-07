$(function () {
    /**
     * Show login popup when /login url is visited.
     */
    if (window.location.pathname === '/login') {
        $('[data-popup-id="login-popup"]').click();
    }

    /**
     * Login.
     */
    $('[data-action="login"]').click(function () {
        let $form = $('#login-form');

        $.ajax({
            url       : $form.attr('action'),
            type      : $form.attr('method'),
            headers   : {
                Accept: 'application/json',
            },
            data      : $form.serialize(),
            beforeSend: function () {
                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                $('#login-popup [data-action="close-popup"]').click();

                let executableSuccessFunctionName = $('#login-popup').data('executable-success-function');

                if (executableSuccessFunctionName !== '' && typeof window[executableSuccessFunctionName] === 'function') {
                    $('meta[name="csrf-token"]').attr('content', response.csrf_token);

                    window[executableSuccessFunctionName]();
                } else {
                    window.location.href = $('#login-popup').data('intended-url');
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
     * Register.
     */
    $('[data-action="register"]').click(function () {
        let $form = $('#register-form');

        $.ajax({
            url       : $form.attr('action'),
            type      : $form.attr('method'),
            headers   : {
                Accept: 'application/json',
                _token : $('meta[name=csrf-token]').attr('content'),
            },
            data      : $form.serialize(),
            beforeSend: function () {
                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                $('#register-popup [data-action="close-popup"]').click();

                showNotificationWithText('You have successfully registered your account.');

                let executableSuccessFunctionName = $('#login-popup').data('executable-success-function');

                if (executableSuccessFunctionName !== '' && typeof window[executableSuccessFunctionName] === 'function') {
                    $('meta[name="csrf-token"]').attr('content', response.csrf_token);

                    window[executableSuccessFunctionName]();
                } else {
                    window.location.href = $('#login-popup').data('intended-url');
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
     * Logout.
     */
    $('[data-action="logout"]').click(function (e) {
        e.preventDefault();

        Swal.fire({
            title             : 'Are you sure?',
            icon              : 'info',
            showCancelButton  : true,
            cancelButtonText  : 'Cancel',
            confirmButtonColor: '#34BC89',
            cancelButtonColor : '#293F94',
            confirmButtonText : 'Yes, log out!'
        }).then((result) => {
            if (result.value) {
                $('#logout-form').submit();
            }
        });
    });

    $('[data-action="reset-password"]').click(function () {
        let $form = $('#password-form');

        $.ajax({
            url       : $form.attr('action'),
            type      : $form.attr('method'),
            headers   : {
                Accept: 'application/json',
            },
            data      : $form.serialize(),
            beforeSend: function () {
                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function () {
                $('#forgot-password-popup [data-action="close-popup"]').click();
                showNotificationWithText('A link was sent to your email, please use it to reset your password.', 'success');
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
