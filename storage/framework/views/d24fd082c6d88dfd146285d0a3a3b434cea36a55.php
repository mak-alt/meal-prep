<div class="mobile_header mobile_header-mobile">
    <a href="" class="mobile_header_menu">
        <img src="<?php echo e(asset('assets/frontend/img/burger-menu-icon.svg')); ?>" alt="Menu icon">
    </a>
    <a href="<?php echo e(route('frontend.landing.index')); ?>" class="header_logo">
        <img src="<?php echo e(asset('assets/frontend/img/logo.svg')); ?>" alt="Logo">
    </a>
    <a href="<?php echo e(route('frontend.shopping-cart.index')); ?>" class="mobile_header_cart_btn">
        <img src="<?php echo e(asset('assets/frontend/img/icon-shopping-cart.svg')); ?>" alt="Shopping cart icon">
    </a>
</div>
<div class="sidebar deactive sidebar-home">
    <div class="switch_sidebar">
        
    </div>
    <div class="sidebar_content perfect_scroll">
        <ul class="sidebar_menu">
            <li class="sidebar_menu_shopping">
                <a href="<?php echo e(route('frontend.shopping-cart.index')); ?>" class="btn btn-green">
                    Shopping card
                    <img src="<?php echo e(asset('assets/frontend/img/shopping-card.svg')); ?>" alt="Shopping cart icon">
                </a>
            </li>
            <li class="active">
                <a href="<?php echo e(route('frontend.landing.index')); ?>">
                    <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-1.svg')); ?>" alt="Sidebar menu icon">
                    <span>Order and menu</span>
                </a>
            </li>
            <?php if($isAuthenticated): ?>
                <li>
                    <a href="<?php echo e(route('frontend.orders.index', \App\Models\Order::STATUSES['completed'])); ?>">
                        <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-2.svg')); ?>" alt="Sidebar menu icon">
                        <span>History of orders</span>
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href="<?php echo e(url('weekly-menu')); ?>">
                    <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-3.svg')); ?>" alt="Sidebar menu icon">
                    <span>Weekly menu</span>
                </a>
            </li>
            <?php if($isAuthenticated): ?>
                <li>
                    <a href="<?php echo e(route('frontend.profile.index')); ?>">
                        <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-4.svg')); ?>" alt="Sidebar menu icon">
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('frontend.rewards.index')); ?>">
                        <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-5.svg')); ?>" alt="Sidebar menu icon">
                        <span>Rewards & Referrals</span>
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href="<?php echo e(url('delivery-and-pickup')); ?>">
                    <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-6.svg')); ?>" alt="Sidebar menu icon">
                    <span>Delivery & Pickup</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('frontend.gifts.index')); ?>" class="<?php echo e(request()->is('loyalty/gifts*') ? 'active' : ''); ?>">
                    <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-5.svg')); ?>" alt="Sidebar menu icon">
                    <span>Gift Certificate</span>
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
                    <a href="<?php echo e(route('login')); ?>"
                       class="">
                        <img src="<?php echo e(asset('assets/frontend/img/login-icon.svg')); ?>" alt="Sidebar menu icon">
                        <span>Login</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<div class="mobile-header-main-menu">
    <div class="sidebar">
        <div class="sidebar_header flex justify-between">
            <div class="logo">
                <a href="<?php echo e(route('frontend.landing.index')); ?>">
                    <img src="<?php echo e(asset('assets/frontend/img/logo.svg')); ?>" alt="Logo">
                </a>
            </div>
            <a href="" class="mobile-header-main-menu__close-link">
                <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close popup icon">
            </a>
        </div>
        <div class="sidebar_content perfect_scroll ps">
            <ul class="sidebar_menu">
                <li class="sidebar_menu_shopping">
                    <a href="<?php echo e(route('frontend.shopping-cart.index')); ?>" class="btn btn-green">
                        Shopping card
                        <img src="<?php echo e(asset('assets/frontend/img/shopping-card.svg')); ?>" alt="Shopping cart icon">
                    </a>
                </li>
                <li class="active">
                    <a href="<?php echo e(empty($categoryId) ? route('frontend.order-and-menu.select-meals', 1) : route('frontend.order-and-menu.index', $categories->where('id', $categoryId)->first()->name)); ?>">
                        <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-1.svg')); ?>"
                             alt="Sidebar menu icon">
                        <span>Order and menu</span>
                    </a>
                </li>
                <?php if($isAuthenticated): ?>
                    <li>
                        <a href="<?php echo e(route('frontend.orders.index', \App\Models\Order::STATUSES['completed'])); ?>">
                            <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-2.svg')); ?>"
                                 alt="Sidebar menu icon">
                            <span>History of orders</span>
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?php echo e(url('weekly-menu')); ?>">
                        <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-3.svg')); ?>"
                             alt="Sidebar menu icon">
                        <span>Weekly menu</span>
                    </a>
                </li>
                <?php if($isAuthenticated): ?>
                    <li>
                        <a href="<?php echo e(route('frontend.profile.index')); ?>">
                            <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-4.svg')); ?>"
                                 alt="Sidebar menu icon">
                            <span>Profile</span>
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?php echo e(route('frontend.rewards.index')); ?>">
                        <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-5.svg')); ?>"
                             alt="Sidebar menu icon">
                        <span>Rewards &amp; Referrals</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(url('delivery-and-pickup')); ?>">
                        <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-6.svg')); ?>"
                             alt="Sidebar menu icon">
                        <span>Delivery &amp; Pickup</span>
                    </a>
                </li>
                <li>
                    <ul class="open-menu">
                        <li class="open-menu__item active">
                            <a href="" class="open-menu__header">
                                <img src="<?php echo e(asset('assets/frontend/img/icon-sidebar-link-7.svg')); ?>"
                                     alt="Sidebar menu icon">
                                <span>About</span>
                                <span>
                                    <img class="open-menu__icon active"
                                         src="<?php echo e(asset('assets/frontend/img/arrow-up-blue.svg')); ?>"
                                         alt="Arrow up icon">
                                </span>
                            </a>
                            <ul class="open-menu__item__dropdown" style="display: block;">
                                <li class="open-menu__item">
                                    <a href="<?php echo e(url('gallery-and-reviews')); ?>" class="dropdown-link">
                                        Gallery & Reviews
                                    </a>
                                    <a href="<?php echo e(url('partners-and-references')); ?>" class="dropdown-link">
                                        Partners & References
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

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
                        <a href="<?php echo e(route('login')); ?>"
                           class="">
                            <img src="<?php echo e(asset('assets/frontend/img/login-icon.svg')); ?>" alt="Sidebar menu icon">
                            <span>Login</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/layouts/partials/landing/header-mobile.blade.php ENDPATH**/ ?>