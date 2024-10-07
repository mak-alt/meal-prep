<div class="popup_wrpr mobile-full" id="start-over-meals-creation">
    <div class="popup_wrpr_inner">
        <div class="popup popup_style2 popup_style3">
            <a href="" class="close_popup_btn" data-action="close-popup">
                <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
            </a>
            <div class="popup-delete-entry__content">
                <div class="popup-delete-entry__img flex justify-center">
                    <img src="<?php echo e(asset('assets/frontend/img/delete-entry-icon.svg')); ?>" alt="Delete icon">
                </div>
                <div class="popup-delete-entry__title mt-16">
                    Delete everything?
                </div>
                <p class="popup-delete-entry__description">
                    Are you sure you want to delete all selected meals? There is no write-back!.
                </p>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <a href="" class="btn btn_transparent" data-action="close-popup">No, cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_red" data-action="submit-confirmation-popup"
                            data-listener="<?php echo e(route('frontend.order-and-menu.meal-creation.start-over')); ?>"
                            data-request-type="POST">
                        Yes, delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/order-and-menu/partials/popups/start-over-meals-creation.blade.php ENDPATH**/ ?>