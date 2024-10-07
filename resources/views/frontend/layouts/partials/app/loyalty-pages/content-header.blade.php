<div class="content_header wizard-header wizard-header-inner history">
    <div class="steps text-center">
        <div class="wizard-step {{ request()->is('loyalty/rewards*') ? 'active' : '' }}">
            <span>
                <a href="{{ route('frontend.rewards.index') }}">My rewards</a>
            </span>
        </div>
        <div class="wizard-step {{ request()->is('loyalty/referrals*') ? 'active' : '' }}">
            <span>
                <a href="{{ route('frontend.referrals.index') }}">My referrals</a>
            </span>
        </div>
    </div>
</div>
