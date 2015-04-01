<?php

// function to valdate the car customer address input data and then invoke
// the function to insert into the database 

include 'db_car_customer_addr_insert.php';

function died($error) {
   // your error code can go here
   echo "We're sorry, but there's errors found with the form you submitted.<br /><br />";
   echo $error."<br /><br />";
   echo "Please go back and fix these errors.<br /><br />";
   die();
}
	
// validation expected data exists
if (!isset($_POST['address_type']) ||
    !isset($_POST['address1']) ||
    !isset($_POST['address2']) ||
    !isset($_POST['city']) ||
    !isset($_POST['state']) ||
    !isset($_POST['zipcode'])) {
   died('We are sorry, but there appears to be a problem with the form you submitted.');		
}

// customer_id will come from the customer insert or possibly from a query with a name entered
// $customer_id = 1;
// FIXME


$address_type = $_POST['address_type']; // required
$address1 = $_POST['address1']; // required
$address2 = $_POST['address2']; // required
$city = $_POST['city']; // not required
$state = $_POST['state']; // required
$zipcode = $_POST['zipcode']; // required
	
$error_message = "";

$string_exp = "/^[A-Za-z .'-]+$/";
if(!preg_match($string_exp,$address1)) {
$error_message .= 'The address1 you entered does not appear to be valid.<br />';
}
// this should be optional.  test if it is set first, then validate
if(!preg_match($string_exp,$address2)) {
	$error_message .= 'The address2 you entered does not appear to be valid.<br />';
}
if(!preg_match($string_exp,$city)) {
  	$error_message .= 'The city you entered does not appear to be valid.<br />';
}
if(!preg_match($string_exp,$state)) {
  	$error_message .= 'The state you entered does not appear to be valid.<br />';
}
if(strlen($zipcode) < 5) {
  	$error_message .= 'The Zip Code you entered do not appear to be valid.<br />';
}
if(strlen($error_message) > 0) {
  	died($error_message);
}
$email_message = "Form details below.\n\n";
	
function clean_string($string) {
   $bad = array("content-type","bcc:","to:","cc:","href");
   return str_replace($bad,"",$string);
}

// create a session so that I can get the customer id from the customer screen

session_start ();

$customerId = $_SESSION["customerId"];

// echo "customer id: " . $customerId . "\n";

$customerData = array();
$customerData['customerId'] = $customerId;
$customerData['addrType'] = $address_type;
$customerData['address1'] = $address1;
$customerData['address2'] = $address2;
$customerData['city'] = $city;
$customerData['state'] = $state;
$customerData['zipcode'] = $zipcode;

$ret = dbCarCustomerAddrInsert ($customerData, $msg);

?>

<!-- place your own success html below -->

Thank you for contacting us. We will be in touch with you very soon.

<?php
die();
?>
