<?php $__env->startSection('content'); ?>
    <div class="content">
        <?php echo $__env->make('frontend.layouts.partials.app.content-header', ['title' => $page->title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="content_main perfect_scroll">
            <div class="content_box">
                <div class="content_box_part_inner">
                    <h2 class="section-title">
                        <?php echo e($page->data['delivery_and_pickup_timing']['title']); ?>

                    </h2>
                    <div class="box_part_text_wrapp">
                        <?php $__currentLoopData = $page->data['delivery_and_pickup_timing']['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="box_part_text_item">
                                <h2 class="section-title"><?php echo e($time['title']); ?></h2>
                                <?php echo $time['description']; ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="content_box_part_inner">
                    <h2 class="section-title">
                        <?php echo e($page->data['delivery_fees']['title']); ?>

                    </h2>
                    <p><?php echo e($page->data['delivery_fees']['description']); ?></p>
                    <div class="search-form">
                        <div class="input-wrapper">
                            <input class="input" type="text" name="search"
                                   placeholder="<?php echo e($page->data['delivery_fees']['placeholder']); ?>" required>
                            <button type="button" class="calear-form">
                                <img src="<?php echo e(asset('assets/frontend/img/delete-entry.svg')); ?>" alt="Delete icon">
                            </button>
                            <p class="error-text"></p>
                            <p class="res-text" style="display: none;">
                                FEE: <span></span>
                            </p>
                        </div>
                        <a href="" class="btn btn_disabled" id="search-button"
                           data-url="<?php echo e(route('frontend.delivery.calculate-delivery-fees')); ?>">
                            <?php echo e($page->data['delivery_fees']['button']); ?>

                        </a>
                    </div>
                </div>

                <div class="content_box_part_inner">
                    <h2 class="section-title">
                        <?php echo e($page->data['pickup_locations']['title']); ?>

                    </h2>
                    <p><?php echo e($page->data['pickup_locations']['description']); ?></p>
                    <div class="location-info-wrapper">
                        <div class="location-info-buttons pickup">
                            <?php $__currentLoopData = $page->data['pickup_locations']['items'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="<?php echo e($loop->iteration === 1 ? 'active' : ''); ?>"
                                   href="loc-item-<?php echo e($key); ?>"><?php echo e($location['name']); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php $__currentLoopData = $page->data['pickup_locations']['items'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="loc-item-<?php echo e($key); ?> <?php echo e($loop->iteration === 1 ? 'active' : ''); ?> locations">
                                <p>
                                    <img src="<?php echo e(asset('assets/frontend/img/Location.svg')); ?>" alt="Location icon">
                                    <span class="locations-address"><?php echo e($location['address']); ?></span>
                                </p>
                                <iframe
                                    src="https://maps.google.com/maps?q=<?php echo e(str_replace(" ", "%20", $location['address'])); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                    width="600" height="450" style="border:0;" allowfullscreen=""
                                    loading="lazy"></iframe>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="content_box_part_inner">
                    <h2 class="section-title">
                        <?php echo e($page->data['contact_info']['title']); ?>

                    </h2>
                    <div class="box_part_text_wrapp style-2">
                        <div class="box_part_text_contacts">
                            <h2 class="section-title">
                                Address
                            </h2>
                            <p><?php echo $page->data['contact_info']['address']; ?></p>
                        </div>
                        <div class="box_part_text_contacts">
                            <h2 class="section-title">
                                Email
                            </h2>
                            <a href="mailto:<?php echo e($page->data['contact_info']['email']); ?>">
                                <?php echo e($page->data['contact_info']['email']); ?>

                            </a>
                        </div>
                        <div class="box_part_text_contacts">
                            <h2 class="section-title">
                                Number
                            </h2>
                            <a href="tel:<?php echo e($page->data['contact_info']['phone']); ?>">
                                <?php echo e($page->data['contact_info']['phone']); ?>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $__env->make('frontend.layouts.partials.subscribe-left-aligned', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('frontend.layouts.partials.app.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('popups'); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.login', ['redirectUrl' => url()->current()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.register', ['redirectUrl' => url()->current()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.landing.partials.popups.forgot-password', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.layouts.partials.app.alerts.session-response-message', ['fromFrontendResponse' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_API_KEY')); ?>&libraries=geometry"></script>
    <script src="<?php echo e(asset('assets/frontend/js/delivery-and-pickup.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/delivery-and-pickup/index.blade.php ENDPATH**/ ?>