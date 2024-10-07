<?php ($contentClasses = 'order-menu-mobile'); ?>

<?php $__env->startSection('mobile-header'); ?>
    <div class="btn-back-to-home btn-back-to-home-inner" data-redirect="<?php echo e(route('frontend.landing.index')); ?>">
        <img src="<?php echo e(asset('assets/frontend/img/icon-arrow-left.svg')); ?>" alt="Arrow left icon">
        <span>Back to homepage</span>
    </div>
    <div class="mobile_top_notif success" style="display: none">
        <span class="response-text"></span>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content right-sidebar">
        <?php echo $__env->make('frontend.order-and-menu.partials.content-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="content_box--padding-small content_box--order-menu">
            <div class="content_box_part">
                <h2 class="section-title mobile-display-none">
                    <?php echo e(getInscriptions('selected-menu-title','order-and-menu/','Before adding to the cart, please review this week menu')); ?>

                </h2>
                <ul class="weekly-menu">
                    <?php $__currentLoopData = $meals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($meal->status): ?>
                            <li class="weekly-menu__item"
                                data-action="show-meal-details-popup"
                                data-show-add-btn="0" data-show-sides="1" data-menu-id="<?php echo e($menu->id); ?>"
                                data-meal-id="<?php echo e($meal->id); ?>"
                                data-listener="<?php echo e(route('frontend.order-and-menu.render-meal-details-popup', $meal->id)); ?>">
                                <span class="weekly-menu__item-before">Meal <?php echo e($loop->iteration); ?></span>
                                <a href=""
                                   class="weekly-menu__item-link">
                                    <div class="weekly-menu__img">
                                        <img src="<?php echo e(asset($meal->thumb)); ?>" alt="Meal photo">
                                    </div>
                                    <div class="weekly-menu__content">
                                        <h2 class="weekly-menu__title"><?php echo e($meal->name); ?></h2>
                                        <?php if(isset($meal->selected_sides) && is_array($meal->selected_sides) && !empty($meal->selected_sides)): ?>
                                            <div class="weekly-menu__text">
                                                <?php $__currentLoopData = $meal->selected_sides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mealSide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php ($side = \App\Models\Meal::find($mealSide)); ?>
                                                    <?php if($side->status): ?>
                                                        <p>
                                                            <span>Side:</span> <?php echo e($side->name); ?>

                                                        </p>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="weekly-menu__info">
                                            <div class="weekly-menu__info-item">
                                                <img src="<?php echo e(asset('assets/frontend/img/fat.svg')); ?>" alt="Icon">
                                                <span>
                                                    <?php echo e($meal->calories); ?>

                                                    <span class="weekly-menu__info-item-title">calories</span>
                                                </span>
                                            </div>
                                            <div class="weekly-menu__info-item">
                                                <img src="<?php echo e(asset('assets/frontend/img/calories.svg')); ?>" alt="Icon">
                                                <span>
                                                    <?php echo e($meal->fats); ?>g
                                                    <span class="weekly-menu__info-item-title">fats</span>
                                                </span>
                                            </div>
                                            <div class="weekly-menu__info-item">
                                                <img src="<?php echo e(asset('assets/frontend/img/tree.svg')); ?>" alt="Icon">
                                                <span>
                                                    <?php echo e($meal->carbs); ?>g
                                                    <span class="weekly-menu__info-item-title">carbs</span>
                                                </span>
                                            </div>
                                            <div class="weekly-menu__info-item">
                                                <img src="<?php echo e(asset('assets/frontend/img/fat-2.svg')); ?>" alt="Icon">
                                                <span>
                                                    <?php echo e($meal->proteins); ?>g
                                                    <span class="weekly-menu__info-item-title">proteins</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="bottom-gradient bottom-gradient-inner"></div>
        </div>
        <?php echo $__env->make('frontend.layouts.partials.subscribe-left-aligned', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('frontend.layouts.partials.app.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="success-order-info success_order_info_in_content success">
        <span class="response-text"></span>
        <img src="<?php echo e(asset('assets/frontend/img/close-white.svg')); ?>" class="success-order-info__close"
             alt="Close icon"
             style="cursor: pointer;">
    </div>
    <div class="content_cart content_cart-fixed">
        <div class="content_cart__title">
            <a href="" class="btn-close-right-sidebar">
                <img src="<?php echo e(asset('assets/frontend/img/icon-arrow-left.svg')); ?>" alt="Arrow left icon">
                <span><?php echo e(getInscriptions('selected-menu-order-title','order-and-menu/','Your order')); ?></span>
            </a>
        </div>
        <ul class="order-value">
            <li class="order-value_title">Calories in this menu</li>
            <li id="order-calories">
                <img src="<?php echo e(asset('assets/frontend/img/cart-icon-1.svg')); ?>" alt="Icon">
                <span>
                    <?php echo e($mealsMicronutrientsData['calories'] + $selectedAddonsMicronutrientsData['calories']); ?>

                </span>
                calories
            </li>
            <li id="order-fats">
                <img src="<?php echo e(asset('assets/frontend/img/cart-icon-2.svg')); ?>" alt="Icon">
                <span>
                    <?php echo e($mealsMicronutrientsData['fats'] + $selectedAddonsMicronutrientsData['fats']); ?>

                </span>
                g fats
            </li>
            <li id="order-carbs">
                <img src="<?php echo e(asset('assets/frontend/img/cart-icon-3.svg')); ?>" alt="Icon">
                <span>
                    <?php echo e($mealsMicronutrientsData['carbs'] + $selectedAddonsMicronutrientsData['carbs']); ?>

                </span>
                g carbs
            </li>
            <li id="order-proteins">
                <img src="<?php echo e(asset('assets/frontend/img/cart-icon-4.svg')); ?>" alt="Icon">
                <span>
                    <?php echo e($mealsMicronutrientsData['proteins'] + $selectedAddonsMicronutrientsData['proteins']); ?>

                </span>
                g proteins
            </li>
        </ul>
        <div class="content_cart__block mt-16" id="portion-selection-block"
             style="<?php echo e(count($portionSizes) < 1 ? 'display: none;' : ''); ?>">
            <div class="content_cart__block-title">Increase portion sizes</div>
            <ul class="portions flex">
                <?php $__currentLoopData = $portionSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $portionSize): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li data-size="<?php echo e($portionSize['size']); ?>">
                        <a href=""
                           class="btn <?php echo e($portionSize['size'] === $selectedPortionSize['size'] ? 'btn-green' : 'btn-white'); ?>"
                           data-action="select-portion-size"
                           data-listener="<?php echo e(route('frontend.order-and-menu.meal-creation.select-portion-size-menu', $category->id)); ?>"
                           data-size="<?php echo e($portionSize['size']); ?>"
                           data-percentage="<?php echo e($portionSize['percentage']); ?>">
                            <?php echo e($portionSize['size']); ?>oz
                        </a>
                        <span
                            class="<?php echo e($portionSize['size'] === $selectedPortionSize['size'] ? 'active' : ''); ?>">
                            $<span><?php echo e(calculatePercentageValueFromNumber($portionSize['percentage'], $totalPriceWithoutPortionSize)); ?></span>
                        </span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php if(isset(optional(optional($menu)->category)->addons)): ?>
            <?php if(!optional(optional($menu)->category)->addons->isEmpty()): ?>
                <div class="content_cart__block mt-16">
                    <div class="content_cart__block-title">Add-ons</div>
                    <ul id="addons-list">
                        <?php $__currentLoopData = optional(optional($menu)->category)->addons ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="add-ons__item flex <?php echo e($selectedAddons->contains('id', $addon->id) ? 'active' : ''); ?>"
                                data-redirect="<?php echo e(route('frontend.order-and-menu.addons.show', $addon->id)); ?>">
                                    <span class="add-ons__item-img-wrapper">
                                        <img src="<?php echo e(asset('assets/frontend/img/icon-cherry.svg')); ?>"
                                             alt="Icon">
                                    </span>
                                <div class="add-ons__item-details">
                                    <span class="add-ons__item-details-title">Add <?php echo e($addon->name); ?></span>
                                    <?php if($selectedAddons->contains('id', $addon->id)): ?>
                                        <span>
                                            <span class="add-ons__item-details-item">
                                                +<?php echo e($selectedAddonMeals->where('pivot.addon_id', $addon->id)->sum('pivot.points')); ?> points
                                            </span>
                                            <span class="add-ons__item-details-item">
                                                +$<?php echo e($selectedAddonMeals->where('pivot.addon_id', $addon->id)->sum('pivot.price')); ?>

                                            </span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <div class="content_cart_bottom">
            <div class="cart_sum">
                <h3 class="cart_sum_total">
                    Menu total:
                    <span>$</span>
                    <span class="meals-price">
                        <?php echo e($totalPrice); ?>

                    </span>
                </h3>
                <h4 class="cart_sum_point">
                    +
                    <span class="points">
                        <?php echo e($totalPoints); ?>

                    </span>
                    points for this order
                </h4>
            </div>
            <?php if(isset($menu)): ?>
                <button type="button" class="btn btn_transparent mb-6" id="duplicate-menu"
                        data-listener="<?php echo e(route('frontend.order-and-menu.menu.duplicate', $menu->id)); ?>">
                    <?php echo e(getInscriptions('select-menu-duplicate','order-and-menu/','Duplicate')); ?>

                </button>
            <?php endif; ?>
            <button id="wizard-next" type="button" class="btn <?php echo e($menu ? 'btn-green' : 'btn_disabled'); ?>"
                    data-action="add-to-cart"
                    data-before="1"
                    data-listener="<?php echo e(route('frontend.shopping-cart.store')); ?>">
                Checkout
                <img src="<?php echo e(asset('assets/frontend/img/cart-icon-white.svg')); ?>" alt="Arrow right icon">
            </button>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('popups'); ?>
    <?php echo $__env->make('frontend.order-and-menu.partials.popups.meal-details', ['empty' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.login', ['redirectUrl' => url()->current()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.register', ['redirectUrl' => url()->current()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.forgot-password', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <?php if($menu): ?>
        <div class="mobile-add-to-card">
            <a href="" class="btn-open-right-sidebar">
                <?php echo e(getInscriptions('selected-menu-add-to-cart-mobile','order-and-menu/','Add to cart')); ?>

                
            </a>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(asset('assets/frontend/js/order-and-menu-index.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/frontend/js/landing.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/order-and-menu/index.blade.php ENDPATH**/ ?>