<div class="content_header wizard-header wizard-header-chekout">
    <div class="steps text-center">
        <div class="wizard-step <?php echo e(request()->is('shopping-cart') ? 'active' : ''); ?>"
             data-redirect="<?php echo e(route('frontend.shopping-cart.index')); ?>">
            <span class="desk_title active"><?php echo e(getInscriptions('shopping-cart-tab',request()->path(),'1. Shopping Cart')); ?></span>
            <span class="mob_title active"><?php echo e(getInscriptions('shopping-cart-tab-mobile',request()->path(),'1. Cart')); ?></span>
            <?php (include 'assets/frontend/img/arrow-wizard.svg'); ?>
        </div>
        <div
            class="wizard-step <?php echo e(request()->is('checkout') ? 'active' : ''); ?>"
            <?php echo e(!session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['proceeded_to_checkout']) ? '' : 'data-redirect=' . route('frontend.checkout.index')); ?>

            id="checkout-step">
            <span
                class="<?php echo e(!session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['proceeded_to_checkout']) ? '' : 'active'); ?>">
                <?php echo e(getInscriptions('checkout-tab',request()->path(),'2. Checkout')); ?>

            </span>
            <?php (include 'assets/frontend/img/arrow-wizard.svg'); ?>
        </div>
        <div class="wizard-step <?php echo e(request()->is('orders/*') ? 'active' : ''); ?>">
            <span class="desk_title"><?php echo e(getInscriptions('order-status-tab',request()->path(),'3. Order Status')); ?></span>
            <span class="mob_title"><?php echo e(getInscriptions('order-status-tab-mobile',request()->path(),'3. Status')); ?></span>
        </div>
    </div>
</div>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/layouts/partials/app/checkout-steps/content-header.blade.php ENDPATH**/ ?>