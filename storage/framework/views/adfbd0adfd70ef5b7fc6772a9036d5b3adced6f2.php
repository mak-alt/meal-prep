<?php ($empty = $empty ?? false); ?>

<div class="popup_wrpr" id="popup-about-selected-meal">
    <?php if (! ($empty)): ?>
        <div class="popup_wrpr_inner">
            <div class="popup">
                <a href="" class="close_popup_btn" data-action="close-popup">
                    <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
                </a>
                <div class="popup_header">
                    <img src="<?php echo e(asset($meal->thumb)); ?>" alt="Meal photo">
                </div>
                <div class="popup-about-selected-meal__wrapper">
                    <div class="popup-about-selected-meal__title">
                        <?php echo e($meal->name); ?>

                    </div>
                    <?php if(!empty($showSides) && !empty($menuId)): ?>
                        <?php $__currentLoopData = $meal->menuSides()->where('menu_id', $menuId)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mealMenuSide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="weekly-menu__text">
                                <p>
                                    <span>Side:</span> <?php echo e($mealMenuSide->name); ?>

                                </p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
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
                    <p class="popup-about-selected-meal__description">
                        <span>Contains:</span>
                        <?php echo e($meal->ingredients->implode('name', ', ')); ?>

                    </p>
                    <div class="popup_btn_wrpr">
                        <div class="popup_btn_wrpr_item">
                            <a href="" class="btn btn_transparent" data-action="close-popup">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/order-and-menu/partials/popups/meal-details.blade.php ENDPATH**/ ?>