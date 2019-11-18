<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DELTA - CHECK OUT</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Top 1 self-designed fashion in Singapore">
        <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.css"> 
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/checkout.css">
        <script src="js/checkout.js"></script>
    </head>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "header.php";
$acc_id = $_SESSION['acc_id'];
$address = $postal = $errorMsg = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["checkoutbutton"])) {
        if (empty($_POST["address"])) {
            $errorMsg .= "Address is required.<br>";
            $success = false;
        } else {
            $address = sanitize_input($_POST["address"]);
            if (!preg_match('(?=^[A-Za-z]+\s?[A-Za-z]+$).{3,}', $address)) {
                $errorMsg .= "Invalid address format.<br>";
                $success = false;
            }
        }

        if (empty($_POST["postal"])) {
            $errorMsg .= "Postal code is required.<br>";
            $success = false;
        } else {
            $postal = sanitize_input($_POST["postal"]);
            if (!preg_match('^[0-9]{6}$', $postal)) {
                $errorMsg .= "Invalid postal code format.<br>";
                $success = false;
            }
        }

        if ($success == true) {
            $existorder_id = true;
            include 'dbcon.php';
            do {
                $order_id = mt_rand(1000000, 99999999);
                $checkorder_id = ("SELECT order_id FROM order_info WHERE order_id = '$order_id'");
                $results = $conn->query($checkorder_id);
                if ($results->num_rows == 1) {
                    $existorder_id = true;
                } else {
                    $results->free_result();
                    $cartsql = "SELECT * FROM cart WHERE acc_id = '$acc_id'";
                    $cartresults = $conn->query($cartsql);
                    if ($cartresults->num_rows == 0) {
                        $errorMsg = "There is no items in the cart.<br>";
                        $success = false;
                    } else {
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
        } 
    } else {
        $errorMsg = "Please submit the form from the check out page.<br>";
        $success = false;
    }
} else {
    $errorMsg = "Please submit the form from the check out page.<br>";
    $success = false;
}

if ($success)   
{
    echo "<section class=\"container\"><hr>
          <h1>Your check out is successful!</h1>
          <h2>Your address is $address S$postal</h2><br>
          <h2>Please paynow using the following QR code:</h2>
          <img src=\"qrcode.png\" alt=\"Delta QR Code\">

";}
else            
{
    echo '<section class="container"><hr>';
    echo '<h1>Oops!</h1>';
    echo '<h2>The following errors were detected:</h2>';
    echo '<p>' . $errorMsg . '</p>';
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