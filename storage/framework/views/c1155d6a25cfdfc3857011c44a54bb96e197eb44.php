<div class="vaimascertain">
    <div class="dascevaimas">
        <div class="order-menu-header dascevaimas-wrapper">
            <ul class="header__nav">
                <div class="kasetudsionud" id="kasetudsionud"></div>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="order-menu-heade__item"
                        data-category-id="<?php echo e($menuCategory->id); ?>"
                        data-listener="<?php echo e(route('frontend.order-and-menu.remember-preferred-menu-type-selection')); ?>">
                        <?php if(empty($categoryId)): ?>
                            <a class="order-menu-heade__link <?php echo e($menuCategory->id === $category->id ? 'active' : ''); ?>"
                               href="<?php echo e(route('frontend.order-and-menu.index', $menuCategory->name)); ?>">
                                <?php echo e($menuCategory->name); ?>

                            </a>
                        <?php else: ?>
                            <a class="order-menu-heade__link <?php echo e($categoryId === $menuCategory->id ? 'active' : ''); ?>"
                               href="<?php echo e($categoryId === $menuCategory->id ? route('frontend.order-and-menu.index', $menuCategory->name) : ''); ?>">
                                <?php echo e($menuCategory->name); ?>

                            </a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <div class="asenavi-gatgtudsion-menyu">
                <button class="dascevaimas-paddle-left icon-chevronleft" aria-hidden="true">
                    <img src="<?php echo e(asset('assets/frontend/img/menu-slider-icon.svg')); ?>" alt="Slider menu icon">
                </button>
                <button class="dascevaimas-paddle-right icon-chevronright" aria-hidden="true">
                    <img src="<?php echo e(asset('assets/frontend/img/menu-slider-icon.svg')); ?>" alt="Slider menu icon">
                </button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/order-and-menu/partials/content-header.blade.php ENDPATH**/ ?>