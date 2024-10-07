<div class="sidebar deactive">
    <input type="hidden" name="user_role" value="{{auth()->user()->role ?? null}}">
    <div class="switch_sidebar">
        {{--        @php(include 'assets/frontend/img/arrow_switch.svg')--}}
    </div>
    <div class="sidebar_header">
        <div class="logo">
            <a href="{{ route('frontend.landing.index') }}">
                <img src="{{ asset('assets/frontend/img/logo.svg') }}" alt="Logo">
            </a>
        </div>
    </div>
    <div class="sidebar_content perfect_scroll">
        <ul class="sidebar_menu">
            <li class="sidebar_menu_shopping">
                <a href="{{ route('frontend.shopping-cart.index') }}" class="btn btn-green">
                    {{getInscriptions('side-bar-shopping-cart', 'sidebar', 'Shopping cart')}}
                    <img src="{{ asset('assets/frontend/img/shopping-card.svg') }}" alt="Shopping cart icon">
                </a>
            </li>
            <li>
                <a href="{{ route('frontend.landing.index')}}"
                   class="{{ request()->is('/') ? 'active' : '' }}">
                    <img src="{{ asset('assets/frontend/img/icon-sidebar-link-1.svg') }}" alt="Sidebar menu icon">
                    <span>Order and menu</span>
                </a>
            </li>
            @auth
                <li>
                    <a href="{{ route('frontend.orders.index', \App\Models\Order::STATUSES['completed']) }}"
                       class="{{ request()->is('orders*') ? 'active' : '' }}">
                        <img src="{{ asset('assets/frontend/img/icon-sidebar-link-2.svg') }}" alt="Sidebar menu icon">
                        <span>History of orders</span>
                    </a>
                </li>
            @endauth
            <li>
                <a href="{{ url('weekly-menu') }}" class="{{ request()->is('weekly-menu') ? 'active' : '' }}">
                    <img src="{{ asset('assets/frontend/img/icon-sidebar-link-3.svg') }}" alt="Sidebar menu icon">
                    <span>Weekly menu</span>
                </a>
            </li>
            @if($isAuthenticated)
                <li>
                    <a href="{{ route('frontend.profile.index') }}"
                       class="{{ request()->is('profile') ? 'active' : '' }}">
                        <img src="{{ asset('assets/frontend/img/icon-sidebar-link-4.svg') }}" alt="Sidebar menu icon">
                        <span>Profile</span>
                    </a>
                </li>
            @endif
            @if(auth()->check())
                <li>
                    <a href="{{ route('frontend.rewards.index') }}" class="{{ (request()->is('loyalty/rewards') || request()->is('loyalty/referrals'))  ? 'active' : '' }}">
                        <img src="{{ asset('assets/frontend/img/icon-sidebar-link-5.svg') }}" alt="Sidebar menu icon">
                        <span>Rewards & Referrals</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('frontend.gifts.index') }}" class="{{ request()->is('loyalty/gifts*') ? 'active' : '' }}">
                    <img src="{{ asset('assets/frontend/img/icon-sidebar-link-5.svg') }}" alt="Sidebar menu icon">
                    <span>Gift Certificate</span>
                </a>
            </li>
            <li>
                <a href="{{ url('delivery-and-pickup') }}"
                   class="{{ request()->is('delivery-and-pickup') ? 'active' : '' }}">
                    <img src="{{ asset('assets/frontend/img/icon-sidebar-link-6.svg') }}" alt="Sidebar menu icon">
                    <span>Delivery & Pickup</span>
                </a>
            </li>
            <li class="has-sub {{ request()->is('gallery-and-reviews', 'partners-and-references') ? 'opened-sub' : '' }}">
                <a href="">
                    <img src="{{ asset('assets/frontend/img/icon-sidebar-link-7.svg') }}" alt="icon sidebar">
                    <span>About</span>
                    <span class="has-sub_arrow">
                        <img src="{{ asset('assets/frontend/img/arrow-menu.svg') }}" alt="Arrow icon">
                    </span>
                </a>
                <ul class="sidebar_menu_sub">
                    <li>
                        <a href="{{ url('gallery-and-reviews') }}"
                           class="{{ request()->is('gallery-and-reviews') ? 'active' : '' }}">
                            Gallery & Reviews
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('partners-and-references') }}"
                           class="{{ request()->is('partners-and-references') ? 'active' : '' }}">
                            Partners & References
                        </a>
                    </li>
                </ul>
            </li>

{{--            @if(!auth()->check())
                <li>
                    <a href="{{route('login')}}"
                       class="">
                        <img src="{{ asset('assets/frontend/img/login-icon.svg') }}" alt="Sidebar menu icon">
                        <span>Login</span>
                    </a>
                </li>
            @endif--}}
        </ul>
        <div class="sidebar_content_bottom">
            @if($isAuthenticated)

                    <li>
                        <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none">
                            @csrf
                        </form>
                        <a href="{{ route('logout') }}" data-action="logout">
                            <img src="{{ asset('assets/frontend/img/icon-sidebar-link-8.svg') }}"
                                 alt="Sidebar menu icon">
                            <span>Log out</span>
                        </a>
                    </li>

            @else
                <li>
                    {{--<a href="{{route('login')}}"
                       class="">
                        <img src="{{ asset('assets/frontend/img/login-icon.svg') }}" alt="Sidebar menu icon">
                        <span>Log in</span>
                    </a>--}}

                    <a href=""
                            class=""
                            data-action="show-popup"
                            data-popup-id="login-popup">
                        Log in
                    </a>
                </li>
            @endif
        </div>
    </div>
</div>
