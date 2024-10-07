<div class="popup_wrpr login-popup" id="forgot-password-popup">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn">
                <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
            </a>
            <div class="popup_header">
                <h3 class="popup_title">Password recovery</h3>
            </div>
            <div class="popup-block-wrapper">
                <form action="<?php echo e(route('password.email')); ?>" method="POST" id="password-form">
                    <?php echo csrf_field(); ?>
                    <div class="input-wrapper-inner">
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="email">Email</label>
                            <div class="input-wrapper" style="margin-bottom: 0px">
                                <input type="email" name="email" class="input" id="email" autocomplete="email" required>
                                <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'email'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <a href="" class="btn btn_transparent" data-action="close-popup">Cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn-green" data-action="reset-password">Reset</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/landing/partials/popups/forgot-password.blade.php ENDPATH**/ ?>