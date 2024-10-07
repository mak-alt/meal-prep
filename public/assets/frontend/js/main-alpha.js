$(function () {
    let uaTwo   = window.navigator.userAgent;
    let isIETwo = /MSIE|Trident/.test(uaTwo);

    if (isIETwo) {
        document.documentElement.classList.add('ie');
    }

    if (navigator.userAgent.indexOf('Safari') !== -1 &&
        navigator.userAgent.indexOf('Chrome') === -1) {
        $('body').addClass('safari');
    }

    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.scroll_to_top').addClass('active');
        } else {
            $('.scroll_to_top').removeClass('active');
        }
    });

    $('.scroll_to_top').click(function () {
        $('html, body').animate({scrollTop: 0}, 'slow');
        return false;
    });

    $('.duplicate_popup_btn').click(function () {
        $('#duplicate-this-meal').addClass('active');
        return false;
    })

    $(document).on('change', '.duplicate_meals_list input', function () {
        if (this.checked) {
            $('.duplicate_btn').removeClass('btn_disabled').addClass('btn-green');

            if ($('.duplicate_meals_list input:checked').length === $('.duplicate_meals_list input').length) {
                let $buttonDuplicateListSelectAll = $('.duplicate_list_select_all');

                $buttonDuplicateListSelectAll
                    .addClass('duplicate_list_deselect_all')
                    .text('Deselect All')
                    .removeClass('duplicate_list_select_all');
            }

        } else {
            if ($('.duplicate_meals_list input:checked').length === 0) {
                $('.duplicate_btn').removeClass('btn-green').addClass('btn_disabled');
            }

            if ($('.duplicate_meals_list input:checked').length !== $('.duplicate_meals_list input').length) {
                let $buttonDuplicateListDeselectAll = $('.duplicate_list_deselect_all');

                $buttonDuplicateListDeselectAll
                    .addClass('duplicate_list_select_all')
                    .text('Select All')
                    .removeClass('duplicate_list_deselect_all');
            }
        }
    });

    $(document).on('click', '.duplicate_list_select_all', function () {
        $('.duplicate_meals_list input').prop('checked', true);
        $('.duplicate_btn').removeClass('btn_disabled').addClass('btn-green');

        $(this).removeClass('duplicate_list_select_all');
        $(this).addClass('duplicate_list_deselect_all');
        $(this).text('Deselect All');

        return false;
    });

    $(document).on('click', '.duplicate_list_deselect_all', function () {

        console.log(22)
        $('.duplicate_meals_list input').prop('checked', false);
        $('.duplicate_btn').removeClass('btn-green').addClass('btn_disabled');

        $(this).removeClass('duplicate_list_deselect_all');
        $(this).addClass('duplicate_list_select_all');
        $(this).text('Select All');

        return false;
    })

    $(document).on('input', '.duplicated_amount_input', function () {
        $('.duplicate_meals_list_box').addClass('active');
    });

    $('.mobile_header_menu').click(function () {
        $('.sidebar').toggleClass('active');
        $('body').toggleClass('body-lock');
        $('.mobile_header').toggleClass('active');

        if ($('.mobile_header').hasClass('active')) {
            $('img', this).attr('src', '/assets/frontend/img/close-menu-icon.svg');
        } else {
            $('img', this).attr('src', '/assets/frontend/img/burger-menu-icon.svg');
        }

        $(this).addClass('mobile_header_menu-close');

        return false;
    })


    // $('.entry-item').click(function(){
    //     $('.content_cart.content_cart-fixed').toggleClass('active');
    //     return false;
    // })
});
