<?php $__env->startSection('mobile-header'); ?>
    <header
        class="mobile_header <?php echo e(session()->has('response-message') && is_string(session()->get('response-message')) ? 'active' : ''); ?>">
        <a href="" class="mobile_header_menu">
            <img src="<?php echo e(asset('assets/frontend/img/burger-menu-icon.svg')); ?>" alt="Menu icon">
        </a>
        <a href="<?php echo e(route('frontend.landing.index')); ?>" class="header_logo">
            <img src="<?php echo e(asset('assets/frontend/img/logo.svg')); ?>" alt="Logo">
        </a>
        <a class="mobile_header_cart_btn">
        </a>
    </header>
<?php $__env->stopSection(); ?>

<?php ($contentClasses = 'wizard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <?php echo $__env->make('frontend.layouts.partials.app.checkout-steps.content-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="ovh-x">
            <div class="wizard-body">
                <div class="step active">
                    <form action="<?php echo e(route('frontend.checkout.store')); ?>" method="POST" id="checkout-form">
                        <?php echo csrf_field(); ?>
                        <div class="content_main content_main_checkout max_w-100percent">
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
                                <div class="content_box_part">
                                    <div class="tabs">
                                        <ul class="tabs-nav mb15">
                                            <li class="delivery_tab">
                                                <a href="#tab1"
                                                   class="<?php echo e(!empty($checkoutData['pickup_location']) ? '' : 'active'); ?>"
                                                   data-listener="<?php echo e(route('frontend.checkout.calculate-total-price')); ?>">
                                                    <?php (include 'assets/frontend/img/tab-delivery.svg'); ?>
                                                    <?php echo e(getInscriptions('checkout-delivery-tab',request()->path(),'Delivery')); ?>

                                                </a>
                                            </li>
                                            <?php if(!empty($deliveryPickupLocationData['pickup_locations']['items'])): ?>
                                                <li>
                                                    <a href="#tab2"
                                                       class="<?php echo e(!empty($checkoutData['pickup_location']) ? 'active' : ''); ?>"
                                                       data-listener="<?php echo e(route('frontend.checkout.calculate-total-price')); ?>">
                                                        <?php (include 'assets/frontend/img/tab-pick.svg'); ?>
                                                        <?php echo e(getInscriptions('checkout-pickup-tab',request()->path(),'Pickup')); ?>

                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                        <div class="tabs-items">
                                            <div id="tab1" class="tabs-item"
                                                 style="<?php echo e(empty($checkoutData['pickup_location']) ? '' : 'display: none;'); ?>">
                                                <div class="content_box_part">
                                                    <h2 class="content_box_title"><?php echo e(getInscriptions('checkout-delivery-frame',request()->path(),'Select preferred delivery time')); ?></h2>
                                                    <div class="box_part_wrapper mb50">
                                                        <div class="box_part_item">
                                                            <fieldset class="fieldset">
                                                                <label class="fieldset_sub_label" for="delivery-date">
                                                                    Delivery date<span>*</span>
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <input type="text" class="input input-delivery"
                                                                           id="delivery-date" name="delivery_date"
                                                                           value="<?php echo e($closestDay); ?>"
                                                                           placeholder="MM/DD/YYYY"
                                                                           required
                                                                           autocomplete="off">
                                                                    <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="box_part_item">
                                                            <fieldset class="fieldset">
                                                                <label class="fieldset_sub_label" for="boxes_to_open">
                                                                    Time frame<span>*</span>
                                                                </label>
                                                                <input type="hidden" name="delivery_time_frame"
                                                                       value="<?php echo e($checkoutData['delivery_time_frame'] ?? ''); ?>"
                                                                       required>
                                                                <div class="select-wrap input-wrapper">
                                                                    <div class="custom-select">
                                                                        <button name="boxes_to_open" id="boxes_to_open"
                                                                                class="boxes-select">
                                                                            <?php echo e(!empty($checkoutData['delivery_time_frame']) ? $checkoutData['delivery_time_frame'] : ''); ?>

                                                                        </button>
                                                                        <ul class="select_pag delivery_times">
                                                                            <?php $__currentLoopData = $deliveryTime; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <li>
                                                                                    <a href=""
                                                                                       class="<?php echo e(!empty($checkoutData['delivery_time_frame']) && $checkoutData['delivery_time_frame'] === $value['since'] . ' - ' . $value['until'] ? 'active' : ''); ?>"
                                                                                       data-action="select-time-frame"
                                                                                       data-value="<?php echo e($key); ?>">
                                                                                        <?php echo e($value['since'] . '-' . $value['until']); ?>

                                                                                    </a>
                                                                                </li>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </ul>
                                                                    </div>
                                                                    <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_time_frame'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <h2 class="content_box_title"><?php echo e(getInscriptions('checkout-set-address',request()->path(),'Specify your delivery address')); ?></h2>
                                                    <div id="delivery-address-wrapper">
                                                        <div class="box_part_wrapper">
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label" for="country">
                                                                        Country / Region</label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" name="delivery_country"
                                                                               class="input"
                                                                               id="country"
                                                                               autocomplete="country-name"
                                                                               value="<?php echo e(optional($user->profile)->delivery_country ?? 'United States (US)'); ?>"
                                                                               required readonly>
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_country'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label"
                                                                           for="street-address">
                                                                        Street address<span>*</span>
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" id="street-address"
                                                                               name="delivery_street_address"
                                                                               class="input"
                                                                               autocomplete="street-address"
                                                                               value="<?php echo e($checkoutData['delivery_street_address'] ?? optional($user->profile)->delivery_street_address); ?>"
                                                                               required>
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_street_address'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <div class="box_part_wrapper">
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label"
                                                                           for="street-address-opt">
                                                                        Apartment, suite, etc.
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" id="street-address-opt"
                                                                               name="delivery_address_opt"
                                                                               class="input"
                                                                               autocomplete="street-address-opt"
                                                                               value="<?php echo e($checkoutData['delivery_address_opt'] ?? optional($user->profile)->delivery_address_opt); ?>">
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_address_opt'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label" for="city">
                                                                        Town / City<span>*</span>
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" id="city"
                                                                               name="delivery_city"
                                                                               class="input"
                                                                               autocomplete="address-level2"
                                                                               value="<?php echo e($checkoutData['delivery_city'] ?? optional($user->profile)->delivery_city); ?>"
                                                                               required>
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_city'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <div class="box_part_wrapper">
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label" for="zip">
                                                                        ZIP<span>*</span>
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" id="zip" name="delivery_zip"
                                                                               class="input"
                                                                               autocomplete="postal-code"
                                                                               value="<?php echo e($checkoutData['delivery_zip'] ?? optional($user->profile)->delivery_zip); ?>"
                                                                               required>
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_zip'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label" for="delivery_state">
                                                                        State<span>*</span>
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <select class="input" name="delivery_state" required>
                                                                            <option selected disabled>Select a state</option>
                                                                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <option value="<?php echo e($state); ?>" <?php echo e(optional($user->profile)->delivery_state === $state ? 'selected' : ''); ?>><?php echo e($state); ?></option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_state'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <div class="box_part_wrapper">
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label" for="company">
                                                                        Company (optional)
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" id="company"
                                                                               name="delivery_company_name"
                                                                               class="input"
                                                                               autocomplete="organization"
                                                                               value="<?php echo e($checkoutData['delivery_company_name'] ?? optional($user->profile)->delivery_company_name); ?>">
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_company_name'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label"
                                                                           for="phone-number">
                                                                        Phone number<span>*</span>
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text"
                                                                               class="input input phone-number__mask"
                                                                               id="phone-number"
                                                                               name="delivery_phone_number"
                                                                               autocomplete="tel-local"
                                                                               value="<?php echo e($checkoutData['delivery_phone_number'] ?? optional($user->profile)->delivery_phone_number); ?>">
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_phone_number'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <div class="box_part_wrapper">
                                                            <div class="box_part_item">
                                                                <fieldset class="fieldset">
                                                                    <label class="fieldset_sub_label"
                                                                           for="order-notes">
                                                                        Order notes
                                                                    </label>
                                                                    <div class="input-wrapper">
                                                                        <input type="text" class="input"
                                                                               id="order-notes"
                                                                               name="delivery_order_notes"
                                                                               value="<?php echo e($checkoutData['delivery_order_notes'] ?? ''); ?>"
                                                                               maxlength="255">
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'delivery_order_notes'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <div class="box_part_wrapper">
                                                            <div class="box_part_item full">
                                                                <div class="module_check_wrapper">
                                                                    <div class="module__check">
                                                                        <input type="checkbox"
                                                                               name="use_billing_as_delivery"
                                                                               id="use-billing-as-delivery">
                                                                        <span class="check"></span>
                                                                        <label class="text"
                                                                               for="use-billing-as-delivery">
                                                                            Use this address as my billing address
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if(!empty($deliveryPickupLocationData['pickup_locations']['items'])): ?>
                                                <div id="tab2" class="tabs-item"
                                                     style="<?php echo e(!empty($checkoutData['pickup_location']) ? '' : 'display: none;'); ?>">
                                                    <h2 class="section-title"><?php echo e(getInscriptions('checkout-set-pickup-location',request()->path(),'Select pickup location')); ?></h2>
                                                    <div class="location-info-wrapper">
                                                        <div class="location-info-buttons pickup">
                                                            <?php $__currentLoopData = $deliveryPickupLocationData['pickup_locations']['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pickupLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <a href="#<?php echo e(strtolower($pickupLocation['name'])); ?>"
                                                                   class="<?php echo e($loop->first ? 'active' : ''); ?>"
                                                                   data-pickup-location="<?php echo e($pickupLocation['address']); ?>">
                                                                    <?php echo e(ucfirst($pickupLocation['name'])); ?>

                                                                </a>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                        <?php $__currentLoopData = $deliveryPickupLocationData['pickup_locations']['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pickupLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div
                                                                class="location-info-block <?php echo e($loop->first ? 'active' : ''); ?>"
                                                                id="<?php echo e(strtolower($pickupLocation['name'])); ?>">
                                                                <p>
                                                                    <img
                                                                        src="<?php echo e(asset('assets/frontend/img/Location.svg')); ?>"
                                                                        alt="Location icon">
                                                                    <?php echo e($pickupLocation['address']); ?>

                                                                </p>
                                                                <iframe
                                                                    src="https://maps.google.com/maps?hl=en&amp;q=<?php echo e(urlencode($pickupLocation['address'])); ?>&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                                                                    height="450" allowfullscreen
                                                                    loading="lazy" style="border: 0;"></iframe>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                    <h2 class="content_box_title"><?php echo e(getInscriptions('checkout-pickup-frame',request()->path(),'Select preferred pickup time')); ?></h2>
                                                    <div class="box_part_wrapper mb50">
                                                        <div class="box_part_item">
                                                            <fieldset class="fieldset">
                                                                <label class="fieldset_sub_label" for="delivery-date">
                                                                    Pickup date<span>*</span>
                                                                </label>
                                                                <div class="input-wrapper">
                                                                    <input type="text" class="input input-delivery"
                                                                           id="pickup-date" name="pickup_date"
                                                                           value="<?php echo e($closestDay); ?>"
                                                                           placeholder="MM/DD/YYYY"
                                                                           required>
                                                                    <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'pickup_date'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="box_part_item">
                                                            <fieldset class="fieldset">
                                                                <label class="fieldset_sub_label" for="boxes_to_open_1">
                                                                    Time frame<span>*</span>
                                                                </label>
                                                                <input type="hidden" name="pickup_time_frame"
                                                                       value="<?php echo e($checkoutData['pickup_time_frame'] ?? ''); ?>"
                                                                       required>
                                                                <div class="select-wrap input-wrapper">
                                                                    <div class="custom-select">
                                                                        <button name="boxes_to_open"
                                                                                id="boxes_to_open_1"
                                                                                class="boxes-select">
                                                                            <?php echo e(!empty($checkoutData['pickup_time_frame']) ? $checkoutData['pickup_time_frame'] : ''); ?>

                                                                        </button>
                                                                        <ul class="select_pag decatur">
                                                                            <?php $__currentLoopData = $pickupTime; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <li>
                                                                                    <a href=""
                                                                                       class="<?php echo e(!empty($checkoutData['pickup_time_frame']) && $checkoutData['pickup_time_frame'] === $key ? 'active' : ''); ?>"
                                                                                       data-action="select-time-frame"
                                                                                       data-value="<?php echo e($key); ?>">
                                                                                        <?php echo e($value['since'] . '-' . $value['until']); ?>

                                                                                    </a>
                                                                                </li>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </ul>
                                                                        <ul class="select_pag brookhaven" style="display: none;">
                                                                            <?php $__currentLoopData = $pickupTimeB; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <li>
                                                                                    <a href=""
                                                                                       class="<?php echo e(!empty($checkoutData['pickup_time_frame']) && $checkoutData['pickup_time_frame'] === $key ? 'active' : ''); ?>"
                                                                                       data-action="select-time-frame"
                                                                                       data-value="<?php echo e($key); ?>">
                                                                                        <?php echo e($value['since'] . '-' . $value['until']); ?>

                                                                                    </a>
                                                                                </li>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </ul>
                                                                    </div>
                                                                    <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'pickup_time_frame'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="content_box_part">
                                    <h2 class="content_box_title"><?php echo e(getInscriptions('checkout-set-billing-address',request()->path(),'Specify your billing address')); ?></h2>
                                    <div id="delivery-address-wrapper">
                                        <div class="box_part_wrapper">
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label" for="country">
                                                        Country / Region</label>
                                                    <div class="input-wrapper">
                                                        <input type="text" name="billing_country"
                                                               class="input"
                                                               id="country"
                                                               autocomplete="country-name"
                                                               value="<?php echo e(optional($user->profile)->billing_country ?? 'United States (US)'); ?>"
                                                               required readonly>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_country'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label"
                                                           for="street-address">
                                                        Street address<span>*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text" id="street-address"
                                                               name="billing_street_address"
                                                               class="input"
                                                               autocomplete="street-address"
                                                               value="<?php echo e($checkoutData['billing_street_address'] ?? optional($user->profile)->billing_street_address); ?>"
                                                               required>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_street_address'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="box_part_wrapper">
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label"
                                                           for="street-address-opt">
                                                        Apartment, suite, etc.
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text" id="street-address-opt"
                                                               name="billing_address_opt"
                                                               class="input"
                                                               autocomplete="street-address-opt"
                                                               value="<?php echo e($checkoutData['billing_address_opt'] ?? optional($user->profile)->billing_address_opt); ?>">
                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_address_opt'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label" for="city">
                                                        Town / City<span>*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text" id="city"
                                                               name="billing_city"
                                                               class="input"
                                                               autocomplete="address-level2"
                                                               value="<?php echo e($checkoutData['billing_city'] ?? optional($user->profile)->billing_city); ?>"
                                                               required>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_city'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="box_part_wrapper">
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label" for="zip">
                                                        ZIP<span>*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text" id="zip" name="billing_zip"
                                                               class="input"
                                                               autocomplete="postal-code"
                                                               value="<?php echo e($checkoutData['billing_zip'] ?? optional($user->profile)->billing_zip); ?>"
                                                               required>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_zip'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label" for="billing-state">
                                                        State<span>*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <select class="input" name="billing_state" id="billing-state" required>
                                                            <option selected disabled>Select a state</option>
                                                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($state); ?>" <?php echo e(optional($user->profile)->billing_state === $state ? 'selected' : ''); ?>><?php echo e($state); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_state'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="box_part_wrapper">
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label" for="company">
                                                        Company (optional)
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text" id="company"
                                                               name="billing_company_name"
                                                               class="input"
                                                               autocomplete="organization"
                                                               value="<?php echo e($checkoutData['billing_company_name'] ?? optional($user->profile)->billing_company_name); ?>">
                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_company_name'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label"
                                                           for="phone-number">
                                                        Phone number<span>*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="text"
                                                               class="input input phone-number__mask"
                                                               id="phone-number"
                                                               name="billing_phone_number"
                                                               autocomplete="tel-local"
                                                               value="<?php echo e($checkoutData['billing_phone_number'] ?? optional($user->profile)->billing_phone_number); ?>">
                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_phone_number'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="box_part_wrapper">
                                            <div class="box_part_item">
                                                <fieldset class="fieldset">
                                                    <label class="fieldset_sub_label" for="billing-email">
                                                        Email address<span>*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <input type="email" id="billing-email" name="billing_email_address"
                                                               class="input"
                                                               autocomplete="email"
                                                               value="<?php echo e(optional($user->profile)->billing_email_address ?? $user->email); ?>" required>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'billing_email_address'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <?php echo $__env->make('frontend.layouts.partials.app.icons.clear-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="box_part_wrapper">
                                            <div class="box_part_item full">
                                                <div class="module_check_wrapper">
                                                    <div class="module__check">
                                                        <input type="checkbox"
                                                               name="send_updates_and_promotions"
                                                               id="send-updates-and-promotions" <?php echo e(!empty($checkoutData['send_updates_and_promotions']) ? 'checked' : ''); ?>>
                                                        <span class="check"></span>
                                                        <label class="text"
                                                               for="send-updates-and-promotions">
                                                            Send me updates about products & promotions
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="content_box_part hide-payment-info">
                                    <div class="checkout_list_coupon box_part_item mb-15"
                                        style="<?php echo e($totalPriceWithDiscounts < 0 ? 'display: none;' : ''); ?>">
                                        <div id="coupon" class="row-checkout center">
                                            <div class="input-wrapper80">
                                                <input type="text" name="coupon" class="input" placeholder="Your coupon">
                                                <div class="mb-15">
                                                    <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'coupon_code'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </div>
                                            </div>
                                            <a href="<?php echo e(route('frontend.checkout.coupon.apply')); ?>"
                                               class="btn btn-green button-coupon"
                                               data-action="apply-coupon">
                                                <?php echo e(getInscriptions('checkout-coupon-apply',request()->path(),'Apply')); ?>

                                            </a>
                                        </div>
                                    </div>
                                    <h2 class="content_box_title" style="display: none;"><?php echo e(getInscriptions('checkout-select-payment-method',request()->path(),'Select preferred payment method ')); ?></h2>
                                    <div class="tabs" style="display: none;">
                                        <ul class="tabs-nav pay mb15">
                                            <li>
                                                <a href="#tab1-2" class="active">
                                                    <?php (include 'assets/frontend/img/tab-pp.svg'); ?>
                                                    <span><?php echo e(getInscriptions('checkout-paypal-tab',request()->path(),'Pay with PayPal')); ?></span>
                                                    <span class="tabs-nav_mob"><?php echo e(getInscriptions('checkout-paypal-tab-mobile',request()->path(),'PayPal')); ?></span>
                                                </a>
                                            </li>
                                            
                                        </ul>
                                        <input type="hidden" name="is_within_perimeter_of_i_285" value=false>
                                        <div class="tabs-items cc-margin">
                                            <div id="tab1-1" class="tabs-item">
                                                <div class="content_box_part">
                                                    <div class="box_part_wrapper">
                                                        <div class="card-info">
                                                            <div id="user-cards"
                                                                 style="<?php echo e($user->paymentProfiles->isEmpty() ? 'display: none;' : ''); ?>">
                                                                <?php $__currentLoopData = $user->paymentProfiles->sortBy('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentProfile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <div class="card-info_top mb15" id="stored-cards">
                                                                        <fieldset class="fieldset">
                                                                            <?php if($loop->first): ?>
                                                                                <label class="fieldset_sub_label">
                                                                                    Primary payment method
                                                                                </label>
                                                                            <?php endif; ?>
                                                                            <input type="hidden"
                                                                                   name="payment_profile_id"
                                                                                   value="<?php echo e($paymentProfile->id); ?>"
                                                                                <?php echo e($loop->first ? '' : 'disabled'); ?>>
                                                                            <input type="text"
                                                                                   class="input cursor-pointer <?php echo e($loop->first ? 'input-card__selected' : ''); ?>"
                                                                                   value="<?php echo e('•••• •••• •••• ' . substr($paymentProfile->card_number, -4)); ?>"
                                                                                   readonly>
                                                                        </fieldset>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="card-info_bottom">
                                                                    <button type="button" class="btn btn_transparent"
                                                                            data-action="use-another-card">
                                                                        Use another card
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="tab1-2" class="tabs-item">
                                                <p class="failed-pay">
                                                    After placing your order you'll be redirected to the PayPal payment
                                                    flow
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="content_cart_bottom cart_bottom_checkout desktop-only" style="width: 320px">
                                    <a href="" class="btn btn_disabled btn_checkout"><?php echo e(getInscriptions('checkout-place-order',request()->path(),'Place order')); ?></a>
                                    
                                </div>
                            </div>
                            <div class="content_cart_checkout content_cart content_cart-fixed sticky min_w-320">
                                <a href="" class="btn-close-right-sidebar">
                                    <img src="<?php echo e(asset('assets/frontend/img/icon-arrow-left.svg')); ?>"
                                         alt="Arrow left icon">
                                    <span><?php echo e(getInscriptions('checkout-order-summary-title-mobile',request()->path(),'Order summary')); ?></span>
                                </a>
                                <div class="content_cart_checkout_inner">
                                    <h3 class=""><?php echo e(getInscriptions('checkout-order-summary-title',request()->path(),'Order summary')); ?></h3>
                                    <ul class="checkout_list">
                                        <?php $__currentLoopData = $shoppingCartOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uuid => $shoppingCartOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <div class="checkout_list_item">
                                                    <div class="checkout_list_title">
                                                        <span class="title">
                                                            <?php echo e($shoppingCartOrder['menu'] ? $shoppingCartOrder['menu']->name : 'Custom meal plan'); ?>

                                                        </span>
                                                        <span><?php echo e($shoppingCartOrder['meals_amount'] ?? ''); ?> meals</span>
                                                    </div>
                                                    <span class="checkout_list_price">
                                                        $<?php echo e($shoppingCartOrder['total_price']); ?>

                                                    </span>
                                                </div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <li class="checkout_list_delivery price-block" id="delivery-price-block"
                                            style="<?php echo e($deliveryFees !== null ? '' : 'display: none;'); ?>">
                                            <div class="checkout_list_item">
                                                <div class="checkout_list_title">
                                                    Delivery
                                                </div>
                                                <span class="checkout_list_price">
                                                    $<span><?php echo e($deliveryFees); ?></span>
                                                </span>
                                            </div>
                                        </li>
                                        <?php if($applicablePointsDiscount): ?>
                                            <li class="checkout_list_delivery">
                                                <div class="checkout_list_item">
                                                    <div class="checkout_list_title">
                                                        Points discount
                                                    </div>
                                                    <span class="checkout_list_price">
                                                        - $<span><?php echo e($applicablePointsDiscount); ?></span>
                                                    </span>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                        <?php if($applicableGiftsDiscount): ?>
                                            <li class="checkout_list_delivery">
                                                <div class="checkout_list_item">
                                                    <div class="checkout_list_title">
                                                        Gift certificate discount
                                                    </div>
                                                    <span class="checkout_list_price">
                                                        - $<span><?php echo e($applicableGiftsDiscount); ?></span>
                                                    </span>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                        <?php if($referralFirstOrderDiscount): ?>
                                            <li class="checkout_list_delivery">
                                                <div class="checkout_list_item">
                                                    <div class="checkout_list_title">
                                                        Referral user discount
                                                    </div>
                                                    <span class="checkout_list_price">
                                                        - $<span><?php echo e($referralFirstOrderDiscount); ?></span>
                                                    </span>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                        <?php if($applicableReferralInviterDiscount): ?>
                                            <li class="checkout_list_delivery">
                                                <div class="checkout_list_item">
                                                    <div class="checkout_list_title">
                                                        Referral inviter discount
                                                    </div>
                                                    <span class="checkout_list_price">
                                                        - $<span><?php echo e($applicableReferralInviterDiscount); ?></span>
                                                    </span>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                        <li class="checkout_list_delivery applied-coupon" style="display: none;">
                                            <div class="checkout_list_item">
                                                <input type="hidden" name="coupon_id" value="">
                                                <div class="checkout_list_title"></div>
                                                <span class="checkout_list_price coupon__right-section">
                                                    <div>
                                                        <span class="span-for-discount"></span>
                                                        <span class="coupon-discount"></span>
                                                    </div>
                                                    <span>
                                                        <a href="<?php echo e(route('frontend.checkout.coupon.remove')); ?>"
                                                           data-action="remove-coupon">
                                                            Delete
                                                        </a>
                                                    </span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="checkout_list_total">
                                            <h4>
                                                Total: $<span class="total-price"><?php echo e($totalPriceWithDiscounts); ?></span>
                                            </h4>
                                        </li>
                                    </ul>

                                    <div id="map"></div>

                                    <div class="checkout_sum">
                                        <h4>
                                            Total: $<span class="total-price"><?php echo e($totalPriceWithDiscounts); ?></span>
                                        </h4>
                                    </div>
                                </div>
								
                            </div>
                        </div>
                    </form>
                    <div class="mobile-add-to-card double">
                        <a href="" class="btn btn_transparent summary-popup-button"><?php echo e(getInscriptions('checkout-summary-button',request()->path(),'Summary')); ?></a>
                        <a href="" class="btn btn_disabled btn_checkout"><?php echo e(getInscriptions('checkout-place-order-mobile',request()->path(),'Place order')); ?></a>
                        <div class="paypal-checkout__wrapper">
                            <a href="" class="btn btn_disabled btn_checkout"><?php echo e(getInscriptions('checkout-place-order-paypal-mobile',request()->path(),'Place order')); ?></a>
                            <div id="paypal-checkout-mobile"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mobile-popups'); ?>
    <?php if(session()->has('response-message')): ?>
        <?php echo $__env->make('frontend.layouts.partials.app.alerts.session-response-message', ['mobileView' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('frontend.layouts.partials.app.alerts.session-response-message', ['mobileView' => true, 'fromFrontendResponse' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <?php echo $__env->make('frontend.checkout.summary-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('popups'); ?>
    <?php if(session()->has('response-message')): ?>
        <?php echo $__env->make('frontend.layouts.partials.app.alerts.session-response-message', ['flash' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('frontend.layouts.partials.app.alerts.session-response-message', ['flash' => true, 'fromFrontendResponse' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script>
        let timeframesLink = '<?php echo e(route('frontend.checkout.timeframes')); ?>';
    </script>
    <script
        src="https://www.paypal.com/sdk/js?client-id=<?php echo e(env('PAYPAL_SANDBOX_CLIENT_ID')); ?>&disable-funding=credit,card"
        data-namespace="paypalSdk"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_API_KEY')); ?>&libraries=geometry"></script>

    <script src="<?php echo e(asset('assets/frontend/js/checkout.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/checkout/index.blade.php ENDPATH**/ ?>