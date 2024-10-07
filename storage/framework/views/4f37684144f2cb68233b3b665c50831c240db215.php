<div class="ovh-x">
    <div class="wizard-body">
        <div class="step active">
            <div class="content_main perfect_scroll" id="shopping-cart-empty" style="display: none;">
                <div class="empty-page">
                    <div class="empty-page_logo">
                        <img src="<?php echo e(asset('assets/frontend/img/empty-logo.svg')); ?>"
                             alt="Empty shopping cart icon">
                    </div>
                    <h1 class="empty-page_h1"><?php echo e(getInscriptions('shopping-cart-empty',request()->path(),'Your cart is empty')); ?></h1>
                    <p class="empty-page_p">
                        You'll see selected meals here as soon as you start shopping.
                    </p>
                    <a href="<?php echo e(route('frontend.landing.index')); ?>" class="btn btn-green"><?php echo e(getInscriptions('shopping-cart-go-shop',request()->path(),'Start shopping')); ?></a>
                </div>
            </div>
            <div class="content_main content_main_cart content_main_cart_full perfect_scroll">
                <div class="content_box content_box_cart box-full-width">
                    <div class="order-menu">
                        <ul class="order-menu-without-header">
                            <?php $__currentLoopData = $shoppingCartOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uuid => $shoppingCartOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="order-menu__item"
                                    data-micronutrients-data="<?php echo e(json_encode($shoppingCartOrder['micronutrients_data'])); ?>"
                                    data-total-price="<?php echo e($shoppingCartOrder['total_price']); ?>"
                                    data-total-points="<?php echo e($shoppingCartOrder['total_points']); ?>">
                                    <div class="order-menu__header">
                                        <div class="order-menu__header-block-flex">
                                            <div class="order-menu__title-wrapper">
                                                <h2 class="order-menu__title">
                                                    <?php echo e($shoppingCartOrder['menu'] ? $shoppingCartOrder['menu']->name : 'Custom meal plan'); ?>

                                                    <?php echo e($shoppingCartOrder['menu'] ? '' : ( $shoppingCartOrder['meals_amount'] . 'meals')); ?>

                                                </h2>
                                                <div class="order-menu__title-links">
                                                    <?php if(!$shoppingCartOrder['menu']): ?>
                                                        <a href=""
                                                           data-action="complete-menu"
                                                           data-listener="<?php echo e(route('frontend.shopping-cart.complete-menu', $uuid)); ?>"
                                                           class="<?php echo e(!$shoppingCartOrder['selection_completed'] ? 'active-link' : ''); ?>">
                                                            <?php echo e(!$shoppingCartOrder['selection_completed'] ? 'Complete menu' : 'Edit'); ?>

                                                        </a>
                                                    <?php endif; ?>
                                                    <a href=""
                                                       data-action="show-popup"
                                                       data-popup-id="delete-shopping-cart-order"
                                                       data-listener="<?php echo e(route('frontend.shopping-cart.destroy', $uuid)); ?>">
                                                        Delete
                                                    </a>
                                                    <a href="" data-action="duplicate"
                                                       data-listener="<?php echo e(route('frontend.shopping-cart.duplicate', $uuid)); ?>">
                                                        Duplicate
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="order-menu__price-wrapper">
                                                <span class="price main-price" data-price-id="<?php echo e($loop->index); ?>">$<?php echo e($shoppingCartOrder['total_price']); ?></span>
                                            </div>
                                            
                                        </div>
                                        <div class="order-menu__title-links order-menu__title-links-mobile">
                                            <?php if(!$shoppingCartOrder['menu']): ?>
                                                <a href=""
                                                   data-action="complete-menu"
                                                   data-listener="<?php echo e(route('frontend.shopping-cart.complete-menu', $uuid)); ?>"
                                                   class="<?php echo e(!$shoppingCartOrder['selection_completed'] ? 'active-link' : ''); ?>">
                                                    <?php echo e(!$shoppingCartOrder['selection_completed'] ? 'Complete menu' : 'Edit'); ?>

                                                </a>
                                            <?php endif; ?>
                                            <a href=""
                                               data-action="show-popup"
                                               data-popup-id="delete-shopping-cart-order"
                                               data-listener="<?php echo e(route('frontend.shopping-cart.destroy', $uuid)); ?>">
                                                Delete
                                            </a>
                                            <a href="" data-action="duplicate"
                                               data-listener="<?php echo e(route('frontend.shopping-cart.duplicate', $uuid)); ?>">
                                                Duplicate
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <?php if(!empty($shoppingCartOrder['addons'])): ?>
                                        <?php $__currentLoopData = $shoppingCartOrder['addons']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="order-menu__item">
                                                <div class="order-menu__header">
                                                    <div class="order-menu__header-block-flex">
                                                        <div class="order-menu__title-wrapper">
                                                            <h2 class="order-menu__title">
                                                                <?php echo e($addon[0]->name); ?>

                                                            </h2>
                                                            <div class="order-menu__title-links">
                                                                <a href="<?php echo e(route('frontend.order-and-menu.addons.show', $addon[0]->id)); ?>">
                                                                    Edit
                                                                </a>
                                                                <a href=""
                                                                   data-action="show-popup"
                                                                   data-popup-id="delete-addon"
                                                                   data-listener="<?php echo e(route('frontend.order-and-menu.addons.remove', [$addon[0]->id, $uuid])); ?>">
                                                                    Delete
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="order-menu__price-wrapper">
                                                            <span class="price secondary-price" data-dep-price-id="<?php echo e($loop->parent->index); ?>">$<?php echo e(number_format($addon['price'],2)); ?></span>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="order-menu__title-links order-menu__title-links-mobile">
                                                        <a href="<?php echo e(route('frontend.order-and-menu.addons.show', $addon[0]->id)); ?>">
                                                            Edit
                                                        </a>
                                                        <a href=""
                                                           data-action="show-popup"
                                                           data-popup-id="delete-addon"
                                                           data-listener="<?php echo e(route('frontend.order-and-menu.addons.remove', [$addon[0]->id, $uuid])); ?>">
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                                
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <div class="success-order-info success_order_info_in_content" id="menu-restore-prompt"
                     style="width: calc(100% - 530px);">
                    <span>
                        Your menu was deleted but you can still
                        <a href="<?php echo e(route('frontend.shopping-cart.undo-destroy')); ?>" data-action="undo-menu-deleting">
                            undo it.
                        </a>
                    </span>
                    <span class="success-order-info_mob">
                        Your menu was deleted.
                        <a href="<?php echo e(route('frontend.shopping-cart.undo-destroy')); ?>" data-action="undo-menu-deleting">
                            Undo it.
                        </a>
                    </span>
                    <img src="<?php echo e(asset('assets/frontend/img/close-white.svg')); ?>" class="success-order-info__close"
                         alt="Close icon"
                         style="cursor: pointer;">
                </div>
                <div class="content_cart cart_order content_cart-inner content_cart-fixed">
                    <a href="" class="btn-close-right-sidebar">
                        <img src="<?php echo e(asset('assets/frontend/img/icon-arrow-left.svg')); ?>" alt="Arrow left icon">
                        <span>Order value</span>
                    </a>
                    <ul class="order-value mobile-order-value">
                        <li class="order-value_title">Total order value</li>
                        <li>
                            <img src="<?php echo e(asset('assets/frontend/img/cart-icon-1.svg')); ?>" alt="Icon">
                            <span id="order-calories" class="pr-3px">
                                <?php echo e($shoppingCartOrders->sum('micronutrients_data.calories')); ?>

                            </span>
                            calories
                        </li>
                        <li>
                            <img src="<?php echo e(asset('assets/frontend/img/cart-icon-2.svg')); ?>" alt="Icon">
                            <span id="order-fats">
                                <?php echo e($shoppingCartOrders->sum('micronutrients_data.fats')); ?>

                            </span>
                            g fats
                        </li>
                        <li>
                            <img src="<?php echo e(asset('assets/frontend/img/cart-icon-3.svg')); ?>" alt="Icon">
                            <span id="order-carbs">
                                <?php echo e($shoppingCartOrders->sum('micronutrients_data.carbs')); ?>

                            </span>
                            g carbs
                        </li>
                        <li>
                            <img src="<?php echo e(asset('assets/frontend/img/cart-icon-4.svg')); ?>" alt="Icon">
                            <span id="order-proteins">
                                <?php echo e($shoppingCartOrders->sum('micronutrients_data.proteins')); ?>

                            </span>
                            g proteins
                        </li>
                    </ul>
                    <div class="content_cart_bottom" style="display: block">
                        <div class="cart_sum mobile-total">
                            <h3 class="cart_sum_total">
                                Menu total:
                                <span>$</span><span
                                    class="total-price"><?php echo e($shoppingCartOrders->sum('total_price')); ?></span>
                            </h3>
                            <h4 class="cart_sum_point">
                                + <span class="total-points"><?php echo e($shoppingCartOrders->sum('total_points')); ?></span>
                                points for this order
                            </h4>
                        </div>
                        <div class="wizard-button-group order-value-buttons">
                            <div class="mobile-order-value">
                                <a href="" class="btn btn-green close-order-value">Return to Cart</a>
                            </div>
                            <?php if(auth()->guard()->check()): ?>
                                <?php if($shoppingCartOrders->pluck('selection_completed')->contains(false)): ?>
                                    <button type="button" class="btn btn-green" data-action="show-popup"
                                            data-popup-id="order-complete">
                                        <?php echo e(getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')); ?>

                                        <img src="<?php echo e(asset('assets/frontend/img/cart-icon-white.svg')); ?>"
                                             alt="Shopping cart icon">
                                    </button>
                                <?php else: ?>
                                    <button id="wizard-next" type="button"
                                            class="btn btn_checkout btn-green"
                                            data-action="proceed-to-checkout"
                                            data-listener="<?php echo e(route('frontend.checkout.proceed-to-checkout')); ?>">
                                        <?php echo e(getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')); ?>

                                        <img src="<?php echo e(asset('assets/frontend/img/cart-icon-white.svg')); ?>"
                                             alt="Shopping cart icon">
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if($shoppingCartOrders->pluck('selection_completed')->contains(false)): ?>
                                <button type="button"
                                        class="btn btn_checkout btn-green" data-action="show-popup"
                                        data-popup-id="order-complete">
                                    <?php echo e(getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')); ?>

                                    <img src="<?php echo e(asset('assets/frontend/img/cart-icon-white.svg')); ?>"
                                         alt="Shopping cart icon">
                                </button>
                                <?php else: ?>
                                    <button type="button"
                                            class="btn btn_checkout btn-green"
                                            data-action="show-popup"
                                            data-popup-id="login-popup">
                                        <?php echo e(getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')); ?>

                                        <img src="<?php echo e(asset('assets/frontend/img/cart-icon-white.svg')); ?>"
                                             alt="Shopping cart icon">
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-add-to-card double order-value">
                <a href="" class="btn btn_order btn_transparent btn-open-right-sidebar"><?php echo e(getInscriptions('shopping-cart-order-value',request()->path(),'Order value')); ?></a>
                <?php if(auth()->guard()->check()): ?>

                    <?php if($shoppingCartOrders->pluck('selection_completed')->contains(false)): ?>
                        <a href=""
                           class="btn btn_checkout btn-green" data-action="show-popup"
                           data-popup-id="order-complete"
                           data-listener="<?php echo e(route('frontend.checkout.proceed-to-checkout')); ?>">
                            <span><?php echo e(getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')); ?></span>
                            <span class="btn_price">$<?php echo e($shoppingCartOrders->sum('total_price')); ?></span>
                        </a>
                    <?php else: ?>
                        <a href=""
                           class="btn btn_checkout btn-green"
                           data-action="proceed-to-checkout"
                           data-listener="<?php echo e(route('frontend.checkout.proceed-to-checkout')); ?>">
                            <span><?php echo e(getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')); ?></span>
                            <span class="btn_price">$<?php echo e($shoppingCartOrders->sum('total_price')); ?></span>
                        </a>
                    <?php endif; ?>

                <?php else: ?>

                    <?php if($shoppingCartOrders->pluck('selection_completed')->contains(false)): ?>
                        <a href=""
                           class="btn btn_checkout btn-green"
                           data-action="show-popup"
                           data-popup-id="order-complete">
                            <span><?php echo e(getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')); ?></span>
                            <span class="btn_price">$<?php echo e($shoppingCartOrders->sum('total_price')); ?></span>
                        </a>
                    <?php else: ?>
                        <a href=""
                           class="btn btn_checkout btn-green"
                           data-action="show-popup"
                           data-popup-id="login-popup">
                            <span><?php echo e(getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')); ?></span>
                            <span class="btn_price">$<?php echo e($shoppingCartOrders->sum('total_price')); ?></span>
                        </a>
                    <?php endif; ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/shopping-cart/partials/content-types/not-empty.blade.php ENDPATH**/ ?>