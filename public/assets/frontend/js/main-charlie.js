$(function() {
    $('.close_popup_btn').click(function(evt) {
        evt.preventDefault();
        $(this).closest('.popup_wrpr').removeClass('active');
        $(this).closest('body').removeClass('ovh');
        $(this).closest('html').removeClass('ovh');
    });


    // Checking button status ( wether or not next/previous and
    // submit should be displayed )
    const checkButtons = (activeStep, stepsCount) => {
        const prevBtn = $('#wizard-prev');
        const nextBtn = $('#wizard-next');
        const submBtn = $('#wizard-subm');

        switch (activeStep / stepsCount) {
            case 0: // First Step
                prevBtn.hide();
                submBtn.hide();
                nextBtn.show();
                break;
            case 1: // Last Step
                nextBtn.hide();
                prevBtn.show();
                submBtn.show();
                break;
            default:
                submBtn.hide();
                prevBtn.show();
                nextBtn.show();
        }
    };

    // Scrolling the form to the middle of the screen if the form
    // is taller than the viewHeight
    const scrollWindow = (activeStepHeight, viewHeight) => {
        if (viewHeight < activeStepHeight) {
            $(window).scrollTop($(steps[activeStep]).offset().top - viewHeight / 2);
        }
    };

    // Setting the wizard body height, this is needed because
    // the steps inside of the body have position: absolute
    const setWizardHeight = activeStepHeight => {
        $('.wizard-body').height(activeStepHeight);
    };

    $(function() {
        // Form step counter (little cirecles at the top of the form)
        const wizardSteps = $('.wizard-header .wizard-step');
        // Form steps (actual steps)
        const steps = $('.wizard-body .step');
        // Number of steps (counting from 0)
        const stepsCount = steps.length - 1;
        // Screen Height
        const viewHeight = $(window).height();
        // Current step being shown (counting from 0)
        let activeStep = 0;
        // Height of the current step
        let activeStepHeight = $(steps[activeStep]).height();

        checkButtons(activeStep, stepsCount);
        setWizardHeight(activeStepHeight);

        // Resizing wizard body when the viewport changes
        $(window).resize(function() {
            setWizardHeight($(steps[activeStep]).height());
        });

        // Previous button handler
        $('#wizard-prev').click(() => {
            // Sliding out current step
            $(steps[activeStep]).removeClass('active');
            $(wizardSteps[activeStep]).removeClass('active');

            activeStep--;

            // Sliding in previous Step
            $(steps[activeStep]).removeClass('off').addClass('active');
            $(wizardSteps[activeStep]).addClass('active');

            activeStepHeight = $(steps[activeStep]).height();
            setWizardHeight(activeStepHeight);
            checkButtons(activeStep, stepsCount);
        });

        // Next button handler
        $('#wizard-next').click(() => {
            // Sliding out current step
            $(steps[activeStep]).removeClass('inital').addClass('off').removeClass('active');
            $(wizardSteps[activeStep]).removeClass('active');

            // Next step
            activeStep++;

            // Sliding in next step
            $(steps[activeStep]).addClass('active');
            $(wizardSteps[activeStep]).addClass('active');

            activeStepHeight = $(steps[activeStep]).height();
            setWizardHeight(activeStepHeight);
            checkButtons(activeStep, stepsCount);
        });
    });


    var tab = $('.tabs .tabs-items > div');
    tab.hide();

    $('.tabs .tabs-nav a').click(function() {
        let $this = $(this);

        $this.parents('.tabs').find('.tabs-items > div').hide();
        tab.filter(this.hash).show();

        $this.parents('.tabs').find('.tabs-nav a').removeClass('active');
        $this.addClass('active');

        return false;
    });

    $('.tabs .tabs-nav li:first-of-type > a').click();

    $('.tabs-target').click(function() {
        $('.tabs .tabs-nav a[href=' + $(this).data('id') + ']').click();
    });


    const pickers = $('.input-delivery').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minDate: new Date(),
        autoUpdateInput: true,
        maxYear: parseInt(moment().format('YYYY'), 10),
        // parentEl: $('.input-wrapper'),
        isInvalidDate: function(ele) {
            return ele.day() == 1 || ele.day() == 3 || ele.day() == 4 || ele.day() == 5 || ele.day() == 6;
        }
    });

    $('div').scroll(function(ev) {
        pickers.each(function(index, picker) {
            $(picker).data('daterangepicker').hide();
        });
    });


    $('.coupon').click(function(evt) {
        evt.preventDefault();
        $(this).closest('.checkout_list_coupon').addClass('open-coupon');
    });

    $('.coupon_input input').keyup(function() {
        var value = $(this).val();
        if (value.length > 1) {
            $(this).closest('.coupon_input').addClass('entered-coupon')
        }
    }).keyup();

    $('.apply-coupon').click(function() {
        $(this).closest('.checkout_list').find('.checkout_list_discount').addClass('applyed-coupon');
        $(this).closest('.checkout_list').find('.checkout_list_coupon').addClass('applyed-coupon');
        $(this).closest('.content_cart_checkout').find('.btn_place-order').removeClass('btn_disabled');
        $(this).closest('.content_cart_checkout').find('.btn_place-order').addClass('btn-green');
        $(this).closest('.content_cart_checkout').find('.btn_place-order').attr('id', 'wizard-next');

    });

    $('.custom-select .boxes-select').click(function(evt) {
        evt.preventDefault();
        $(this).closest('.custom-select').find('.select_pag').toggleClass('active');
    });

    $(document).on('click', '.select_pag li a', function(evt) {
        evt.preventDefault();

        let $this = $(this);

        $this.parents('.select_pag').prev('.boxes-select').text($this.text());
        $this.closest('.custom-select').find('.select_pag').toggleClass('active');
    });

    $('.btn_copy').click(function(evt) {
        evt.preventDefault();
        $(this).addClass('copied');
    });


    $('.btn_order').click(function(evt) {
        evt.preventDefault();
        $(this).closest('.mobile-add-to-card').addClass('order-active');
        $(this).closest('.mobile-add-to-card').find('.btn_checkout').removeClass('btn_disabled').addClass('btn-green');
    });

    $('.btn-close-right-sidebar').click(function(evt) {
        evt.preventDefault();
        $('.mobile-add-to-card').removeClass('order-active');
    });

    $('.open-mob-step-1').click(function(evt) {
        evt.preventDefault();
        $('.mob-step-1').addClass('active');
    });

    $('.open-mob-step-2').click(function(evt) {
        evt.preventDefault();
        $('.mob-step-2').addClass('active');
        $('.mob-step-1').removeClass('active');
    });

    $('#pie').pieChart({
            size: 300,
            lineWidth: 16,
            barColor: '#34BC89',
            trackColor: '#F6F9FC',
        }

    );

    $('.has-sub > a').click(function(e) {
        e.preventDefault(e);
        $(this).closest('.has-sub').toggleClass('opened-sub');
    });

});
