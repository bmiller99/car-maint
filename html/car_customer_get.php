<?php

// function to get the session data from customer to show on the address page

// this will echo the data but I cant put the data on the form.  why ????

// echo "car customer get";

session_start ();
$first_name = $_SESSION['fname'];
$last_name  = $_SESSION['lname'];

echo $first_name;
echo $last_name;

die();
?>
