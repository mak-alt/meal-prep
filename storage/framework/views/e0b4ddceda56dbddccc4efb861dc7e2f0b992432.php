<?php ($contentClasses = 'wizard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content" style="display: flex; flex-direction: column;">
        <div class="content_header wizard-header wizard-header-inner history">
            <div class="steps text-center">
                <div class="wizard-step <?php echo e(request()->is('loyalty/gifts*') ? 'active' : ''); ?>">
                    <span>
                        <a href="<?php echo e(route('frontend.gifts.index')); ?>">Gift Certificate</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="content_main perfect_scroll">
            <div class="empty-page gift">
                <div class="empty-page_logo">
                    <img src="<?php echo e(asset('assets/frontend/img/atlantaMeal.png')); ?>" alt="Gift card icon">
                </div>
                <h1 class="empty-page_h1"></h1>
                <div class="empty-page-btn-wrapp">
                    <a href="" class="btn btn-green" data-action="show-popup" data-popup-id="purchase-gift-card-popup">
                        Purchase a Gift Card
                    </a>
                    <?php if($isAuthenticated): ?>
                        <a href="" class="btn btn_transparent" data-action="show-popup"
                           data-popup-id="redeem-gift-card-popup">
                            Redeem a Gift Card
                        </a>
                    <?php else: ?>
                        <a href="" class="btn btn_transparent" data-action="show-popup"
                           data-popup-id="login-popup">
                            Redeem a Gift Card
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

		<?php echo $__env->make('frontend.layouts.partials.subscribe-left-aligned', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('frontend.layouts.partials.app.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('popups'); ?>
    <?php echo $__env->make('frontend.gifts.partials.popups.make-payment-with-credit-card', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.gifts.partials.popups.payment-failed', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.gifts.partials.popups.purchase-gift-card', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.gifts.partials.popups.send-via-email', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.gifts.partials.popups.send-via-sms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.gifts.partials.popups.redeem-gift-card', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.login', ['redirectUrl' => route('frontend.gifts.index')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.register', ['redirectUrl' => route('frontend.gifts.index')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.forgot-password', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(asset('assets/frontend/js/gifts.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/gifts/index.blade.php ENDPATH**/ ?>