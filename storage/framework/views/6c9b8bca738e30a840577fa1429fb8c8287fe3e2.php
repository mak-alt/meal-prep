<?php $__env->startSection('mobile-header'); ?>
    <div class="btn-back-to-home btn-back-to-home-inner" data-redirect="<?php echo e(route('frontend.landing.index')); ?>">
        <img src="<?php echo e(asset('assets/frontend/img/icon-arrow-left.svg')); ?>" alt="Arrow left icon">
        <span><?php echo e($page->name ?? ''); ?></span>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <?php echo $__env->make('frontend.layouts.partials.app.content-header', ['classes' => 'content_header-about', 'hideOnMobile' => true, 'title' => $page->name ?? ''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="content_main perfect_scroll">
            <div class="content_box content_box_weekly">
                    <div class="content_box_part">
                        <h2 class="section-title">Entrees</h2>
                        <p>Entrees <?php echo e($defaultPortionSize['size']); ?> oz portion</p>
                        <ul class="weekly-menu">
                            <?php $__currentLoopData = $meals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="weekly-menu__item"
                                    data-action="show-meal-details-popup"
                                    data-show-add-btn="0" data-show-sides="1"
                                    data-meal-id="<?php echo e($meal->id); ?>"
                                    data-listener="<?php echo e(route('frontend.order-and-menu.render-meal-details-popup', $meal->id)); ?>">
                                    <a href=""
                                       class="weekly-menu__item-link">
                                        <div class="weekly-menu__img">
                                            <img src="<?php echo e(asset($meal->thumb)); ?>" alt="Meal photo">
                                        </div>
                                        <div class="weekly-menu__content">
                                            <h2 class="weekly-menu__title"><?php echo e($meal->name); ?></h2>
                                            <div class="weekly-menu__text">
                                                <p>
                                                    <span>Contains:</span>
                                                    <?php echo e($meal->ingredients->implode('name', ', ')); ?>

                                                </p>
                                            </div>
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
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                        <br />
                        <h2 class="section-title">Sides</h2>
                        <ul class="weekly-menu">
                            <?php $__currentLoopData = $sides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $side): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="weekly-menu__item"
                                    data-action="show-meal-details-popup"
                                    data-show-add-btn="0" data-show-sides="1"
                                    data-meal-id="<?php echo e($side->id); ?>"
                                    data-listener="<?php echo e(route('frontend.order-and-menu.render-meal-details-popup', $side->id)); ?>">
                                    <a href=""
                                       class="weekly-menu__item-link">
                                        <div class="weekly-menu__img">
                                            <img src="<?php echo e(asset($side->thumb)); ?>" alt="Meal photo">
                                        </div>
                                        <div class="weekly-menu__content">
                                            <h2 class="weekly-menu__title"><?php echo e($side->name); ?></h2>
                                            <div class="weekly-menu__text">
                                                <p>
                                                    <span>Contains:</span>
                                                    <?php echo e($side->ingredients->implode('name', ', ')); ?>

                                                </p>
                                            </div>
                                            <div class="weekly-menu__info">
                                                <div class="weekly-menu__info-item">
                                                    <img src="<?php echo e(asset('assets/frontend/img/fat.svg')); ?>" alt="Icon">
                                                    <span>
                                                <?php echo e($side->calories); ?>

                                                <span class="weekly-menu__info-item-title">calories</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="<?php echo e(asset('assets/frontend/img/calories.svg')); ?>" alt="Icon">
                                                    <span>
                                                <?php echo e($side->fats); ?>g
                                                <span class="weekly-menu__info-item-title">fats</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="<?php echo e(asset('assets/frontend/img/tree.svg')); ?>" alt="Icon">
                                                    <span>
                                                <?php echo e($side->carbs); ?>g
                                                <span class="weekly-menu__info-item-title">carbs</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="<?php echo e(asset('assets/frontend/img/fat-2.svg')); ?>" alt="Icon">
                                                    <span>
                                                <?php echo e($side->proteins); ?>g
                                                <span class="weekly-menu__info-item-title">proteins</span>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                        <br />
                        <h2 class="section-title">Add-Ons/Breakfast/Snacks</h2>
                        <ul class="weekly-menu">
                            <?php $__currentLoopData = $other; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="weekly-menu__item"
                                    data-action="show-meal-details-popup"
                                    data-show-add-btn="0" data-show-sides="1"
                                    data-meal-id="<?php echo e($item->id); ?>"
                                    data-listener="<?php echo e(route('frontend.order-and-menu.render-meal-details-popup', $item->id)); ?>">
                                    <a href=""
                                       class="weekly-menu__item-link">
                                        <div class="weekly-menu__img">
                                            <img src="<?php echo e(asset($item->thumb)); ?>" alt="Meal photo">
                                        </div>
                                        <div class="weekly-menu__content">
                                            <h2 class="weekly-menu__title"><?php echo e($item->name); ?></h2>
                                            <div class="weekly-menu__text">
                                                <p>
                                                    <span>Contains:</span>
                                                    <?php echo e($item->ingredients->implode('name', ', ')); ?>

                                                </p>
                                            </div>
                                            <div class="weekly-menu__info">
                                                <div class="weekly-menu__info-item">
                                                    <img src="<?php echo e(asset('assets/frontend/img/fat.svg')); ?>" alt="Icon">
                                                    <span>
                                                <?php echo e($item->calories); ?>

                                                <span class="weekly-menu__info-item-title">calories</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="<?php echo e(asset('assets/frontend/img/calories.svg')); ?>" alt="Icon">
                                                    <span>
                                                <?php echo e($item->fats); ?>g
                                                <span class="weekly-menu__info-item-title">fats</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="<?php echo e(asset('assets/frontend/img/tree.svg')); ?>" alt="Icon">
                                                    <span>
                                                <?php echo e($item->carbs); ?>g
                                                <span class="weekly-menu__info-item-title">carbs</span>
                                            </span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="<?php echo e(asset('assets/frontend/img/fat-2.svg')); ?>" alt="Icon">
                                                    <span>
                                                <?php echo e($item->proteins); ?>g
                                                <span class="weekly-menu__info-item-title">proteins</span>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                    </div>
            </div>
            <?php echo $__env->make('frontend.layouts.partials.subscribe-left-aligned', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('frontend.layouts.partials.app.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('popups'); ?>
    <?php echo $__env->make('frontend.order-and-menu.partials.popups.meal-details', ['empty' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.login', ['redirectUrl' => url()->current()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.register', ['redirectUrl' => url()->current()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php echo $__env->make('frontend.landing.partials.popups.forgot-password', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <div class="mobile-add-to-card">
        <a href="<?php echo e(route('frontend.landing.index')); ?>" class="btn btn-green btn-start">
            Start shopping
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/weekly-menu/index.blade.php ENDPATH**/ ?>