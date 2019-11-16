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
<?php
include "header.php";
session_start();
$handphone = $postal = $address = $card = $expday = $expmonth = $cvv = $namecard  = $errorMsg = "";
$success = true;
// ANDY CODES START HERE
$acc_id = $_SESSION['acc_id'];
$address = $_POST['address']; // temporary measure
$postal = $_POST['postal']; //Temporary measure
// ANDY CODES END HERE
   
            // START OF ANDY CODES
            $existorder_id = true;
            include 'dbcon.php';
            do {
                $order_id = mt_rand(1000000, 99999999);
                $checkorder_id = ("SELECT order_id FROM order_info WHERE order_id = '$order_id'");
                $results = $conn->query($checkorder_id);
                if ($results->num_rows == 1) {
                    $existorder_id = true;
                } 
                else {
                    $results->free_result();
                    $cartsql = "SELECT * FROM cart WHERE acc_id = '$acc_id'";
                    $cartresults = $conn->query($cartsql);
                    
                    if ($cartresults->num_rows == 0) {
                        //print error here
                        //
                        // PRINT ERROR HERE
                    }
                    else {
                        $rowitem = array();
                        $rowquan = array();
                        $i = 0;
                        $count = 0;
                        $totalprice = 0;
                        $shipped = 'N';
                        
                        while ($cartrow = $cartresults->fetch_assoc()) {
                        $item_id = $cartrow['item_id'];
                        $quantity = $cartrow['quantity'];
                        $rowitemid[] = $item_id;
                        $rowquan[] = $quantity;
                        $checkpricesql = "SELECT product_price FROM item WHERE item_id = '$item_id'";
                        $checkpriceresults = $conn->query($checkpricesql);
                        $checkpricerow = $checkpriceresults->fetch_assoc();
                        $price = $checkpricerow['product_price'];
                        $totalprice += ($price * $quantity);
                        $count += 1;
                        }       
                        $checkpriceresults->free_result();
                        $current_time = date('Y-m-d H:i:s');
                        $orderinfosql = "INSERT INTO order_info (order_id, acc_id, order_date, order_totalprice, address, postal_code, shipped)"
                       . " VALUES ('$order_id', '$acc_id', '$current_time', '$totalprice', '$address', '$postal', '$shipped')"; 
                        $conn->query($orderinfosql);
                        
                        
                        while ($i < $count) {
                            $orderitemsql = "INSERT INTO order_item (order_id, item_id, quantity) VALUES ('$order_id', '$rowitemid[$i]', '$rowquan[$i]')"; 
                            $conn->query($orderitemsql);
                            $i++;
                        }
                        $deletecart = "DELETE FROM cart WHERE acc_id = '$acc_id'";
                        $conn->query($deletecart);
                        $conn->close();
                        $existorder_id = false;
                    }
                }
            } while ($existorder_id == true);
            
            // END OF ANDY CODES
            
      
      
if ($success)   
{
    echo '<section class="container"><hr>';
    echo "<h1>Your payment is successful!</h1>";
    echo "<h2>Thank you for shopping with us!</h2><br>";
    echo "<h2>Your Postal Code is: ".$postal."</h2><br>"; 
    echo $order_id, $acc_id, $current_time, $totalprice, $address, $postal, $shipped;
    echo "<h2>Your Address is: ".$address."</h2><br>";  
    echo '<a href="index.php" class="btn btn-default" role="button">Return to Home</a></section><hr>';

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

include "footer.php";
?>