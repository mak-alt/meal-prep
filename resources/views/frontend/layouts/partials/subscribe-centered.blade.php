<section class="subscribe" style="background: linear-gradient(0deg, rgba(41, 63, 148, 0.66),rgba(41, 63, 148, 0.66)), url({{asset($sub_photo)}});">
    <div class="home__subscribe-wrapper">
        <h2 class="subscribe_title">{{getInscriptions('sing-up-title',request()->path(),'Sign Up For Updates, Events & Recipes!')}}</h2>
        <form action="{{ route('frontend.newsletter.subscribe') }}" method="POST" id="subscribe-to-newsletter-form">
            @csrf
            <div class="subscribe_form flex">
                <input type="email" name="email" class="input" placeholder="alice234@gmail.com" required>
                <button type="submit" class="btn btn-green">{{getInscriptions('sing-up-button',request()->path(),'Sign me up')}}</button>
            </div>
        </form>
        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'email'])
    </div>
</section>
