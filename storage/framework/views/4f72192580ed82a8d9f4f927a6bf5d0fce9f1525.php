<section class="subscribe" style="background: linear-gradient(0deg, rgba(41, 63, 148, 0.66),rgba(41, 63, 148, 0.66)), url(<?php echo e(asset($sub_photo)); ?>);">
    <div class="home__subscribe-wrapper">
        <h2 class="subscribe_title"><?php echo e(getInscriptions('sing-up-title',request()->path(),'Sign Up For Updates, Events & Recipes!')); ?></h2>
        <form action="<?php echo e(route('frontend.newsletter.subscribe')); ?>" method="POST" id="subscribe-to-newsletter-form">
            <?php echo csrf_field(); ?>
            <div class="subscribe_form flex">
                <input type="email" name="email" class="input" placeholder="alice234@gmail.com" required>
                <button type="submit" class="btn btn-green"><?php echo e(getInscriptions('sing-up-button',request()->path(),'Sign me up')); ?></button>
            </div>
        </form>
        <?php echo $__env->make('frontend.layouts.partials.app.alerts.input-error', ['isAjax' => true, 'name' => 'email'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</section>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/layouts/partials/subscribe-centered.blade.php ENDPATH**/ ?>