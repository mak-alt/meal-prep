$(function () {
    let $orderCalories = $('.order-calories > span');
    let $orderFats     = $('.order-fats > span');
    let $orderCarbs    = $('.order-carbs > span');
    let $orderProteins = $('.order-proteins > span');
    let $mealsPrice    = $('.meals-price');
    let $pointsAmount  = $('.points');

    //$('.header__nav').scrollLeft(100);
    //$('.header__nav').animate({scrollLeft:$('[data-meal-number="9"]').offset().left});
    if ($('.order-menu-heade__link.check.active').offset().left < 1000){
        $('.header__nav').animate({scrollLeft:0});
    }else{
        $('.header__nav').animate({scrollLeft:$('.order-menu-heade__link.check.active').offset().left - 1000});
    }

    /**
     * Toggle entry meal selection.
     */
    $(document).on('click', '[data-action="toggle-entry-meal-selection"]', function () {
        let $this      = $(this);
        let mealNumber = $this.data('meal-number');

        $.ajax({
            url       : $this.data('listener'),
            type      : 'POST',
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data      : {
                meal_number: mealNumber,
                operation  : $this.data('operation'),
            },
            beforeSend: function () {
                $('#wizard-next').removeClass('btn-green').addClass('btn_disabled');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    let orderCaloriesValue = parseInt($orderCalories.text());
                    let orderFatsValue     = parseInt($orderFats.text());
                    let orderCarbsValue    = parseInt($orderCarbs.text());
                    let orderProteinsValue = parseInt($orderProteins.text());
                    let mealsPriceValue    = parseInt($mealsPrice.text());
                    let pointsAmountValue  = parseInt($pointsAmount.text());

                    if (response.data.removing_from_order) {
                        $('#mobileConfirm').hide();
                        $('.order-selection').show();
                        $('.order-value').show();
                        $('.your-meal-hide').hide();
                        $('.content_cart__title').text('Your meal plan');
                        $('#review-order').hide();
                        $('.close_popup_btn').trigger('click');
                        $this.removeClass('btn_transparent').addClass('btn-green').data('operation', 'select').text('Select');
                        $('.btn-select').removeClass('btn_transparent btn_red').addClass('btn-green').data('operation', 'select').text('Select');
                        $('#wizard-next').removeClass('btn-green').addClass('btn_disabled');

                        $('#meals .entry-item').fadeIn();
                        $('.order-step__1 .order-step__selected-icon').hide();

                        $('#side-meals-wrapper').hide();
                        $('#sides').empty();

                        $('#discard-all').hide();
                        $('#duplicate').hide();

                        $('#entry-selection .order-selection__item[data-meal-number="' + mealNumber + '"]').remove();
                        $('#sides-selection .order-selection__item[data-meal-number="' + mealNumber + '"]').remove();
                        $('.order-menu-heade__item[data-meal-number="' + mealNumber + '"] a').find('.check').hide();

                        $orderCalories.text(orderCaloriesValue - response.data.micronutrients_data.calories - response.data.unselected_sides.micronutrients_data.calories);
                        $orderFats.text(orderFatsValue - response.data.micronutrients_data.fats - response.data.unselected_sides.micronutrients_data.fats);
                        $orderCarbs.text(orderCarbsValue - response.data.micronutrients_data.carbs - response.data.unselected_sides.micronutrients_data.carbs);
                        $orderProteins.text(orderProteinsValue - response.data.micronutrients_data.proteins - response.data.unselected_sides.micronutrients_data.proteins);
                        $pointsAmount.text(pointsAmountValue - response.data.points - response.data.unselected_sides.points);
                        $mealsPrice.text(mealsPriceValue - response.data.price - response.data.unselected_sides.price);

                        $('.open-menu').first().removeClass('step1_selected')
                    } else {
                        $('.close_popup_btn').trigger('click');
                        if(response.data.meal_id !== null){
                            $(document).find('[data-meal-id="' + response.data.meal_id +'"]').closest('.open-menu').find('.open-menu__header').trigger('click');
                        }
                        $('.btn-unselect').removeClass('btn-green').addClass('btn_red').data('operation', 'unselect').text('Unselect');
                        $('.btn-select').removeClass('btn-green').addClass('btn_transparent').data('operation', 'unselect').text('Unselect');
                        $('.entry-meal').trigger('click');
                        $('.order-step__1').removeClass('warning');
                        $('.order-step__1 .order-step__selected-icon.warning').hide();
                        $('.order-step__2').removeClass('warning');
                        $('.order-step__2 .order-step__selected-icon.warning').hide();
                        $('.order-menu-heade__item[data-meal-number="' + mealNumber + '"] a').find('.warning').hide();

                        $this.removeClass('btn-green').addClass('btn_transparent').data('operation', 'unselect').text('Unselect');
                        $('#meals .entry-item').not('[data-meal-id="' + $this.data('meal-id') + '"]').hide();
                        $('.order-step__1 .order-step__selected-icon.check').show();

                        $('#entry-selection').append('<li class="order-selection__item" data-meal-number="' + mealNumber + '">' + response.data.name + '</li>');
                        $orderCalories.text(orderCaloriesValue + response.data.micronutrients_data.calories);
                        $orderFats.text(orderFatsValue + response.data.micronutrients_data.fats);
                        $orderCarbs.text(orderCarbsValue + response.data.micronutrients_data.carbs);
                        $orderProteins.text(orderProteinsValue + response.data.micronutrients_data.proteins);
                        $pointsAmount.text(pointsAmountValue + response.data.points);
                        $mealsPrice.text(mealsPriceValue + response.data.price);

                        if (response.data.sides_count > 0) {
                            $('#side-meals-wrapper').fadeIn();
                            $('#sides').empty().append(response.data.sides_view);

                            if (response.data.required_sides_selected === true) {
                                $('.order-menu-heade__item[data-meal-number="' + mealNumber + '"] a').find('.warning').hide();
                                $('.order-menu-heade__item[data-meal-number="' + mealNumber + '"] a').find('.check').show();
                                $('#duplicate').fadeIn();
                                $('#wizard-next').removeClass('btn_disabled').addClass('btn-green');
                            }
                        } else {
                            $('.order-menu-heade__item[data-meal-number="' + mealNumber + '"] a').find('.warning').hide();
                            $('.order-menu-heade__item[data-meal-number="' + mealNumber + '"] a').find('.check').show();
                            $('#duplicate').fadeIn();
                            $('#wizard-next').removeClass('btn_disabled').addClass('btn-green');
                            if( $('#mobileConfirm').css('position') == 'fixed' ) {
                                $('#mobileConfirm').show();
                            }
                            if (response.data.last_step){
                                $('#review-order').show();
                                $('.order-selection').hide();
                                $('.order-value').hide();
                                $('.your-meal-hide').show();
                                $('.content_cart__title').text('Before you go');
                            }
                        }

                        $('#discard-all').fadeIn();

                        $('.open-menu').first().addClass('step1_selected');
                    }

                    refreshPortionSizesAdditionToTotalPriceValues();
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    Swal.fire({
                        title: 'Validation error!',
                        text : 'Some data has been corrupted.',
                        icon : 'error',
                        timer: 1500,
                    });
                } else {
                    Swal.fire('Error!', JSON.parse(response.responseText).message, 'error');
                }
            }
        });
    });

    /**
     * Toggle side meal selection.
     */
    $(document).on('click', '.btn-green[data-action="toggle-side-meal-selection"]', function (e) {
        e.preventDefault();

        let $this      = $(this);
        let operation  = $this.data('operation');
        let mealNumber = $this.data('meal-number');
        let selectedId = $this.closest('.entry-item__amount_picker').find('.entry-item__amount_picker-digit').data('sel-side-id');

        $.ajax({
            url       : $this.attr('href'),
            type      : 'POST',
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data      : {
                meal_number: mealNumber,
                operation  : operation,
                selected_id: selectedId,
            },
            beforeSend: function () {
                $('#wizard-next').removeClass('btn-green').addClass('btn_disabled');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    let $selectedAmount = $this.parent().find('.entry-item__amount_picker-digit');

                    if (response.data.required_side_meals_selected) {
                        if (response.data.entry_meal_selected) {
                            $('#wizard-next').removeClass('btn_disabled').addClass('btn-green');
                        }

                        if (response.data.last_step){
                            $('#review-order').show();
                            $('.order-selection').hide();
                            $('.order-value').hide();
                            $('.your-meal-hide').show();
                            $('.content_cart__title').text('Before you go');
                        }

                        let sideSelected = Object.entries(response.data.side_selected).map(function (element) {
                            return element[1];
                        });

                        $('#sides>.entry-item').each(function (index, item) {
                            if(!sideSelected.includes($(item).data('side-id'))) {
                                $(item).hide();
                            }
                        });
                        $('.close_popup_btn').trigger('click');
                        $('[data-action="toggle-side-meal-selection"][data-operation="select"]')
                            .removeClass('btn-green')
                            .addClass('btn_disabled');
                        $('.btn-green[data-action="toggle-side-meal-selection"][data-operation="select"]')
                            .parent()
                            .find('[data-action="toggle-side-meal-selection"][data-operation="unselect"]')
                            .removeClass('btn_disabled')
                            .addClass('btn-green');
                        $('.order-step__2').removeClass('warning');
                        $('.order-step__2 .order-step__selected-icon.warning').hide();
                        $('.order-step__2 .order-step__selected-icon.check').show();
                        if( $('#mobileConfirm').css('position') == 'fixed' ) {
                            $('#mobileConfirm').show();
                        }
                        if (response.data.entry_meal_selected) {
                            $('.order-menu-heade__item[data-meal-number="' + mealNumber + '"] a').find('.warning').hide();
                            $('.order-menu-heade__item[data-meal-number="' + mealNumber + '"] a').find('.check').show();
                            $('#duplicate').fadeIn();
                        }

                        if (parseInt($selectedAmount.text()) >= response.side_count) {
                            return false;
                        }
                    }

                    $selectedAmount.prev('[data-action="toggle-side-meal-selection"][data-operation="unselect"]')
                        .removeClass('btn_disabled')
                        .addClass('btn-green');

                    let orderCaloriesValue = parseInt($orderCalories.text());
                    let orderFatsValue     = parseInt($orderFats.text());
                    let orderCarbsValue    = parseInt($orderCarbs.text());
                    let orderProteinsValue = parseInt($orderProteins.text());
                    let $sideMealPrice     = $this.parents('.entry-item').find('.side-price');

                    if (operation === 'select') {
                        $selectedAmount.text(parseInt($selectedAmount.text()) + 1);
                        if(response.data.selected_id !== null && response.data.selected_id === $selectedAmount.data('sel-side-id')){
                            $(document).find('.main-picker[data-sel-side-id="' + response.data.selected_id +'"]').text($selectedAmount.text());
                            $sideMealPrice = $(document).find('.main-picker[data-sel-side-id="' + response.data.selected_id +'"]').closest('.entry-item__right').find('.side-price');
                        }
                        $(document).find('.main-picker[data-sel-side-id="' + response.data.selected_id +'"]')
                            .parent()
                            .find('[data-action="toggle-side-meal-selection"][data-operation="unselect"]')
                            .removeClass('btn_disabled')
                            .addClass('btn-green');
                        if ($('#sides-selection .order-selection__item[data-side-id="' + response.data.side_id + '"][data-meal-number="' + mealNumber + '"]').length > 0) {
                            $('#sides-selection .order-selection__item[data-side-id="' + response.data.side_id + '"][data-meal-number="' + mealNumber + '"]')
                                .first()
                                .after('<li class="order-selection__item" data-side-id="' + response.data.side_id + '" data-meal-number="' + mealNumber + '">' + response.data.name + '</li>');
                        } else {
                            $('#sides-selection')
                                .append('<li class="order-selection__item" data-side-id="' + response.data.side_id + '" data-meal-number="' + mealNumber + '">' + response.data.name + '</li>');
                        }

                        $orderCalories.text(orderCaloriesValue + response.data.micronutrients_data.calories);
                        $orderFats.text(orderFatsValue + response.data.micronutrients_data.fats);
                        $orderCarbs.text(orderCarbsValue + response.data.micronutrients_data.carbs);
                        $orderProteins.text(orderProteinsValue + response.data.micronutrients_data.proteins);

                        if ((parseInt($sideMealPrice.text()) + parseInt(response.data.price)) === 0) {
                            $sideMealPrice.parent().hide();
                        } else {
                            $sideMealPrice.parent().show();
                        }

                        $sideMealPrice.text(parseInt($sideMealPrice.text()) + parseInt(response.data.price));
                        $pointsAmount.text(parseInt($pointsAmount.text()) + response.data.points);
                        $mealsPrice.text(parseInt($mealsPrice.text()) + response.data.price);
                    } else {
                        $('.order-selection').show();
                        $('.order-value').show();
                        $('.your-meal-hide').hide();
                        $('.content_cart__title').text('Your meal plan');
                        $('#review-order').hide();
                        $('.order-step__2 .order-step__selected-icon.check').hide();
                        $('[data-action="toggle-side-meal-selection"][data-operation="select"]')
                            .removeClass('btn_disabled')
                            .addClass('btn-green');
                        $(document).find('.main-picker[data-sel-side-id="' + response.data.selected_id +'"]')
                            .parent()
                            .find('[data-action="toggle-side-meal-selection"][data-operation="unselect"]')
                            .removeClass('btn_disabled')
                            .addClass('btn-green');

                        $('#sides .entry-item').each(function (){
                            $(this).show();
                        });

                        $selectedAmount.text(parseInt($selectedAmount.text()) - 1);
                        if(response.data.selected_id !== null && response.data.selected_id === $selectedAmount.data('sel-side-id')){
                            $(document).find('.main-picker[data-sel-side-id="' + response.data.selected_id +'"]').text($selectedAmount.text());
                            $sideMealPrice = $(document).find('.main-picker[data-sel-side-id="' + response.data.selected_id +'"]').closest('.entry-item__right').find('.side-price');
                        }

                        if (parseInt($selectedAmount.text()) < response.data.side_count) {
                            $('.order-menu-heade__item[data-meal-number="' + mealNumber + '"] a').find('.warning').hide();
                            $('.order-menu-heade__item[data-meal-number="' + mealNumber + '"] a').find('.check').hide();
                            $('#mobileConfirm').hide();
                            $('#duplicate').hide();
                            $('#wizard-next').removeClass('btn-green').addClass('btn_disabled');
                        }

                        if ($selectedAmount.text() === '0') {
                            $('#duplicate').hide();
                            $('#wizard-next').removeClass('btn-green').addClass('btn_disabled');
                            $('.close_popup_btn').trigger('click');
                            $this.addClass('btn_disabled').removeClass('btn-green');
                            $(document).find('.main-picker[data-sel-side-id="' + response.data.selected_id +'"]')
                                .parent()
                                .find('[data-action="toggle-side-meal-selection"][data-operation="unselect"]')
                                .removeClass('btn-green')
                                .addClass('btn_disabled');
                        }

                        $('#sides-selection .order-selection__item[data-side-id="' + response.data.side_id + '"][data-meal-number="' + mealNumber + '"]').first().remove();
                        $orderCalories.text(orderCaloriesValue - response.data.micronutrients_data.calories);
                        $orderFats.text(orderFatsValue - response.data.micronutrients_data.fats);
                        $orderCarbs.text(orderCarbsValue - response.data.micronutrients_data.carbs);
                        $orderProteins.text(orderProteinsValue - response.data.micronutrients_data.proteins);

                        if ((parseInt($sideMealPrice.text()) - parseInt(response.data.price)) === 0) {
                            $sideMealPrice.parent().hide();
                        } else {
                            $sideMealPrice.parent().show();
                        }

                        $sideMealPrice.text(parseInt($sideMealPrice.text()) - parseInt(response.data.price));
                        $pointsAmount.text(parseInt($pointsAmount.text()) - response.data.points);
                        $mealsPrice.text(parseInt($mealsPrice.text()) - response.data.price);


                    }

                    $('.addon-meals-selected').text(response.data.meals_selected_amount);
                    refreshPortionSizesAdditionToTotalPriceValues();
                } else if (response.status === 'warning') {
                    Swal.fire({
                        title: 'Whoops!',
                        text : response.message,
                        icon : 'warning',
                        timer: 1500,
                    });
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    Swal.fire({
                        title: 'Validation error!',
                        text : 'Some data has been corrupted.',
                        icon : 'error',
                        timer: 1500,
                    });
                } else {
                    Swal.fire('Error!', JSON.parse(response.responseText).message, 'error');
                }
            }
        });
    });

    /**
     * Validate meal creation step.
     */
    $(document).on('click', '[data-action="validate-meal-creation-step"]:not(.btn_disabled)', function (e) {
        e.preventDefault();

        let $this = $(this);

        $.ajax({
            url    : $this.data('listener'),
            type   : 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data   : {
                wanted_meal_number: $this.data('wanted-meal-number'),
            },
            success: function (response) {
                if (response.status === 'success') {
                    window.location.href = response.data.redirect;
                } else if (response.status === 'warning') {
                    let mealNumber = $this.data('meal-number');

                    Swal.fire({
                        title: 'Whoops!',
                        text : response.message,
                        icon : 'warning',
                        timer: 1500,
                    }).then(() => {
                        $('.order-menu-heade__item[data-meal-number="' + mealNumber + '"] a').find('.check').hide();
                        $('.order-menu-heade__item[data-meal-number="' + mealNumber + '"] a').find('.warning').show();

                        if (response.data.warning_for === 'entry') {
                            $('.order-step__1').addClass('warning');
                            $('.order-step__1 .order-step__selected-icon.check').hide();
                            $('.order-step__1 .order-step__selected-icon.warning').show();
                        } else {
                            $('.order-step__2').addClass('warning');
                            $('.order-step__2 .order-step__selected-icon.check').hide();
                            $('.order-step__2 .order-step__selected-icon.warning').show();
                        }
                    });
                }
            },
            error  : function (response) {
                if (response.status === 422) {
                    Swal.fire({
                        title: 'Validation error!',
                        text : 'Some data has been corrupted.',
                        icon : 'error',
                        timer: 1500,
                    });
                } else {
                    Swal.fire('Error!', JSON.parse(response.responseText).message, 'error');
                }
            }
        });
    });

    $(document).on('input', '#meal-amount-input', function () {
        let $amountMeal = $(this).val();
        let $this = $(this);

        $.ajax({
            url: $this.data('href'),
            type : 'get',
            data : {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'amountMeal' : $amountMeal,
            },
            success : function (response) {
                $('#meal-price').text(response.price);
            }
        })
    });

    /**
     * Update amount of meals.
     */
    $(document).on('click', '.active[data-action="update-amount-of-meals"]', function () {
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
                    showNotificationWithText(response.message);
                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    showNotificationWithText('Validation error!', 'error');

                    $mealAmountInput.addClass('error');
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
     * Duplicate meals amount input logic.
     */
    $(document).on('input', '#duplicate-meals-form .duplicated_amount_input', function () {
        let value = $(this).val();

        if (value === '' || value < 1 || value > parseInt($('[name="max_duplicate_amount"]').val())) {
            $('.duplicate_meals_list_box').removeClass('active');
            $('.meals-calculate__subtitle').addClass('error');
            $(this).addClass('error');
        } else {
            $('.duplicate_meals_list_box').addClass('active');
            $('.meals-calculate__subtitle').removeClass('error');
            $(this).removeClass('error');
        }
    });
    $(document).on('click', '.duplicated_amount_input + .calear-form', function () {
        $('.duplicate_meals_list_box').removeClass('active');
        $('.duplicate_btn').removeClass('btn-green').addClass('btn_disabled');
    });

    if(window.location.hash === '#rewiew'){
        $('#mobileConfirm').find('a.btn-open-right-sidebar').trigger('click');
    }

    /**
     * Submit duplicate meals form.
     */
    $(document).on('submit', '#duplicate-meals-form', function (e) {
        e.preventDefault();

        let $this            = $(this);
        let $mealAmountInput = $this.find('[name="amount"]');

        $.ajax({
            url       : $this.attr('action'),
            type      : 'POST',
            data      : $this.serialize(),
            beforeSend: function () {
                $mealAmountInput.removeClass('error');
                $this.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    $('#duplicate-meal-step-selection').find('[data-action="close-popup"]').click();
                    window.location.href = response.data.redirect;
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    $mealAmountInput.addClass('error');
                    $('.meals-calculate__subtitle').addClass('error');
                    /*$.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');
                        $errorField.removeClass('error-text').addClass('error-text-no-abs');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });*/
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
     * Load and render duplicate meals popup.
     */
    $('#duplicate').click(function () {
        let $this = $(this);

        $.ajax({
            url    : $this.data('listener'),
            type   : 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('#duplicate-meal-step-selection').replaceWith(response.data.duplicate_meals_popup_view);
                    $('#duplicate-meal-step-selection').addClass('active');
                    $('body, html').addClass('ovh');
                }
            },
            error  : function (response) {
                Swal.fire({
                    title: 'Error!',
                    text : JSON.parse(response.responseText).message,
                    icon : 'error',
                    timer: 1500,
                });
            }
        });
    });

    /**
     * Refresh portion sizes addition to total price values.
     */
    function refreshPortionSizesAdditionToTotalPriceValues() {
        let $selectPortionsBlock = $('#portion-selection-block');

        $.ajax({
            url    : $selectPortionsBlock.data('listener'),
            type   : 'GET',
            success: function (response) {
                if (response.status === 'success') {
                    $('.meals-price').text(parseInt(response.data.total_price));

                    if ($selectPortionsBlock.is(':visible')) {
                        $.each(response.data.portion_sizes, function (index, portionSize) {
                            $('.portions li[data-size="' + portionSize.size + '"] span > span').text(portionSize.value);
                        });
                    }
                }
            },
            error  : function (response) {
                if (response.status === 422) {
                    showNotificationWithText('Validation error!', 'error');
                } else {
                    showNotificationWithText(JSON.parse(response.responseText).message, 'error');
                }
            }
        });
    }

    /**
     * Select portion size.
     */
    $('[data-action="select-portion-size"]').click(function (e) {
        e.preventDefault();

        let $this = $(this);

        if (!$this.hasClass('btn-green')) {
            $.ajax({
                url    : $this.data('listener'),
                type   : 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data   : {
                    size      : $this.data('size'),
                    percentage: $this.data('percentage'),
                },
                success: function (response) {
                    if (response.status === 'success') {
                        $('.portions li a').not(this).removeClass('btn-green').addClass('btn-white');
                        $('.portions li span').not(this).removeClass('active');
                        $this.removeClass('btn-white').addClass('btn-green');
                        $this.next('span').addClass('active');

                        $('.meals-price').text(response.data.total_price);
                        $('.points').text(response.data.total_points);
                    }
                },
                error  : function (response) {
                    if (response.status === 422) {
                        showNotificationWithText('Validation error!', 'error');
                    } else {
                        showNotificationWithText(JSON.parse(response.responseText).message, 'error');
                    }
                }
            });
        }
    });
});
