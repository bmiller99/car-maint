<?php 

// ---------------------------------------------------------------------------
// query the customer table to get data based on first and last name.
//  - presumes no duplicates (at least for now)
//
// embedded "main" for testing purposes
// ---------------------------------------------------------------------------

// define ('MAIN_TEST', 'YES');

if (defined ('MAIN_TEST')) {
   $customerData = array();
   $customerData['fname'] = "bill";
   $customerData['lname'] = "millerb";

   $ret = 0;
   $msg = "";

   echo "\ndbCarCustomerQuery: calling\n";
   $ret = dbCarCustomerQuery ( $customerData, $msg );
   printf ("ret: %d, msg: %s\n", $ret, $msg);

   if ($ret == 0) {
      carCustomerDump ( $customerData );
   }
   echo "dbCarCustomerQuery: Complete\n";

   $ret = 0;
   $msg = "";
   $customerData['fname'] = "bill";
   $customerData['lname'] = "miller";

   echo "\ndbCarCustomerQuery: calling\n";
   $ret = dbCarCustomerQuery ( $customerData, $msg );
   printf ("ret: %d, msg: %s\n", $ret, $msg);

   if ($ret == 0) {
      carCustomerDump ( $customerData );
   }
   echo "dbCarCustomerQuery: Complete\n";

   $ret = 0;
   $msg = "";
   $customerData['fname'] = "junk";
   $customerData['lname'] = "junk";

   echo "\nCar Customer NO DATA\n";
   echo "\ndbCarCustomerQuery: calling\n";
   $ret = dbCarCustomerQuery ( $customerData, $msg );
   printf ("ret: %d, msg: %s\n", $ret, $msg);

   if ($ret == 0) {
      carCustomerDump ( $customerData );
   }
   echo "dbCarCustomerQuery: Complete\n";
}

// --------------------------------------------------------------------------
// A simple funtion to output customer data
// I: customerData array
// --------------------------------------------------------------------------
function carCustomerDump ( &$customerData = array() ) {

$fname = $customerData['fname'];
$lname = $customerData['lname'];
$customerId = $customerData['customerId'];
$phone = $customerData['phone'];
$email = $customerData['email'];
$comment = $customerData['comment'];
printf ("\nfname: %s, lname: %s, customer_id: %d, phone: %s, email: %s, comment: %s \n",
        $fname, $lname, $customerId, $phone, $email, $comment);
}


// --------------------------------------------------------------------------
// A simple funtion to query the customer
// Connects to Database 
// return code, 0 success, -x fatal error, +x not fatal but unexpected results
// I/O: customerData array
//   O: msg
// --------------------------------------------------------------------------

function dbCarCustomerQuery ( &$customerData = array(), &$msg ) {

// set return code to zero = ok
$ret = 0;

// set blank return msg to match no error
$msg = "";

// define return array
// $customerData = array();

// just hardcoding for now, should come from a config file

$host = "localhost";
$user = "root";
$pw   = "123456";
$db   = "car_maintenance";

$db_conn = new mysqli($host, $user, $pw, $db);
if ($db_conn->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
echo $db_conn->host_info . "\n";

// just some variables to hold data, these will come from the form

$fname = $customerData['fname'];
$lname = $customerData['lname'];

$stmt = $db_conn->prepare("select customer_id, phone, email_address, comments from customer 
                           where name_first = ? and name_last = ?");

$stmt->bind_param("ss", $fname, $lname);

$stmt->execute();

echo "select errno: ".$db_conn->errno.", msg: ".$db_conn->error."\n";

if ($db_conn->errno) {
   echo "select failed, errno: ".$db_conn->errno.", msg: ".$db_conn->error."\n";
   $ret = -1;
   $msg = "select failed";
   goto skip;
}

/* store result */
$stmt->store_result();

printf("Number of rows: %d.\n", $stmt->num_rows);

if ($stmt->num_rows == 0) {
   $ret = 1;  //  This is a problem but not a fatal error
   $msg = "No match";
   goto skip;
}

if ($stmt->num_rows > 1) {
   $ret = 2;  //  This is a problem but not a fatal error
   $msg = "More than 1 row for query";
   goto skip;
}

$stmt->bind_result($customerId, $phone, $email, $comment);

/* fetch value */
$stmt->fetch();

// printf ("fname: %s, lname: %s, customer_id: %d, phone: %s, email: %s, comment: %s \n",
//         $fname, $lname, $customerId, $phone, $email, $comment);

// pass back customer data

$customerData['customerId'] = $customerId;
$customerData['phone'] = $phone;
$customerData['email'] = $email;
$customerData['comment'] = $comment;

skip:

/* free result */
$stmt->free_result();

$stmt->close();

$db_conn->close();

return $ret;

}

?> 
