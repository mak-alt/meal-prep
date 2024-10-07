$(function () {
    let $orderCalories    = $('#order-calories > span');
    let $orderFats        = $('#order-fats > span');
    let $orderCarbs       = $('#order-carbs > span');
    let $orderProteins    = $('#order-proteins > span');
    let $mealsPrice       = $('.meals-price');
    let $pointsAmount     = $('.points');
    let $addToCartButtons = $('[data-action="add-to-cart"]');

    /**
     * Toggle meal selection.
     */
    $(document).on('click', '.btn-green[data-action="toggle-addon-meal-selection"]', function (e) {
        e.preventDefault();

        let $this     = $(this);
        let operation = $this.data('operation');

        $.ajax({
            url    : $this.attr('href'),
            type   : 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data   : {
                meal_id  : $this.data('meal-id'),
                operation: operation,
            },
            success: function (response) {
                if (response.status === 'success') {
                    let $selectedAmount = $this.parent().find('.entry-item__amount_picker-digit');

                    if (response.data.required_meals_selected) {
                        $('[data-action="toggle-addon-meal-selection"][data-operation="select"]')
                            .removeClass('btn-green')
                            .addClass('btn_disabled');
                        $('.btn-green[data-action="toggle-addon-meal-selection"][data-operation="select"]')
                            .parent()
                            .find('[data-action="toggle-addon-meal-selection"][data-operation="unselect"]')
                            .removeClass('btn_disabled')
                            .addClass('btn-green');
                        $('.vegan-check-icon').show();
                        $addToCartButtons.removeClass('btn_disabled').addClass('btn-green');

                        if (parseInt($selectedAmount.text()) >= response.data.required_minimum_meals_amount) {
                            return false;
                        }
                    }

                    $selectedAmount.prev('[data-action="toggle-addon-meal-selection"][data-operation="unselect"]')
                        .removeClass('btn_disabled')
                        .addClass('btn-green');

                    let orderCaloriesValue = parseInt($orderCalories.text());
                    let orderFatsValue     = parseInt($orderFats.text());
                    let orderCarbsValue    = parseInt($orderCarbs.text());
                    let orderProteinsValue = parseInt($orderProteins.text());
                    let $addonMealPrice    = $this.parents('.entry-item').find('.entry-item__price > span');

                    if (operation === 'select') {
                        $selectedAmount.text(parseInt($selectedAmount.text()) + 1);

                        $orderCalories.text(orderCaloriesValue + response.data.micronutrients_data.calories);
                        $orderFats.text(orderFatsValue + response.data.micronutrients_data.fats);
                        $orderCarbs.text(orderCarbsValue + response.data.micronutrients_data.carbs);
                        $orderProteins.text(orderProteinsValue + response.data.micronutrients_data.proteins);

                        $mealsPrice.text(parseFloat(response.data.total_price));
                        $addonMealPrice.text(parseInt($addonMealPrice.text()) + parseInt(response.data.price));
                        $pointsAmount.text(parseInt($pointsAmount.text()) + response.data.points);
                    } else {
                        $addToCartButtons.removeClass('btn-green').addClass('btn_disabled');
                        $('.vegan-check-icon').hide();
                        $('[data-action="toggle-addon-meal-selection"][data-operation="select"]')
                            .removeClass('btn_disabled')
                            .addClass('btn-green');

                        $selectedAmount.text(parseInt($selectedAmount.text()) - 1);

                        if ($selectedAmount.text() === '0') {
                            $this.addClass('btn_disabled').removeClass('btn-green');
                        }

                        $orderCalories.text(orderCaloriesValue - response.data.micronutrients_data.calories);
                        $orderFats.text(orderFatsValue - response.data.micronutrients_data.fats);
                        $orderCarbs.text(orderCarbsValue - response.data.micronutrients_data.carbs);
                        $orderProteins.text(orderProteinsValue - response.data.micronutrients_data.proteins);

                        $mealsPrice.text(parseFloat(response.data.total_price));
                        $addonMealPrice.text(parseInt($addonMealPrice.text()) - parseInt(response.data.price));
                        $pointsAmount.text(parseInt($pointsAmount.text()) - response.data.points);
                    }

                    $('.addon-meals-selected').text(response.data.meals_selected_amount);
                } else if (response.status === 'warning') {
                    Swal.fire({
                        title: 'Whoops!',
                        text : response.message,
                        icon : 'warning',
                        timer: 1500,
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

    /**
     * Add to cart.
     */
    $(document).on('click', '.btn-green[data-action="add-to-cart"]', function (e) {
        e.preventDefault();

        let $this = $(this);

        $.ajax({
            url    : $this.attr('href'),
            type   : 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data   : {
                operation: $this.data('operation'),
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('.btn-green[data-action="add-to-cart"]').removeClass('btn-green').addClass('btn_disabled');
                    window.location.href = $('.vegan-select-header__left').find('a.back').attr('href') + '#rewiew';
                } else if (response.status === 'warning') {
                    Swal.fire({
                        title: 'Whoops!',
                        text : response.message,
                        icon : 'warning',
                        timer: 1500,
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
});
