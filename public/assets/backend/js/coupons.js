$(function () {
    let $couponField = $('input[name="coupon_code"]');

    function pasteCouponCode() {
        $couponField.val(Math.random().toString(36).substring(5));
    }

    if ($couponField.val().length === 0) {
        pasteCouponCode();
    }

    $('.generate-code').click(function (e) {
        e.preventDefault();

        pasteCouponCode();
    });

    $(document).on('click', 'input[name="all_users"]', function () {
        let $usersSelect = $('#users-select');

        $usersSelect.val('').trigger('change');
        $usersSelect.prop('disabled', $(this).prop('checked'));
    });
});
