<?php
require_once('./lib/Stripe.php'); 
/*Stripe::setApiKey("hzKG6oNLVXaJpipg5j2AWqv0gl90MQZi"); 
Stripe_Charge::create(array( "amount" => 400, 
							"currency" => "usd",
							"card" => "tok_2WOnvOKOR0Cpz5", // obtained with stripe.js 
							"description" => "Charge for site@stripe.com") ); 



*/



// get the credit card details submitted by the form
$token = $_POST['stripeToken'];


// set your secret key: remember to change this to your live secret key in production
// see your keys here https://manage.stripe.com/account
Stripe::setApiKey("hzKG6oNLVXaJpipg5j2AWqv0gl90MQZi");

// create a Customer
$customer = Stripe_Customer::create(array(
  "card" => $token,
  "description" => "payinguser@example.com")
);

// charge the Customer instead of the card
Stripe_Charge::create(array(
  "amount" => 1000, # amount in cents, again
  "currency" => "usd",
  "customer" => $customer->id)
);

// save the customer ID in your database so you can use it later
saveStripeCustomerId($user, $customer->id);

// later
$customerId = getStripeCustomerId($user);

Stripe_Charge::create(array(
    "amount" => 1500, # $15.00 this time
    "currency" => "usd",
    "customer" => $customerId)
);


?>