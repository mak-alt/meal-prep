$(function () {
    let  $isWithinPerimeterOfI285;
    let $deliveryType = 'delivery';

    getAvailableDates();

    if ($('[name="delivery_zip"]').val().length > 0){
        $('[name="delivery_zip"]').trigger('change');
    }
 /*   $('.delivery-tab').click(function (e) {
        e.preventDefault();
        console.log(32323)
        $('[name="delivery_zip"]').trigger('change');
    });*/

    $('#delivery_tab').click(function () {
    })

    $('.tabs .tabs-nav a').click(function() {
        if ($(this).parents().hasClass('delivery_tab')) {
            $('[name="delivery_zip"]').trigger('change');
        }
    });

    /**
     * Handle place order button status.
     */
    function handlePlaceOrderButtonStatus(buttonState = null) {
        if (buttonState === null) {
            let isValid = true;
            let $inputs = $('input:visible');

            if ($('a[href="#tab1"]').hasClass('active')) {
                $inputs = $inputs.add($('input[name="delivery_time_frame"]'));
            } else {
                $inputs = $inputs.add($('input[name="pickup_time_frame"]'));
            }

            $.each($inputs, function (index, element) {
                let $element = $(element);

                if ($element.attr('required') && $element.val() === '') {
                    isValid = false;
                }
            });

            if (isValid) {
                $('.btn_checkout').addClass('btn-green').removeClass('btn_disabled');
            } else {
                $('.btn_checkout').addClass('btn_disabled').removeClass('btn-green');
            }

            return isValid;
        } else {
            if (buttonState) {
                $('.btn_checkout').addClass('btn-green').removeClass('btn_disabled');
            } else {
                $('.btn_checkout').addClass('btn_disabled').removeClass('btn-green');
            }

            return buttonState;
        }
    }

    $('#tab1-1').on('input', 'input', function (){
        $('#use-billing-as-delivery').prop('checked', false);
    });

    $('input').on('change', function () {
        handlePlaceOrderButtonStatus();
    });
    $('[name="csc"]').off('change');
    $('[name="csc"]').on('keyup', function () {
        if ($(this).val().length === 3){
            handlePlaceOrderButtonStatus();
        }
    });
    $('a[href="#tab1"], a[href="#tab2"]').click(function () {
        handlePlaceOrderButtonStatus();
        calculateTotalPrice();
        if ($(this).attr('href') === '#tab1'){
            $deliveryType = 'delivery';
        }
        else{
            $deliveryType = 'decatur';
        }
        getAvailableDates();
    });
    $('a[href="#tab1-1"], a[href="#tab1-2"]').click(function () {
        handlePlaceOrderButtonStatus();
    });

    $('#use-billing-as-delivery').on('click', function (){
        if ($(this).is(':checked')){
            $('[name="billing_phone_number"]').val($('[name="delivery_phone_number"]').val());
            $('[name="billing_company_name"]').val($('[name="delivery_company_name"]').val());
            $('[name="billing_address_opt"]').val($('[name="delivery_address_opt"]').val());
            $('[name="billing_zip"]').val($('[name="delivery_zip"]').val());
            $('[name="billing_city"]').val($('[name="delivery_city"]').val());
            $('[name="billing_state"]').val($('[name="delivery_state"]').val());
            $('[name="billing_street_address"]').val($('[name="delivery_street_address"]').val());
        } else {
            $('[name="billing_state"]').prop('selectedIndex',0);
            $('[name="billing_phone_number"]').val()
            $('[name="billing_company_name"]').val()
            $('[name="billing_address_opt"]').val()
            $('[name="billing_zip"]').val()
            $('[name="billing_city"]').val()
            $('[name="billing_street_address"]').val()
        }

    });

    /**
     * Set time frame hidden input value.
     */
    $(document).on('click', '[data-action="select-time-frame"]', function (e) {
        e.preventDefault();

        let $this = $(this);

        //$this.parents('.select-wrap.input-wrapper').prev('input:hidden').val($this.data('value')).change();
        $this.parents('.select-wrap.input-wrapper').prev('input:hidden').val($this.text()).change();
        $this.parents('.select-wrap.input-wrapper').find('.boxes-select').text($this.text());
        $this.parents('.select_pag').find('[data-action="select-time-frame"]').removeClass('active');
        $this.addClass('active');
    });

    $('#delivery-date').on('change', function () {
        let $date = new Date($(this).val());
        if ($date.getDay() === 2){
            $('.select_pag').find('a:contains("1:00 PM (Sunday Only)-4:30 PM (Sunday Only)")').hide();
        }
        else{
            $('.select_pag').find('a:contains("1:00 PM (Sunday Only)-4:30 PM (Sunday Only)")').show();
        }
    });

    /**
     * Display or hide pickup location blocks.
     */
    $('.location-info-buttons').find('a').click(function (e) {
        e.preventDefault();

        let $this = $(this);

        $('.location-info-buttons').find('a').removeClass('active');
        $('.location-info-block').removeClass('active');
        $('.boxes-select').text('');
        $('[name="pickup_time_frame"]').val('');
        $('.select_pag').removeClass('active').find('li a').removeClass('active');

        $this.addClass('active');
        $($this.attr('href')).addClass('active');

        if ($this.attr('href') === '#decatur'){
            $deliveryType = 'decatur';

        }
        else {
            $deliveryType = 'brookhaven';
        }
        getAvailableDates();
    });

    /**
     * Handle deliver to different address action.
     */
    $('#deliver-to-different-address').change(function () {
        if ($(this).is(':checked')) {
            $('#delivery-address-wrapper').find('input').prop('readonly', false);
        } else {
            $.ajax({
                url    : $(this).data('listener'),
                type   : 'GET',
                success: function (response) {
                    if (response.status === 'success') {
                        $.each(response.data, function (name, value) {
                            $('#delivery-address-wrapper').find('input[name="' + name + '"]').val(value);
                        });

                        $('#delivery-address-wrapper').find('input').not('delivery_order_notes').prop('readonly', true).change();
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
        }
    });

    /**
     * Use another card.
     */
    $('[data-action="use-another-card"]').click(function () {
        $('#user-cards').hide();

        $('#use-another-card').fadeIn();
        $('#use-another-card input').val('').change();
    });

    /**
     * Place order.
     */
    $(document).on('click', '.btn-green.btn_checkout', function (e) {
        e.preventDefault();

        makeCheckout();
    });

    /**
     * Make checkout.
     */
    function makeCheckout() {
        let $form                = $('#checkout-form');
        let formData             = $form.serializeArray();
        let removeCardInfo       = !$('#use-another-card').is(':visible');
        let removeStoredCardInfo = !removeCardInfo || $('a[href="#tab1-2"]').hasClass('active');
        let removeDeliveryInfo   = !$('a[href="#tab1"]').hasClass('active');
        let removePickupInfo     = !$('a[href="#tab2"]').hasClass('active');

        if (removeCardInfo || removeDeliveryInfo || removePickupInfo) {
            $.each(formData, function (index, data) {
                if (removeCardInfo) {
                    if (['card_number', 'expiration', 'csc', 'securely_save_to_account'].includes(data.name)) {
                        delete formData[index];
                    }
                }
                if (removeStoredCardInfo) {
                    if (data.name === 'payment_profile_id') {
                        delete formData[index];
                    }
                }
                if (removeDeliveryInfo) {
                    if (data.name.startsWith('delivery_') || data.name === 'send_updates_and_promotions') {
                        delete formData[index];
                    }
                }
                if (removePickupInfo) {
                    if (data.name.startsWith('pickup_')) {
                        delete formData[index];
                    }
                }
            });
        }

        if (removeDeliveryInfo) {
            formData.push({
                name : 'pickup_location',
                value: $('.location-info-buttons.pickup a.active').data('pickup-location'),
            });
        }

        placeOrder($form, formData);
    }

    /**
     * Place order.
     */
    function placeOrder($form, formData, paypalPaymentResponse = null) {
        if (paypalPaymentResponse !== null) {
            formData.push({name: 'paypal_payment[id]', value: paypalPaymentResponse.id});
            formData.push({name: 'paypal_payment[status]', value: paypalPaymentResponse.status});
            formData.push({name: 'paypal_payment[created_at]', value: paypalPaymentResponse.create_time});
        }

        $.ajax({
            url       : $form.attr('action'),
            type      : $form.attr('method'),
            data      : formData,
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            dataType  : 'json',
            beforeSend: function () {
                handlePlaceOrderButtonStatus(false);

                $form.find('.input-wrapper').removeClass('error');
                $form.find('p.error-text[data-field-name]').text('').removeClass('active');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    window.location.href = response.data.redirect;
                }
            },
            error     : function (response) {
                handlePlaceOrderButtonStatus();

                if (response.status === 422) {
                    Swal.fire({
                        title: 'Validation error!',
                        icon : 'error',
                        timer: 1000,
                    }).then(() =>{
                        $.each(JSON.parse(response.responseText).errors, function (field, value) {
                            let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                            $errorField.parents('.input-wrapper').addClass('error');
                            $errorField.text(value[0]).addClass('active');
                        });
                        $('.content').animate({scrollTop: $(".error-text.error-input-text.active").first().offset().top - 900});
                    });
                } else if (response.status === 419){
                    swal.fire({
                        title : 'You have been idle too long, refresh page please.',
                        icon : 'warning',
                        showConfirmButton : true,
                        confirmButtonText : 'Refresh page',
                    }).then(() => {
                        window.location.reload();
                    });
                }
                else {
                    Swal.fire({
                        title: 'Error!',
                        text : JSON.parse(response.responseText).message,
                        icon : 'error',
                        timer: 2500,
                    });
                }
            }
        });
    }

    /**
     * Select stored payment method.
     */
    $('#stored-cards .input').click(function () {
        let $this = $(this);

        $('[name="payment_profile_id"]').prop('disabled', true);
        $this.prev('[name="payment_profile_id"]').prop('disabled', false);
        $('#stored-cards .input').removeClass('input-card__selected');
        $this.addClass('input-card__selected');
    });

    let $couponDiv;

    /**
     * Show coupon input.
     */
    $('[data-action="show-coupon-input"]').click(function (e) {
        e.preventDefault();
        $(this).hide();
        $couponDiv = $(this).parent().find('#coupon');
        $couponDiv.fadeIn();
    });

    /**
     * Apply coupon.
     */
    $('[data-action="apply-coupon"]').click(function (e) {
        e.preventDefault();
        $couponDiv = $('#coupon');
        let $this        = $(this);
        let $couponInput = $this.parent().find('[name="coupon"]');

        $.ajax({
            url       : $this.attr('href'),
            type      : 'POST',
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data      : {
                coupon_code: $couponInput.val(),
                total_price: $('.total-price').first().text(),
            },
            beforeSend: function () {
                handlePlaceOrderButtonStatus(false);
            },
            success   : function (response) {
                //handlePlaceOrderButtonStatus();

                if (response.status === 'success') {
                    let $appliedCouponBlock = $('.applied-coupon');
                    $couponDiv.hide();
                    $couponInput.val('');

                    $('[name="coupon_id"]').val(response.data.coupon_id);
                    $appliedCouponBlock.find('.checkout_list_title').html(
                        response.data.coupon_name + '<span>Code: ' + response.data.coupon_code + '</span>'
                    );
                    $appliedCouponBlock.find('.span-for-discount').text('- $');
                    $appliedCouponBlock.find('.checkout_list_price .coupon-discount').text(response.data.discount);
                    $appliedCouponBlock.fadeIn();

                    $('.total-price').text(response.data.total_price_with_coupon_discount);
                    if (response.data.total_price_with_coupon_discount === 0){
                        $('.hide-payment-info').hide();
                        handlePlaceOrderButtonStatus();
                    }
                }
            },
            error     : function (response) {
                handlePlaceOrderButtonStatus();

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
                    console.log($(".error-text.error-input-text.active").first().offset().top);
                    $('.content').animate({scrollTop: $(".error-text.error-input-text.active").first().offset().top - 900});
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

    $('.summary-popup-button').on('click',function (e){
        e.preventDefault();

       $('#summary-popup').addClass('active');
    });

    /**
     * Remove coupon.
     */
    $('[data-action="remove-coupon"]').click(function (e) {
        e.preventDefault();

        let $couponIdInput = $('[name="coupon_id"]');
        let $couponDiv = $('#coupon');
        let $address = $('input[name="delivery_zip"]').val();

        $.ajax({
            url       : $(this).attr('href'),
            type      : 'POST',
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data      : {
                is_within_perimeter_of_i_285: $isWithinPerimeterOfI285,
                coupon_id   : $couponIdInput.val(),
                search_address   : $address,
            },
            beforeSend: function () {
                handlePlaceOrderButtonStatus(false);
            },
            success   : function (response) {
                handlePlaceOrderButtonStatus();

                if (response.status === 'success') {
                    $('.hide-payment-info').show();
                    $(document).find('.applied-coupon').hide();

                    $('[name="coupon"]').val('');
                    $couponIdInput.val('');
                    $couponDiv.show();
                    $('[data-action="show-coupon-input"]').fadeIn();

                    $('.total-price').text(response.data.total_price_without_coupon_discount);
                    handlePlaceOrderButtonStatus();
                }
            },
            error     : function (response) {
                handlePlaceOrderButtonStatus();

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
                    $('.content').animate({scrollTop: $(".error-text.error-input-text.active").first().offset().top - 900});
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

    $('.boxes-select').click(function(evt) {
        evt.preventDefault();
        let $button = $('.location-info-buttons').find('.active');
        if ($button.attr('href') === '#decatur'){
            $(this).closest('.custom-select').find('.decatur').addClass('active').show();
            $(this).closest('.custom-select').find('.brookhaven').removeClass('active').hide();
        }
        else {
            $(this).closest('.custom-select').find('.brookhaven').addClass('active').show();
            $(this).closest('.custom-select').find('.decatur').removeClass('active').hide();
        }
    });

    $('.input-delivery').on('change', function (e) {
        let $this = $(this);
        $('[name="pickup_time_frame"]').val('');
        $('.boxes-select').text('');
        $('[name="delivery_time_frame"]').val('');
        $.ajax({
            url : timeframesLink,
            type : 'get',
            data : {
                type : $deliveryType,
                day : $this.val()
            },
            success : function (response) {
                let timeframes = response.timeframes;

                if (timeframes !== null){
                    switch ($deliveryType){
                        case 'delivery':
                            $('.delivery_times').empty().append(timeframes);
                            break;
                        case 'decatur':
                            $('.decatur').empty().append(timeframes);
                            break;
                        case 'brookhaven':
                            $('.brookhaven').empty().append(timeframes);
                            break;
                    }
                }
            },
        })
    });

    /**
     * Recalculate total order price.
     */
    function calculateTotalPrice(isWithinPerimeterOfI285) {
        let deliveryCity = !$('a[href="#tab1"]').hasClass('active') ? null : $('[name="delivery_city"]').val();
        let totalPrice  = null;
        let $address = $('input[name="delivery_zip"]').is(':visible') ? $('input[name="delivery_zip"]').val() : null;

        $.ajax({
            url       : $('a[href="#tab1"]').data('listener'),
            type      : 'GET',
            async     : false,
            data      : {
                is_within_perimeter_of_i_285: isWithinPerimeterOfI285,
                coupon_id   : $('[name="coupon_id"]').val(),
                search_address   : $address,
            },
            beforeSend: function () {
                handlePlaceOrderButtonStatus(false);
            },
            success   : function (response) {
                handlePlaceOrderButtonStatus(null, true);

                if (response.status === 'success') {
                    totalPrice = response.data.total_price;

                    $('.total-price').text(response.data.total_price);
                    $('#delivery-price-block .checkout_list_price > span').text(response.data.delivery_price);
                    $('.coupon__right-section .coupon-discount').text(response.data.discounts);

                    $('input[name="is_within_perimeter_of_i_285"]').val(isWithinPerimeterOfI285);

                    response.data.hide_delivery_price ? $('.price-block').hide() : $('.price-block').fadeIn();
                }
            },
            error     : function (response) {
                handlePlaceOrderButtonStatus(null, true);

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
                    $('.content').animate({scrollTop: $(".error-text.error-input-text.active").first().offset().top - 900});
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

        return totalPrice;
    }

    /*Start check address point within polygon area*/
    $('[name="delivery_zip"]').on('change', function () {
        const address = $('input[name="delivery_city"]').val() + ' ' + $('input[name="delivery_street_address"]').val()+ ' ' + $('input[name="delivery_zip"]').val();

        new google.maps.Geocoder().geocode({
            "address": address
        }, function (results) {
            if (results !== null) {
                const lat = results[0].geometry.location.lat();
                const lng = results[0].geometry.location.lng();
                const isWithinPerimeterOfI285 = Polygon(lat, lng)
                calculateTotalPrice(isWithinPerimeterOfI285);
                $isWithinPerimeterOfI285 = isWithinPerimeterOfI285;
            } else {
                calculateTotalPrice(false);
                $isWithinPerimeterOfI285 = false;
            }

        });
    });

    if (!google.maps.Polygon.prototype.getBounds) {
        google.maps.Polygon.prototype.getBounds = function (latLng) {
            var bounds = new google.maps.LatLngBounds(),
                paths = this.getPaths(),
                path,
                p, i;

            for (p = 0; p < paths.getLength(); p++) {
                path = paths.getAt(p);
                for (i = 0; i < path.getLength(); i++) {
                    bounds.extend(path.getAt(i));
                }
            }

            return bounds;
        };
    }

    // Polygon containsLatLng - method to determine if a latLng is within a polygon
    google.maps.Polygon.prototype.containsLatLng = function (latLng) {
        var inPoly = false,
            bounds, lat, lng,
            numPaths, p, path, numPoints,
            i, j, vertex1, vertex2;

        if (arguments.length == 2) {
            if (
                typeof arguments[0] == "number" &&
                typeof arguments[1] == "number"
            ) {
                lat = arguments[0];
                lng = arguments[1];
            }
        } else if (arguments.length == 1) {
            bounds = this.getBounds();

            if (!bounds && !bounds.contains(latLng)) {
                return false;
            }
            lat = latLng.lat();
            lng = latLng.lng();
        } else {
            console.log("Wrong number of inputs in google.maps.Polygon.prototype.contains.LatLng");
        }

        // Raycast point in polygon method

        numPaths = this.getPaths().getLength();
        for (p = 0; p < numPaths; p++) {
            path = this.getPaths().getAt(p);
            numPoints = path.getLength();
            j = numPoints - 1;

            for (i = 0; i < numPoints; i++) {
                vertex1 = path.getAt(i);
                vertex2 = path.getAt(j);

                if (
                    vertex1.lng() < lng &&
                    vertex2.lng() >= lng ||
                    vertex2.lng() < lng &&
                    vertex1.lng() >= lng
                ) {
                    if (
                        vertex1.lat() +
                        (lng - vertex1.lng()) /
                        (vertex2.lng() - vertex1.lng()) *
                        (vertex2.lat() - vertex1.lat()) <
                        lat
                    ) {
                        inPoly = !inPoly;
                    }
                }

                j = i;
            }
        }

        return inPoly;
    };

    function Polygon(lat, lng) {
        // Define the LatLng coordinates for the polygon's path.
        const triangleCoords = [
            new google.maps.LatLng(33.670818, -84.335508),
            new google.maps.LatLng(33.664532, -84.351987),
            new google.maps.LatLng(33.659674, -84.360227),
            new google.maps.LatLng(33.656531, -84.364690),
            new google.maps.LatLng(33.645957, -84.369497),
            new google.maps.LatLng(33.639954, -84.378080),
            new google.maps.LatLng(33.634809, -84.382886),
            new google.maps.LatLng(33.631665, -84.390439),
            new google.maps.LatLng(33.632808, -84.400396),
            new google.maps.LatLng(33.632808, -84.408635),
            new google.maps.LatLng(33.629664, -84.415502),
            new google.maps.LatLng(33.623375, -84.425115),
            new google.maps.LatLng(33.618229, -84.443998),
            new google.maps.LatLng(33.620516, -84.456357),
            new google.maps.LatLng(33.619658, -84.474897),
            new google.maps.LatLng(33.619658, -84.483137),
            new google.maps.LatLng(33.619658, -84.486913),
            new google.maps.LatLng(33.634524, -84.492063),
            new google.maps.LatLng(33.645099, -84.497213),
            new google.maps.LatLng(33.689960, -84.500989),
            new google.maps.LatLng(33.707383, -84.497556),
            new google.maps.LatLng(33.726802, -84.502363),
            new google.maps.LatLng(33.753353, -84.495496),
            new google.maps.LatLng(33.765056, -84.492750),
            new google.maps.LatLng(33.784462, -84.495839),
            new google.maps.LatLng(33.797016, -84.486913),
            new google.maps.LatLng(33.809569, -84.497213),
            new google.maps.LatLng(33.818126, -84.495839),
            new google.maps.LatLng(33.828679, -84.486913),
            new google.maps.LatLng(33.844934, -84.487256),
            new google.maps.LatLng(33.885130, -84.471464),
            new google.maps.LatLng(33.892825, -84.453954),
            new google.maps.LatLng(33.900805, -84.445028),
            new google.maps.LatLng(33.905364, -84.433011),
            new google.maps.LatLng(33.915906, -84.420308),
            new google.maps.LatLng(33.916761, -84.408635),
            new google.maps.LatLng(33.915621, -84.397649),
            new google.maps.LatLng(33.913057, -84.381856),
            new google.maps.LatLng(33.911917, -84.362974),
            new google.maps.LatLng(33.913627, -84.350957),
            new google.maps.LatLng(33.921034, -84.326581),
            new google.maps.LatLng(33.921034, -84.306669),
            new google.maps.LatLng(33.919610, -84.292249),
            new google.maps.LatLng(33.909923, -84.281949),
            new google.maps.LatLng(33.901375, -84.273710),
            new google.maps.LatLng(33.893110, -84.258947),
            new google.maps.LatLng(33.882565, -84.249334),
            new google.maps.LatLng(33.871449, -84.249334),
            new google.maps.LatLng(33.852063, -84.246244),
            new google.maps.LatLng(33.829535, -84.252080),
            new google.maps.LatLng(33.780182, -84.245214),
            new google.maps.LatLng(33.771050, -84.233541),
            new google.maps.LatLng(33.754210, -84.232511),
            new google.maps.LatLng(33.728516, -84.231138),
            new google.maps.LatLng(33.714809, -84.241094),
            new google.maps.LatLng(33.699672, -84.255170),
            new google.maps.LatLng(33.697958, -84.275426),
            new google.maps.LatLng(33.694245, -84.290189),
            new google.maps.LatLng(33.689960, -84.301175),
            new google.maps.LatLng(33.683961, -84.310789),
            new google.maps.LatLng(33.677676, -84.319028),
            new google.maps.LatLng(33.671390, -84.334821)
        ];
        // Construct the polygon.
        const polygon = new google.maps.Polygon({
            paths: triangleCoords,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
        });

        const coordinate = new google.maps.LatLng(lat, lng)

        return polygon.containsLatLng(coordinate);
    }

    function getAvailableDates() {
        $.ajax({
            type : 'get',
            data : {
                type : $deliveryType,
            },
            success : function (response) {
                let days = response.days;
                let d = new Date();
                d = d.setDate(d.getDate() + 1);
                d = new Date(d);
                $('.input-delivery').val(response.closest_day).daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minDate: d,
                    autoUpdateInput: true,
                    maxYear: parseInt(moment().format('YYYY'), 10),
                    isInvalidDate: function(ele) {
                        for (let item in days) {
                            if (ele.day() == item) return true;
                        }
                    }
                });
            },
        })
    }
});
