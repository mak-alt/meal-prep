<div class="ovh-x">
    <div class="wizard-body">
        <div class="step active">
            <div class="content_main perfect_scroll">
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
        </div>
    </div>
</div>
