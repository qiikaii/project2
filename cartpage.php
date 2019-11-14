<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>DELTA - CART</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Top 1 self-designed fashion in Singapore">
        <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/cartpage.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/errorstyling.css">
        <!-- Prevent ClickJacking -->
   	<meta http-equiv="X-Frame-Options" content="deny">
    </head>
</html>

<?php
include 'header.php';
$success = true;
$cartsuccess = true;
//TO BE DELETED
session_start();
//TO BE DELETED 
$_SESSION['acc_id'] = 67191009;
if (!isset($_SESSION['acc_id'])) {
    $errorMsg = "Please login to add items to your cart";
    $cartsuccess = false;
 
} else {
    $acc_id = $_SESSION['acc_id'];
    include 'dbcon.php';
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        $sql = "SELECT COUNT(*) AS count FROM cart WHERE acc_id = '$acc_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $result->free_result();
        $count = $row['count'];
        if ($count < 1) {
            $errorMsg = "You don't have any items in your cart";
            $cartsuccess = false;
            $conn->close();
        } else {
            $item_id = 0;
            $quantity = 0;

            $cartsql = "SELECT * FROM cart WHERE acc_id = '$acc_id'";
            $cartresult = $conn->query($cartsql);

            $rowitem = array(); // Insert item id in the array
            $rowquan = array();
            $i = 0;

            while ($cartrow = $cartresult->fetch_assoc()) {
                $rowitem[] = $cartrow['item_id'];
                $rowquan[] = $cartrow['quantity'];
            }
            $cartresult->free_result();
            
            echo "<section class=\"container-fluid\">
                <article class=\"row\" id=\"cartheadhide\">
                <section class=\"col-sm-4\">
                <article class=\"cartheader\">
                <p> Item </p>
                </article>
                </section>
                <section class=\"col-sm-4\">
                <article class=\"cartheader\">
                <p> Item Name </p>
                </article>
                </section>
                <section class=\"col-sm-1\">
                <article class=\"cartheader\">
                <p>Price</p>
                </article>
                </section>
                <section class=\"col-sm-1\">
                <article class=\"cartheader\">
                <p> Qty </p>
                </article>
                </section>
                <section class=\"col-sm-1\">
                <article class=\"cartheader\">
                <p> Total</p>
                </article>
                </section>
                <section class=\"col-sm-1\">
                <article class=\"cartheader\">
                <p> Delete </p>
                </article>
                </section>
                </article>";

            while ($i != $count) {
                $itemsql = "SELECT * FROM item WHERE item_id = '$rowitem[$i]'";
                $itemresult = $conn->query($itemsql);
                $itemrow = $itemresult->fetch_assoc();
                $itemresult->free_result();

                $itemprice = $itemrow['product_price'];
                $size = $itemrow['size'];
                $imgsrc = $itemrow['img_source'];
                $quantity = $itemrow['quantity'];
                $itemname = $itemrow['product_name'];

                echo "<form name=\"cartform\" action=\"htmlspecialchars(\"actioncart.php\")\" method=\"post\">
                <article class=\"row justify-content-center align-self-center\" id=\"cartreveal\">
                <section class=\"col-sm-4\">
                <article class=\"cartitempic\">
                <figure><img src=\"$imgsrc\" alt=\"$itemname\"></figure>
                </article>
                <p> $itemname ($size) </p>
                <p> Price: $$itemprice</p>
                <p> Qty: <input type=\"number\" class=\"qtyupdate\" name=\"cartquantity\" placeholder=\"$rowquan[$i]\" value=\"$rowquan[$i]\" min=\"1\" max=\"99\" autocomplete=\"off\" required></p>
                <input type=\"submit\" name=\"updatecart\" value=\"Update\">
                <p class=\"cartreveal\"> Total: $" . $itemprice * $rowquan[$i] . "</p>
                <input type=\"hidden\" name=\"cartitemid\" value=\"$rowitem[$i]\"</td>
                <input type=\"submit\" name=\"deletecart\" value=\"Remove\">
                </section>
                </article>
                </form>

                <form name=\"cartform\" action=\"actioncart.php\" method=\"post\">
                <article class=\"row justify-content-center align-self-center\" id=\"cartitemhide\">
                <section class=\"col-sm-4\">
                <article class=\"cartitempic\">
                <figure><img src=\"$imgsrc\" alt=\"$itemname\"></figure>
                </article>
                </section>
                <section class=\"col-sm-4\">
                <article class=\"cartitem\">
                <p> $itemname ($size) </p>
                </article>
                </section>
                <section class=\"col-sm-1\">
                <article class=\"cartitem\">
                <p>$$itemprice</p>
                </article>
                </section>
                <section class=\"col-sm-1\">
                <article class=\"cartitem\">
                <input type=\"number\" class=\"qtyupdate\" name=\"cartquantity\" placeholder=\"$rowquan[$i]\" value=\"$rowquan[$i]\" size=\"2\" min=\"1\" max=\"99\" autocomplete=\"off\" required>
                <input type=\"submit\" name=\"updatecart\" value=\"Update\">
                </article>
                </section>
                <section class=\"col-sm-1\">
                <article class=\"cartitem\">
                <p> $" . $itemprice * $rowquan[$i] . "</p>
                </article>
                </section>
                <section class=\"col-sm-1\">
                <article class=\"cartitem\">
                <input type=\"hidden\" name=\"cartitemid\" value=\"$rowitem[$i]\"</td>
                <input type=\"submit\" name=\"deletecart\" value=\"Remove\">
                </article>
                </section>
                </article>
                </form>";

                $i++;
            }
            
            echo "<section class=\"container-fluid\">
            <article class=\"row\">
            <section class=\"bottomcart\">
            <article class=\"col-sm-12\">
            <a href=\"checkout.php\"><button class=\"cartbutton\"> Proceed to Check Out </button></a>
            </article>
            </section>
            </article>
            </section>";
            $conn->close();
        }
    }
}

if (!$success) {
    echo "<section class=\"middle\">
    <h4>The following input errors were detected:</h4>
    <p>" . $errorMsg . "</p>
    </section>";
}

if (!$cartsuccess) {
    echo "<section class=\"middle\">
    <p>" . $errorMsg . "</p>
    </section>";
}

include 'footer.php';
?>
