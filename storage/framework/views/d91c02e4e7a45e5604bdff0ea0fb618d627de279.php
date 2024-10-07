<?php $__env->startSection('mobile-header'); ?>
    <header
        class="mobile_header <?php echo e(session()->has('response-message') && is_string(session()->get('response-message')) ? 'active' : ''); ?>">
        <a href="" class="mobile_header_menu">
            <img src="<?php echo e(asset('assets/frontend/img/burger-menu-icon.svg')); ?>" alt="Menu icon">
        </a>
        <a href="<?php echo e(route('frontend.landing.index')); ?>" class="header_logo">
            <img src="<?php echo e(asset('assets/frontend/img/logo.svg')); ?>" alt="Logo">
        </a>
        <a class="mobile_header_cart_btn">
        </a>
    </header>
<?php $__env->stopSection(); ?>

<?php ($contentClasses = 'wizard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content content-scroll">
        <?php echo $__env->make('frontend.layouts.partials.app.checkout-steps.content-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->renderWhen($isShoppingCartEmpty, 'frontend.shopping-cart.partials.content-types.empty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
        <?php echo $__env->renderWhen(!$isShoppingCartEmpty, 'frontend.shopping-cart.partials.content-types.not-empty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('popups'); ?>
    <?php if(session()->has('response-message')): ?>
        <?php echo $__env->make('frontend.layouts.partials.app.alerts.session-response-message', ['flash' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <?php echo $__env->make('frontend.shopping-cart.partials.popups.delete-order', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.shopping-cart.partials.popups.delete-addon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.shopping-cart.partials.popups.order-complete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if($isShoppingCartEmpty): ?>
        <?php echo $__env->make('frontend.landing.partials.popups.login', ['redirectUrl' => route('frontend.shopping-cart.index')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('frontend.landing.partials.popups.register', ['redirectUrl' => route('frontend.shopping-cart.index')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('frontend.landing.partials.popups.login', ['redirectUrl' => route('frontend.shopping-cart.index'), 'executableSuccessFunction' => 'proceedToCheckout'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('frontend.landing.partials.popups.register', ['redirectUrl' => route('frontend.shopping-cart.index'), 'executableSuccessFunction' => 'proceedToCheckout'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <?php echo $__env->make('frontend.landing.partials.popups.forgot-password', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(asset('assets/frontend/js/shopping-cart.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/shopping-cart/index.blade.php ENDPATH**/ ?>