<?php
require_once('vendor/autoload.php');

// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_OHaF8huGHhSC7dWMomEBJmJQ");

// Get the credit card details submitted by the form
$token =  $_POST['token'];
$name = $_POST['name'];
$email = $_POST['email'];

// Create the charge on Stripe's servers - this will charge the user's card
try {
  $customer = \Stripe\Customer::create(array(
    "source" => $token,
    "description" => $name,
    "email" => $email)
  );

  // Check that it was paid:
  // if ($customer->paid == true) {
    $response = array( 'status'=> 'Success', 
                       'message'=>'Payment has been charged!!',
                       'cust_id'=>$customer
                );
  // } else { // Charge was not paid!
    // $response = array( 'status'=> 'Failure', 'message'=>'Your payment could NOT be processed because the payment system rejected the transaction. You can try again or use another card.' );
  // }
  header('Content-Type: application/json');
  echo json_encode($response);

} catch(\Stripe\Error\Card $e) {
  // The card has been declined
}

?>
