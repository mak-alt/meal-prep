<div class="popup_wrpr popup-success mobile-full login-popup" id="login-popup"
     data-intended-url="<?php echo e($redirectUrl ?? redirect()->intended()->getTargetUrl()); ?>"
     data-executable-success-function="<?php echo e($executableSuccessFunction ?? ''); ?>">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn" data-action="close-popup">
                <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
            </a>
            <div class="popup_content">
                <div class="title">
                    Please, log in to proceed
                </div>
                <p class="text-sign">
                    Don't have an account?
                    <a href="" class="login-link" data-action="show-popup" data-popup-id="register-popup">
                        <?php echo e(getInscriptions('login-popup-create-account','login-popup','Create an Account')); ?>

                    </a>
                </p>
                <div class="popup-block-wrapper">
                    <form action="<?php echo e(route('login')); ?>" method="POST" id="login-form">
                        <?php echo csrf_field(); ?>
                        <div class="input-wrapper-inner">
                            <fieldset class="fieldset">
                                <label class="fieldset_label" for="login-name">Username or Email:</label>
                                <div class="input-wrapper">
                                    <input type="name" class="input" id="login-name" name="name" autocomplete="name"
                                           required>
                                    <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'name'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </fieldset>
                            <fieldset class="fieldset">
                                <label class="fieldset_label" for="login-password">Password:</label>
                                <div class="input-wrapper">
                                    <input type="password" class="input" id="login-password" name="password" required>
                                    <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'password'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </fieldset>
                        </div>
                        <div class="flex justify-between mt-16">
                            <div class="module__check">
                                <input type="checkbox" name="remember" id="login-remember-me">
                                <span class="check"></span>
                                <label class="text" for="login-remember-me">Remember me</label>
                            </div>
                            <a href="" class="login-link" data-action="show-popup" data-popup-id="forgot-password-popup">Lost password?</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_transparent" data-action="close-popup">Cancel</button>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn-green" data-action="login">Log in</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/landing/partials/popups/login.blade.php ENDPATH**/ ?>