<div class="ovh-x">
    <div class="wizard-body">
        <div class="step active">
            <div class="content_main perfect_scroll" id="shopping-cart-empty" style="display: none;">
                <div class="empty-page">
                    <div class="empty-page_logo">
                        <img src="{{ asset('assets/frontend/img/empty-logo.svg') }}"
                             alt="Empty shopping cart icon">
                    </div>
                    <h1 class="empty-page_h1">{{getInscriptions('shopping-cart-empty',request()->path(),'Your cart is empty')}}</h1>
                    <p class="empty-page_p">
                        You'll see selected meals here as soon as you start shopping.
                    </p>
                    <a href="{{ route('frontend.landing.index') }}" class="btn btn-green">{{getInscriptions('shopping-cart-go-shop',request()->path(),'Start shopping')}}</a>
                </div>
            </div>
            <div class="content_main content_main_cart content_main_cart_full perfect_scroll">
                <div class="content_box content_box_cart box-full-width">
                    <div class="order-menu">
                        <ul class="order-menu-without-header">
                            @foreach($shoppingCartOrders as $uuid => $shoppingCartOrder)
                                <li class="order-menu__item"
                                    data-micronutrients-data="{{ json_encode($shoppingCartOrder['micronutrients_data']) }}"
                                    data-total-price="{{ $shoppingCartOrder['total_price'] }}"
                                    data-total-points="{{ $shoppingCartOrder['total_points'] }}">
                                    <div class="order-menu__header">
                                        <div class="order-menu__header-block-flex">
                                            <div class="order-menu__title-wrapper">
                                                <h2 class="order-menu__title">
                                                    {{ $shoppingCartOrder['menu'] ? $shoppingCartOrder['menu']->name : 'Custom meal plan' }}
                                                    {{ $shoppingCartOrder['menu'] ? '' : ( $shoppingCartOrder['meals_amount'] . 'meals') }}
                                                </h2>
                                                <div class="order-menu__title-links">
                                                    @if(!$shoppingCartOrder['menu'])
                                                        <a href=""
                                                           data-action="complete-menu"
                                                           data-listener="{{ route('frontend.shopping-cart.complete-menu', $uuid) }}"
                                                           class="{{ !$shoppingCartOrder['selection_completed'] ? 'active-link' : '' }}">
                                                            {{ !$shoppingCartOrder['selection_completed'] ? 'Complete menu' : 'Edit' }}
                                                        </a>
                                                    @endif
                                                    <a href=""
                                                       data-action="show-popup"
                                                       data-popup-id="delete-shopping-cart-order"
                                                       data-listener="{{ route('frontend.shopping-cart.destroy', $uuid) }}">
                                                        Delete
                                                    </a>
                                                    <a href="" data-action="duplicate"
                                                       data-listener="{{ route('frontend.shopping-cart.duplicate', $uuid) }}">
                                                        Duplicate
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="order-menu__price-wrapper">
                                                <span class="price main-price" data-price-id="{{$loop->index}}">${{ $shoppingCartOrder['total_price'] }}</span>
                                            </div>
                                            {{--<div class="order-menu__icon">
                                                <img src="{{ asset('assets/frontend/img/Up.svg') }}"
                                                     alt="Arrow up icon">
                                            </div>--}}
                                        </div>
                                        <div class="order-menu__title-links order-menu__title-links-mobile">
                                            @if(!$shoppingCartOrder['menu'])
                                                <a href=""
                                                   data-action="complete-menu"
                                                   data-listener="{{ route('frontend.shopping-cart.complete-menu', $uuid) }}"
                                                   class="{{ !$shoppingCartOrder['selection_completed'] ? 'active-link' : '' }}">
                                                    {{ !$shoppingCartOrder['selection_completed'] ? 'Complete menu' : 'Edit' }}
                                                </a>
                                            @endif
                                            <a href=""
                                               data-action="show-popup"
                                               data-popup-id="delete-shopping-cart-order"
                                               data-listener="{{ route('frontend.shopping-cart.destroy', $uuid) }}">
                                                Delete
                                            </a>
                                            <a href="" data-action="duplicate"
                                               data-listener="{{ route('frontend.shopping-cart.duplicate', $uuid) }}">
                                                Duplicate
                                            </a>
                                        </div>
                                    </div>
                                    {{--<ul class="order-menu__dropdown">
                                        @foreach($shoppingCartOrder['items'] as $shoppingCartOrderItemData)
                                            <li class="order-menu__food-info-item">
                                                <div class="order-menu__food-info-head">
                                                    @if($shoppingCartOrderItemData[0])
                                                        <p>{{ $shoppingCartOrderItemData[0]->name }}</p>
                                                        <span class="price">
                                                           ${{ $shoppingCartOrderItemData[0]->price }}
                                                        </span>
                                                    @endif
                                                </div>
                                                @if(!empty($shoppingCartOrderItemData['sides']))
                                                    <div class="order-menu__food-info-list">
                                                        @foreach($shoppingCartOrderItemData['sides'] as $side)
                                                            @if($side !== null)
                                                                <div>
                                                                    <p>
                                                                        <span>Side:</span> {{ $side->name }}
                                                                    </p>
                                                                    <span class="price">
                                                                        ${{ optional($side->pivot)->price ?? $side->price }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <div class="weekly-menu__info">
                                                    <div class="weekly-menu__info-item">
                                                        <img src="{{ asset('assets/frontend/img/fat.svg') }}"
                                                             alt="Icon">
                                                        {{ optional($shoppingCartOrderItemData[0])->calories ?? 0 + collect($shoppingCartOrderItemData['sides'])->sum('calories') }}
                                                        <span> calories</span>
                                                    </div>
                                                    <div class="weekly-menu__info-item">
                                                        <img src="{{ asset('assets/frontend/img/calories.svg') }}"
                                                             alt="Icon">
                                                        <span>
                                                            {{ optional($shoppingCartOrderItemData[0])->fats ?? 0 + collect($shoppingCartOrderItemData['sides'])->sum('fats') }}g
                                                        </span>
                                                        <span> fats</span>
                                                    </div>
                                                    <div class="weekly-menu__info-item">
                                                        <img src="{{ asset('assets/frontend/img/tree.svg') }}"
                                                             alt="Icon">
                                                        <span>
                                                            {{ optional($shoppingCartOrderItemData[0])->carbs ?? 0 + collect($shoppingCartOrderItemData['sides'])->sum('carbs') }}g
                                                        </span>
                                                        <span> carbs</span>
                                                    </div>
                                                    <div class="weekly-menu__info-item">
                                                        <img src="{{ asset('assets/frontend/img/fat-2.svg') }}"
                                                             alt="Icon">
                                                        <span>
                                                            {{ optional($shoppingCartOrderItemData[0])->proteins ?? 0 + collect($shoppingCartOrderItemData['sides'])->sum('proteins') }}g
                                                        </span>
                                                        <span> proteins</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>--}}
                                    @if(!empty($shoppingCartOrder['addons']))
                                        @foreach($shoppingCartOrder['addons'] as $addon)
                                            <li class="order-menu__item">
                                                <div class="order-menu__header">
                                                    <div class="order-menu__header-block-flex">
                                                        <div class="order-menu__title-wrapper">
                                                            <h2 class="order-menu__title">
                                                                {{ $addon[0]->name }}
                                                            </h2>
                                                            <div class="order-menu__title-links">
                                                                <a href="{{route('frontend.order-and-menu.addons.show', $addon[0]->id)}}">
                                                                    Edit
                                                                </a>
                                                                <a href=""
                                                                   data-action="show-popup"
                                                                   data-popup-id="delete-addon"
                                                                   data-listener="{{route('frontend.order-and-menu.addons.remove', [$addon[0]->id, $uuid])}}">
                                                                    Delete
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="order-menu__price-wrapper">
                                                            <span class="price secondary-price" data-dep-price-id="{{$loop->parent->index}}">${{ number_format($addon['price'],2) }}</span>
                                                        </div>
                                                        {{--<div class="order-menu__icon">
                                                            <img src="{{ asset('assets/frontend/img/Up.svg') }}"
                                                                 alt="Arrow up icon">
                                                        </div>--}}
                                                    </div>
                                                    <div class="order-menu__title-links order-menu__title-links-mobile">
                                                        <a href="{{route('frontend.order-and-menu.addons.show', $addon[0]->id)}}">
                                                            Edit
                                                        </a>
                                                        <a href=""
                                                           data-action="show-popup"
                                                           data-popup-id="delete-addon"
                                                           data-listener="{{route('frontend.order-and-menu.addons.remove', [$addon[0]->id, $uuid])}}">
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                                {{--<ul class="order-menu__dropdown">
                                                    @foreach($addon['meals'] as $meal)
                                                        <li class="order-menu__food-info-item">
                                                            <div class="order-menu__food-info-head">
                                                                <p>{{ $meal->name }}</p>
                                                                <span class="price">
                                                                ${{ $meal->price }}
                                                                </span>
                                                            </div>
                                                            <div class="weekly-menu__info">
                                                                <div class="weekly-menu__info-item">
                                                                    <img src="{{ asset('assets/frontend/img/fat.svg') }}"
                                                                         alt="Icon">
                                                                    {{ $meal->calories }}
                                                                    <span> calories</span>
                                                                </div>
                                                                <div class="weekly-menu__info-item">
                                                                    <img src="{{ asset('assets/frontend/img/calories.svg') }}"
                                                                         alt="Icon">
                                                                    <span>
                                                                    {{ $meal->fats }}g
                                                                    </span>
                                                                    <span> fats</span>
                                                                </div>
                                                                <div class="weekly-menu__info-item">
                                                                    <img src="{{ asset('assets/frontend/img/tree.svg') }}"
                                                                         alt="Icon">
                                                                    <span>
                                                                    {{ $meal->carbs }}g
                                                                    </span>
                                                                    <span> carbs</span>
                                                                </div>
                                                                <div class="weekly-menu__info-item">
                                                                    <img src="{{ asset('assets/frontend/img/fat-2.svg') }}"
                                                                         alt="Icon">
                                                                    <span>
                                                                    {{ $meal->proteins }}g
                                                                    </span>
                                                                    <span> proteins</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>--}}
                                            </li>
                                        @endforeach
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="success-order-info success_order_info_in_content" id="menu-restore-prompt"
                     style="width: calc(100% - 530px);">
                    <span>
                        Your menu was deleted but you can still
                        <a href="{{ route('frontend.shopping-cart.undo-destroy') }}" data-action="undo-menu-deleting">
                            undo it.
                        </a>
                    </span>
                    <span class="success-order-info_mob">
                        Your menu was deleted.
                        <a href="{{ route('frontend.shopping-cart.undo-destroy') }}" data-action="undo-menu-deleting">
                            Undo it.
                        </a>
                    </span>
                    <img src="{{ asset('assets/frontend/img/close-white.svg') }}" class="success-order-info__close"
                         alt="Close icon"
                         style="cursor: pointer;">
                </div>
                <div class="content_cart cart_order content_cart-inner content_cart-fixed">
                    <a href="" class="btn-close-right-sidebar">
                        <img src="{{ asset('assets/frontend/img/icon-arrow-left.svg') }}" alt="Arrow left icon">
                        <span>Order value</span>
                    </a>
                    <ul class="order-value mobile-order-value">
                        <li class="order-value_title">Total order value</li>
                        <li>
                            <img src="{{ asset('assets/frontend/img/cart-icon-1.svg') }}" alt="Icon">
                            <span id="order-calories" class="pr-3px">
                                {{ $shoppingCartOrders->sum('micronutrients_data.calories') }}
                            </span>
                            calories
                        </li>
                        <li>
                            <img src="{{ asset('assets/frontend/img/cart-icon-2.svg') }}" alt="Icon">
                            <span id="order-fats">
                                {{ $shoppingCartOrders->sum('micronutrients_data.fats') }}
                            </span>
                            g fats
                        </li>
                        <li>
                            <img src="{{ asset('assets/frontend/img/cart-icon-3.svg') }}" alt="Icon">
                            <span id="order-carbs">
                                {{ $shoppingCartOrders->sum('micronutrients_data.carbs') }}
                            </span>
                            g carbs
                        </li>
                        <li>
                            <img src="{{ asset('assets/frontend/img/cart-icon-4.svg') }}" alt="Icon">
                            <span id="order-proteins">
                                {{ $shoppingCartOrders->sum('micronutrients_data.proteins') }}
                            </span>
                            g proteins
                        </li>
                    </ul>
                    <div class="content_cart_bottom" style="display: block">
                        <div class="cart_sum mobile-total">
                            <h3 class="cart_sum_total">
                                Menu total:
                                <span>$</span><span
                                    class="total-price">{{ $shoppingCartOrders->sum('total_price') }}</span>
                            </h3>
                            <h4 class="cart_sum_point">
                                + <span class="total-points">{{ $shoppingCartOrders->sum('total_points') }}</span>
                                points for this order
                            </h4>
                        </div>
                        <div class="wizard-button-group order-value-buttons">
                            <div class="mobile-order-value">
                                <a href="" class="btn btn-green close-order-value">Return to Cart</a>
                            </div>
                            @auth
                                @if($shoppingCartOrders->pluck('selection_completed')->contains(false))
                                    <button type="button" class="btn btn-green" data-action="show-popup"
                                            data-popup-id="order-complete">
                                        {{getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')}}
                                        <img src="{{ asset('assets/frontend/img/cart-icon-white.svg') }}"
                                             alt="Shopping cart icon">
                                    </button>
                                @else
                                    <button id="wizard-next" type="button"
                                            class="btn btn_checkout btn-green"
                                            data-action="proceed-to-checkout"
                                            data-listener="{{ route('frontend.checkout.proceed-to-checkout') }}">
                                        {{getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')}}
                                        <img src="{{ asset('assets/frontend/img/cart-icon-white.svg') }}"
                                             alt="Shopping cart icon">
                                    </button>
                                @endif
                            @else
                                @if($shoppingCartOrders->pluck('selection_completed')->contains(false))
                                <button type="button"
                                        class="btn btn_checkout btn-green" data-action="show-popup"
                                        data-popup-id="order-complete">
                                    {{getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')}}
                                    <img src="{{ asset('assets/frontend/img/cart-icon-white.svg') }}"
                                         alt="Shopping cart icon">
                                </button>
                                @else
                                    <button type="button"
                                            class="btn btn_checkout btn-green"
                                            data-action="show-popup"
                                            data-popup-id="login-popup">
                                        {{getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')}}
                                        <img src="{{ asset('assets/frontend/img/cart-icon-white.svg') }}"
                                             alt="Shopping cart icon">
                                    </button>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-add-to-card double order-value">
                <a href="" class="btn btn_order btn_transparent btn-open-right-sidebar">{{getInscriptions('shopping-cart-order-value',request()->path(),'Order value')}}</a>
                @auth

                    @if($shoppingCartOrders->pluck('selection_completed')->contains(false))
                        <a href=""
                           class="btn btn_checkout btn-green" data-action="show-popup"
                           data-popup-id="order-complete"
                           data-listener="{{ route('frontend.checkout.proceed-to-checkout') }}">
                            <span>{{getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')}}</span>
                            <span class="btn_price">${{ $shoppingCartOrders->sum('total_price') }}</span>
                        </a>
                    @else
                        <a href=""
                           class="btn btn_checkout btn-green"
                           data-action="proceed-to-checkout"
                           data-listener="{{ route('frontend.checkout.proceed-to-checkout') }}">
                            <span>{{getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')}}</span>
                            <span class="btn_price">${{ $shoppingCartOrders->sum('total_price') }}</span>
                        </a>
                    @endif

                @else

                    @if($shoppingCartOrders->pluck('selection_completed')->contains(false))
                        <a href=""
                           class="btn btn_checkout btn-green"
                           data-action="show-popup"
                           data-popup-id="order-complete">
                            <span>{{getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')}}</span>
                            <span class="btn_price">${{ $shoppingCartOrders->sum('total_price') }}</span>
                        </a>
                    @else
                        <a href=""
                           class="btn btn_checkout btn-green"
                           data-action="show-popup"
                           data-popup-id="login-popup">
                            <span>{{getInscriptions('shopping-cart-checkout',request()->path(),'Checkout')}}</span>
                            <span class="btn_price">${{ $shoppingCartOrders->sum('total_price') }}</span>
                        </a>
                    @endif

                @endauth
            </div>
        </div>
    </div>
</div>
