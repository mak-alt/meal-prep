

<?php $__env->startSection('content'); ?>
   
<p>Please wait...</p>
	<script src="https://js.stripe.com/v3/"></script>
	<script type="text/javascript">
		var stripe = Stripe('<?php echo env('DEV_STRIPE_PK') ?>');
		stripe.redirectToCheckout({
		  sessionId: '<?php echo $sessionId ?>'
		}).then(function (result) {
			console.log(result);
		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Gitlab Project\atlanta\resources\views/dummy/index.blade.php ENDPATH**/ ?>