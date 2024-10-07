$(function () {
    /**
     * Add row to portion sizes table.
     */
    $('[data-action="add-portion-size"]').click(function () {
        $.ajax({
            url    : $(this).data('listener'),
            type   : 'GET',
            data   : {
                index: parseInt($('#meals-portion-sizes-table tbody tr').last().data('index')) + 1,
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('#meals-portion-sizes-table').append(response.data.portion_size_table_item);
                }
            },
            error  : function (response) {
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
    });

    /**
     * Delete row from portion sizes table.
     */
    $(document).on('click', '[data-action="delete-portion-size"]', function () {
        $(this).parents('tr').remove();
    });
});
