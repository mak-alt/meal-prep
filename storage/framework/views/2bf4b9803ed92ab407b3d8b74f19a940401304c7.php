<div class="popup_wrpr popup-success-filter mobile-full" id="filter-by-tags">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn" data-action="close-popup" data-do-not-reset-form="<?php echo e(true); ?>">
                <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
            </a>
            <div class="filters">
                <div class="filters__title">
                    All filters
                </div>
                <form action="<?php echo e(route('frontend.order-and-menu.select-meals', $mealNumber)); ?>" method="GET">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="filter[tags]" value="<?php echo e(null); ?>">
                    <div class="flex filters-block">
                        <div class="flex flex-col filters-col">
                            <?php $__currentLoopData = $tags->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="standart_checkbox filter-checkbox-item">
                                    <input type="checkbox" name="filter[tags][]" value="<?php echo e($tag->name); ?>">
                                    <span class="standart_checkbox__check"></span>
                                    <span class="standart_checkbox__label"><?php echo e($tag->name); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="flex flex-col filters-col">
                            <?php $__currentLoopData = $tags->skip(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="standart_checkbox filter-checkbox-item">
                                    <input type="checkbox" name="filter[tags][]" value="<?php echo e($tag->name); ?>">
                                    <span class="standart_checkbox__check"></span>
                                    <span class="standart_checkbox__label"><?php echo e($tag->name); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item clean-all" style="display: none">
                    <button type="button" class="btn btn_transparent" data-action="unselect-all-filters">
                        Clear all
                    </button>
                </div>
                <div class="popup_btn_wrpr_item select-all">
                    <button type="button" class="btn btn_transparent">
                        Select all
                    </button>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn-green" data-action="filter" data-items-wrapper-id="meals">
                        Show results
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/order-and-menu/partials/popups/filter-by-tags.blade.php ENDPATH**/ ?>