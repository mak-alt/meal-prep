<?php ($currentSelectedSides = $currentSelectedSides ?? collect()); ?>
<?php ($entry = $entry->side_count ?? 2); ?>

<?php $__currentLoopData = $sides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $side): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="entry-item" data-side-id="<?php echo e($side->id); ?>" style="display:<?php echo e(($currentSelectedSides->count() < $entry) ? 'show' : (($currentSelectedSides->contains('id', $side->id)) ? 'show' : 'none')); ?>">
        <div class="entry-item__left">
            <div class="entry-item__food-icon-wrapper">
                <span>
                    <img src="<?php echo e(asset($side->thumb)); ?>" alt="Side meal photo">
                </span>
            </div>
            <div class="entry-item__info">
                <div class="entry-item__title"><?php echo e($side->name); ?></div>
                <div class="weekly-menu__info">
                    <div class="weekly-menu__info-item">
                        <img src="<?php echo e(asset('assets/frontend/img/fat.svg')); ?>" alt="Icon">
                        <?php echo e($side->calories); ?> calories
                    </div>
                    <div class="weekly-menu__info-item">
                        <img src="<?php echo e(asset('assets/frontend/img/calories.svg')); ?>" alt="Icon">
                        <?php echo e($side->fats); ?>g fats
                    </div>
                    <div class="weekly-menu__info-item">
                        <img src="<?php echo e(asset('assets/frontend/img/tree.svg')); ?>" alt="Icon">
                        <?php echo e($side->carbs); ?>g carbs
                    </div>
                    <div class="weekly-menu__info-item">
                        <img src="<?php echo e(asset('assets/frontend/img/fat-2.svg')); ?>" alt="Icon">
                        <?php echo e($side->proteins); ?>g proteins
                    </div>
                </div>
            </div>
        </div>
        <div class="entry-item__right">
            <div class="entry-item__btn-wrpr flex">
                <a href="" class="btn btn_transparent" data-action="show-meal-details-popup" data-sel-side-id="<?php echo e($loop->index); ?>"
                   data-show-add-btn="0" data-show-sides="0" data-meal-id="<?php echo e($side->id); ?>" data-meal-number="<?php echo e($mealNumber); ?>"
                   data-listener="<?php echo e(route('frontend.order-and-menu.render-side-details-popup', $side->id)); ?>">
                    Info
                </a>
                <div class="entry-item__amount_picker flex items-center">
                    <a href="<?php echo e(route('frontend.order-and-menu.toggle-side-meal-selection', $side->id)); ?>"
                       class="btn btn-side-select <?php echo e($currentSelectedSides->contains('id', $side->id) ? 'btn-green' : 'btn_disabled'); ?>"
                       data-action="toggle-side-meal-selection"
                       data-meal-number="<?php echo e($mealNumber); ?>" data-operation="unselect">
                        -
                    </a>
                    <span class="entry-item__amount_picker-digit main-picker" data-sel-side-id="<?php echo e($loop->index); ?>">
                        <?php echo e($currentSelectedSides->where('id', $side->id)->count()); ?>

                    </span>
                    <a href="<?php echo e(route('frontend.order-and-menu.toggle-side-meal-selection', $side->id)); ?>"
                       class="btn btn-side-unselect <?php echo e($currentSelectedSides->count() >= $entry ? 'btn_disabled' : 'btn-green'); ?>"
                       data-action="toggle-side-meal-selection"
                       data-meal-number="<?php echo e($mealNumber); ?>" data-operation="select">
                        +
                    </a>
                </div>
            </div>
            <div class="entry-item__price" style=" display: <?php echo e($currentSelectedSides->where('id', $side->id)->count() === 0 ? 'none' : 'block'); ?>">
                <?php echo e(((int)(optional($side->pivot)->price ?? $side->price) !== 0) ? '+$ ' : ''); ?>

                 <span class="side-price" style="display: <?php echo e(((int)(optional($side->pivot)->price ?? $side->price) !== 0) ? 'block' : 'none'); ?>;"><?php echo e((optional($side->pivot)->price ?? $side->price) * $currentSelectedSides->where('id', $side->id)->count()); ?></span>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/order-and-menu/partials/side-meals-items.blade.php ENDPATH**/ ?>