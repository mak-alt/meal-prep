<?php $__currentLoopData = $meals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="entry-item"
         data-meal-id="<?php echo e($meal->id); ?>"
         style="<?php echo e(empty($currentSelectedEntryMeal) ? '' : ($currentSelectedEntryMeal->id === $meal->id ? '' : 'display: none;')); ?>">
        <div class="entry-item__left">
            <div class="entry-item__food-icon-wrapper">
                <span>
                <img src="<?php echo e(asset($meal->thumb)); ?>" alt="Meal photo">
                </span>
                <?php if($meal->sides->isEmpty()): ?>
                    <div class="entry-item__food-option">
                        <img src="<?php echo e(asset('assets/frontend/img/green-close-icon-white-bg.svg')); ?>" alt="Icon">
                        No sides
                    </div>
                <?php endif; ?>
            </div>
            <div class="entry-item__info">
                <div class="entry-item__title">
                    <?php echo e($meal->name); ?>

                </div>
                <div class="weekly-menu__info">
                    <div class="weekly-menu__info-item">
                        <img src="<?php echo e(asset('assets/frontend/img/fat.svg')); ?>" alt="Icon">
                        <?php echo e($meal->calories); ?> calories
                    </div>
                    <div class="weekly-menu__info-item">
                        <img src="<?php echo e(asset('assets/frontend/img/calories.svg')); ?>" alt="Icon">
                        <?php echo e($meal->fats); ?>g fats
                    </div>
                    <div class="weekly-menu__info-item">
                        <img src="<?php echo e(asset('assets/frontend/img/tree.svg')); ?>" alt="Icon">
                        <?php echo e($meal->carbs); ?>g carbs
                    </div>
                    <div class="weekly-menu__info-item">
                        <img src="<?php echo e(asset('assets/frontend/img/fat-2.svg')); ?>" alt="Icon">
                        <?php echo e($meal->proteins); ?>g proteins
                    </div>
                </div>
            </div>
        </div>
        <div class="entry-item__right">
            <div class="entry-item__btn-wrpr flex">
                <a href="" class="btn btn_transparent" data-action="show-meal-details-popup"
                   data-show-add-btn="0" data-show-sides="0" data-meal-id="<?php echo e($meal->id); ?>" data-meal-number="<?php echo e($mealNumber); ?>"
                   data-listener="<?php echo e(route('frontend.order-and-menu.render-meal-details-popup', $meal->id)); ?>">
                    Info
                </a>
                <?php if(optional($currentSelectedEntryMeal)->id === $meal->id): ?>
                    <button type="button" class="btn btn_transparent btn-select" data-action="toggle-entry-meal-selection"
                            data-listener="<?php echo e(route('frontend.order-and-menu.toggle-entry-meal-selection', $meal->id)); ?>"
                            data-meal-id="<?php echo e($meal->id); ?>"
                            data-meal-number="<?php echo e($mealNumber); ?>"
                            data-has-entry-meal-warning="<?php echo e($hasEntryMealWarning ? 1 : 0); ?>"
                            data-operation="unselect">
                        Unselect
                    </button>
                <?php else: ?>
                    <button type="button" class="btn btn-green btn-select" data-action="toggle-entry-meal-selection"
                            data-listener="<?php echo e(route('frontend.order-and-menu.toggle-entry-meal-selection', $meal->id)); ?>"
                            data-meal-id="<?php echo e($meal->id); ?>"
                            data-meal-number="<?php echo e($mealNumber); ?>"
                            data-has-entry-meal-warning="<?php echo e($hasEntryMealWarning ? 1 : 0); ?>"
                            data-operation="select">
                        Select
                    </button>
                <?php endif; ?>
            </div>
            <div class="entry-item__price">
                <?php echo e(((int)$meal->price !== 0) ? '+$ ' . $meal->price : ''); ?>

            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/order-and-menu/partials/entry-meals-items.blade.php ENDPATH**/ ?>