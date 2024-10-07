<header
    class="mobile_header <?php echo e($classes ?? ''); ?> <?php echo e(session()->has('response-message') && is_string(session()->get('response-message')) ? 'active' : ''); ?>">
    <a href="" class="mobile_header_menu">
        <img src="<?php echo e(asset('assets/frontend/img/burger-menu-icon.svg')); ?>" alt="Menu icon">
    </a>
    <a href="<?php echo e(route('frontend.landing.index')); ?>" class="header_logo">
        <img src="<?php echo e(asset('assets/frontend/img/logo.svg')); ?>" alt="Logo">
    </a>
    <a href="<?php echo e(route('frontend.shopping-cart.index')); ?>" class="mobile_header_cart_btn">
        <img src="<?php echo e(asset('assets/frontend/img/icon-shopping-cart.svg')); ?>" alt="Shopping cart icon">
    </a>
</header>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/layouts/partials/app/header.blade.php ENDPATH**/ ?>