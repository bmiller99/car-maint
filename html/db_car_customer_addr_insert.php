<?php 

// let me see if I can have a "main" inside this file and call the function.  Then maybe I can
// keep it here while I call it from somewhere else
// this is wasteful to check if defined for every execution, but beats commenting out
// just trying to come up with a strategy for self testing functions
// use the C strategy of all caps for defines`

// ---------------------------------------------------------------------------
// define (MAIN_TEST, 'YES');

if (defined ('MAIN_TEST')) {
   $customerData = array();
   $customerData['customerId'] = "1";
   $customerData['addrType'] = "hm";  //home
   $customerData['address1'] = "123 Any St";
   $customerData['address2'] = "apt 101";
   $customerData['city'] = "Anycity";
   $customerData['state'] = "NJ";
   $customerData['zipcode'] = "12345";

   echo "\n" . "Car Customer Address Insert: calling" . "\n";
   $msg = '';
   $ret = dbCarCustomerAddrInsert ($customerData, $msg);
   echo "\n" . "Car Customer Address Insert: Complete" . "\n";
}

// --------------------------------------------------------------------------
// A simple funtion to insert customer address data into the db
// Connects to Database 
// input: customerData array
// --------------------------------------------------------------------------

function dbCarCustomerAddrInsert ( $customerData = array(), &$msg ) {

// just hardcoding for now, should come from a config file

$host = "localhost";
$user = "root";
$pw   = "123456";
$db   = "car_maintenance";

$ret = 0;
$msg = '';

$db_conn = new mysqli($host, $user, $pw, $db);
if ($db_conn->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
echo $db_conn->host_info . "\n";

// just some variables to hold data, these will come from the form

//get the customer id from the session variable which is passed from the customer form

$custId   = $customerData['customerId'];
$addrType = $customerData['addrType'];
$address1 = $customerData['address1'];
$address2 = $customerData['address2'];
$city     = $customerData['city'];
$state    = $customerData['state'];
$zipcode  = $customerData['zipcode'];

$stmt = $db_conn->prepare("Insert into address (customer_id, address_type, address1, address2, 
                           city, state, zip_code)
        values (?,?,?,?,?,?,?)");

$stmt->bind_param("issssss", $custId, $addrType, $address1, $address2, $city, $state, $zipcode);

$stmt->execute();

// Need a specific table error message
echo "insert errno: ".$db_conn->errno.", msg: ".$db_conn->error."\n";

if ($db_conn->errno) {
   echo "insert failed, errno: ".$db_conn->errno.", msg: ".$db_conn->error."\n";
   $ret = -2;
   goto skip;
}

skip:

$stmt->close();

$db_conn->close();

return $ret;

}

?> 
