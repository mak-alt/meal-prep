<?php ($contentClasses = 'order-menu-mobile'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content right-sidebar">
        <div class="content_header meals-header">
            <?php echo $__env->make('frontend.order-and-menu.partials.select-meals-content-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="content_main perfect_scroll">
            <div class="content_box_part content_box--padding-small content_box--order-menu">
                <ul class="open-menu <?php echo e($currentSelectedEntryMeal ? 'step1_selected' : ''); ?>">
                    <li class="open-menu__item active">
                        <div
                            class="order-step order-step__1 open-menu__header <?php echo e($hasEntryMealWarning && !$currentSelectedEntryMeal ? 'warning' : ''); ?>">
                            <span class="order-step__title">
                                <img src="<?php echo e(asset('assets/frontend/img/Yes.svg')); ?>"
                                     class="order-step__selected-icon check"
                                     alt="Success icon" style="<?php echo e($currentSelectedEntryMeal ? '' : 'display: none;'); ?>">
                                <img src="<?php echo e(asset('assets/frontend/img/Warning-meals.svg')); ?>"
                                     class="order-step__selected-icon warning"
                                     alt="Warning icon"
                                     style="<?php echo e($hasEntryMealWarning && !$currentSelectedEntryMeal ? '' : 'display: none;'); ?>">
                                <?php echo e(getInscriptions('select-meals-step-1','order-and-menu/select-meals','Step 1. Select entree meal')); ?>

                            </span>
                            <span>
                                <img src="<?php echo e(asset('assets/frontend/img/arrow-up-blue.svg')); ?>"
                                     class="open-menu__item-icon" alt="Arrow up icon">
                            </span>
                        </div>
                        <ul class="open-menu__item__dropdown">
                            <li class="open-menu__item">
                                <div class="order-panel flex justify-between">
                                    <div class="order-panel__left">
                                        <div class="order-panel__title"><?php echo e(getInscriptions('select-meals-entry-name','order-and-menu/select-meals','Entree meal')); ?></div>
                                    </div>
                                    <div class="order-panel__right flex items-center">
                                        <div class="sort-categories">
                                            <a href="" class="sort-link">
                                                <span>Sort by</span>
                                                <span>
                                                    Calories
                                                    <img class="sort-link__icon"
                                                         src="<?php echo e(asset('assets/frontend/img/icon-down-little-black.svg')); ?>"
                                                         alt="Arrow down icon">
                                                </span>
                                            </a>
                                            <ul class="sort-categories__list sort-options__wrapper"
                                                style="display: none;">
                                                <li>
                                                    <a href="<?php echo e(route('frontend.order-and-menu.select-meals', $mealNumber)); ?>"
                                                       data-action="sort" data-sort-column="calories"
                                                       data-sort-direction="ASC"
                                                       data-items-wrapper-id="meals">
                                                        Less calories
                                                        <img
                                                            src="<?php echo e(asset('assets/frontend/img/icon-check-filter.svg')); ?>"
                                                            class="sort-icon__checked"
                                                            alt="Check icon" style="display: none">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo e(route('frontend.order-and-menu.select-meals', $mealNumber)); ?>"
                                                       data-action="sort" data-sort-column="calories"
                                                       data-sort-direction="DESC"
                                                       data-items-wrapper-id="meals">
                                                        More calories
                                                        <img
                                                            src="<?php echo e(asset('assets/frontend/img/icon-check-filter.svg')); ?>"
                                                            class="sort-icon__checked"
                                                            alt="Check icon" style="display: none">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="" class="sort-link" data-action="show-popup"
                                           data-popup-id="filter-by-tags">
                                            Filter diets
                                            <img class="sort-link__icon"
                                                 src="<?php echo e(asset('assets/frontend/img/icon-filter.svg')); ?>"
                                                 alt="Filter icon">
                                        </a>
                                    </div>
                                </div>
                                <div class="entry_scroll" id="meals">
                                    <?php echo $__env->make('frontend.order-and-menu.partials.entry-meals-items', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="open-menu">
                    <li class="open-menu__item active">
                        <div id="side-meals-wrapper"
                             style="<?php echo e(($currentSelectedEntryMeal && $currentSelectedEntryMeal->sides_count > 0) || $hasEntryMealWarning ? '' : 'display: none;'); ?>">
                            <div
                                class="order-step order-step__2 open-menu__header <?php echo e($hasSidesWarning ? 'warning' : ''); ?>">
                                <span class="order-step__title">
                                    <img class="order-step__selected-icon check"
                                         src="<?php echo e(asset('assets/frontend/img/Yes.svg')); ?>"
                                         alt="Success icon"
                                         style="<?php echo e($currentSelectedSides->count() >= 2 ? '' : 'display: none;'); ?>">
                                    <img src="<?php echo e(asset('assets/frontend/img/Warning-meals.svg')); ?>"
                                         class="order-step__selected-icon warning"
                                         alt="Warning icon" style="<?php echo e($hasSidesWarning ? '' : 'display: none;'); ?>">
                                    <?php echo e(getInscriptions('select-meals-step-2','order-and-menu/select-meals','Step 2. Select side dishes')); ?>

                                </span>
                                <span>
                                    <img src="<?php echo e(asset('assets/frontend/img/arrow-up-blue.svg')); ?>"
                                         class="open-menu__item-icon" alt="Arrow up icon">
                                </span>
                            </div>
                            <div class="flex justify-between mb-15">
                                <div></div>
                                <div>
                                    <a href="" class="sort-link" data-action="show-popup"
                                        data-popup-id="filter-sides-by-tags">
                                        Filter diets
                                        <img class="sort-link__icon"
                                             src="<?php echo e(asset('assets/frontend/img/icon-filter.svg')); ?>"
                                             alt="Filter icon">
                                    </a>
                                </div>
                            </div>
                            <ul class="open-menu__item__dropdown">
                                <li class="open-menu__item">
                                    <div id="sides" class="entry_scroll entry_scroll-sides">
                                        <?php echo $__env->make('frontend.order-and-menu.partials.side-meals-items', ['sides' => ($hasEntryMealWarning || $hasSidesWarning) && $currentSelectedSides->isNotEmpty() ? $currentSelectedSides->merge(optional($currentSelectedEntryMeal)->sidesActive ?? collect())->unique('id') : optional($currentSelectedEntryMeal)->sidesActive ?? [], 'entry' => $currentSelectedEntryMeal ?? []], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="bottom-gradient bottom-gradient-inner"></div>
        </div>

        <div class="mobile-add-to-card" id="mobileConfirm" style="<?php echo e(($currentSelectedSides->count() >= ($currentSelectedEntryMeal->side_count ?? 2) || (isset($currentSelectedEntryMeal) && $currentSelectedEntryMeal->sides->count() === 0)) ? '' : 'display: none;'); ?>">
            <a href="" class="btn btn-green btn-start btn-open-right-sidebar">
                <?php echo e(getInscriptions('select-meals-mobile-confirm','order-and-menu/select-meals','Confirm')); ?>

            </a>
        </div>

		<?php echo $__env->make('frontend.layouts.partials.subscribe-left-aligned', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('frontend.layouts.partials.app.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php echo $__env->make('frontend.layouts.partials.app.alerts.session-response-message', ['flash' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if(!$allMealsSelected): ?>
        <div class="content_cart content_cart-fixed content_cart-breakfast content_cart-mobile-next-step">
            <div class="content_cart_top">
                <a href="" class="btn-close-right-sidebar">
                    <img src="<?php echo e(asset('assets/frontend/img/icon-arrow-left.svg')); ?>" alt="Arrow left icon">
                    <span>Review your meal</span>
                </a>
                <div class="content_cart__title">
                    Your meal plan
                </div>
                <div class="order-selection">
                    <div class="order-selection__title">
                        Selection
                    </div>
                    <ul id="entry-selection">
                        <li class="order-selection__list-title">Entry:</li>
                        <?php if($currentSelectedEntryMeal !== null): ?>
                        <li class="order-selection__item" data-meal-number="<?php echo e($mealNumber); ?>">
                            <?php echo e($currentSelectedEntryMeal->name); ?>

                        </li>
                        <?php endif; ?>
                    </ul>
                    <ul class="mt-16" id="sides-selection">
                        <li class="order-selection__list-title">Sides:</li>
                        <?php $__currentLoopData = $currentSelectedSides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currentSelectedSide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="order-selection__item" data-side-id="<?php echo e($currentSelectedSide->id); ?>"
                                data-meal-number="<?php echo e($mealNumber); ?>">
                                <?php echo e($currentSelectedSide->name); ?>

                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <ul class="order-value">
                    <li class="order-value_title">Calories in this meal</li>
                    <li class="order-calories">
                        <img src="<?php echo e(asset('assets/frontend/img/cart-icon-1.svg')); ?>" alt="Icon">
                        <span class="pr-3px">
                            
                            <?php echo e($mealsAndSidesMicronutrientsData['calories']); ?>

                        </span>calories
                    </li>
                    <li class="order-fats">
                        <img src="<?php echo e(asset('assets/frontend/img/cart-icon-2.svg')); ?>" alt="Icon">
                        <span>
                            
                            <?php echo e($mealsAndSidesMicronutrientsData['fats']); ?>

                        </span>g fats
                    </li>
                    <li class="order-carbs">
                        <img src="<?php echo e(asset('assets/frontend/img/cart-icon-3.svg')); ?>" alt="Icon">
                        <span>
                            
                            <?php echo e($mealsAndSidesMicronutrientsData['carbs']); ?>

                        </span>g carbs
                    </li>
                    <li class="order-proteins">
                        <img src="<?php echo e(asset('assets/frontend/img/cart-icon-4.svg')); ?>" alt="Icon">
                        <span>
                            
                            <?php echo e($mealsAndSidesMicronutrientsData['proteins']); ?>

                        </span>g proteins
                    </li>
                </ul>
                <div class="your-meal-hide" style="display: none">
                    <div class="content_cart__block mt-16" id="portion-selection-block"
                         data-listener="<?php echo e(route('frontend.order-and-menu.meal-creation.refresh-portion-sizes-values')); ?>"
                         style="<?php echo e(count($portionSizes) < 1 ? 'display: none;' : ''); ?>">
                        <div class="content_cart__block-title">Increase portion sizes</div>
                        <ul class="portions flex">
                            <?php $__currentLoopData = $portionSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $portionSize): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li data-size="<?php echo e($portionSize['size']); ?>">
                                    <a href=""
                                       class="btn <?php echo e($portionSize['size'] === $selectedPortionSize['size'] ? 'btn-green' : 'btn-white'); ?>"
                                       data-action="select-portion-size"
                                       data-listener="<?php echo e(route('frontend.order-and-menu.meal-creation.select-portion-size')); ?>"
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
                    <div class="content_cart__block mt-16">
                        <div class="content_cart__block-title">Add-ons</div>
                        <ul id="addons-list">
                            <?php $__currentLoopData = $addons ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                        <?php else: ?>
                                            <span>
                                                <span class="add-ons__item-details-item">
                                                    +100 points
                                                </span>
                                                <span class="add-ons__item-details-item">
                                                    +$10
                                                </span>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn btn_transparent mt-16" id="discard-all" data-action="show-popup"
                        data-popup-id="discard-meal-creation" data-popup-with-confirmation="<?php echo e(true); ?>"
                        data-popup-data="<?php echo e(json_encode(['name' => optional($currentSelectedEntryMeal)->name ?? 'entry'])); ?>"
                        style="<?php echo e(empty($currentSelectedEntryMeal) && (!$hasEntryMealWarning && !$hasSidesWarning) ? 'display: none;' : ''); ?>">
                    <?php echo e(getInscriptions('select-meals-delete','order-and-menu/select-meals','Delete meal')); ?>

                </button>
                <?php if($selectedMeals->isNotEmpty() && $selectedSides->isNotEmpty()): ?>
                    <button type="button" class="btn btn_transparent mt-16 mb-6" id="start-over"
                            data-action="show-popup"
                            data-popup-id="start-over-meals-creation" data-popup-with-confirmation="<?php echo e(true); ?>">
                        <?php echo e(getInscriptions('select-meals-refresh','order-and-menu/select-meals','Start over')); ?>

                    </button>
                <?php endif; ?>
                <div class="cart_sum mt-16">
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
            </div>
            <div class="content_cart_bottom">
                <div class="wizard-button-group">
                    <?php if($mealNumber === (int)$mealsAmount): ?>
                        <a href="<?php echo e(route('frontend.order-and-menu.review-order-selection')); ?>"
                           class="btn btn_transparent mb-6" id="review-order" style="display: none">
                            <?php echo e(getInscriptions('select-meals-review','order-and-menu/select-meals','Review order')); ?>

                        </a>
                    <?php else: ?>
                        <button type="button" class="btn btn_transparent mb-6" id="duplicate"
                                data-listener="<?php echo e(route('frontend.order-and-menu.meal-creation.render-duplicate-meals-popup', $mealNumber)); ?>"
                                style="<?php echo e($currentSelectedEntryMeal && (!$currentSelectedEntryMeal->sides()->exists() || $currentSelectedSides->count() >= 2) ? '' : 'display: none;'); ?>">
                            <?php echo e(getInscriptions('select-meals-duplicate','order-and-menu/select-meals','Duplicate')); ?>

                        </button>
                    <?php endif; ?>
                    <?php if($mealNumber === (int)$mealsAmount): ?>
                        <button type="button" id="wizard-next"
                                class="btn <?php echo e((session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealNumber") === true) || (!empty($currentSelectedEntryMeal) && (!$currentSelectedEntryMeal->sides()->exists() || $currentSelectedSides->count() >= ($currentSelectedEntryMeal->side_count ?? 2))) ? 'btn-green' : 'btn_disabled'); ?>"
                                data-action="add-to-cart"
                                data-before="1"
                                data-listener="<?php echo e(route('frontend.shopping-cart.store')); ?>">
                            
                            Checkout
                            <img src="<?php echo e(asset('assets/frontend/img/cart-icon-white.svg')); ?>" alt="Shopping cart icon">
                        </button>
                    <?php else: ?>
                        <button id="wizard-next" type="button"
                                class="btn <?php echo e(!empty($currentSelectedEntryMeal) && (!$currentSelectedEntryMeal->sides()->exists() || $currentSelectedSides->count() >= 2) ? 'btn-green' : 'btn_disabled'); ?>"
                                data-action="validate-meal-creation-step"
                                data-listener="<?php echo e(route('frontend.order-and-menu.meal-creation.validate-step', $mealNumber)); ?>"
                                data-meal-number="<?php echo e($mealNumber); ?>"
                                data-wanted-meal-number="<?php echo e($mealNumber + 1); ?>">
                            <?php echo e(getInscriptions('select-meals-next','order-and-menu/select-meals','Next meal')); ?>

                            <img src="<?php echo e(asset('assets/frontend/img/icon-arrow-long-right.svg')); ?>" alt="Arrow right icon">
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="content_cart content_cart-fixed content_cart-breakfast content_cart-mobile-next-step">
            <div class="content_cart_top">
                <a href="" class="btn-close-right-sidebar">
                    <img src="<?php echo e(asset('assets/frontend/img/icon-arrow-left.svg')); ?>" alt="Arrow left icon">
                    <span>Before you go</span>
                </a>
                <div class="content_cart__title">
                    Before you go
                </div>
                <div class="order-selection" style="display: none">
                    <div class="order-selection__title">
                        Selection
                    </div>
                    <ul id="entry-selection">
                        <li class="order-selection__list-title">Entry:</li>
                        <?php if($currentSelectedEntryMeal !== null): ?>
                            <li class="order-selection__item" data-meal-number="<?php echo e($mealNumber); ?>">
                                <?php echo e($currentSelectedEntryMeal->name); ?>

                            </li>
                        <?php endif; ?>
                    </ul>
                    <ul class="mt-16" id="sides-selection">
                        <li class="order-selection__list-title">Sides:</li>
                        <?php $__currentLoopData = $currentSelectedSides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currentSelectedSide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="order-selection__item" data-side-id="<?php echo e($currentSelectedSide->id); ?>"
                                data-meal-number="<?php echo e($mealNumber); ?>">
                                <?php echo e($currentSelectedSide->name); ?>

                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <ul class="order-value" style="display: none">
                    <li class="order-value_title">Calories in this meal</li>
                    <li class="order-calories">
                        <img src="<?php echo e(asset('assets/frontend/img/cart-icon-1.svg')); ?>" alt="Icon">
                        <span class="pr-3px">
                            
                            <?php echo e($mealsAndSidesMicronutrientsData['calories']); ?>

                        </span>calories
                    </li>
                    <li class="order-fats">
                        <img src="<?php echo e(asset('assets/frontend/img/cart-icon-2.svg')); ?>" alt="Icon">
                        <span>
                            
                            <?php echo e($mealsAndSidesMicronutrientsData['fats']); ?>

                        </span>g fats
                    </li>
                    <li class="order-carbs">
                        <img src="<?php echo e(asset('assets/frontend/img/cart-icon-3.svg')); ?>" alt="Icon">
                        <span>
                            
                            <?php echo e($mealsAndSidesMicronutrientsData['carbs']); ?>

                        </span>g carbs
                    </li>
                    <li class="order-proteins">
                        <img src="<?php echo e(asset('assets/frontend/img/cart-icon-4.svg')); ?>" alt="Icon">
                        <span>
                            
                            <?php echo e($mealsAndSidesMicronutrientsData['proteins']); ?>

                        </span>g proteins
                    </li>
                </ul>
                <div class="your-meal-hide" style="display: block">
                    <div class="content_cart__block mt-16" id="portion-selection-block"
                         data-listener="<?php echo e(route('frontend.order-and-menu.meal-creation.refresh-portion-sizes-values')); ?>"
                         style="<?php echo e(count($portionSizes) < 1 ? 'display: none;' : ''); ?>">
                        <div class="content_cart__block-title">Increase portion sizes</div>
                        <ul class="portions flex">
                            <?php $__currentLoopData = $portionSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $portionSize): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li data-size="<?php echo e($portionSize['size']); ?>">
                                    <a href=""
                                       class="btn <?php echo e($portionSize['size'] === $selectedPortionSize['size'] ? 'btn-green' : 'btn-white'); ?>"
                                       data-action="select-portion-size"
                                       data-listener="<?php echo e(route('frontend.order-and-menu.meal-creation.select-portion-size')); ?>"
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
                    <div class="content_cart__block mt-16">
                        <div class="content_cart__block-title">Add-ons</div>
                        <ul id="addons-list">
                            <?php $__currentLoopData = $addons ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                        <?php else: ?>
                                            <span>
                                                <span class="add-ons__item-details-item">
                                                    +100 points
                                                </span>
                                                <span class="add-ons__item-details-item">
                                                    +$10
                                                </span>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn btn_transparent mt-16" id="discard-all" data-action="show-popup"
                        data-popup-id="discard-meal-creation" data-popup-with-confirmation="<?php echo e(true); ?>"
                        data-popup-data="<?php echo e(json_encode(['name' => optional($currentSelectedEntryMeal)->name ?? 'entry'])); ?>"
                        style="<?php echo e(empty($currentSelectedEntryMeal) && (!$hasEntryMealWarning && !$hasSidesWarning) ? 'display: none;' : ''); ?>">
                    <?php echo e(getInscriptions('select-meals-delete','order-and-menu/select-meals','Delete meal')); ?>

                </button>
                
                <div class="cart_sum mt-16">
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
            </div>
            <div class="content_cart_bottom">
                <div class="wizard-button-group">
                    <a href="<?php echo e(route('frontend.order-and-menu.review-order-selection')); ?>"
                       class="btn btn_transparent mb-6" id="review-order" style="display: block">
                        <?php echo e(getInscriptions('select-meals-review','order-and-menu/select-meals','Review order')); ?>

                    </a>
                    <button type="button" id="wizard-next"
                            class="btn <?php echo e((session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['meal_creation_step_validated'] . ".$mealNumber") === true) || (!empty($currentSelectedEntryMeal) && (!$currentSelectedEntryMeal->sides()->exists() || $currentSelectedSides->count() >= 2)) ? 'btn-green' : 'btn_disabled'); ?>"
                            data-action="add-to-cart"
                            data-before="1"
                            data-listener="<?php echo e(route('frontend.shopping-cart.store')); ?>">
                        Checkout
                        <img src="<?php echo e(asset('assets/frontend/img/cart-icon-white.svg')); ?>" alt="Shopping cart icon">
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mobile-popups'); ?>
    <?php echo $__env->make('frontend.layouts.partials.app.alerts.session-response-message', ['mobileView' => true, 'fromFrontendResponse' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('popups'); ?>
    <?php echo $__env->make('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.order-and-menu.partials.popups.meal-details', ['empty' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.order-and-menu.partials.popups.filter-by-tags', ['tags' => $tags], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.order-and-menu.partials.popups.filter-sides-by-tags', ['tags' => $tags], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.order-and-menu.partials.popups.discard-meal-creation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.order-and-menu.partials.popups.start-over-meals-creation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.order-and-menu.partials.popups.add-meals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.order-and-menu.partials.popups.duplicate-meal-step-selection', ['empty' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.login', ['redirectUrl' => url()->current()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.register', ['redirectUrl' => url()->current()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.forgot-password', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(asset('assets/frontend/js/order-and-menu-select-meals.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/order-and-menu/select-meals.blade.php ENDPATH**/ ?>