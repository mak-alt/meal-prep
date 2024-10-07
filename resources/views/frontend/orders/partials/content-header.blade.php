<div class="content_header wizard-header wizard-header-inner history">
    <div class="steps text-center">
        <div
            class="wizard-step {{ request()->is('orders/' . \App\Models\Order::STATUSES['completed']) ? 'active' : '' }}">
            <span>
                <a href="{{ route('frontend.orders.index', \App\Models\Order::STATUSES['completed']) }}">
                    {{getInscriptions('orders-past',request()->path(),'Past orders')}}
                </a>
            </span>
        </div>
        <div
            class="wizard-step {{ request()->is('orders/' . \App\Models\Order::STATUSES['upcoming']) ? 'active' : '' }}">
            <span>
                <a href="{{ route('frontend.orders.index', \App\Models\Order::STATUSES['upcoming']) }}">
                    {{getInscriptions('orders-upcoming',request()->path(),'Upcoming orders')}}
                </a>
            </span>
        </div>
    </div>
</div>
