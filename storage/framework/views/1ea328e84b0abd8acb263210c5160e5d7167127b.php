<?php if(empty($hideOnMobile)): ?>
    <div class="content_header <?php echo e($classes ?? ''); ?>">
        <h1 class="content_header_title"><?php echo e($title ?? ''); ?></h1>
    </div>
<?php else: ?>
    <div class="mobile-none">
        <div class="content_header <?php echo e($classes ?? ''); ?>">
            <h1 class="content_header_title"><?php echo e($title ?? ''); ?></h1>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/layouts/partials/app/content-header.blade.php ENDPATH**/ ?>