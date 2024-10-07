<div class="popup_wrpr popup-error mobile-full" id="delete-shopping-cart-order">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn" data-action="close-popup">
                <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
            </a>
            <div class="popup_content">
                <img src="<?php echo e(asset('assets/frontend/img/error-pass.png')); ?>" alt="Delete icon">
                <h3>Are you sure you want to delete the whole menu?</h3>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <a href="" class="btn btn_transparent" data-action="close-popup">No, cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_red" data-action="delete-order">
                        Yes, delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/shopping-cart/partials/popups/delete-order.blade.php ENDPATH**/ ?>