<div class="popup_wrpr" id="summary-popup">
    <div class="popup_wrpr_inner">
        <div class="popup popup-summary">
            <a href="" class="close_popup_btn" data-action="close-popup">
                <img src="<?php echo e(asset('assets/frontend/img/close-popup.svg')); ?>" alt="Close icon">
            </a>
            <div class="popup_header">
                <h3 class="popup_title">Order summary</h3>
            </div>
            <div class="content_cart_checkout_inner">
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
                <div class="checkout_sum">
                    <h4>
                        Total: $<span class="total-price"><?php echo e($totalPriceWithDiscounts); ?></span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/checkout/summary-popup.blade.php ENDPATH**/ ?>