<div class="popup_wrpr" id="summary-popup">
    <div class="popup_wrpr_inner">
        <div class="popup popup-summary">
            <a href="" class="close_popup_btn" data-action="close-popup">
                <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
            </a>
            <div class="popup_header">
                <h3 class="popup_title">Order summary</h3>
            </div>
            <div class="content_cart_checkout_inner">
                <ul class="checkout_list">
                    @foreach($shoppingCartOrders as $uuid => $shoppingCartOrder)
                        <li>
                            <div class="checkout_list_item">
                                <div class="checkout_list_title">
                                                        <span class="title">
                                                            {{ $shoppingCartOrder['menu'] ? $shoppingCartOrder['menu']->name : 'Custom meal plan' }}
                                                        </span>
                                    <span>{{ $shoppingCartOrder['meals_amount'] ?? '' }} meals</span>
                                </div>
                                <span class="checkout_list_price">
                                                        ${{$shoppingCartOrder['total_price'] }}
                                                    </span>
                            </div>
                        </li>
                    @endforeach
                    <li class="checkout_list_delivery price-block" id="delivery-price-block"
                        style="{{ $deliveryFees !== null ? '' : 'display: none;' }}">
                        <div class="checkout_list_item">
                            <div class="checkout_list_title">
                                Delivery
                            </div>
                            <span class="checkout_list_price">
                                                    $<span>{{ $deliveryFees }}</span>
                                                </span>
                        </div>
                    </li>
                    @if($applicablePointsDiscount)
                        <li class="checkout_list_delivery">
                            <div class="checkout_list_item">
                                <div class="checkout_list_title">
                                    Points discount
                                </div>
                                <span class="checkout_list_price">
                                                        - $<span>{{ $applicablePointsDiscount }}</span>
                                                    </span>
                            </div>
                        </li>
                    @endif
                    @if($applicableGiftsDiscount)
                        <li class="checkout_list_delivery">
                            <div class="checkout_list_item">
                                <div class="checkout_list_title">
                                    Gift certificate discount
                                </div>
                                <span class="checkout_list_price">
                                                        - $<span>{{ $applicableGiftsDiscount }}</span>
                                                    </span>
                            </div>
                        </li>
                    @endif
                    @if($referralFirstOrderDiscount)
                        <li class="checkout_list_delivery">
                            <div class="checkout_list_item">
                                <div class="checkout_list_title">
                                    Referral user discount
                                </div>
                                <span class="checkout_list_price">
                                                        - $<span>{{ $referralFirstOrderDiscount }}</span>
                                                    </span>
                            </div>
                        </li>
                    @endif
                    @if($applicableReferralInviterDiscount)
                        <li class="checkout_list_delivery">
                            <div class="checkout_list_item">
                                <div class="checkout_list_title">
                                    Referral inviter discount
                                </div>
                                <span class="checkout_list_price">
                                                        - $<span>{{ $applicableReferralInviterDiscount }}</span>
                                                    </span>
                            </div>
                        </li>
                    @endif
                    {{--<li class="checkout_list_coupon"
                        style="{{ $totalPriceWithDiscounts < 0 ? 'display: none;' : '' }}">
                        <a href="" data-action="show-coupon-input">Have a coupon?</a>
                        <div id="coupon" style="display: none">
                            <div class="input-wrapper">
                                <input type="text" name="coupon" class="input">
                                <div class="mb-15">
                                    @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'coupon_code'])
                                </div>
                            </div>
                            <a href="{{ route('frontend.checkout.coupon.apply') }}"
                               class="btn btn-green coupon_apply"
                               data-action="apply-coupon">
                                Apply
                            </a>
                        </div>
                    </li>--}}
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
                                    <a href="{{ route('frontend.checkout.coupon.remove') }}"
                                       data-action="remove-coupon">
                                        Delete
                                    </a>
                                </span>
                            </span>
                        </div>
                    </li>
                    <li class="checkout_list_total">
                        <h4>
                            Total: $<span class="total-price">{{ $totalPriceWithDiscounts }}</span>
                        </h4>
                    </li>
                </ul>
                <div class="checkout_sum">
                    <h4>
                        Total: $<span class="total-price">{{ $totalPriceWithDiscounts }}</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

