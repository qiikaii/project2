<head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <head>
        <title>Jackson</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel= "stylesheet" href ="css/main.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <script defer src="js/main.js" type="text/javascript"></script>
    </head>
<h1>*****</h1>
<?php
include "header.inc.php";
include "session.php";


define("DBHOST", "161.117.122.252");
define("DBNAME", "p2_3");
define("DBUSER", "p2_3");
define("DBPASS", "8sG4RNsso8");

$handphone = $postal = $address = $card = $expday = $expmonth = $cvv = $namecard  = $errorMsg = "";
$slash = "/";

$success = true;

if (empty($_POST["handphone"]))
{
$errorMsg .= "Handphone is required.<br>";
$success = false;
}
else
{
$handphone = sanitize_input($_POST["handphone"]);
}



if (empty($_POST["postal"]))
{
$errorMsg .= "Postal Code is required.<br>";
$success = false;
}
else
{
$postal = sanitize_input($_POST["postal"]);
}



if (empty($_POST["address"]))
{
$errorMsg .= "Postal Code is required.<br>";
$success = false;
}
else
{
$address = sanitize_input($_POST["address"]);
}



if (empty($_POST["card"]))
{
$errorMsg .= "Credit Card Number is required.<br>";
$success = false;
}
else
{
$card = sanitize_input($_POST["card"]);
}



if (empty($_POST["expday"]))
{
$errorMsg .= "Expiry Date is required.<br>";
$success = false;
}
else
{
$expday = sanitize_input($_POST["expday"]);
}




if (empty($_POST["expmonth"]))
{
$errorMsg .= "Email is required.<br>";
$success = false;
}
else
{
$expmonth = sanitize_input($_POST["expmonth"]);
}



if (empty($_POST["cvv"]))
{
$errorMsg .= "CVV name is required.<br>";
$success = false;
}
else
{
$cvv = sanitize_input($_POST["cvv"]);
}



if (empty($_POST["namecard"]))
{
$errorMsg .= "Password is required.<br>";
$success = false;
}
else
{
$namecard = sanitize_input($_POST["namecard"]);
}



$_SESSION['acc_id'] = 66871025;
$shipped = $_SESSION['shipped'] = 'N';  
$order_total_price = $_SESSION['order_total_price '] = 50;
  
   
    if (!isset($_SESSION['acc_id'])) {
        $errorMsg = "Please login to check out!";
        $sucess = false;
        } 
        else {
            $acc_id = $_SESSION['acc_id'];
            $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($conn->connect_error)
        {$errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
        } 
        else{
            $sql = "DELETE FROM cart WHERE acc_id ='{$_SESSION['acc_id']}'";
            echo "cart items deleted";
            $sql1 = "INSERT INTO order_info (acc_id, order_total_price, shipped,address, handphone, postal_code)";$sql1 
            .= " VALUES('{$_SESSION['acc_id']}', '$order_total_price', '$shipped' , '$address', '$handphone', '$postal')";
            echo "insert into order_info table";
            
        if (!$conn->query($sql))
        {
            $errorMsg = "Database error: " . $conn->error;
            $success = false;
        
        } 
        if (!$conn->query($sql1))
        {
            $errorMsg = "Database error: " . $conn->error;
            $success = false;
        
        } 
        }
  $conn->close();
}

//if(isset($_POST['checkout'])){
//    $handphone = $_POST['handphone']; 
//    $postal = $_POST['postal'];
//    $address = $_POST['address'];
//
//    
//    
//    
//}



if ($success)   
{
    echo '<section class="container"><hr>';
    echo "<h1>Your payment is successful!</h1>";
    echo ("{$_SESSION['acc_id']}"."<br />");
    echo "<h2>Thank you for shopping with us!</h2><br>";
    echo "<h2>Your handphone number is: ".$handphone."</h2><br>"; 
    echo "<h2>Your Postal Code is: ".$postal."</h2><br>"; 
    echo "<h2>Your Address is: ".$address."</h2><br>"; 
    echo "<h2>Your order_ID is: ".$expday.$slash.$expmonth."</h2><br>";    
    echo '<a href="index.php" class="btn btn-default" role="button">Return to Home</a></section><hr>';
    saveMemberToDB();
}
else            
{
    echo '<section class="container"><hr>';
    echo '<h1>Oops!</h1>';
    echo '<h2>The following errors were detected:</h2>';
    echo '<p>' . $errorMsg . '</p>';
    echo '<a href="checkout.php" class="btn btn-default" role="button">Return to Checkout</a></section><hr>';
}



//Helper function that checks input for malicious or unwanted content.
function sanitize_input($data)
{
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}

include "footer.inc.php";




 

function saveMemberToDB(){
    global $handphone, $postal, $address, $card , $expday , $expmonth , $cvv, $namecard, $errorMsg , $success;
    $card = MD5($card);
    // Create connection
    $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    //Check connection
    if ($conn->connect_error)
    {$errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
    }
    else
    {
    $sql = "INSERT INTO test (handphone, postalcode, address, cardno, expirymonth, expiryyear, cvv, namecard)";$sql .= " VALUES('$handphone', '$postal', '$address', '$card', '$expday', '$expmonth', '$cvv', '$namecard')";
//    $sql = "DELETE FROM cart WHERE acc_id ='{$_SESSION['acc_id']}'";
    // Execute the queryif (!$conn->query($sql))   
    if (!$conn->query($sql))
    {
        $errorMsg = "Database error: " . $conn->error;
        $success = false;
        
    }   
  }
  $conn->close();
}



//function creditcard(){
//    global  $card ,$acc_id, $cvv, $namecard, $expday, $expmonth , $date, $errorMsg;
//    $card = MD5($card);
//    $date = date('$expmonth_$expday_d-H-i-s');
//    $slash = "/";
//    $mmyy = "$expday$slash$expmonth";
//    // Create connection
//    $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
//    //Check connection
//    if ($conn->connect_error)
//    {$errorMsg = "Connection failed: " . $conn->connect_error;
//    $success = false;
//    }
//    else
//    {
//    $sql = "INSERT INTO credit_card (card_no, acc_id, exp_date, ccv, card_name)";$sql .= " VALUES('$card', '$acc_id',  '$date', '$cvv','$namecard')";
//    // Execute the queryif (!$conn->query($sql))   
//    if (!$conn->query($sql))
//    {
//        $errorMsg = "Database error: " . $conn->error;
//        $success = false;
//        
//    }   
//  }
//  $conn->close();
//}




//function test(){
//    global $handphone, $postal, $address, $acc_id , $order_total_price , $shipped, $errorMsg , $success;
//    $acc_id = 35324387; $order_total_price = 50;$shipped = 'N';  $address = 'hg';
//    $handphone = 98989;
//    $postal = 12345;
//    // Create connection
//    $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
//    //Check connection
//    if ($conn->connect_error)
//    {$errorMsg = "Connection failed: " . $conn->connect_error;
//    $success = false;
//    }
//    else
//    {
//    $sql = "INSERT INTO order_info (order_id, acc_id, order_total_price, shipped,address, handphone, postal_code)";$sql 
//            .= " VALUES('$acc_id', '$order_total_price', '$shipped' , '$address', '$handphone', '$postal')";
//   
//    if (!$conn->query($sql))
//    {
//        $errorMsg = "Database error: " . $conn->error;
//        $success = false;
//    }   
//  }
//  $conn->close();
//}
