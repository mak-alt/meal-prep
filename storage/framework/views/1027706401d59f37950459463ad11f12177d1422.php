<footer class="footer">
    <div class="footer__container flex">
        <div class="footer__logo">
            <img src="<?php echo e(asset('assets/frontend/img/home__logo-footer.svg')); ?>" alt="Logo">
        </div>
        <div class="company-info-block">
            <span class="b">Atlanta Meal Prep, LLC.</span>
            <span>
                <a href="https://maps.google.com/?q=<?php echo e($supportLocation); ?>" target="_blank"><?php echo e($supportLocation); ?></a>
            </span>
            <span>
                <a href="tel:<?php echo e($supportPhoneNumber); ?>"><?php echo e($supportPhoneNumber); ?></a>
            </span>
            <span>
                <a href="mailto:<?php echo e($supportEmail); ?>"><?php echo e($supportEmail); ?></a>
            </span>
            <ul class="company-info-block__social-links">
                <li>
                    <?php if(!empty($socialMediaData['facebook'])): ?>
                        <a href="<?php echo e($socialMediaData['facebook']); ?>" target="_blank">
                            <img src="<?php echo e(asset('assets/frontend/img/icon-facebook.svg')); ?>" alt="Facebook icon">
                        </a>
                    <?php endif; ?>
                    <?php if(!empty($socialMediaData['twitter'])): ?>
                        <a href="<?php echo e($socialMediaData['twitter']); ?>" target="_blank">
                            <img src="<?php echo e(asset('assets/frontend/img/icon-twitter.svg')); ?>" alt="Twitter icon">
                        </a>
                    <?php endif; ?>
                    <?php if(!empty($socialMediaData['instagram'])): ?>
                        <a href="<?php echo e($socialMediaData['instagram']); ?>" target="_blank">
                            <img src="<?php echo e(asset('assets/frontend/img/icon-instagram.svg')); ?>" alt="Instagram icon">
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
        <div class="footer__copyright">
            © <?php echo e(date('Y')); ?> Atlanta Meal Prep, LLC.
        </div>
    </div>
</footer>
<?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/layouts/partials/landing/footer.blade.php ENDPATH**/ ?>