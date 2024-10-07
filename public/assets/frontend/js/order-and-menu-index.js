$(function () {
    /**
     * Header categories links handler.
     */
    $('.order-menu-heade__link').click(function (e) {
        if ($(this).attr('href') === '') {
            e.preventDefault();
        }
    });

    let $addonsList       = $('#addons-list');
    let $orderCalories    = $('#order-calories > span');
    let $orderFats        = $('#order-fats > span');
    let $orderCarbs       = $('#order-carbs > span');
    let $orderProteins    = $('#order-proteins > span');
    let $mealsPrice       = $('.cart_sum_total > .meals-price');
    let $mealsPriceMobile = $('.button-prise-mobile');

    /**
     * Toggle meal selection.
     */
    $(document).on('click', '[data-action="toggle-meal-selection"]', function (e) {
        e.preventDefault();

        let $this = $(this);

        $.ajax({
            url    : $this.data('listener'),
            type   : 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status === 'success') {
                    let orderCaloriesValue = parseInt($orderCalories.text());
                    let orderFatsValue     = parseInt($orderFats.text());
                    let orderCarbsValue    = parseInt($orderCarbs.text());
                    let orderProteinsValue = parseInt($orderProteins.text());

                    if (response.data.removing_from_order) {
                        let newMealsPrice = parseInt($mealsPrice.text()) - parseInt(response.data.price);

                        $orderCalories.text(orderCaloriesValue - response.data.micronutrients_data.calories);
                        $orderFats.text(orderFatsValue - response.data.micronutrients_data.fats);
                        $orderCarbs.text(orderCarbsValue - response.data.micronutrients_data.carbs);
                        $orderProteins.text(orderProteinsValue - response.data.micronutrients_data.proteins);

                        $mealsPrice.text(newMealsPrice);
                        $mealsPriceMobile.text(newMealsPrice);

                        $.each(response.data.addons, function (index, addon) {
                            let $addonCopy             = $addonsList.find('li[data-addon-id="' + addon.id + '"]');
                            let addonCopyParentMealIds = $addonCopy.data('parent-meal-ids');

                            if ($addonCopy.length !== 0 && addonCopyParentMealIds !== null) {
                                if (
                                    addonCopyParentMealIds.length === 1 ||
                                    !response.data.selected_meal_ids.some(item => addonCopyParentMealIds.includes(item))
                                ) {
                                    $addonCopy.remove();
                                }
                            }
                        });
                    } else {
                        let newMealsPrice = parseInt($mealsPrice.text()) + parseInt(response.data.price);

                        $orderCalories.text(orderCaloriesValue + response.data.micronutrients_data.calories);
                        $orderFats.text(orderFatsValue + response.data.micronutrients_data.fats);
                        $orderCarbs.text(orderCarbsValue + response.data.micronutrients_data.carbs);
                        $orderProteins.text(orderProteinsValue + response.data.micronutrients_data.proteins);

                        $mealsPrice.text(newMealsPrice);
                        $mealsPriceMobile.text(newMealsPrice);

                        $.each(response.data.addons, function (index, addon) {
                            let $addonCopy = $addonsList.find('li[data-addon-id="' + addon.id + '"]');

                            if ($addonCopy.length === 0) {
                                $addonsList.append('<li class="add-ons__item flex" data-addon-id="' + addon.id + '"\n' +
                                    '                            data-parent-meal-ids="' + JSON.stringify(addon.addon_for) + '">\n' +
                                    '                            <span class="add-ons__item-img-wrapper">\n' +
                                    '                                <img src="/assets/frontend/img/icon-cherry.svg" alt="Icon">\n' +
                                    '                            </span>\n' +
                                    '                            <div class="add-ons__item-details">\n' +
                                    '                                <span class="add-ons__item-details-title">Add ' + addon.name + '</span>\n' +
                                    '                                <span>\n' +
                                    '                                    <span class="add-ons__item-details-item">+100 points</span>\n' +
                                    '                                    <span class="add-ons__item-details-item">+$' + addon.price + '</span>\n' +
                                    '                                </span>\n' +
                                    '                            </div>\n' +
                                    '                        </li>');
                            }
                        });
                    }

                    $('#popup-about-selected-meal').find('[data-action="close-popup"]').click();
                    $('[data-action="show-meal-details-popup"][data-meal-id="' + $this.data('meal-id') + '"]')
                        .find('.weekly-menu__item-link')
                        .toggleClass('active');
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

    $('#duplicate-menu').on('click', function () {
        $.ajax({
            url : $(this).data('listener'),
            type : 'get',
            success : function (response) {
                if(response.success){
                    if(window.matchMedia("(max-width: 767px)").matches){
                        $('.mobile_top_notif').show();
                    } else{
                        $('.success_order_info_in_content').addClass('active');
                    }
                    $('.response-text').text(response.message);

                }
            },
        });
    });
});
