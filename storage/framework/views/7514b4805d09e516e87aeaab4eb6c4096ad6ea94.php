<section class="subscribe">
    <h2 class="subscribe_title">Sign Up For Updates, Events & Recipes!</h2>
    <div class="subscribe_form">
        <form action="<?php echo e(route('frontend.newsletter.subscribe')); ?>" method="POST" id="subscribe-to-newsletter-form">
            <?php echo csrf_field(); ?>
            <input type="email" name="email" class="input" placeholder="alice234@gmail.com" required>
            <button type="submit" class="btn btn-green">Sign me up</button>
        </form>
        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'email'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</section>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/layouts/partials/subscribe-left-aligned.blade.php ENDPATH**/ ?>