$(function () {

    // $('#meals').select2({
    //     templateResult: formatResultData,
    //     tags : true,
    // });

    $('.add_price_button').click(function (e) {
        e.preventDefault();

        let $number = $(document).find('.add_price_block:last').data('number') + 1;

        $('.add_price_block:last').clone()
            .attr('data-number', $number)
            .find('input').val('').end()
            .find('.count-input').attr('name', 'plan[' + $number + '][count]').end()
            .find('.price-input').attr('name', 'plan[' + $number + '][price]').end()
            .find('.remove-address').attr('data-id', $number).end()
            .appendTo('.addresses:last');
    });

    $(document).on('click', '.remove-price', function (e) {
        e.preventDefault();
        let $removeBlockNumber = $(this).data('id');

        $('.add_price_block[data-number="' + $removeBlockNumber + '"]').remove();
    });

    let $mealsSelect = $('#meals');
    let $mealsTable  = $('#meals-table');

    let old_values = [];

    /**
     * Render and append selected meal table item.
     */
    $mealsSelect.on('select2:select', function (e) {
        let values = [];
        // copy all option values from selected
        $(e.currentTarget).find("option:selected").each(function(i, selected){
            values[i] = $(selected).data('select2-id');
        });
        let last = $(values).not(old_values).get();
        old_values = values;

        let $last = $('[data-select2-id="'+ last[0] +'"]').val();
        let $this = $(this);

        $this.append('<option value="'+$last+'">' +e.params.data.text + '</option>');
        renderAndAppendSelectedMeal(e.params.data.id);
        $mealsSelect.trigger('change');
    }).on('select2:unselecting', function (e) {
        $mealsSelect.find('option[value="'+ e.params.args.data.id +'"]:not(:selected):first').remove();
        let $row = $mealsTable.find('tr[data-meal-id="' + e.params.args.data.id + '"]').last();
        $('#carbs').val(parseInt($('#carbs').val()) - parseInt($row.data('carbs')));
        $('#proteins').val(parseInt($('#proteins').val()) - parseInt($row.data('proteins')));
        $('#calories').val(parseInt($('#calories').val()) - parseInt($row.data('calories')));
        $('#fats').val(parseInt($('#fats').val()) - parseInt($row.data('fats')));
        $row.remove();
        if($('#carbs').val() < 0){
            $('#carbs').val('0');
        }
        if($('#proteins').val() < 0){
            $('#proteins').val('0');
        }
        if($('#calories').val() < 0){
            $('#calories').val('0');
        }
        if($('#fats').val() < 0){
            $('#fats').val('0');
        }
        setTimeout(function () {
            if($mealsSelect.val().length === 0){
                $('#fats').val('0');
                $('#calories').val('0');
                $('#proteins').val('0');
                $('#carbs').val('0');
            }
        });
    });

    $(document).on('select2:select','.select-sides' ,function (e) {
        if($(e.target).hasClass('select-sides')) {
            $('#carbs').val(parseInt($('#carbs').val()) + parseInt(e.params.data.element.dataset.carbs));
            $('#proteins').val(parseInt($('#proteins').val()) + parseInt(e.params.data.element.dataset.proteins));
            $('#calories').val(parseInt($('#calories').val()) + parseInt(e.params.data.element.dataset.calories));
            $('#fats').val(parseInt($('#fats').val()) + parseInt(e.params.data.element.dataset.fats));
        }
    }).on('select2:unselecting', function (e) {
        if($(e.target).hasClass('select-sides')){
            $('#carbs').val(parseInt($('#carbs').val()) - parseInt(e.params.args.data.element.dataset.carbs));
            $('#proteins').val(parseInt($('#proteins').val()) - parseInt(e.params.args.data.element.dataset.proteins));
            $('#calories').val(parseInt($('#calories').val()) - parseInt(e.params.args.data.element.dataset.calories));
            $('#fats').val(parseInt($('#fats').val()) - parseInt(e.params.args.data.element.dataset.fats));

            if($('#carbs').val() < 0){
                $('#carbs').val('0');
            }
            if($('#proteins').val() < 0){
                $('#proteins').val('0');
            }
            if($('#calories').val() < 0){
                $('#calories').val('0');
            }
            if($('#fats').val() < 0){
                $('#fats').val('0');
            }
            setTimeout(function () {
                if($mealsSelect.val().length === 0){
                    $('#fats').val('0');
                    $('#calories').val('0');
                    $('#proteins').val('0');
                    $('#carbs').val('0');
                }
            });
        }
    });

    /**
     * Render and append selected meal to meals table.
     * @param mealId
     */
    function renderAndAppendSelectedMeal(mealId) {
        let arr = [];
        $mealsSelect.find('option:selected').each(function (index, item) {
            arr.push($(item).val());
        })
        $.ajax({
            url       : $mealsSelect.data('listener'),
            type      : 'GET',
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data      : {
                meal_id: mealId,
                times : countSameNumber(arr, mealId),
            },
            beforeSend: function () {
                $('p.text-danger[data-field-name="meal_ids"], p.text-danger[data-field-name="meal_id"]').text('');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    $mealsTable.find('tbody').append(response.data.meals_table_item_view);
                    $mealsTable.find('tr[data-meal-id="' + mealId + '"]').find('.select2').select2();
                    $('#carbs').val(parseInt($('#carbs').val()) + response.data.carbs);
                    $('#proteins').val(parseInt($('#proteins').val()) + response.data.proteins);
                    $('#calories').val(parseInt($('#calories').val()) + response.data.calories);
                    $('#fats').val(parseInt($('#fats').val()) + response.data.fats);
                }
            },
            error     : function (response) {
                if (response.status === 422) {
                    Swal.fire({
                        title: 'Validation error!',
                        icon : 'error',
                        timer: 1000,
                    });

                    $.each(response.responseJSON.errors, function (field, value) {
                        $('p.text-danger[data-field-name="' + field + '"]').text(value[0]);
                    });
                } else {
                    Swal.fire('Error!', response.responseJSON.message, 'error');
                }
            }
        });
    }

    function formatResultData (data) {
        if (!data.id) return data.text;
        if (data.element.selected) return
        return data.text;
    }

    function countSameNumber(ar, findNumber){
        let count = 0;
        ar.map((value) => {
            if(value === findNumber) {
                count = count + 1;
            }
        })
        return count;
    }
});
