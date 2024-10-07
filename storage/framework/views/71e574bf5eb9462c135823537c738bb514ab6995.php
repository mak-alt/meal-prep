<div class="sidebar deactive">
    <input type="hidden" name="user_role" value="<?php echo e(auth()->user()->role ?? null); ?>">
    <div class="switch_sidebar">
        
    </div>
    <div class="sidebar_header">
        <div class="logo">
            <a href="<?php echo e(route('frontend.landing.index')); ?>">
                <img src="<?php echo e(asset('assets/frontend/img/logo.svg')); ?>" alt="Logo">
            </a>
        </div>
    </div>
    <div class="sidebar_content perfect_scroll">
        <ul class="sidebar_menu">
            <li class="sidebar_menu_shopping">
                <a href="<?php echo e(route('frontend.shopping-cart.index')); ?>" class="btn btn-green">
                    <?php echo e(getInscriptions('side-bar-shopping-cart', 'sidebar', 'Shopping cart')); ?>

                    <img src="<?php echo e(asset('assets/frontend/img/shopping-card.svg')); ?>" alt="Shopping cart icon">
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('frontend.landing.index')); ?>"
                   class="<?php echo e(request()->is('/') ? 'active' : ''); ?>">
                    <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-1.svg')); ?>" alt="Sidebar menu icon">
                    <span>Order and menu</span>
                </a>
            </li>
            <?php if(auth()->guard()->check()): ?>
                <li>
                    <a href="<?php echo e(route('frontend.orders.index', \App\Models\Order::STATUSES['completed'])); ?>"
                       class="<?php echo e(request()->is('orders*') ? 'active' : ''); ?>">
                        <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-2.svg')); ?>" alt="Sidebar menu icon">
                        <span>History of orders</span>
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href="<?php echo e(url('weekly-menu')); ?>" class="<?php echo e(request()->is('weekly-menu') ? 'active' : ''); ?>">
                    <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-3.svg')); ?>" alt="Sidebar menu icon">
                    <span>Weekly menu</span>
                </a>
            </li>
            <?php if($isAuthenticated): ?>
                <li>
                    <a href="<?php echo e(route('frontend.profile.index')); ?>"
                       class="<?php echo e(request()->is('profile') ? 'active' : ''); ?>">
                        <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-4.svg')); ?>" alt="Sidebar menu icon">
                        <span>Profile</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(auth()->check()): ?>
                <li>
                    <a href="<?php echo e(route('frontend.rewards.index')); ?>" class="<?php echo e((request()->is('loyalty/rewards') || request()->is('loyalty/referrals'))  ? 'active' : ''); ?>">
                        <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-5.svg')); ?>" alt="Sidebar menu icon">
                        <span>Rewards & Referrals</span>
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href="<?php echo e(route('frontend.gifts.index')); ?>" class="<?php echo e(request()->is('loyalty/gifts*') ? 'active' : ''); ?>">
                    <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-5.svg')); ?>" alt="Sidebar menu icon">
                    <span>Gift Certificate</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('delivery-and-pickup')); ?>"
                   class="<?php echo e(request()->is('delivery-and-pickup') ? 'active' : ''); ?>">
                    <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-6.svg')); ?>" alt="Sidebar menu icon">
                    <span>Delivery & Pickup</span>
                </a>
            </li>
            <li class="has-sub <?php echo e(request()->is('gallery-and-reviews', 'partners-and-references') ? 'opened-sub' : ''); ?>">
                <a href="">
                    <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-7.svg')); ?>" alt="icon sidebar">
                    <span>About</span>
                    <span class="has-sub_arrow">
                        <img src="<?php echo e(asset('assets/frontend/img/arrow-menu.svg')); ?>" alt="Arrow icon">
                    </span>
                </a>
                <ul class="sidebar_menu_sub">
                    <li>
                        <a href="<?php echo e(url('gallery-and-reviews')); ?>"
                           class="<?php echo e(request()->is('gallery-and-reviews') ? 'active' : ''); ?>">
                            Gallery & Reviews
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('partners-and-references')); ?>"
                           class="<?php echo e(request()->is('partners-and-references') ? 'active' : ''); ?>">
                            Partners & References
                        </a>
                    </li>
                </ul>
            </li>


        </ul>
        <div class="sidebar_content_bottom">
            <?php if($isAuthenticated): ?>

                    <li>
                        <form action="<?php echo e(route('logout')); ?>" method="POST" id="logout-form" style="display: none">
                            <?php echo csrf_field(); ?>
                        </form>
                        <a href="<?php echo e(route('logout')); ?>" data-action="logout">
                            <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-8.svg')); ?>"
                                 alt="Sidebar menu icon">
                            <span>Log out</span>
                        </a>
                    </li>

            <?php else: ?>
                <li>
                    

                    <a href=""
                            class=""
                            data-action="show-popup"
                            data-popup-id="login-popup">
                        Log in
                    </a>
                </li>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/layouts/partials/app/left-sidebar.blade.php ENDPATH**/ ?>