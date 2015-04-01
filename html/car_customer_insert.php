<?php

// function to valdate the car customer input data and then invoke
// the function to insert into the database 

include 'db_car_customer_insert.php';
include 'db_car_customer_query.php';

// all this code is base in this "if" - do i need this

if(isset($_POST['email'])) {
	
   // CHANGE THE TWO LINES BELOW
   $email_to = "you@yourdomain.com";

   $email_subject = "website html form submissions";
	
	
   function died($error) {
      // your error code can go here
      echo "We're sorry, but there's errors found with the form you submitted.<br /><br />";
      echo $error."<br /><br />";
      echo "Please go back and fix these errors.<br /><br />";
      die();
   }
	
   // validation expected data exists
   if (!isset($_POST['first_name']) ||
       !isset($_POST['last_name']) ||
       !isset($_POST['email']) ||
       !isset($_POST['telephone']) ||
       !isset($_POST['comments'])) {
      died('We are sorry, but there appears to be a problem with the form you submitted.');		
   }
	
   $first_name = $_POST['first_name']; // required
   $last_name = $_POST['last_name']; // required
   $email_from = $_POST['email']; // required
   $telephone = $_POST['telephone']; // not required
   $comments = $_POST['comments']; // required
	
   $error_message = "";
   $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
   if(!preg_match($email_exp,$email_from)) {
  	$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
   }

   $string_exp = "/^[A-Za-z .'-]+$/";
   if(!preg_match($string_exp,$first_name)) {
  	$error_message .= 'The First Name you entered does not appear to be valid.<br />';
  }
  if(!preg_match($string_exp,$last_name)) {
  	$error_message .= 'The Last Name you entered does not appear to be valid.<br />';
  }
  if(strlen($comments) < 2) {
  	$error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
  if(strlen($error_message) > 0) {
  	died($error_message);
  }
  $email_message = "Form details below.\n\n";
	
  function clean_string($string) {
     $bad = array("content-type","bcc:","to:","cc:","href");
     return str_replace($bad,"",$string);
  }

  // create a session so that I can pass variables to subsequent pages

  session_start ();

  $_SESSION['fname'] = $first_name;
  $_SESSION['lname'] = $last_name;

  $customerData = array();
  $customerData['fname'] = $first_name;
  $customerData['lname'] = $last_name;
  $customerData['phone'] = $telephone;
  $customerData['email'] = $email_from;
  $customerData['comment'] = $comments;

   $msg = '';
   $ret = dbCarCustomerInsert ($customerData, $msg);

   if ($ret != 0) {
      echo "DB Insert cuastomer failure" . ", ret = " . $ret;
      // what should i do to the form
   }

   $msg = '';
   $ret = 0;
   $ret - dbCarCustomerQuery ($customerData, $msg);
   if ($ret != 0) {
      echo "DB Failure: customer id retrieval failed:" . ", ret = " . $ret;
      // what to do to the form
   }

   $customerId = $customerData['customerId'];
   echo "customerId: " . $customerId . "\n";

   $_SESSION['customerId'] = $customerId;

	
//   $email_message .= "First Name: ".clean_string($first_name)."\n";
//   $email_message .= "Last Name: ".clean_string($last_name)."\n";
//   $email_message .= "Email: ".clean_string($email_from)."\n";
//   $email_message .= "Telephone: ".clean_string($telephone)."\n";
//   $email_message .= "Comments: ".clean_string($comments)."\n";
	
	
//   create email headers
//   $headers = 'From: '.$email_from."\r\n".
//   'Reply-To: '.$email_from."\r\n" .
//   'X-Mailer: PHP/' . phpversion();
   //bmiller comment out
   //@mail($email_to, $email_subject, $email_message, $headers);  

?>

<!-- place your own success html below -->

Thank you for contacting us. We will be in touch with you very soon.

<?php
}
die();
?>
