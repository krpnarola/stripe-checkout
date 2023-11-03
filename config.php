<?php
$productName = 'APPLE 15';
$productID = "AP-5111";
$productPrice = 50;
$currency = "usd"; 

/* 
 * Stripe API configuration 
 */
define('STRIPE_API_KEY', 'sk_test_NTFiLROEmc6LRRAXubw9pNFY00Gk3v0bQi'); 
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_CEDSYMElWNMGXvabz07TSvVm00MjOxMstt'); 
define('STRIPE_SUCCESS_URL', 'http://localhost/php-test/stripe-demo/success.php'); //Payment success URL 
define('STRIPE_CANCEL_URL', 'http://localhost/php-test/stripe-demo/cancel.php'); //Payment cancel URL 

// Database configuration    
define('DB_HOST', 'localhost');   
define('DB_USERNAME', 'root'); 
define('DB_PASSWORD', '');   
define('DB_NAME', 'stripe_demo'); 

?>