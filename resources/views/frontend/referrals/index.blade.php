@extends('frontend.layouts.app')

@php($contentClasses = 'wizard')

@section('content')
    <div class="content">
        @include('frontend.layouts.partials.app.loyalty-pages.content-header')
        <div class="content_main content_main_checkout w-full">
            <div class="content_box w-full rewards">
                <div class="points-info-block active">
                    <div class="points-info-block__title">
                        <h2>Earn Points on Each Purchase Redeemable For Discounts</h2>
                        <img src="{{ asset('assets/frontend/img/Down-black.svg') }}" alt="Arrow down icon">
                    </div>
                    <div class="points-info-block__content-wrapper bt0">
                        <div class="points-info-block__content-item ">
                            <div class="points-info-block__content-item-img">
                                <img src="{{ asset('assets/frontend/img/Untitled_Artwork-22.png') }}"
                                     alt="Referral program icon">
                            </div>
                            <p>
                                Give friends ${{\App\Models\Setting::key('amountInviteeGets')->first()->data}} off their first order, and you’ll automatically get ${{\App\Models\Setting::key('amountInviterGets')->first()->data}} added to your
                                account when they place a successful pickup. It’s that easy.
                            </p>
                        </div>
                    </div>
                </div>
                @if($isAuthenticated)
                    <div class="referal-link-block">
                        <div class="referal-link-block__img">
                            <img src="{{ asset('assets/frontend/img/Ticket.svg') }}" alt="Ticket icon">
                        </div>
                        <div class="referal-link-block__text">
                            Your referral code is:
                            <span>{{ $referralCode }}</span>
                        </div>
                        <div class="referal-link-block__buttons">
                            <button type="button" class="btn btn_transparent edit-referral-code">Edit</button>
                            <button type="button" class="btn btn-green btn_copy" data-action="copy-referral-code">
                                <span class="copy_text">Copy</span>
                                <span class="copied_text">Copied</span>
                            </button>
                        </div>
                    </div>
                    <div class="share-links-block">
                        <a href="" class="share-links-block__item" data-action="show-popup"
                           data-popup-id="share-via-email-popup">
                            <img src="{{ asset('assets/frontend/img/email_40.svg') }}" alt="Email icon">
                            Share via Email
                        </a>
                        <a href="" class="share-links-block__item" data-action="show-popup"
                           data-popup-id="share-via-link-popup">
                            <img src="{{ asset('assets/frontend/img/Link-share.svg') }}" alt="Link icon">
                            Share via Link
                        </a>
                        <a href=""
                           rel="nofollow"
                           data-url="{{ route('frontend.referrals.join', $referralCode) }}"
                           class="share-links-block__item fb-share-button" data-action="share-via-facebook">
                            <img src="{{ asset('assets/frontend/img/FB.svg') }}" alt="Facebook icon">
                            Share via Facebook
                        </a>
                    </div>
                    <div class="table_wrpr">
                        <table class="referals-table" id="referrals-table">
                            <thead>
                            <tr>
                                <th>
                                    Referrals
                                    {{ "({$referrals->count()})" }}
                                </th>
                                <th>Status</th>
                                <th>
                                    Earned
                                    <span>
                                        (${{ $referrals->where('status', \App\Models\Referral::STATUSES['active'])->count() * \App\Models\Setting::key('amountInviterGets')->first()->data }})
                                    </span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($referrals as $referral)
                                <tr>
                                    <td>
                                        <a href="mailto:{{ optional($referral->user)->email ?? $referral->user_email }}"
                                           class="link__muted">
                                            {{ optional($referral->user)->email ?? $referral->user_email }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="referals-table__wrapper">
                                            @if($referral->isPending())
                                                Invited
                                            @elseif($referral->isActive())
                                                Code used
                                                <img src="{{ asset('assets/frontend/img/Yes.svg') }}"
                                                     alt="Arrow success icon">
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($referral->isActive())
                                            ${{\App\Models\Setting::key('amountInviterGets')->first()->data}}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="bottom-gradient bottom-gradient-inner"></div>
        </div>
        @include('frontend.layouts.partials.subscribe-left-aligned')
        @include('frontend.layouts.partials.app.footer')
    </div>
@endsection

@section('popups')
    @if(!empty($joinMode))
        @include('frontend.landing.partials.popups.login', ['redirectUrl' => url()->current()])
        @include('frontend.landing.partials.popups.register', ['redirectUrl' => url()->current()])
    @endif
    @if($isAuthenticated)
        @include('frontend.referrals.partials.popups.edit-referral-code')
        @include('frontend.referrals.partials.popups.share-via-email')
        @include('frontend.referrals.partials.popups.share-via-link')
    @endif
@endsection

@push('js')
    <script src="{{ asset('assets/frontend/js/referrals.js') }}"></script>
@endpush
