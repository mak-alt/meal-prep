<?php ($empty = $empty ?? false); ?>

<div class="popup_wrpr" id="duplicate-meal-step-selection">
    <?php if (! ($empty)): ?>
        <div class="popup_wrpr_inner">
            <div class="popup duplicate_this_meal_popup">
                <a href="" class="close_popup_btn" data-action="close-popup">
                    <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
                </a>
                <div class="popup_header">
                    <h3 class="popup_title">Duplicate this meal</h3>
                </div>
                <a href="" class="btn-close-duplicate-mobile" data-action="close-popup">
                    <img src="<?php echo e(asset('assets/frontend/img/icon-arrow-left.svg')); ?>" alt="Arrow left icon">
                    <span>Duplicate this meal</span>
                </a>
                <form action="<?php echo e(route('frontend.order-and-menu.meal-creation.duplicate-meals')); ?>" method="POST"
                      id="duplicate-meals-form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="max_duplicate_amount" value="<?php echo e($maximumMealsAmount); ?>">
                    <div class="popup_content popup_content_no-padding">
                        <div class="meals-calculate mb_24">
                            <div class="meals-calculate__title">
                                How many times would you like to duplicate the meal?
                            </div>
                            <div class="meals-calculate__subtitle">
                                Can not be more than <?php echo e($maximumMealsAmount); ?> (amount of meals you have)
                            </div>
                            <div class="input-wrapper">
                                <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'amount'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <input type="number" name="amount" class="duplicated_amount_input input-check" min="1"
                                       autocomplete="off" required>
                                <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="popup_content popup_content_no-padding duplicate_meals_list_box">
                        <div class="meals-calculate mb_24">
                            <div class="meals-calculate__title">Click on items you want to duplicate</div>
                            <div class="duplicate_meals_list">
                                <label class="duplicate_meal_item">
                                    <input type="checkbox" name="entry_meal_id"
                                           value="<?php echo e(optional($currentSelectedEntryMeal)->id); ?>">
                                    <span><?php echo e(optional($currentSelectedEntryMeal)->name); ?></span>
                                </label>
                                <?php $__currentLoopData = $currentSelectedSides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currentSelectedSide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="duplicate_meal_item">
                                        <input type="checkbox" name="side_meal_ids[]"
                                               value="<?php echo e($currentSelectedSide->id); ?>">
                                        <span><?php echo e($currentSelectedSide->name); ?></span>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'entry_meal_id'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'side_meal_ids'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <button class="btn btn_transparent duplicate_list_select_all">Select All</button>
                        </div>
                    </div>
                    <div class="popup_btn_wrpr">
                        <div class="popup_btn_wrpr_item">
                            <a href="" class="btn btn_transparent" data-action="close-popup">Cancel</a>
                        </div>
                        <div class="popup_btn_wrpr_item">
                            <button type="submit" class="btn btn_disabled duplicate_btn"
                                    data-action="duplicate-selected-meals">
                                Duplicate
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/order-and-menu/partials/popups/duplicate-meal-step-selection.blade.php ENDPATH**/ ?>