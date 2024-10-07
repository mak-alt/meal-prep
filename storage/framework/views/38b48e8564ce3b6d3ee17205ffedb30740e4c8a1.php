<header class="header-home">
    <div class="header-home__container">
        <div class="logo">
            <img src="<?php echo e(asset('assets/frontend/img/home__header-logo.svg')); ?>" alt="Logo">
        </div>
        <div class="header-home__right">
            <ul class="header-home__menu">
                <?php if($isAuthenticated): ?>
                    <li>
                        <a href="<?php echo e(route('frontend.orders.index', \App\Models\Order::STATUSES['completed'])); ?>">
                            History
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?php echo e(url('weekly-menu')); ?>">Weekly menu</a>
                </li>
                <?php if($isAuthenticated): ?>
                    <li>
                        <a href="<?php echo e(route('frontend.profile.index')); ?>">Profile</a>
                    </li>
                <?php endif; ?>

                <li>
                    <a href="<?php echo e(url('delivery-and-pickup')); ?>">Delivery & Pickup</a>
                </li>
                <li>
                    <a href="<?php echo e(route('frontend.gifts.index')); ?>">Gift certificate</a>
                </li>
                <li>
                    <a href="<?php echo e(url('gallery-and-reviews')); ?>">About</a>
                </li>
                <?php if(!$isAuthenticated): ?>
                    <li>
                        <a href="" class="green-link" data-action="show-popup" data-popup-id="login-popup">Log in</a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="header-home__buttons-wrapper">
                <a href="<?php echo e(route('frontend.shopping-cart.index')); ?>" class="btn--sm btn--green">
                    <img src="<?php echo e(asset('assets/frontend/img/icon-shopping-cart.svg')); ?>"
                         alt="Shopping cart icon">
                </a>
                <?php if($isAuthenticated): ?>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" id="logout-form" style="display: none">
                        <?php echo csrf_field(); ?>
                    </form>
                    <a href="<?php echo e(route('logout')); ?>" class="login-icon" data-action="logout">
                        <img src="<?php echo e(asset('assets/frontend/img/icon-login-in.svg')); ?>" alt="Logout icon">
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
<?php echo $__env->make('frontend.layouts.partials.landing.header-mobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/layouts/partials/landing/header.blade.php ENDPATH**/ ?>