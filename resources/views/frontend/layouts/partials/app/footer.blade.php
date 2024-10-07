<div class="footer- mt-16">
    <div class="footer__container flex">
        <div class="footer__logo">
            <img src="{{ asset('assets/frontend/img/home__logo-footer.svg') }}" alt="Logo">
        </div>
        <div class="company-info-block">
            <span class="b">Atlanta Meal Prep, LLC.</span>
            <span>
                    <a href="https://maps.google.com/?q={{ $supportLocation }}" target="_blank">{{ $supportLocation }}</a>
                </span>
            <span>
                    <a href="tel:{{ $supportPhoneNumber }}">{{ $supportPhoneNumber }}</a>
                </span>
            <span>
                    <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>
                </span>
            <ul class="company-info-block__social-links">
                <li>
                    @if(!empty($socialMediaData['facebook']))
                        <a href="{{ $socialMediaData['facebook'] }}" target="_blank">
                            <img src="{{ asset('assets/frontend/img/icon-facebook.svg') }}" alt="Facebook icon">
                        </a>
                    @endif
                    @if(!empty($socialMediaData['twitter']))
                        <a href="{{ $socialMediaData['twitter'] }}" target="_blank">
                            <img src="{{ asset('assets/frontend/img/icon-twitter.svg') }}" alt="Twitter icon">
                        </a>
                    @endif
                    @if(!empty($socialMediaData['instagram']))
                        <a href="{{ $socialMediaData['instagram'] }}" target="_blank">
                            <img src="{{ asset('assets/frontend/img/icon-instagram.svg') }}" alt="Instagram icon">
                        </a>
                    @endif
                </li>
            </ul>
        </div>
        <div class="footer__copyright">
            © {{ date('Y') }} Atlanta Meal Prep, LLC.
        </div>
    </div>
</div>
