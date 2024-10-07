$(function () {
    /**
     * Repeat order.
      */
    $('[data-action="repeat-order"]').click(function (e) {
        e.preventDefault();

        $.ajax({
            url    : $(this).attr('href'),
            type   : 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text : response.message,
                        icon : 'success',
                        timer: 1500,
                    }).then(() => {
                        window.location.href = response.data.redirect;
                    });
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
    });
});
