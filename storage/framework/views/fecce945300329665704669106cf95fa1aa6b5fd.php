<?php if(session()->has('response-message') && is_string(session()->get('response-message')) || !empty($fromFrontendResponse)): ?>
    <?php if(!empty($mobileView)): ?>
        <div class="mobile_top_notif <?php echo e(session()->get('response-message-style') ?? ''); ?>"
             style="<?php echo e(empty($fromFrontendResponse) ? '' : 'display: none;'); ?>">
            <span><?php echo e(empty($fromFrontendResponse) ? session()->get('response-message') : ''); ?></span>
        </div>
    <?php else: ?>
        <div
            class="success-order-info success_order_info_in_content <?php echo e(empty($fromFrontendResponse) ? 'active' : ''); ?> <?php echo e(session()->get('response-message-style') ?? ''); ?>">
            <span><?php echo e(empty($fromFrontendResponse) ? session()->get('response-message') : ''); ?></span>
            <img src="<?php echo e(asset('assets/frontend/img/close-white.svg')); ?>" class="success-order-info__close"
                 alt="Close icon"
                 style="cursor: pointer;">
        </div>
    <?php endif; ?>

    <?php if(!empty($flash)): ?>
        <?php (session()->flash('response-message')); ?>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH F:\Gitlab Project\atlanta\resources\views/frontend/layouts/partials/app/alerts/session-response-message.blade.php ENDPATH**/ ?>