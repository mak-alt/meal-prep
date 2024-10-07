$(function () {
    /**
     * Update status.
     */
    $('a[data-action="update-status"]').click(function (e) {
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
                $.ajax({
                    url    : $(this).attr('href'),
                    type   : 'PATCH',
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
                                window.location.reload();
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
     * Toggle profile fields visibility.
     */
    $('#role').change(function () {
        if ($(this).find('option:selected').val() === 'user') {
            $('#profile-block').fadeIn();
            $('#update-profile').prop('checked', true).attr('disabled', false);
        } else {
            $('#profile-block').hide();
            $('#update-profile').prop('checked', false).attr('disabled', true);
        }
    });

    $('#search-field').on('change', function () {
        if (window.location.href.includes('?search')){
            window.location.href = window.location.href.replace( new RegExp('\\?search=.*?(?=&|$)','gm'), '?search='
                + $(this).val());
        } else if(window.location.href.includes('&search')){
            window.location.href = window.location.href.replace( new RegExp('&search=.*?(?=&|$)','gm'), '&search='
                + $(this).val());
        }else if(window.location.href.includes('?')){
            window.location.href = window.location.href + '&search=' + $(this).val();
        } else{
            window.location.href = window.location.href + '?search=' + $(this).val();
        }
    });

    $('#clear-filters').on('click', function (e) {
        e.preventDefault();

        if (window.location.href.includes('?')){
            window.location.href = window.location.href.replace(window.location.search,'');
        }
    });
});
