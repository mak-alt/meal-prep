<section class="subscribe">
    <h2 class="subscribe_title">Sign Up For Updates, Events & Recipes!</h2>
    <div class="subscribe_form">
        <form action="{{ route('frontend.newsletter.subscribe') }}" method="POST" id="subscribe-to-newsletter-form">
            @csrf
            <input type="email" name="email" class="input" placeholder="alice234@gmail.com" required>
            <button type="submit" class="btn btn-green">Sign me up</button>
        </form>
        @include('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'email'])
    </div>
</section>
