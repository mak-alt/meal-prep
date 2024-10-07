<div class="content_box content_box_meal">
    <div class="order-menu">
        <ul>
            @foreach($orders as $order)
                <li class="order-menu__item">
                    <div class="order-menu__header">
                        <div class="order-menu__header-block-flex">
                            <div class="order-menu__title-wrapper">
                                <h2 class="order-menu__title">
                                    Order from {{ $order->created_at->format('m/d/Y') }}
                                </h2>
                                <div class="order-menu__title-links">
                                    <a href="{{ route('frontend.orders.download-receipt', $order->id) }}"
                                       class="active-link">
                                        Download receipt
                                    </a>
                                    <a href="{{ route('frontend.orders.repeat', $order->id) }}"
                                       data-action="repeat-order">
                                        Repeat the same order
                                    </a>
                                </div>
                            </div>
                            <div class="order-menu__price-wrapper">
                                <span class="price">${{ (int)$order->total_price }}</span>
                                <span class="points">+{{ $order->total_points }} points</span>
                            </div>
                            <div class="order-menu__icon">
                                <img src="{{ asset('assets/frontend/img/Up.svg') }}" alt="Arrow icon">
                            </div>
                        </div>
                        <div class="order-menu__title-links order-menu__title-links-mobile">
                            <a href="{{ route('frontend.orders.download-receipt', $order->id) }}"
                               class="active-link">
                                Download receipt
                            </a>
                            <a href="{{ route('frontend.orders.repeat', $order->id) }}"
                               data-action="repeat-order">
                                Repeat the same order
                            </a>
                        </div>
                    </div>
                    <ul class="order-menu__dropdown">
                        @if($status === \App\Models\Order::STATUSES['upcoming'])
                            <li>
                                <div class="order-menu__dropdown-custom-content">
                                    <div class="dropdown-custom-content-head">
                                        <h3>
                                            {{ $order->hasDeliveryOption() ? 'Delivery' : 'Pick-up' }}
                                        </h3>
                                        @if($order->hasDeliveryOption())
                                            <p>
                                                Your order will be delivered on
                                                <span>{{ $order->delivery_date->format('l, F jS') }}</span> between
                                                <span>{{ $order->delivery_time_frame_value }}.</span>
                                            </p>
                                        @else
                                            <p>
                                                Your can pickup your order on
                                                <span>{{ $order->pickup_date->format('l, F jS') }}</span> between
                                                <span>{{ $order->pickup_time_frame_value }}.</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endif
                        @foreach($order->orderItems as $orderItem)
                            <li>
                                <div class="order-menu__header">
                                    <div class="order-menu__header-wrapper">
                                        <div class="order-menu__title-wrapper">
                                            <h3 class="order-menu__dropdown-title">
                                                {{ $orderItem->name }}
                                            </h3>
                                        </div>
                                        <div class="order-menu__price-wrapper">
                                            <span class="price">${{ $orderItem->total_price }}</span>
                                        </div>
                                        <div class="order-menu__icon">
                                            <img src="{{ asset('assets/frontend/img/Up-small.svg') }}"
                                                 alt="Arrow icon">
                                        </div>
                                    </div>
                                </div>
                                <ul class="order-menu__dropdown order-menu__food-info">
                                    @foreach($orderItem->orderItemables->whereNull('parent_id')->where('order_itemable_type', '!==', \App\Models\Addon::class) as $orderItemable)
                                        <li class="order-menu__food-info-item">
                                            <div class="order-menu__food-info-head">
                                                <p>{{ $orderItemable->orderItemable->name }}</p>
                                                @if($orderItem->menu_id === null)
                                                    <span class="price">${{ $orderItemable->price }}</span>
                                                @endif
                                            </div>
                                            @if($orderItemable->children->isNotEmpty())
                                                <div class="order-menu__food-info-list">
                                                    @foreach($orderItemable->children as $orderItemableChild)
                                                        <div>
                                                            <p>
                                                                <span>Side:</span>
                                                                {{ $orderItemableChild->orderItemable->name }}
                                                            </p>
                                                            @if($orderItem->menu_id === null)
                                                                <span class="price">
                                                                            ${{ $orderItemableChild->price }}
                                                                        </span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="weekly-menu__info">
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/fat.svg') }}"
                                                         alt="Icon">
                                                    {{ $orderItemable->orderItemable->calories }}
                                                    <span>calories</span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/calories.svg') }}"
                                                         alt="Icon">
                                                    {{ $orderItemable->orderItemable->fats }}g
                                                    <span>fats</span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/tree.svg') }}"
                                                         alt="Icon">
                                                    {{ $orderItemable->orderItemable->carbs }}g
                                                    <span>carbs</span>
                                                </div>
                                                <div class="weekly-menu__info-item">
                                                    <img src="{{ asset('assets/frontend/img/fat-2.svg') }}"
                                                         alt="Icon">
                                                    {{ $orderItemable->orderItemable->proteins }}g
                                                    <span>proteins</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</div>

@push('js')
<script src="{{ asset('assets/frontend/js/orders.js') }}"></script>
@endpush
