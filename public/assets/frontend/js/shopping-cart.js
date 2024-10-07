$(function () {
    let $orderCalories = $('#order-calories');
    let $orderFats     = $('#order-fats');
    let $orderCarbs    = $('#order-carbs');
    let $orderProteins = $('#order-proteins');
    let $totalPrice    = $('.total-price');
    let $totalPoints   = $('.total-points');

    /**
     * Duplicate shopping cart order.
     */
    $('[data-action="duplicate"]').click(function (e) {
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
                    window.location.reload();
                }
            },
            error  : function (response) {
                showNotificationWithText(JSON.parse(response.responseText).message, 'error');
            }
        });
    });

    /**
     * Complete menu.
     */
    $('[data-action="complete-menu"]').click(function (e) {
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
                    window.location.href = response.data.redirect;
                }
            },
            error  : function (response) {
                showNotificationWithText(JSON.parse(response.responseText).message, 'error');
            }
        });
    });

    $('.close-order-value').on('click', function (e) {
        e.preventDefault();

        $('.btn-close-right-sidebar').trigger('click');
    });

    if($(document).find('.secondary-price').first().text() !== ''){
        $.each($(document).find('.main-price'),function (){
            let main = Number($(this).text().replace(/[^0-9.-]+/g,""));
            let priceId = $(this).data('price-id');

            let secondary = 0;
            $.each($(document).find('.secondary-price'), function (){
                if ($(this).data('dep-price-id') === priceId){
                    secondary += Number($(this).text().replace(/[^0-9.-]+/g,""));
                }
            });
            let price = Number(main) - Number(secondary);
            $(this).text('$'+ price.toFixed(2));
        });
    }

    $('[data-popup-id="delete-addon"]').click(function () {
        $('[data-action="delete-addon"]').data('listener', $(this).data('listener'));
    });

    $(document).on('click', '[data-action="delete-addon"]', function (){
        let listener = $(this).data('listener');

        $.ajax({
            url : listener,
            type: 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function (response){
                if(response.status === 'success'){
                    $('#delete-addon').find('[data-action="close-popup"]').click();
                    window.location.reload();
                }
            },
            error  : function (response) {
                showNotificationWithText(JSON.parse(response.responseText).message, 'error');
            }
        });
    });

    /**
     * Delete shopping cart order.
     */
    $('[data-popup-id="delete-shopping-cart-order"]').click(function () {
        $('[data-action="delete-order"]').data('listener', $(this).data('listener'));
    });
    $(document).on('click', '[data-action="delete-order"]', function () {
        let listener = $(this).data('listener');

        $.ajax({
            url    : listener,
            type   : 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('#delete-shopping-cart-order').find('[data-action="close-popup"]').click();
                    window.location.reload();
                    /*let $orderMenuItem                = $('[data-popup-id="delete-shopping-cart-order"][data-listener="' + listener + '"]')
                        .parents('li.order-menu__item');
                    let micronutrientsDataToBeRemoved = $orderMenuItem.data('micronutrients-data');

                    $orderMenuItem.hide();

                    $orderCalories.text(parseInt($orderCalories.text()) - parseInt(micronutrientsDataToBeRemoved.calories));
                    $orderFats.text(parseInt($orderFats.text()) - parseInt(micronutrientsDataToBeRemoved.fats));
                    $orderCarbs.text(parseInt($orderCarbs.text()) - parseInt(micronutrientsDataToBeRemoved.carbs));
                    $orderProteins.text(parseInt($orderProteins.text()) - parseInt(micronutrientsDataToBeRemoved.proteins));
                    $totalPrice.text(parseInt($totalPrice.text()) - parseInt($orderMenuItem.data('total-price')));
                    $totalPoints.text(parseInt($totalPoints.text()) - parseInt($orderMenuItem.data('total-points')));

                    if ($('li.order-menu__item:visible .active-link[data-action="complete-menu"]').length === 0) {
                        $('.btn_checkout').removeClass('btn_disabled').addClass('btn-green');
                    }

                    $('#menu-restore-prompt').addClass('active');

                    setTimeout(function () {
                        $('#menu-restore-prompt').removeClass('active');

                        if ($('li.order-menu__item:visible').length === 0) {
                            $('#checkout-step').removeProp('redirect').removeClass('active');
                            $('.order-value').hide();
                            $('#shopping-cart-empty').fadeIn();
                        }
                    }, 5000);*/
                }
            },
            error  : function (response) {
                showNotificationWithText(JSON.parse(response.responseText).message, 'error');
            }
        });
    });

    /**
     * Undo shopping cart order deletion.
     */
    $('[data-action="undo-menu-deleting"]').click(function (e) {
        e.preventDefault();

        $.ajax({
            url    : $(this).attr('href'),
            type   : 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('#menu-restore-prompt').hide();
                    $.each($('li.order-menu__item:hidden'), function (index, element) {
                        let $orderMenuItem                = $(element);
                        let micronutrientsDataToBeRemoved = $orderMenuItem.data('micronutrients-data');

                        if ($orderMenuItem.find('.active-link[data-action="complete-menu"]').length !== 0) {
                            $('.btn_checkout').removeClass('btn-green').addClass('btn_disabled');
                        }

                        $orderMenuItem.fadeIn();

                        $orderCalories.text(parseInt($orderCalories.text()) + parseInt(micronutrientsDataToBeRemoved.calories));
                        $orderFats.text(parseInt($orderFats.text()) + parseInt(micronutrientsDataToBeRemoved.fats));
                        $orderCarbs.text(parseInt($orderCarbs.text()) + parseInt(micronutrientsDataToBeRemoved.carbs));
                        $orderProteins.text(parseInt($orderProteins.text()) + parseInt(micronutrientsDataToBeRemoved.proteins));
                        $totalPrice.text(parseInt($totalPrice.text()) + parseInt($orderMenuItem.data('total-price')));
                        $totalPoints.text(parseInt($totalPoints.text()) + parseInt($orderMenuItem.data('total-points')));
                    });
                }
            },
            error  : function (response) {
                showNotificationWithText(JSON.parse(response.responseText).message, 'error');
            }
        });
    });
});
