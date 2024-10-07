$(function () {
    var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    if(iOS) {
        // $(".section1").css({'min-height': "calc(100vh - 170px);"})
        $('body').addClass('ios');
    }
    $('body').animate({
        scrollTop: 0,
    });

    $('.order-menu .order-menu__header:not("a")').click(function (e) {
        let $target = $(e.target);

        if (!$target.is('a') && !$target.is('button')) {
            let link                  = $(this);
            let closest_ul            = link.closest('ul');
            let parallel_active_links = closest_ul.find('.active');
            let closest_li            = link.closest('li');
            let link_status           = closest_li.hasClass('active');
            let arrow                 = link.find('.order-menu__icon');
            let count                 = 0;

            closest_ul.find('ul').slideUp(function () {
                if (++count === closest_ul.find('ul').length)
                    parallel_active_links.removeClass('active');
            });

            if (!link_status) {
                closest_li.children('ul').slideDown();
                closest_li.addClass('active');
                arrow.addClass('active');
            }
        }
    });

    window.onresize = function () {
        document.body.height = window.innerHeight;
    }
    window.onresize();

    $('.success-order-info__close').click(function () {
        $(this).closest('.active').removeClass('active');
    });

    if (window.innerWidth > 991.98) {
        mathWidth(48);
    } else {
        mathWidth(32);
    }

    function mathWidth(num) {
        $(window).on('resize load', function () {
            let widht      = parseInt($('.content_main').css('width')) - num;
            let widhtInner =
                    parseInt($('.content_box--padding-small').css('width')) - num;
            $('.success-order-info').css('max-width', widhtInner);
            $('.success-order-info.success_order_info_in_content').css(
                'max-width',
                widhtInner
            );
        });
    }

    $('.edit-referral-code').click(function (evt) {
        evt.preventDefault();
        $('#edit-referral-popup').addClass('active');
        $('body').addClass('ovh');
        $('html').addClass('ovh');
    });

    $('.share-email-popup').click(function (evt) {
        evt.preventDefault();
        $('#share-email').addClass('active');
        $('body').addClass('ovh');
        $('html').addClass('ovh');
    });
    $('.share-link-popup').click(function (evt) {
        evt.preventDefault();
        $('#share-link').addClass('active');
        $('body').addClass('ovh');
        $('html').addClass('ovh');
    });
    $('.share-gift-popup').click(function (evt) {
        evt.preventDefault();
        $('#gift-card-bay').addClass('active');
        $('body').addClass('ovh');
        $('html').addClass('ovh');
    });
    $('.enter-massage-popup').click(function (evt) {
        evt.preventDefault();
        $('#enter-massage').addClass('active');
        $('body').addClass('ovh');
        $('html').addClass('ovh');
    });
    $('.enter-massage-sms-popup').click(function (evt) {
        evt.preventDefault();
        $('#enter-massage-sms').addClass('active');
        $('body').addClass('ovh');
        $('html').addClass('ovh');
    });
    $('.btn-close-duplicate-mobile').click(function (e) {
        e.preventDefault();
        $(this).closest('#duplicate-this-meal').removeClass('active');
        $('body').removeClass('ovh');
        $('html').removeClass('ovh');
    });
    $('.btn-popup-about-product').click(function (e) {
        e.preventDefault();
        $('#popup-about-product').addClass('active');
        $('body').addClass('ovh');
        $('html').addClass('ovh');
    });

    // / popups init ====================================================
    // input-btn-clear-show ================
    $('.input-clear-show').on('input', function () {
        let inputValue = $(this).val();
        if (inputValue) {
            $(this).next().css('display', 'block');
        } else {
            $(this).next().css('display', 'none');
        }
    });

    $(document).on('click', '.calear-form', function () {
        $(this).parent().find('input').val('').focus();
        $(this).parent().find('select').prop('selectedIndex', 0);
        $(this).css('display', 'none');
    });
    $('.input').on('input', function(){
        if($(this).val().length > 0){
            $(this).parent().find('.calear-form').css('display', 'block');
        } else {
            $(this).parent().find('.calear-form').css('display', 'none');
        }
    })
    $('.btn-open-right-sidebar').on('click', function (e) {
        e.preventDefault();
        $('.content_cart').addClass('active');
        $('body').addClass('body-lock');
    });

    $('.btn-close-right-sidebar').on('click', function () {
        $('.content_cart').removeClass('active');
        $('body').removeClass('body-lock');
    });

    // meals menu =====================================================
    function checkButtons(value) {
        let dataButtons = $('.meals-calculate__picker-button');
        $('.meals-calculate__picker-button').removeClass('active');
        for (i = 0; i < dataButtons.length; i++) {
            if (
                +parseInt($(dataButtons[i]).attr('data-value')) === +parseInt(value)
            ) {
                $(dataButtons[i]).addClass('active');
                return true;
            }
        }

        return false;
    }

    $('.input-check').on('input', function () {
        let $this           = $(this);
        let inputValue      = $this.val();
        let minAllowedValue = $this.data('min-allowed-value') || 0;

        $('.calear-form').css('display', 'block');

        if (inputValue === '' || inputValue < minAllowedValue) {
            $('.btn-meal').addClass('disable').removeClass('active');
            $this.addClass('error');
            $('.meals-calculate__subtitle').addClass('error');
        } else {
            $('.btn-meal').removeClass('disable').addClass('active');
            $this.removeClass('error');
            $('.meals-calculate__subtitle').removeClass('error');
        }
    });

    $('.meals-calculate__picker-button').click(function () {
        $('.meals-calculate__picker-button').removeClass('active');
        $(this).addClass('active');
        $('.calear-form').css('display', 'block');
        $('.input-check').val($(this).attr('data-value')).removeClass('error').trigger('input');
        $('.btn-meal').removeClass('disable').addClass('active');
    });

    $('.up-date').click(function () {
        let liCount   = $('.input-check').val();
        let mealsMenu = $('.header__nav');
        console.log(liCount);
        if (liCount && +liCount >= 5) {
            console.log(liCount);
            mealsMenu.text('');
            mealsMenu.append('<div class="kasetudsionud" id="kasetudsionud"></div>');
            for (i = 0; i < liCount; i++) {
                mealsMenu.append(menuItem(i));
            }
            mealsMenu.append(
                '<a href="#" class="btn btn-green meals-add-btn"><img src="/assets/frontend/img/add-icon_white.svg" alt="">Add</a>'
            );
            $('.popup_wrpr.active').removeClass('active');
            $('body').removeClass('ovh');
            $('html').removeClass('ovh');
        }
    });

    function menuItem(value) {
        return `
        <li class='order-menu-heade__item'>
            <a href='#' class='order-menu-heade__link'>
                <img src='img/Yes.svg' class='' alt=''>
                <img src='img/Warning-meals.svg' class='' alt=''>
                Meal ${value + 1}
            </a>
        </li>
        `;
    }

    $(document).on('click', '.calear-form', function () {
        $('.input-check').val('').removeClass('error');
        $('.meals-calculate__subtitle').removeClass('error');
        $('.meals-calculate__picker-button').removeClass('active');

        $(this).parents('.input-wrapper').find('input').trigger('input').trigger('change');
    });
    // / meals menu =====================================================

    $('.points-info-block__title').click(function () {
        let $pointsInfoBlock = $(this).parents('.points-info-block');

        $pointsInfoBlock.find('.points-info-block__content-wrapper').slideToggle();
        $pointsInfoBlock.toggleClass('active');
    });

    // if ($('.perfect_scroll').length > 0) {
    //   $('.perfect_scroll').each(function () {
    //     const ps = new PerfectScrollbar($(this)[0]);
    //   });
    // }

    // mobele menu slider ===========================
    if ($('.header__nav').length) {
        $(function () {
            let items        = $('.header__nav').width();
            let itemSelected = document.getElementsByClassName(
                'order-menu-heade__item'
            );
            if ($('.header__nav').scrollLeft() < 10) {
                $('.dascevaimas-paddle-left').addClass('not-active');
            }
            $('.header__nav').on('scroll', function (e) {
                if ($(this).scrollLeft() < 10) {
                    $('.dascevaimas-paddle-left').addClass('not-active');
                } else {
                    $('.dascevaimas-paddle-left').removeClass('not-active');
                }
            });
            navPointerScroll($(itemSelected));
            // $('.header__nav').scrollLeft(200).delay(200).animate({
            //     scrollLeft: '-=200'
            // }, 2000, 'easeOutQuad');

            $('.dascevaimas-paddle-right').click(function () {
                $('.header__nav').animate({
                    scrollLeft: '+=' + items,
                });
            });
            $('.dascevaimas-paddle-left').click(function () {
                $('.header__nav').animate({
                    scrollLeft: '-=' + items,
                });
            });

            if (
                !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                    navigator.userAgent
                )
            ) {
                let scrolling = false;

                $('.dascevaimas-paddle-right')
                    .bind('mouseover', function (event) {
                        scrolling = true;
                        scrollContent('right');
                    })
                    .bind('mouseout', function (event) {
                        scrolling = false;
                    });

                $('.dascevaimas-paddle-left')
                    .bind('mouseover', function (event) {
                        scrolling = true;
                        scrollContent('left');
                    })
                    .bind('mouseout', function (event) {
                        scrolling = false;
                    });

                function scrollContent(direction) {
                    let amount = direction === 'left' ? '-=3px' : '+=3px';
                    $('.header__nav').animate(
                        {
                            scrollLeft: amount,
                        },
                        1,
                        function () {
                            if (scrolling) {
                                scrollContent(direction);
                            }
                        }
                    );
                }
            }

            $('.order-menu-heade__item').click(function () {
                $('.dascevaimas').find('.order-menu-heade__item').removeClass('active');
                $(this).addClass('active');
                navPointerScroll($(this));
            });
        });

        function navPointerScroll(ele) {
            let parentScroll = $('.header__nav').scrollLeft();
            let offset       = $(ele).offset().left - $('.header__nav').offset().left;
            let totalelement = offset + $(ele).outerWidth() / 2;

            let rt =
                    $(ele).offset().left -
                    $('.dascevaimas-wrapper').offset().left +
                    $(ele).outerWidth() / 2;
            $('.kasetudsionud').animate({
                left: totalelement + parentScroll,
            });
        }
    }

    // /mobele menu slider ===========================================

    // document.querySelector('.content').addEventListener('touchmove', function (event) {
    //   event.stopPropagation()
    // }, false)
    $('.entry-item__food-icon-wrapper').on('click', function() {
        $(this).closest('.entry-item').find('[data-action="show-meal-details-popup"]').trigger('click')
    })
    // $('.entry-item__food-icon-wrapper').hover(function() {
    //     $(this).closest('.entry-item').find('[data-action="show-meal-details-popup"]').trigger('click')
    // })
});
