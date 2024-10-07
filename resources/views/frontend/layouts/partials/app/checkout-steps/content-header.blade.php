<div class="content_header wizard-header wizard-header-chekout">
    <div class="steps text-center">
        <div class="wizard-step {{ request()->is('shopping-cart') ? 'active' : '' }}"
             data-redirect="{{ route('frontend.shopping-cart.index') }}">
            <span class="desk_title active">{{getInscriptions('shopping-cart-tab',request()->path(),'1. Shopping Cart')}}</span>
            <span class="mob_title active">{{getInscriptions('shopping-cart-tab-mobile',request()->path(),'1. Cart')}}</span>
            @php(include 'assets/frontend/img/arrow-wizard.svg')
        </div>
        <div
            class="wizard-step {{ request()->is('checkout') ? 'active' : '' }}"
            {{ !session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['proceeded_to_checkout']) ? '' : 'data-redirect=' . route('frontend.checkout.index') }}
            id="checkout-step">
            <span
                class="{{ !session()->get(\App\Models\Order::ONBOARDING_SESSION_KEYS['proceeded_to_checkout']) ? '' : 'active' }}">
                {{getInscriptions('checkout-tab',request()->path(),'2. Checkout')}}
            </span>
            @php(include 'assets/frontend/img/arrow-wizard.svg')
        </div>
        <div class="wizard-step {{ request()->is('orders/*') ? 'active' : '' }}">
            <span class="desk_title">{{getInscriptions('order-status-tab',request()->path(),'3. Order Status')}}</span>
            <span class="mob_title">{{getInscriptions('order-status-tab-mobile',request()->path(),'3. Status')}}</span>
        </div>
    </div>
</div>
