<header
    class="mobile_header {{ $classes ?? '' }} {{ session()->has('response-message') && is_string(session()->get('response-message')) ? 'active' : '' }}">
    <a href="" class="mobile_header_menu">
        <img src="{{ asset('assets/frontend/img/burger-menu-icon.svg') }}" alt="Menu icon">
    </a>
    <a href="{{ route('frontend.landing.index') }}" class="header_logo">
        <img src="{{ asset('assets/frontend/img/logo.svg') }}" alt="Logo">
    </a>
    <a href="{{ route('frontend.shopping-cart.index') }}" class="mobile_header_cart_btn">
        <img src="{{ asset('assets/frontend/img/icon-shopping-cart.svg') }}" alt="Shopping cart icon">
    </a>
</header>
