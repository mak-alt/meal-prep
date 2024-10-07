$(function () {
    /**
     * Init Select2
     */
    $('.select2').select2();

    /**
     * Init mask js.
     */
    $('.phone-number__mask').mask('(999) 999-9999');

    /**
     * Init Summernote
     */
    $('.textarea').summernote({height: 150});

    /**
     * Resolve conflict in jQuery UI tooltip with Bootstrap tooltip
     */
    $.widget.bridge('uibutton', $.ui.button);

    /**
     * Init Google Maps autocomplete.
     */
    function googleAutocomplete() {
        let addresses = document.getElementsByClassName('address-input');
        let options   = {};

        for (let i = 0; i < addresses.length; i++) {
            let autocomplete     = new google.maps.places.Autocomplete(addresses[i], options);
            autocomplete.inputId = addresses[i].id;
        }
    }

    googleAutocomplete();

    /**
     * Init FilePond.
     */
    let $filePondInputs = $('input.filepond');

    if ($filePondInputs.length > 0) {
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        FilePond.registerPlugin(FilePondPluginFileValidateType);

        $.each($filePondInputs, function (index, element) {
            let $element = $(element);

            $element.filepond({
                acceptedFileTypes: [
                    'image/jpeg',
                    'image/png',
                    'image/svg+xml'
                ],
                allowMultiple    : $element.attr('multiple') !== 'undefined',
                maxFileSize      : '5MB',
                maxTotalFileSize : '200MB',
                server           : {
                    url    : '/files',
                    type   : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    process: {
                        ondata: function (formData) {
                            formData.append('path', $element.data('upload-path'));
                            formData.append('filepond', true);

                            return formData;
                        },
                    },
                },
            });
        });
    }

    /**
     * Delete record with SweetAlert prompt.
     */
    $(document).on('click', '[data-action="delete-record"]', function (e) {
        e.preventDefault();

        let $this    = $(this);
        let redirect = $this.data('redirect');

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
                    url    : $this.attr('href'),
                    type   : 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Success!',
                                icon : 'success',
                                text : response.message,
                                timer: 1000,
                            }).then(function () {
                                if (typeof redirect !== 'undefined') {
                                    window.location.href = redirect;
                                } else {
                                    window.location.reload();
                                }
                            });
                        }
                    },
                    error  : function (response) {
                        Swal.fire('Error!', response.responseJSON.message, 'error');
                    }
                });
            }
        });
    });

    /**
     * Logout.
     */
    $('[data-action="logout"]').click(function (e) {
        e.preventDefault();

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
                $('#logout-form').submit();
            }
        });
    });

    /**
     * Calculate points amount based on entered price.
     */
    $('[data-action="calculate-points"]').keyup(function () {
        let $this = $(this);

        $.ajax({
            url    : $this.data('listener'),
            type   : 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data   : {
                price: $this.val(),
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('.points__calculatable').val(response.data.points);
                }
            },
        });
    });
});
