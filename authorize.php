<?php
require_once('vendor/autoload.php');

// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_OHaF8huGHhSC7dWMomEBJmJQ");

// Get the credit card details submitted by the form
$cid =  $_POST['cid'];
$amount = $_POST['amount'];
$description = $_POST['description'];

// Create the charge on Stripe's servers - this will charge the user's card
try {
  $charge = \Stripe\Charge::create(array(
    "amount" => $amount*100, // Convert amount in cents to dollar
    "currency" => "usd",
    "customer" => $cid,
    "capture" => False,
    "description" => $description)
  );

  // Check that it was paid:
  if ($charge->paid == true) {
    $response = array( 'status'=> 'Success', 'message'=>'Payment has been charged!!' );
  } else { // Charge was not paid!
    $response = array( 'status'=> 'Failure', 'message'=>'Your payment could NOT be processed because the payment system rejected the transaction. You can try again or use another card.' );
  }
  header('Content-Type: application/json');
  echo json_encode($response);

} catch(\Stripe\Error\Card $e) {
  // The card has been declined
}

?>
