$(function () {

    $('#meal-amount-input').on('input', function () {
        let $amountMeal = $(this).val();
        let $this = $(this);
        let $mealPrice  = $('#meal-price').data('min_meal_price');

        $.ajax({
            url: $this.data('href'),
            type : 'get',
            data : {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'amountMeal' : $amountMeal,
                'mealPrice' : $mealPrice,
            },
            success : function (response) {
                $('#meal-price').text(response.price);
            }
        })
    });
    /**
     * Show menu options.
     */
    $('[data-action="show-menu-options"]').click(function () {
        $('#order-type-initial').hide();
        $('#order-type-menu-options').fadeIn();
    });

    /**
     * Back to order type selection.
     */
    $('[data-action="back-to-order-type-selection"]').click(function () {
        $('#order-type-menu-options').hide();
        $('#order-type-initial').fadeIn();
    });

    /**
     * Select preferred menu type.
     */
    $('[data-category-id]').click(function () {
        let $this        = $(this);
        let $parentBlock = $('#order-type-menu-options');

        $.ajax({
            url       : $this.data('listener'),
            type      : 'POST',
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data      : {
                category_id: $this.data('category-id'),
            },
            beforeSend: function () {
                $parentBlock.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    window.location.href = response.data.redirect;
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
     * Back to preferred menu type selection.
     */
    $('[data-action="back-to-preferred-menu-type-selection"]').click(function (e) {
        e.preventDefault();

        $('#meal-amount-input').val('').removeClass('error');
        $('p.error-text[data-field-name]').text('').removeClass('active');
        $('.btn-meal').addClass('disable').removeClass('active');
        $('.meals-calculate__picker-button').removeClass('active');
        $('#meal-price').text('');
        $('.meals-calculate__subtitle').removeClass('error');

        $('#meals-amount-selection').hide();
        $('#order-type-initial').fadeIn();
    });

    /**
     * Submit amount of meals selection.
     */
    $(document).on('click', '#proceed-free-meals-selection.active', function () {
        let $this            = $(this);
        let $parentBlock     = $('#meals-amount-selection');
        let $mealAmountInput = $('#meal-amount-input');

        $.ajax({
            url       : $this.data('listener'),
            type      : 'POST',
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data      : {
                amount: $mealAmountInput.val(),
            },
            beforeSend: function () {
                $mealAmountInput.removeClass('error');
                $parentBlock.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    window.location.href = response.data.redirect;
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    Swal.fire({
                        title: 'Validation error!',
                        icon : 'error',
                        timer: 1000,
                    });

                    $mealAmountInput.addClass('error');
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
     * Free meal selection.
     */
    $('[data-action="free-meals-selection"]').click(function () {
        $('#order-type-initial').hide();
        $('#meals-amount-selection').fadeIn();
    });
});
