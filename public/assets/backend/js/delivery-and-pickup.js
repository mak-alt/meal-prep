function googleAutocomplete() {
    let addresses     = document.getElementsByClassName('address-input');
    let options       = {};
    let autocompletes = [];

    for (var i = 0; i < addresses.length; i++) {
        var autocomplete     = new google.maps.places.Autocomplete(addresses[i], options);
        autocomplete.inputId = addresses[i].id;
        autocomplete.addListener('place_changed', fillIn);
        autocompletes.push(autocomplete);
    }

    function fillIn() {
        var place = this.getPlace();
    }
}

$(function () {
    $('.add_address_button').click(function (e) {
        e.preventDefault();

        let $number = $(document).find('.add_address_block:last').data('number') + 1;

        $('.add_address_block:last').clone()
            .attr('data-number', $number)
            .find('input:text').val('').end()
            .find('.name-input').attr('name', 'data[pickup_locations][items][' + $number + '][name]').end()
            .find('.address-input').attr('name', 'data[pickup_locations][items][' + $number + '][address]').end()
            .find('.remove-address').attr('data-id', $number).end()
            .appendTo('.addresses:last');

        googleAutocomplete();
    });

    $(document).on('click', '.remove-address', function (e) {
        e.preventDefault();
        let $removeBlockNumber = $(this).data('id');

        $('.add_address_block[data-number="' + $removeBlockNumber + '"]').remove();
    });

    $('.add_timing_button').click(function (e) {
        e.preventDefault();
        let $number = $(document).find('.add_timing_block:last').data('number') + 1;

        $('.add_timing_block:last').clone()
            .attr('data-number', $number)
            .find('.form-control').val('').end()
            .find('#title_timing').attr('name', 'data[delivery_and_pickup_timing][items][' + $number + '][title]').end()
            .find('#description_timing').attr('name', 'data[delivery_and_pickup_timing][items][' + $number + '][description]').end()
            .find('.remove-timing').attr('data-id', $number).end()
            .appendTo('.timings:last');
    });

    $(document).on('click', '.remove-timing', function (e) {
        e.preventDefault();
        let $removeBlockNumber = $(this).data('id');

        $('.add_timing_block[data-number="' + $removeBlockNumber + '"]').remove();
    });
});
