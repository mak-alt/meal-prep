/**
 * Show frontend notification with text.
 */
function showNotificationWithText(text, style = '') {
    if (/Mobi|Android/i.test(navigator.userAgent)) {
        $('.mobile_top_notif span').text(text);
        $('.mobile_header_notif').addClass('active');
        $('.mobile_top_notif').removeClass('error').addClass(style).show();
    }
    $('.success-order-info span').text(text);
    $('.success-order-info').removeClass('error').addClass('active ' + style);
}

/**
 * Proceed to checkout.
 */
function proceedToCheckout(listener = '/checkout/proceed-to-checkout') {
    $.ajax({
        url    : listener,
        type   : 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status === 'success') {
                window.location.href = response.data.redirect;
            }
        },
        error  : function (response) {
            showNotificationWithText(JSON.parse(response.responseText).message, 'error');
        }
    });
}

$(function () {
    /**
     * Init mask js.
     */
    $('.card-number__mask').mask('0000 0000 0000 0000');
    $('.card-expiration__mask').mask('00/00');
    $('.card-csc__mask').mask('0000');
    $('.phone-number__mask').mask('(999) 999-9999');

    /**
     * Open popups based on data attributes.
     */
    $(document).on('click', '[data-action="show-popup"]', function (e) {
        e.preventDefault();
        e.stopPropagation();

        let $this  = $(this);
        let $popup = $('#' + $this.data('popup-id'));
        let $form  = $popup.find('form');

        if ($this.data('popup-with-confirmation') === 1) {
            $popup.find('[data-action="submit-confirmation-popup"]')
                .attr('data-listener', $this.attr('href'))
                .attr('data-request-type', $this.data('request-type'));
        }

        if (typeof $this.data('popup-data') !== 'undefined') {
            $.each($popup.find('[data-field]'), function (index, element) {
                let $element = $(element);

                $element.text($this.data('popup-data')[$element.data('field')]);
            });
        }

        $form.find('.input-wrapper').removeClass('error');
        $form.find('p.error-text[data-field-name]').text('').removeClass('active');

        $('.popup_wrpr').removeClass('active');
        $popup.addClass('active');
        $('body, html').addClass('ovh');
    });

    /**
     * Submit confirmation popup form.
     */
    $(document).on('click', '[data-action="submit-confirmation-popup"]', function (e) {
        e.preventDefault();

        let $this = $(this);

        $.ajax({
            url    : $this.data('listener'),
            type   : $this.data('request-type'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                if (response.status === 'success') {
                    $this.parents('.popup_wrpr').find('[data-action="close-popup"]').click();

                    showNotificationWithText(response.message);

                    if (response.data !== null && typeof response.data.redirect !== 'undefined') {
                        window.location.href = response.data.redirect;
                    } else {
                        window.location.reload();
                    }
                }
            },
            error  : function (response) {
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
     * Close popup and clear form elements.
     */
    $(document).on('click', '[data-action="close-popup"]', function (e) {
        e.preventDefault();

        let $popup = $(this).parents('.popup_wrpr');

        $popup.removeClass('active');
        $('body, html').removeClass('ovh');

        $('.enter-massage-popup, .meals-calculate__picker-button').removeClass('active');

        if ($(this).data('do-not-reset-form') !== 1) {
            $.each($popup.find('input, textarea').not('[name^="_"]'), function (index, element) {
                let $element = $(element);

                $element.val($element.data('initial-data') || '').prop('checked', false);
            });
            $.each($popup.find('button'), function (index, element) {
                let $element = $(element);

                if(!$element.hasClass('ignore_button')) {
                    $element.text($element.data('initial-data') || $element.text());
                }

            });
            $popup.find('select').prop('selectedIndex', 0);
            $popup.find('[data-disabled-on-open="1"]').removeClass('btn-green').addClass('btn_disabled');
        }

        if ($popup.hasClass('reset-all-popup-forms')) {
            let $popupWrappers = $('.popup_wrpr');

            $popupWrappers.find('input, textarea').not('[name^="_"]').val('').prop('checked', false);
            $.each($popupWrappers.find('input[data-initial-data], textarea[data-initial-data]'), function (index, element) {
                let $element = $(element);

                $element.val($element.data('initial-data')).prop('checked', false);
            });
            $popupWrappers.find('.meals-calculate__picker-button').removeClass('active');
            $popupWrappers.find('a.active').removeClass('active');
            $popupWrappers.find('select').prop('selectedIndex', 0);
            $popupWrappers.find('[data-disabled-on-open="1"]').removeClass('btn-green').addClass('btn_disabled');
        }
    });

    /**
     * Redirect based on data attribute.
     */
    $('[data-redirect]').click(function (e) {
        e.preventDefault();

        window.location.href = $(this).data('redirect');
    });

    /**
     * Sort items.
     */
    $('[data-action="sort"]').click(function (e) {
        e.preventDefault();

        let $this = $(this);

        if (!$this.hasClass('active')) {
            $.ajax({
                url    : $this.attr('href'),
                type   : 'GET',
                data   : {
                    sort: {
                        column   : $this.data('sort-column'),
                        direction: $this.data('sort-direction'),
                    },
                },
                success: function (response) {
                    if (response.status === 'success') {
                        let $sortOptionsWrapper = $('.sort-options__wrapper');

                        $('#' + $this.data('items-wrapper-id')).empty().append(response.data.sorted_items_view);

                        $sortOptionsWrapper.find('[data-action="sort"]').removeClass('active');
                        $sortOptionsWrapper.find('.sort-icon__checked').hide();
                        $this.addClass('active');
                        $this.find('.sort-icon__checked').show();
                    }
                },
                error  : function () {
                    showNotificationWithText('Sorting failed.', 'error');
                }
            });
        }
    });

    /**
     * Render and show meal details popup.
     */
    $(document).on('click', '[data-action="show-meal-details-popup"]', function (e) {
        e.preventDefault();
        let $this = $(this);

        $.ajax({
            url    : $this.data('listener'),
            type   : 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data   : {
                show_add_button: $this.data('show-add-btn'),
                show_sides     : $this.data('show-sides'),
                meal_number    : $this.data('meal-number'),
                menu_id        : $this.data('menu-id'),
                selected_id    : $this.data('sel-side-id'),
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('#popup-about-selected-meal').replaceWith(response.data.meal_details_popup_view);
                    $('#popup-about-selected-meal').addClass('active');
                    $('body, html').addClass('ovh');
                }
            },
            error  : function (response) {
                showNotificationWithText(JSON.parse(response.responseText).message, 'error');
            }
        });
    });

    /**
     * Unselect all filters.
     */
    $('[data-action="unselect-all-filters"]').click(function (e) {
        e.preventDefault();

        $(this).parents('.popup_wrpr').find('form').trigger('reset');
        $(this).parents('.popup_wrpr').find('.select-all').show();
        $(this).parents('.popup_wrpr').find('.clean-all').hide();
    });

    $('.select-all').on('click',function (e){
        e.preventDefault();

        $(this).parents('.popup_wrpr').find('.filters-block :input').each( function (index, elem){
            $(elem).trigger('click');
        });
        $(this).parents('.popup_wrpr').find('.select-all').hide();
        $(this).parents('.popup_wrpr').find('.clean-all').show();
    });

    $('.filters-block :input').on('change',function (){
        if($('.filters-block :input:checked').length > 0){
            $(this).parents('.popup_wrpr').find('.select-all').hide();
            $(this).parents('.popup_wrpr').find('.clean-all').show();
        }
        else {
            $(this).parents('.popup_wrpr').find('.select-all').show();
            $(this).parents('.popup_wrpr').find('.clean-all').hide();
        }
    });

    /**
     * Filter.
     */
    $('[data-action="filter"]').click(function (e) {
        e.preventDefault();

        let $this         = $(this);
        let $popupWrapper = $this.parents('.popup_wrpr');
        let $form         = $popupWrapper.find('form');

        $.ajax({
            url    : $form.attr('action'),
            type   : 'GET',
            data   : $form.serialize(),
            success: function (response) {
                if (response.status === 'success') {
                    $popupWrapper.find('[data-action="close-popup"]').click();
                    $('#' + $this.data('items-wrapper-id')).empty().append(response.data.sorted_items_view);
                }
            },
            error  : function (response) {
                showNotificationWithText(response.message, 'error');
            }
        });
    });

    /**
     * Add to cart.
     */
    $(document).on('click', '[data-action="add-to-cart"]', function (e) {
        e.preventDefault();

        if($('[name="user_role"]').val() === 'admin'){
            swal.fire('Warning!', 'You are logged in as Admin, you cant proceed to checkout.', 'warning');
            return false;
        }

        if ($(this).data('before')){
            $.ajax({
                url    : $(this).data('listener'),
                type   : 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 'success') {
                        $.ajax({
                            url : response.data.redirect,
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    window.location.href = response.data.redirect;
                                }
                            },
                            error : function (error) {
                                let data = JSON.parse(error.responseText)
                                if (data.status === 'error'){
                                    swal.fire('Error!', data.message, 'error');
                                }
                            }
                        });
                    }
                },
                error  : function (response) {
                    showNotificationWithText(JSON.parse(response.responseText).message, 'error');
                }
            });
        }
    });

    /**
     * Proceed to checkout.
     */
    $(document).on('click', '.btn-green[data-action="proceed-to-checkout"]', function (e) {
        e.preventDefault();

        proceedToCheckout($(this).data('listener'));
    });

    $('#meal-amount-input').on('keyup', function () {
        let $this = $(this);

        $.each($this.parent().nextAll('.meals-calculate__picker').find('.meals-calculate__picker-button'), function (index, element) {
            let $element = $(element);

            $element.removeClass('active');
            if ($element.data('value') === parseInt($this.val())) {
                $element.addClass('active');
            }
        });
    });

    /**
     * Handle credit card popup submit button status.
     */
    $('[name="card_number"], [name="expiration"], [name="csc"]').on('input', function () {
        let $popup = $(this).parents('.popup_wrpr');

        if ($('[name="card_number"]').val() !== '' && $('[name="expiration"]').val() !== '' && $('[name="csc"]').val() !== '') {
            $popup.find('.popup_btn_wrpr .popup_btn_wrpr_item:last-of-type > [data-action]').removeClass('btn_disabled').addClass('btn-green');
        } else {
            $popup.find('.popup_btn_wrpr .popup_btn_wrpr_item:last-of-type > [data-action]').removeClass('btn-green').addClass('btn_disabled');
        }
    });

    $('.sort-link').click(function (e) {
        e.preventDefault();
    });


    $('.home__wizzard-item').click(function () {
        return false;
    });

    /**
     * Subscribe to newsletter form.
     */
    $('#subscribe-to-newsletter-form').submit(function (e) {
        e.preventDefault();

        let $this        = $(this);
        let $parentBlock = $('.subscribe_form');

        $.ajax({
            url       : $this.attr('action'),
            type      : 'POST',
            data      : $this.serialize(),
            beforeSend: function () {
                $parentBlock.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    // showNotificationWithText(response.message);
                    Swal.fire({
                        title: 'Success!',
                        text : response.message,
                        icon : 'success',
                        timer: 1500,
                    })

                    $('#subscribe-to-newsletter-form').trigger('reset');
                    $('p.error-text[data-field-name="email"]').removeClass('active');;
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    showNotificationWithText('Validation error!', 'error');
                    $.each(JSON.parse(response.responseText).errors, function (field, value) {

                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.text(value[0]).addClass('active').css({
                            position: "inherit",
                            "text-align": "left",
                            "margin-left": "5px",
                        });
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text : "Subscribing to our updates failed.",
                        icon : 'error',
                        timer: 1500,
                    })
                }
            }
        });
    });
});
