$(function () {

    refresh();

    $(document).on('click', '.delete_time_block', function (e) {
        e.preventDefault();
        let $count = $(this).closest('.line').find('.time_block').length;

        if ($count === 1){
            swal.fire('Warning!', 'You have to have at least one timeframe set up.', 'warning');
        }
        else{
            $(this).closest('.time_block').remove();
        }
    });

    $(document).on('click', '.remove-day-delivery', function (e) {
        e.preventDefault();
        let $count = $(this).closest('.date').find('.line').length;

        if ($count === 1){
            swal.fire('Warning!', 'You have to have at least one day set up.', 'warning');
        }
        else{
            $(this).closest('.line').remove();
        }
    });

    $(document).on('click', '.delivery-day-delete', function (e) {
        e.preventDefault();
        let $delivery = $(this).closest('.date');
        let $timeframe = $(this).closest('.timeframes');
        let $count = $delivery.find('.day_time').length;

        if ($count === 1){
            swal.fire('Warning!', 'You have to have at least one delivery day set up.', 'warning');
        }
        else{
            $(this).closest('.day_time').remove();
            $timeframe.find('.day_time:last').find('.add_delivery_day_button').show();
        }
    })

    $(document).on('click', '.remove-day-pickup', function (e) {
        e.preventDefault();
        let $count = $(this).closest('.pickup').find('.line').length;

        if ($count === 1){
            swal.fire('Warning!', 'You have to have at least one day set up.', 'warning');
        }
        else{
            $(this).closest('.line').remove();
        }
    });

    $(document).on('click', '.pickup-day-delete', function (e) {
        e.preventDefault();
        let $pickup = $(this).closest('.pickup');
        let $timeframe = $(this).closest('.timeframes');
        let $count = $pickup.find('.day_time').length;

        if ($count === 1){
            swal.fire('Warning!', 'You have to have at least one pickup day set up.', 'warning');
        }
        else{
            $(this).closest('.day_time').remove();
            $timeframe.find('.day_time:last').find('.add_pickup_day_button').show();
        }
    })

    $(document).on('click', '.remove-day-pickupB', function (e) {
        e.preventDefault();
        let $count = $(this).closest('.pickupB').find('.line').length;

        if ($count === 1){
            swal.fire('Warning!', 'You have to have at least one day set up.', 'warning');
        }
        else{
            $(this).closest('.line').remove();
        }
    });

    $(document).on('click', '.pickupB-day-delete', function (e) {
        e.preventDefault();
        let $pickup = $(this).closest('.pickupB');
        let $timeframe = $(this).closest('.timeframes');
        let $count = $pickup.find('.day_time').length;

        if ($count === 1){
            swal.fire('Warning!', 'You have to have at least one pickup day set up.', 'warning');
        }
        else{
            $(this).closest('.day_time').remove();
            $timeframe.find('.day_time:last').find('.add_pickupB_day_button').show();
        }
    })

    $(document).on('click', '.add_time_button', function (e) {
        e.preventDefault();
        let $this = $(this).closest('.day_time').find('.times');
        let $line = $(this).closest('.date').find('.time_block:last');
        let $numberDay = ($(this).closest('.day_time').data('day-id') ?? 1)
        let $numberTF = ($line.data('number') ?? 0) + 1;
        let $numberLine = $(this).closest('.line').data('line');

        let $block = $line.clone()
            .attr('data-number', $numberTF)
            .find('input').val('').end()
            .find('.since-input').attr('name', 'delivery['+ $numberLine +'][days_available][' + $numberDay + '][times][' + $numberTF + '][since]').val('').end()
            .find('.until-input').attr('name', 'delivery['+ $numberLine +'][days_available][' + $numberDay + '][times][' + $numberTF + '][until]').val('').end()
            .find('.delete_time_block').attr('data-id', $numberTF).end();

        $this.append($block);
        refresh();
    });

    $(document).on('click', '.add_time_button_pickup', function (e) {
        e.preventDefault();
        let $this = $(this).closest('.day_time').find('.times');
        let $line = $(this).closest('.pickup').find('.time_block:last');
        let $numberDay = ($(this).closest('.day_time').data('day-id') ?? 1)
        let $numberTF = ($line.data('number') ?? 0) + 1;
        let $numberLine = $(this).closest('.line').data('line');

        let $block = $line.clone()
            .attr('data-number', $numberTF)
            .find('input').val('').end()
            .find('.since-input').attr('name', 'pickup['+ $numberLine +'][days_available][' + $numberDay + '][times][' + $numberTF + '][since]').val('').end()
            .find('.until-input').attr('name', 'pickup['+ $numberLine +'][days_available][' + $numberDay + '][times][' + $numberTF + '][until]').val('').end()
            .find('.delete_time_block').attr('data-id', $numberTF).end();

        $this.append($block);
        refresh();
    });

    $(document).on('click', '.add_time_button_pickupB', function (e) {
        e.preventDefault();
        let $this = $(this).closest('.day_time').find('.times');
        let $line = $(this).closest('.pickupB').find('.time_block:last');
        let $numberDay = ($(this).closest('.day_time').data('day-id') ?? 1)
        let $numberTF = ($line.data('number') ?? 0) + 1;
        let $numberLine = $(this).closest('.line').data('line');

        let $block = $line.clone()
            .attr('data-number', $numberTF)
            .find('input').val('').end()
            .find('.since-input').attr('name', 'pickupB['+ $numberLine +'][days_available][' + $numberDay + '][times][' + $numberTF + '][since]').val('').end()
            .find('.until-input').attr('name', 'pickupB['+ $numberLine +'][days_available][' + $numberDay + '][times][' + $numberTF + '][until]').val('').end()
            .find('.delete_time_block').attr('data-id', $numberTF).end();

        $this.append($block);
        refresh();
    });

    $(document).on('click', '.add_new_day', function (e) {
        e.preventDefault();
        let $this = $(this).parents('.date');
        let $line = $this.find('.line:last');

        let $numberLine = $line.data('line') + 1;


        $line.clone()
            .attr('data-line', $numberLine)
            .find('input').val('').end()
            .find('.day_time').attr('data-day-id', 1).end()
            .find('select').find('option:first').prop('selected', true).end().end()
            .find('.time_block').remove().end()
            .find('.day-select').attr('name', 'delivery['+ $numberLine +'][day]').val('').end()
            .find('.time-input').attr('name', 'delivery['+ $numberLine +'][time]').val('').end()
            .find('.delivery_day').attr('name', 'delivery['+ $numberLine +'][days_available][1][day]').val('').end()
            .find('.timeframes').children().not(':last').remove().end().end().end()
            .appendTo('.date:last');
    });

    $(document).on('click', '.add_new_day_pickup', function (e) {
        e.preventDefault();

        let $this = $(this).parents('.pickup');
        let $line = $this.find('.line:last');

        let $numberLine = $line.data('line') + 1;

        $line.clone()
            .attr('data-line', $numberLine)
            .find('input').val('').end()
            .find('.day_time').attr('data-day-id', 1).end()
            .find('select').find('option:first').prop('selected', true).end().end()
            .find('.time_block').remove().end()
            .find('.day-select').attr('name', 'pickup['+ $numberLine +'][day]').val('').end()
            .find('.time-input').attr('name', 'pickup['+ $numberLine +'][time]').val('').end()
            .find('.delivery_day').attr('name', 'pickup['+ $numberLine +'][days_available][1][day]').val('').end()
            .find('.timeframes').children().not(':last').remove().end().end().end()
            .appendTo('.pickup:last');
    });

    $(document).on('click', '.add_new_day_pickupB', function (e) {
        e.preventDefault();

        let $this = $(this).parents('.pickupB');
        let $line = $this.find('.line:last');

        let $numberLine = $line.data('line') + 1;

        $line.clone()
            .attr('data-line', $numberLine)
            .find('input').val('').end()
            .find('.day_time').attr('data-day-id', 1).end()
            .find('select').find('option:first').prop('selected', true).end().end()
            .find('.time_block').remove().end()
            .find('.day-select').attr('name', 'pickupB['+ $numberLine +'][day]').val('').end()
            .find('.time-input').attr('name', 'pickupB['+ $numberLine +'][time]').val('').end()
            .find('.delivery_day').attr('name', 'pickupB['+ $numberLine +'][days_available][1][day]').val('').end()
            .find('.timeframes').children().not(':last').remove().end().end().end()
            .appendTo('.pickupB:last');
    });

    $(document).on('click', '.add_delivery_day_button', function (e) {
        e.preventDefault();


        let $this = $(this).closest('.timeframes');
        let $line = $this.find('.day_time:last');
        let $numberTF = ($line.data('day-id') ?? 0) + 1;
        let $numberLine = $(this).closest('.line').data('line');

        let $block = $line.clone()
            .attr('data-day-id', $numberTF)
            .find('select').find('option:first').prop('selected', true).end().end()
            .find('.delivery_day').attr('name', 'delivery['+ $numberLine +'][days_available][' + $numberTF + '][day]').val('').end()
            .find('.time_block').remove().end();

        $this.append($block);
        $(this).hide();
    });

    $(document).on('click', '.add_pickup_day_button', function (e) {
        e.preventDefault();

        let $this = $(this).closest('.timeframes');
        let $line = $this.find('.day_time:last');
        let $numberTF = ($line.data('day-id') ?? 0) + 1;
        let $numberLine = $(this).closest('.line').data('line');

        let $block = $line.clone()
            .attr('data-day-id', $numberTF)
            .find('select').find('option:first').prop('selected', true).end().end()
            .find('.delivery_day').attr('name', 'pickup['+ $numberLine +'][days_available][' + $numberTF + '][day]').val('').end()
            .find('.time_block').remove().end();

        $this.append($block);
        $(this).hide();
    });

    $(document).on('click', '.add_pickupB_day_button', function (e) {
        e.preventDefault();

        let $this = $(this).closest('.timeframes');
        let $line = $this.find('.day_time:last');
        let $numberTF = ($line.data('day-id') ?? 0) + 1;
        let $numberLine = $(this).closest('.line').data('line');

        let $block = $line.clone()
            .attr('data-day-id', $numberTF)
            .find('select').find('option:first').prop('selected', true).end().end()
            .find('.delivery_day').attr('name', 'pickupB['+ $numberLine +'][days_available][' + $numberTF + '][day]').val('').end()
            .find('.time_block').remove().end();

        $this.append($block);
        $(this).hide();
    });

    $('#timeForm').on('submit', function (e) {
        e.preventDefault();
        let $this = $(this);

        $.ajax({
            url : $this.attr('action'),
            type : $this.attr('method'),
            data : $this.serialize(),
            success : function (response) {

            },
            error : function (errors) {

            },
        })
    })

    function refresh() {
        $(".time_picker").datetimepicker({
            format: "LT",
            icons: {
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down"
            }
        });
    }
});
