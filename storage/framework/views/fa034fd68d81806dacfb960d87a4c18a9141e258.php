<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $__env->yieldContent('seo:title', $seoData['title'] ?? ''); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $__env->yieldContent('seo:description', $seoData['description'] ?? ''); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('seo:keywords', $seoData['keywords'] ?? ''); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" href="favicon.ico">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="<?php echo e('https://www.googletagmanager.com/gtag/js?id=' . $googleAnalyticsID); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '<?php echo e($googleAnalyticsID); ?>');
    </script>

    <?php echo $__env->make('frontend.layouts.partials.app.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('css'); ?>
</head>
<body <?php echo e($bodyClasses ?? ''); ?>>
    <?php if (empty(trim($__env->yieldContent('mobile-header')))): ?>
        <?php if (empty(trim($__env->yieldContent('mobile-popups')))): ?>
            <?php echo $__env->make('frontend.layouts.partials.app.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make('frontend.layouts.partials.app.header', ['classes' => 'mobile_header_notif'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php echo $__env->yieldContent('mobile-popups'); ?>
    <?php echo $__env->yieldContent('mobile-header'); ?>

    <main>
        <div class="module__dashboard <?php echo e($contentClasses ?? ''); ?>">
            <?php if(empty($noSidebar)): ?>
            <?php echo $__env->make('frontend.layouts.partials.app.left-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
            <?php echo $__env->yieldContent('popups'); ?>
        </div>

        <?php echo $__env->yieldContent('footer'); ?>
    </main>

    <?php echo $__env->make('frontend.layouts.partials.app.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('js'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\atlanta\resources\views/frontend/layouts/app.blade.php ENDPATH**/ ?>