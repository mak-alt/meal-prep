<div class="popup_wrpr popup-success popup-success-inner mobile-full reset-all-popup-forms"
     id="send-gift-via-email-popup">
    <div class="popup_wrpr_inner">
        <div class="popup popup_style2">
            <div class="popup_heading">
                <a href="#" class="close_popup_btn" data-action="close-popup">
                    <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
                    <img class="mob-close" src="<?php echo e(asset('assets/frontend/img/down-arrow.svg')); ?>" alt="Close icon">
                </a>
                <h3>Share via Email</h3>
            </div>
            <div class="popup_content">
                <h3>Share via Email</h3>
                <div class="popup-block-wrapper">
                    <form action="<?php echo e(route('frontend.gifts.remember-gift-contacts-info')); ?>"
                          method="POST" id="gift-card-contacts-form">
                        <?php echo csrf_field(); ?>
                        <div class="input-wrapper-inner">
                            <label for="share-via-email-to">To:</label>
                            <div class="input-wrapper">
                                <input type="email" name="sent_to" class="input" id="share-via-email-to"
                                       autocomplete="email" required>
                                <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'sent_to'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <label for="share-via-email-from">From:</label>
                            <div class="input-wrapper">
                                <input type="email" name="sender_name" class="input" id="share-via-email-from"
                                       data-initial-data="<?php echo e($isAuthenticated ? auth()->user()->name : ''); ?>"
                                       autocomplete="email" value="<?php echo e($isAuthenticated ? auth()->user()->name : ''); ?>"
                                       required>
                                <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'sender_name'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <label for="share-via-email-date">Delivery Date:</label>
                            <div class="input-wrapper">
                                <input type="text" name="delivery_date" id="share-via-email-date"
                                       data-initial-data="<?php echo e(now()->format('m/d/Y')); ?>"
                                       value="<?php echo e(now()->format('m/d/Y')); ?>"
                                       class="input input-delivery" placeholder="<?php echo e(now()->format('m/d/Y')); ?>">
                                <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <label for="share-via-email-message">Message:</label>
                            <div class="input-wrapper">
                                <textarea name="message" id="share-via-email-message" class="input" cols="30"
                                          data-initial-data="<?php echo e(\App\Models\Gift::getDefaultGiftMessage(session()->get('gift.amount'))); ?>"
                                          rows="8"><?php echo e(\App\Models\Gift::getDefaultGiftMessage(session()->get('gift.amount'))); ?></textarea>
                                <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'message'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_transparent" data-action="back-to-amount">
                        Back to Amount
                    </button>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_disabled" data-action="submit-gift-card-contacts-form"
                            data-disabled-on-open="<?php echo e(true); ?>">
                        Buy a gift card
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/gifts/partials/popups/send-via-email.blade.php ENDPATH**/ ?>