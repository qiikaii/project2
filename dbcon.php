<?php
define("DBHOST", "161.117.122.252");
define("DBNAME", "p2_3");
define("DBUSER", "p2_3");
define("DBPASS", "8sG4RNsso8");
$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME); //connect to database
// $con = mysqli_connect("localhost","root","P@5sword","absfit") // Go to root.localhost to set password.
if (!$conn){
	die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}
?>