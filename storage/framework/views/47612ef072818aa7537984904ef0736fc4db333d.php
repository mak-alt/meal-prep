<div class="popup_wrpr reset-all-popup-forms" id="make-gift-payment">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn" data-action="close-popup">
                <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
            </a>
            <div class="popup_header">
                <h3 class="popup_title">Buy a gift card</h3>
            </div>
            <div class="popup_content">
                <form action="<?php echo e(route('frontend.gifts.send')); ?>" method="POST" id="gift-payment-form">
                    <?php echo csrf_field(); ?>

                </form>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item" data-action="close-popup">
                    <a href="" class="btn btn_transparent">Cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn-green" data-action="make-payment"
                            data-disabled-on-open="<?php echo e(true); ?>">
                        Pay
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/gifts/partials/popups/make-payment-with-credit-card.blade.php ENDPATH**/ ?>