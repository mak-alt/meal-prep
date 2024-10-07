$(function () {
    let $mealsSelect = $('#meals');
    let $mealsTable  = $('#meals-table');

    /**
     * Render and append selected meal table item.
     */
    $mealsSelect.on('select2:select', function (e) {
        renderAndAppendSelectedMeals([e.params.data.id]);
    }).on('select2:unselecting', function (e) {
        $mealsTable.find('tr[data-meal-id="' + e.params.args.data.id + '"]').remove();
    });

    /**
     * Render and append selected meals to meals table.
     * @param mealIds
     */
    function renderAndAppendSelectedMeals(mealIds = null) {
        let data = {
            meal_ids: mealIds ? mealIds : $mealsSelect.val(),
        };

        if (mealIds === null) {
            data.addon_id = $mealsTable.data('addon-id');
        }

        $.ajax({
            url       : $mealsSelect.data('listener'),
            type      : 'GET',
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data      : data,
            beforeSend: function () {
                $('p.text-danger[data-field-name="meal_ids"]').text('');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    $mealsTable.find('tbody').append(response.data.meals_table_items_view);
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
});
