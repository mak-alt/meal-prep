$(function () {
    /**
     * Execute action on multiple selected records.
     */
    $('[data-action="execute-action-for-selected-records"]').click(function () {
        let $selectedOption       = $('#table-multiple-actions').find('option:selected');
        let action                = $selectedOption.data('action');
        let checkedTableRecordIds = $('#meals-table input[type="checkbox"]:checked:not("#check_all")').map(function () {
            return $(this).val();
        });

        checkedTableRecordIds = $.map(checkedTableRecordIds, function (value, index) {
            return [value];
        });

        if (typeof action !== 'undefined' && checkedTableRecordIds.length > 0) {
            Swal.fire({
                title             : 'Are you sure?',
                icon              : 'info',
                showCancelButton  : true,
                cancelButtonText  : 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor : '#d33',
                confirmButtonText : 'Yes!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url       : $selectedOption.data('listener'),
                        type      : 'DELETE',
                        headers   : {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data      : {
                            meal_ids: checkedTableRecordIds,
                        },
                        beforeSend: function () {
                            $('#table-multiple-actions').parent().next('p.text-danger[data-field-name]').text('');
                        },
                        success   : function (response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    icon : 'success',
                                    text : response.message,
                                    timer: 1000,
                                }).then(function () {
                                    window.location.reload();
                                });
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
        }
    });

    let $catSelect = $('#categories');

    $catSelect.on('change', function (e) {
        if ($catSelect.val().length === 0){
            $('#sides').empty();
            $('#sides-table').find('tbody').empty();
            //renderAndAppendSelectedSides();
        } else {
            let selectedSides = $('#sides').val();
            $.ajax({
                url : updateSides,
                data : {
                    ids : $catSelect.val(),
                },
                type : 'get',
                success: function (response) {
                    if (response.success){
                        $('#sides').find('option').not(':selected').remove();

                        $("#sides").select2({
                            data: response.sides
                        });
                    }
                }
            });
        }
    })

    $('#orderBy').on('change', function (){
        if (window.location.href.includes('?sort')){
            window.location.href = window.location.href.replace( new RegExp('\\?sort=.*','gm'), '?sort='+$(this).val());
        }else {
            window.location.href = window.location.href + '?sort='+ $(this).val();
        }
    });

    $('input[name="thumb"]').on('change', function (){
        if($(this).prop('files').length > 0){
            $('.thumb-label').empty();
            $('.thumb-label').append($(this).prop('files')[0].name);
        }
    });

    let $sidesSelect = $('#sides');
    let $sidesTable  = $('#sides-table');

    /**
     * Render and append selected side table item.
     */
    $sidesSelect.on('select2:select', function (e) {
        renderAndAppendSelectedSides([e.params.data.id]);
    }).on('select2:unselecting', function (e) {
        $sidesTable.find('tr[data-side-id="' + e.params.args.data.id + '"]').remove();
        $catSelect.trigger('change');
    });

    /**
     * Render and append selected sides to sides table.
     * @param sideIds
     */
    function renderAndAppendSelectedSides(sideIds = null) {
        let data = {
            side_ids: sideIds ? sideIds : $sidesSelect.val(),
        };

        if (sideIds === null) {
            data.meal_id = $sidesSelect.data('meal-id');
        }

        $.ajax({
            url       : $sidesSelect.data('listener'),
            type      : 'GET',
            headers   : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data      : data,
            beforeSend: function () {
                $('p.text-danger[data-field-name="side_ids"]').text('');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    $sidesTable.find('tbody').append(response.data.sides_table_items_view);
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

    $("#allSides").click(function(){
        let sideIds = [];

        $("#sides > option").prop("selected","selected").each(function() {
            sideIds.push(this.value);
        });
        $('#sides-table>tbody>tr').each(function() {
            let sideId = $(this).data('side-id');
            sideIds = $.grep(sideIds, function(value, ) {
                return value != sideId;
            });
        });

        if(sideIds.length !== 0) {
            renderAndAppendSelectedSides(sideIds);
            $("#sides").trigger("change");
        }
    });


    $('.status-switch').click(function (e) {
        $.ajax({
            url    : $(this).data('url'),
            type   : 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            error  : function (response) {
                Swal.fire('Error!', response.responseJSON.message, 'error');
            }
        });
    });

});
