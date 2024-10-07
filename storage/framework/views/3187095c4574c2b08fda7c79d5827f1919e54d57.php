<div class="popup_wrpr mobile-full" id="purchase-gift-card-popup">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <div class="popup_heading">
                <a href="" class="close_popup_btn" data-action="close-popup">
                    <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
                    <img class="mob-close" src="<?php echo e(asset('assets/frontend/img/down-arrow.svg')); ?>"
                         alt="Arrow down icon">
                </a>
            </div>
            <div class="popup_header">
                <h3 class="popup_title">Specify the details about your gift card</h3>
            </div>
            <div class="popup_content popup_content_no-padding">
                <div class="home__wizzard__container home__meals-container">
                    <form action="<?php echo e(route('frontend.gifts.remember-gift-options')); ?>" method="POST"
                          id="gift-card-options-form">
                        <?php echo csrf_field(); ?>
                        <div class="meals-calculate meals-calculate-inner">
                            <div class="meals-calculate__title">
                                Enter the gift amount
                            </div>
                            <div class="input-wrapper">
                                <input type="number" name="amount" class="input-check" min="1"
                                       data-min-allowed-value="1" required>
                                <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'amount'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <div class="meals-calculate__picker">
                                <div class="meals-calculate__picker-row flex">
                                    <button type="button" class="meals-calculate__picker-button" data-value="25">
                                        $25
                                    </button>
                                    <button type="button" class="meals-calculate__picker-button" data-value="50">
                                        $50
                                    </button>
                                    <button type="button" class="meals-calculate__picker-button" data-value="100">
                                        $100
                                    </button>
                                    <button type="button" class="meals-calculate__picker-button" data-value="150">
                                        $150
                                    </button>
                                </div>
                            </div>
                            <div class="meals-calculate__title">
                                Select the delivery type
                            </div>
                            <div class="select-type">
                                <a href="" class="enter-massage-popup"
                                   data-delivery-channel="<?php echo e(\App\Models\Gift::DELIVERY_CHANNELS['email']); ?>">
                                    <img src="<?php echo e(asset('assets/frontend/img/popup_mail.svg')); ?>" alt="Email icon">
                                    Email
                                </a>
                                <a href="" class="enter-massage-sms-popup"
                                   data-delivery-channel="<?php echo e(\App\Models\Gift::DELIVERY_CHANNELS['sms']); ?>">
                                    <img src="<?php echo e(asset('assets/frontend/img/popup_sms.svg')); ?>" alt="SMS icon">
                                    SMS
                                </a>
                                <input type="hidden" name="delivery_channel">
                            </div>
                            <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_channel'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </form>
                </div>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <a href="" class="btn btn_transparent" data-action="close-popup">Cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_disabled" data-action="submit-gift-card-options-form"
                            data-disabled-on-open="<?php echo e(true); ?>">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/gifts/partials/popups/purchase-gift-card.blade.php ENDPATH**/ ?>