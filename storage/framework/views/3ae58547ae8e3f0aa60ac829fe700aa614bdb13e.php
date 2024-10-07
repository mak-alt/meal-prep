<div class="popup_wrpr popup-success popup-success-inner mobile-full" id="send-gift-via-sms-popup">
    <div class="popup_wrpr_inner">
        <div class="popup popup_style2">
            <div class="popup_heading">
                <a href="#" class="close_popup_btn" data-action="close-popup">
                    <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
                    <img class="mob-close" src="<?php echo e(asset('assets/frontend/img/down-arrow.svg')); ?>" alt="Close icon">
                </a>
                <h3>Share via SMS</h3>
            </div>
            <div class="popup_content ">
                <h3>Share via SMS</h3>
                <div class="popup-block-wrapper">
                    <form action="<?php echo e(route('frontend.gifts.remember-gift-contacts-info')); ?>"
                          method="POST" id="gift-card-contacts-form-sms">
                        <?php echo csrf_field(); ?>
                        <div class="input-wrapper input-wrapper-inner">
                        <label>To:</label>
                        <div class="input-wrapper">
                            <input class="input phone-number__mask" type="text" name="sent_to" placeholder="(404) 805 4726" id="sms_number">
                            <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'sms_number'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <label for="share-via-email-from">From:</label>
                        <div class="input-wrapper">
                            <input type="text" name="sender_name" class="input" id="share-via-email-from"
                                   data-initial-data="<?php echo e($isAuthenticated ? auth()->user()->name : ''); ?>"
                                   autocomplete="name" value="<?php echo e($isAuthenticated ? auth()->user()->name : ''); ?>"
                                   required>
                            <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'sender_name'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <label>Message:</label>
                            <textarea name="message" id="share-via-sms-message" class="input" cols="30"
                                      data-initial-data="<?php echo e(\App\Models\Gift::getDefaultGiftSMS(session()->get('gift.amount'))); ?>"
                                      rows="8"><?php echo e(\App\Models\Gift::getDefaultGiftSMS(session()->get('gift.amount'))); ?></textarea>
                            <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'message'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    </form>
                </div>
            </div>
            <div class="popup_btn_wrpr btn-mob-full">
                <div class="popup_btn_wrpr_item">
                    <a href="#" class="btn btn_transparent" data-action="back-to-amount">Back to Amount</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <a href="" class="btn btn_disabled" data-action="submit-gift-card-contacts-form-sms"
                       data-disabled-on-open="<?php echo e(true); ?>">SUBMIT</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/gifts/partials/popups/send-via-sms.blade.php ENDPATH**/ ?>