
<html>
<head>
<title>Retrieve Name from session </title>
</head>

<style>
h1 {
    font-size: 40px;
}

h2 {
    font-size: 25;
}

h3 {
    font-size: 20px;
}

f {
    font-size: 20px;
}
</style>

<body>

<?php

// function to get the session data from customer to show on the address page

// this will echo the data but I cant put the data on the form.  why ????

// echo "car customer get";

session_start ();
$first_name = $_SESSION['fname'];
$last_name  = $_SESSION['lname'];

echo "<br />";
echo "<f>" . $first_name . " " . $last_name . "</f> <br />";
// echo $last_name  . "<br />";

?>

<form name="carcustomeraddress" method="post" action="car_customer_addr_insert.php">

<h2>Customer Address </h2>
<br>

<table width="450px">
</tr>
<tr>
 <td valign="top">
  <label for="address_type">Address Type</label>
 </td>
 <td>
  <input  type="text" name="address_type" maxlength="2" size="2">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="address1">Address 1 *</label>
 </td>
 <td valign="top">
  <input  type="text" name="address1" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="address2">Address 2</label>
 </td>
 <td valign="top">
  <input  type="text" name="address2" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="city">City *</label>
 </td>
 <td valign="top">
  <input  type="text" name="city" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="state">State *</label>
 </td>
 <td valign="top">
  <input  type="text" name="state" maxlength="2" size="2">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="zipcode">Zip Code *</label>
 </td>
 <td valign="top">
  <input  type="text" name="zipcode" maxlength="5" size="5">
 </td>
</tr>
<tr>
 <td colspan="2" style="text-align:center">
  <input type="submit" name="b1" value="Save" >
 </td>
</tr>
</table>
</form>


</body>
</html>
