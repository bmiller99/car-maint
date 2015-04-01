<?php 

// let me see if I can have a "main" inside this file and call the function.  
// Then maybe I can keep it here while I call it from somewhere else
// this is wasteful to check if defined for every execution, but beats commenting 
// out just trying to come up with a strategy for self testing functions
// use the C strategy of all caps for defines`

// ---------------------------------------------------------------------------
// define ('MAIN_TEST', 'YES');

if (defined ('MAIN_TEST')) {
   $customerData = array();
   $customerData['fname'] = "Billtest";
   $customerData['lname'] = "Millertest";
   $customerData['phone'] = "888-555-1212";
   $customerData['email'] = "billtest@blah.com";
   $customerData['comment'] = "billtest comment line 1";

   echo "\n" . "dbCarCustomerInsert: calling" . "\n";
   $msg = "";
   $ret = 0;
   $ret = dbCarCustomerInsert ($customerData, &$msg);
   echo "\n" . "dbCarCustomerInsert: Complete" . "\n";
}

// --------------------------------------------------------------------------
// A simple funtion to insert patient data into the db
// Connects to Database 
// input: customerData array
// --------------------------------------------------------------------------

function dbCarCustomerInsert ( $customerData = array(), $msg ) {

$ret = 0;

// just hardcoding for now, should come from a config file

$host = "localhost";
$user = "root";
$pw   = "123456";
$db   = "car_maintenance";

$db_conn = new mysqli($host, $user, $pw, $db);
if ($db_conn->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
   $msg = "DB Connect fatal error";
   $ret = -2;
   return ret;
}
// echo $db_conn->host_info . "\n";

// just some variables to hold data, these will come from the form

$fname = $customerData['fname'];
$lname = $customerData['lname'];
$phone = $customerData['phone'];
$email = $customerData['email'];
$comment = $customerData['comment'];

$stmt = $db_conn->prepare("Insert into customer (name_first, name_last, phone, 
        email_address, comments) values (?,?,?,?,?)");

$stmt->bind_param("sssss", $fname, $lname, $phone, $email, $comment);

$stmt->execute();

// echo "insert errno: ".$db_conn->errno.", msg: ".$db_conn->error."\n";

// successful is same as oracle, 0 is good
if ($db_conn->errno) {
   // echo "insert failed, errno: ".$db_conn->errno.", msg: ".$db_conn->error."\n";
   $msg = "insert failed, errno: ".$db_conn->errno.", msg: ".$db_conn->error."\n";
   $ret  = -2;
   goto skip;
}

// need to get the generated customer number so that I can pass it to future
// transactions;

skip:

$stmt->close();

$db_conn->close();

return $ret;

}

?> 
