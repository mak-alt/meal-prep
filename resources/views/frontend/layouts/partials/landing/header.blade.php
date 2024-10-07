<header class="header-home">
    <div class="header-home__container">
        <div class="logo">
            <img src="{{ asset('assets/frontend/img/home__header-logo.svg') }}" alt="Logo">
        </div>
        <div class="header-home__right">
            <ul class="header-home__menu">
                @if($isAuthenticated)
                    <li>
                        <a href="{{ route('frontend.orders.index', \App\Models\Order::STATUSES['completed']) }}">
                            History
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ url('weekly-menu') }}">Weekly menu</a>
                </li>
                @if($isAuthenticated)
                    <li>
                        <a href="{{ route('frontend.profile.index') }}">Profile</a>
                    </li>
                @endif

                <li>
                    <a href="{{ url('delivery-and-pickup') }}">Delivery & Pickup</a>
                </li>
                <li>
                    <a href="{{ route('frontend.gifts.index') }}">Gift certificate</a>
                </li>
                <li>
                    <a href="{{ url('gallery-and-reviews') }}">About</a>
                </li>
                @if(!$isAuthenticated)
                    <li>
                        <a href="" class="green-link" data-action="show-popup" data-popup-id="login-popup">Log in</a>
                    </li>
                @endif
            </ul>
            <div class="header-home__buttons-wrapper">
                <a href="{{ route('frontend.shopping-cart.index') }}" class="btn--sm btn--green">
                    <img src="{{ asset('assets/frontend/img/icon-shopping-cart.svg') }}"
                         alt="Shopping cart icon">
                </a>
                @if($isAuthenticated)
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none">
                        @csrf
                    </form>
                    <a href="{{ route('logout') }}" class="login-icon" data-action="logout">
                        <img src="{{ asset('assets/frontend/img/icon-login-in.svg') }}" alt="Logout icon">
                    </a>
                @endif
            </div>
        </div>
    </div>
</header>
@include('frontend.layouts.partials.landing.header-mobile')
