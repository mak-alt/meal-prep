<div class="popup_wrpr popup-success mobile-full" id="redeem-gift-card-popup">
    <div class="popup_wrpr_inner">
        <div class="popup popup_style2">
            <div class="popup_heading">
                <a href="#" class="close_popup_btn" data-action="close-popup">
                    <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
                    <img class="mob-close" src="<?php echo e(asset('assets/frontend/img/down-arrow.svg')); ?>" alt="Close icon">
                </a>
                <h3>Redeem a Gift Card</h3>
            </div>
            <div class="popup_content">
                <h3>Redeem a Gift Card</h3>
                <form action="<?php echo e(route('frontend.gifts.redeem')); ?>" method="POST" id="redeem-gift-card-form">
                    <?php echo csrf_field(); ?>
                    <div class="popup-block-wrapper input-wrapper-inner">
                        <h4>Edit your gift card code</h4>
                        <div class="input-wrapper">
                            <input type="text" name="code" class="input" autocomplete="off" required>
                            <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'code'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item" data-action="close-popup">
                    <a href="#" class="btn btn_transparent">Cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_disabled" data-action="redeem-gift-card">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/gifts/partials/popups/redeem-gift-card.blade.php ENDPATH**/ ?>