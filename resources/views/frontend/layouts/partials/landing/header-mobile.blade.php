<div class="mobile_header mobile_header-mobile">
    <a href="" class="mobile_header_menu">
        <img src="{{ asset('assets/frontend/img/burger-menu-icon.svg') }}" alt="Menu icon">
    </a>
    <a href="{{ route('frontend.landing.index') }}" class="header_logo">
        <img src="{{ asset('assets/frontend/img/logo.svg') }}" alt="Logo">
    </a>
    <a href="{{ route('frontend.shopping-cart.index') }}" class="mobile_header_cart_btn">
        <img src="{{ asset('assets/frontend/img/icon-shopping-cart.svg') }}" alt="Shopping cart icon">
    </a>
</div>
<div class="sidebar deactive sidebar-home">
    <div class="switch_sidebar">
        {{--            @php(include('assets/frontendassets/frontend/img/arrow_switch.svg'))--}}
    </div>
    <div class="sidebar_content perfect_scroll">
        <ul class="sidebar_menu">
            <li class="sidebar_menu_shopping">
                <a href="{{ route('frontend.shopping-cart.index') }}" class="btn btn-green">
                    Shopping card
                    <img src="{{ asset('assets/frontend/img/shopping-card.svg') }}" alt="Shopping cart icon">
                </a>
            </li>
            <li class="active">
                <a href="{{ route('frontend.landing.index')}}">
                    <img src="{{ asset('assets/frontend/img/icon-sidebar-link-1.svg') }}" alt="Sidebar menu icon">
                    <span>Order and menu</span>
                </a>
            </li>
            @if($isAuthenticated)
                <li>
                    <a href="{{ route('frontend.orders.index', \App\Models\Order::STATUSES['completed']) }}">
                        <img src="{{ asset('assets/frontend/img/icon-sidebar-link-2.svg') }}" alt="Sidebar menu icon">
                        <span>History of orders</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ url('weekly-menu') }}">
                    <img src="{{ asset('assets/frontend/img/icon-sidebar-link-3.svg') }}" alt="Sidebar menu icon">
                    <span>Weekly menu</span>
                </a>
            </li>
            @if($isAuthenticated)
                <li>
                    <a href="{{ route('frontend.profile.index') }}">
                        <img src="{{ asset('assets/frontend/img/icon-sidebar-link-4.svg') }}" alt="Sidebar menu icon">
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.rewards.index') }}">
                        <img src="{{ asset('assets/frontend/img/icon-sidebar-link-5.svg') }}" alt="Sidebar menu icon">
                        <span>Rewards & Referrals</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ url('delivery-and-pickup') }}">
                    <img src="{{ asset('assets/frontend/img/icon-sidebar-link-6.svg') }}" alt="Sidebar menu icon">
                    <span>Delivery & Pickup</span>
                </a>
            </li>
            <li>
                <a href="{{ route('frontend.gifts.index') }}" class="{{ request()->is('loyalty/gifts*') ? 'active' : '' }}">
                    <img src="{{ asset('assets/frontend/img/icon-sidebar-link-5.svg') }}" alt="Sidebar menu icon">
                    <span>Gift Certificate</span>
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
                    <a href="{{route('login')}}"
                       class="">
                        <img src="{{ asset('assets/frontend/img/login-icon.svg') }}" alt="Sidebar menu icon">
                        <span>Login</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
<div class="mobile-header-main-menu">
    <div class="sidebar">
        <div class="sidebar_header flex justify-between">
            <div class="logo">
                <a href="{{ route('frontend.landing.index') }}">
                    <img src="{{ asset('assets/frontend/img/logo.svg') }}" alt="Logo">
                </a>
            </div>
            <a href="" class="mobile-header-main-menu__close-link">
                <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close popup icon">
            </a>
        </div>
        <div class="sidebar_content perfect_scroll ps">
            <ul class="sidebar_menu">
                <li class="sidebar_menu_shopping">
                    <a href="{{ route('frontend.shopping-cart.index') }}" class="btn btn-green">
                        Shopping card
                        <img src="{{ asset('assets/frontend/img/shopping-card.svg') }}" alt="Shopping cart icon">
                    </a>
                </li>
                <li class="active">
                    <a href="{{ empty($categoryId) ? route('frontend.order-and-menu.select-meals', 1) : route('frontend.order-and-menu.index', $categories->where('id', $categoryId)->first()->name) }}">
                        <img src="{{ asset('assets/frontend/img/icon-sidebar-link-1.svg') }}"
                             alt="Sidebar menu icon">
                        <span>Order and menu</span>
                    </a>
                </li>
                @if($isAuthenticated)
                    <li>
                        <a href="{{ route('frontend.orders.index', \App\Models\Order::STATUSES['completed']) }}">
                            <img src="{{ asset('assets/frontend/img/icon-sidebar-link-2.svg') }}"
                                 alt="Sidebar menu icon">
                            <span>History of orders</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ url('weekly-menu') }}">
                        <img src="{{ asset('assets/frontend/img/icon-sidebar-link-3.svg') }}"
                             alt="Sidebar menu icon">
                        <span>Weekly menu</span>
                    </a>
                </li>
                @if($isAuthenticated)
                    <li>
                        <a href="{{ route('frontend.profile.index') }}">
                            <img src="{{ asset('assets/frontend/img/icon-sidebar-link-4.svg') }}"
                                 alt="Sidebar menu icon">
                            <span>Profile</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('frontend.rewards.index') }}">
                        <img src="{{ asset('assets/frontend/img/icon-sidebar-link-5.svg') }}"
                             alt="Sidebar menu icon">
                        <span>Rewards &amp; Referrals</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('delivery-and-pickup') }}">
                        <img src="{{ asset('assets/frontend/img/icon-sidebar-link-6.svg') }}"
                             alt="Sidebar menu icon">
                        <span>Delivery &amp; Pickup</span>
                    </a>
                </li>
                <li>
                    <ul class="open-menu">
                        <li class="open-menu__item active">
                            <a href="" class="open-menu__header">
                                <img src="{{ asset('assets/frontend/img/icon-sidebar-link-7.svg') }}"
                                     alt="Sidebar menu icon">
                                <span>About</span>
                                <span>
                                    <img class="open-menu__icon active"
                                         src="{{ asset('assets/frontend/img/arrow-up-blue.svg') }}"
                                         alt="Arrow up icon">
                                </span>
                            </a>
                            <ul class="open-menu__item__dropdown" style="display: block;">
                                <li class="open-menu__item">
                                    <a href="{{ url('gallery-and-reviews') }}" class="dropdown-link">
                                        Gallery & Reviews
                                    </a>
                                    <a href="{{ url('partners-and-references') }}" class="dropdown-link">
                                        Partners & References
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

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
                        <a href="{{route('login')}}"
                           class="">
                            <img src="{{ asset('assets/frontend/img/login-icon.svg') }}" alt="Sidebar menu icon">
                            <span>Login</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
