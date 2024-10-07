<div class="empty-page empty-page-inner">
    <div class="empty-page_logo">
        <img src="{{ asset('assets/frontend/img/empty-logo.svg') }}" alt="Empty shopping cart icon">
    </div>
    <h1 class="empty-page_h1">
        @if($status === \App\Models\Order::STATUSES['completed'])
            {{ $ordersExist ? getInscriptions('orders-none',request()->path(),'No completed orders') : getInscriptions('orders-not-ordered-yet',request()->path(),'You have not ordered anything yet') }}
        @else
            No upcoming orders
        @endif
    </h1>
    <a href="{{ route('frontend.landing.index') }}" class="btn btn-green">{{getInscriptions('orders-go-shop',request()->path(),'Start shopping')}}</a>
</div>
