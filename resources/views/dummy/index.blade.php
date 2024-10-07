@extends('frontend.layouts.app')

@section('content')
   
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
@endsection
