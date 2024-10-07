$(function () {
    /**
     * File uploaded event.
     */
    document.addEventListener('FilePond:processfile', e => {
        let filePath = e.detail.file.serverId;
        let id       = e.detail.file.id;

        if (filePath.indexOf('/gallery/') !== -1) {
            $('#update-page-form').append('<input type="hidden" name="data[gallery][items][]" value="' + filePath + '" id="' + id + '">');
        } else {
            $('#update-page-form').append('<input type="hidden" name="data[reviews][items][]" value="' + filePath + '" id="' + id + '">');
        }
    });

    /**
     * File removed event.
     */
    document.addEventListener('FilePond:removefile', e => {
        let id = e.detail.file.id;

        $('#' + id).remove();
    });

    /**
     * Submit form.
     */
    $('#update-page-form').submit(function (e) {
        e.preventDefault();

        let $form = $(this);

        $.ajax({
            url       : $form.attr('action'),
            type      : $form.find('[name="_method"]').val(),
            data      : $form.serialize(),
            beforeSend: function () {
                $form.find('p.text-danger[data-field-name]').text('');
            },
            success   : function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text : response.message,
                        icon : 'success',
                        timer: 1500,
                    }).then(() => {
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

                    $.each(JSON.parse(response.responseText).errors, function (field, value) {
                        let $errorField = $('p.error-text[data-field-name="' + field + '"]');

                        $errorField.parents('.input-wrapper').addClass('error');
                        $errorField.text(value[0]).addClass('active');
                    });
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

    /**
     * Delete image.
     */
    $('[data-action="delete-image"]').click(function (e) {
        e.preventDefault();

        let $this = $(this);

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
                    url    : $this.data('listener'),
                    type   : 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data   : {
                        path: $this.data('path'),
                        key : $this.data('key'),
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            $this.parents('.image__wrapper').remove();
                        }
                    },
                    error  : function (response) {
                        if (response.status === 422) {
                            Swal.fire({
                                title: 'Validation error!',
                                text : response.responseJSON.message,
                                icon : 'error',
                                timer: 1500,
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text : response.responseJSON.message,
                                icon : 'error',
                                timer: 1500,
                            });
                        }
                    }
                });
            }
        });
    });
});
