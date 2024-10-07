<div class="popup_wrpr login-popup" id="register-popup"
     data-intended-url="<?php echo e($redirectUrl ?? redirect()->intended()->getTargetUrl()); ?>"
     data-executable-success-function="<?php echo e($executableSuccessFunction ?? ''); ?>">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn">
                <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
            </a>
            <div class="popup_header">
                <h3 class="popup_title">Sign up</h3>
                <span>
                    Already have an account?
                    <a href="" class="login-link" data-action="show-popup" data-popup-id="login-popup">Log in here</a>
                </span>
            </div>
            <div class="popup-block-wrapper">
                <form action="<?php echo e(route('register')); ?>" method="POST" id="register-form">
                    <?php echo csrf_field(); ?>
                    <div class="input-wrapper-inner">
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="first-name">First Name</label>
                            <div class="input-wrapper" style="margin-bottom: 0px">
                                <input type="text" name="first_name" class="input" id="first-name" autocomplete="first_name" required>
                                <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'first_name'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </fieldset>
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="last-name">Last Name</label>
                            <div class="input-wrapper" style="margin-bottom: 0px">
                                <input type="text" name="last_name" class="input" id="last-name" autocomplete="last_name" required>
                                <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'last_name'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </fieldset>
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="name">Username</label>
                            <div class="input-wrapper" style="margin-bottom: 0px">
                                <input type="text" name="name" class="input" id="name" autocomplete="name" required>
                                <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'name'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </fieldset>
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="email">Email address</label>
                            <div class="input-wrapper" style="margin-bottom: 0px">
                                <input type="email" name="email" class="input" id="email" autocomplete="email" required>
                                <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'email'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </fieldset>
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="password">Password</label>
                            <div class="input-wrapper" style="margin-bottom: 0px">
                                <input type="password" name="password" class="input" id="password" required>
                                <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'password'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </fieldset>
                        <fieldset class="fieldset">
                            <label class="fieldset_label" for="password-conf">Confirmation</label>
                            <div class="input-wrapper" style="margin-bottom: 0px">
                                <input type="password" name="password_confirmation" class="input" id="password-conf" required>
                                <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <div class="fieldset_additional">
                                <div class="module__check">
                                    <input type="checkbox" name="subscribe_to_updates" id="subscribe-to-updates"
                                           checked>
                                    <span class="check"></span>
                                    <label class="text" for="subscribe-to-updates">
                                        I want to receive updates about products & promotions.
                                    </label>
                                </div>
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
                    <button type="button" class="btn btn-green" data-action="register">Sign up</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/landing/partials/popups/register.blade.php ENDPATH**/ ?>