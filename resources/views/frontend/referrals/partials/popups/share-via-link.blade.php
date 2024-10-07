<div class="popup_wrpr popup-success mobile-full" id="share-via-link-popup">
    <div class="popup_wrpr_inner">
        <div class="popup popup_style2">
            <div class="popup_heading">
                <a href="" class="close_popup_btn" data-action="close-popup">
                    <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
                    <img class="mob-close" src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
                </a>
                <h3>Share via Link</h3>
            </div>
            <div class="popup_content">
                <h3>Share via Link</h3>
                <h4 class="mb-18">
                    Copy this link
                    <span class="mob-hidden">
                        to share your referral code with your friends, family and neighbors through any social media or as text.
                    </span>
                </h4>
                <div class="copy-link">
                    {{ route('frontend.referrals.join', auth()->user()->referral_code) }}
                </div>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item" data-action="close-popup">
                    <a href="" class="btn btn_transparent">Cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn-green" data-action="copy-referral-link"
                            data-initial-data="Copy link">
                        Copy link
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
