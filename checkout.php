<?php
require_once('config.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title>Checkout</title>
  <script src="https://js.stripe.com/v3/"></script>
  <style type="text/css">
  	.hidden{
  		display: none;
  	}
  </style>
</head>
<body>
	<!-- Product details-->
	<h2><?php echo isset($productName) ? $productName : ''; ?> </h2>
	<p>Price: <b>$<?php echo isset($productPrice) ? $productPrice.' '.(isset($currency) ? $currency :'') : '';  ?></b></p>

	<!-- Payment button -->
	<button class="stripe-button" id="payButton">
	    <div class="spinner hidden" id="spinner">Loading..</div>
	    <span id="buttonText">Pay Now</span>
	</button>

	<!-- Display errors returned by checkout session -->
	<div id="paymentResponse" class="hidden"></div>

</body>
<script type="text/javascript">
	// See your keys here: https://dashboard.stripe.com/apikeys
	const stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');


	// Select payment button
	const payBtn = document.querySelector("#payButton");

	// Payment request handler
	payBtn.addEventListener("click", function (evt) {
	    setLoading(true);
		createCheckoutSession().then(function (data) {
			console.log('data:', data);
	        if(data.sessionId){
	        	// alert(data.sessionId);
	            stripe.redirectToCheckout({
	                sessionId: data.sessionId,
	            }).then(handleResult);
	        }else{
	            handleResult(data);
	        }
	    });
	});

	// Create a Checkout Session with the selected product
	const createCheckoutSession = function (stripe) {
	    return fetch("payment_init.php", {
	        method: "POST",
	        headers: {
	            "Content-Type": "application/json",
	        },
	        body: JSON.stringify({
	            createCheckoutSession: 1,
	        }),
	    }).then(function (result) {
	    	setLoading(false);	
	        return result.json();
	    });
	};

	// Handle any errors returned from Checkout
	const handleResult = function (result) {
	    if (result.error) {
	        showMessage(result.error.message);
	    }
	    
	    setLoading(false);
	};

	// Show a spinner on payment processing
	function setLoading(isLoading) {
	    if (isLoading) {
	        // Disable the button and show a spinner
	        payBtn.disabled = true;
	        document.querySelector("#spinner").classList.remove("hidden");
	        document.querySelector("#buttonText").classList.add("hidden");
	    } else {
	        // Enable the button and hide spinner
	        payBtn.disabled = false;
	        document.querySelector("#spinner").classList.add("hidden");
	        document.querySelector("#buttonText").classList.remove("hidden");
	    }
	}

	// Display message
	function showMessage(messageText) {
	    const messageContainer = document.querySelector("#paymentResponse");
		
	    messageContainer.classList.remove("hidden");
	    messageContainer.textContent = messageText;
		
	    setTimeout(function () {
	        messageContainer.classList.add("hidden");
	        messageText.textContent = "";
	    }, 5000);
	}

  // var stripe = Stripe('pk_test_CEDSYMElWNMGXvabz07TSvVm00MjOxMstt');
  // const btn = document.getElementById("checkout-button")
  // btn.addEventListener('click', function(e) {
  //   e.preventDefault();
  //   stripe.redirectToCheckout({
  //     sessionId: "<?php echo isset($session->id) ? $session->id : ''; ?>"
  //   });
  // });
</script>
</html>