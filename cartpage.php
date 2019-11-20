<?php

function cartPageFunc()
{
    $errorMsg = "";
    $success = true;
    $cartsuccess = true;

    if (!isset($_SESSION['acc_id'])) {
        $errorMsg = "Please login to add items to your cart.<br>";
        $cartsuccess = false;
    } else {
        $acc_id = $_SESSION['acc_id'];
        include 'dbcon.inc.php';
        if ($conn->connect_error) {
            $errorMsg = "Connection failed: " . $conn->connect_error;
            $success = false;
        } else {
            $sql = $conn->prepare("SELECT COUNT(*) AS count FROM cart WHERE acc_id = ?");
            $sql->bind_param('i', $acc_id);
            $sql->execute();
            $result = $sql->get_result();
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
                $totalprice = 0;
                $cartsql = $conn->prepare("SELECT * FROM cart WHERE acc_id = ?");
                $cartsql->bind_param('i', $acc_id);
                $cartsql->execute();
                $cartresult = $cartsql->get_result();

                $rowitem = array();
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
                    $itemsql = $conn->prepare("SELECT * FROM item WHERE item_id = ?");
                    $itemsql->bind_param('i', $rowitem[$i]);
                    $itemsql->execute();
                    $itemresult = $itemsql->get_result();
                    $itemrow = $itemresult->fetch_assoc();
                    $itemresult->free_result();

                    $itemprice = $itemrow['product_price'];
                    $size = $itemrow['size'];
                    $imgsrc = $itemrow['img_source'];
                    $itemname = $itemrow['product_name'];

                    echo "<form name=\"cartform\" action=\"actioncart.php\" method=\"post\">
                <article class=\"row justify-content-center align-self-center\" id=\"cartreveal\">
                <section class=\"col-sm-4\">
                <article class=\"cartitempic\">
                <figure><img src=\"$imgsrc\" alt=\"$itemname\"></figure>
                </article>
                <p> $itemname ($size) </p>
                <p> Price: $$itemprice</p>
                <label for=\"cartquantity\"><input type=\"number\" class=\"qtyupdate\" name=\"cartquantity\" id=\"cartquantity\" 
                placeholder=\"$rowquan[$i]\" value=\"$rowquan[$i]\" min=\"1\" max=\"99\" autocomplete=\"off\" required pattern=\"^[0-9]{1,2}$\"></label>
                <input type=\"submit\" name=\"updatecart\" value=\"Update\">
                <p class=\"cartreveal\"> Total: $" . $itemprice * $rowquan[$i] . "</p>
                <input type=\"hidden\" name=\"cartitemid\" value=\"$rowitem[$i]\" required pattern=\"^[0-9]{1,2}$\">
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
                <label for=\"cartquantity\"><input type=\"number\" class=\"qtyupdate\" name=\"cartquantity\" id=\"cartquantity\" 
                placeholder=\"$rowquan[$i]\" value=\"$rowquan[$i]\" min=\"1\" max=\"99\" autocomplete=\"off\" required pattern=\"^[0-9]{1,2}$\"></label>
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
                <input type=\"hidden\" name=\"cartitemid\" value=\"$rowitem[$i]\" required pattern=\"^[0-9]{1,2}$\">
                <input type=\"submit\" name=\"deletecart\" value=\"Remove\">
                </article>
                </section>
                </article>
                </form>";
                    $totalprice += $itemprice * $rowquan[$i];
                    $i++;
                }

                echo "<article class=\"row\">
            <section class=\"bottomcart\">
            <article class=\"col-sm-12\">
            <p> Total Price: $$totalprice</p>
            </article>
            </section>
            </article>
            </section>";

                echo "<section class=\"container-fluid\">
            <article class=\"row\">
            <section class=\"bottomcart\">
            <article class=\"col-sm-12\">
            <a href=\"checkout.php\"><button class=\"cartbutton\" value=\"checkout\"> Proceed to Check Out </button></a>
            <a href=\"index.php\"><button class=\"cartbutton\" value=\"continue_shopping\"> Continue Shopping </button></a>
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
    <h1>The following input errors were detected:</h1>
    <p>" . $errorMsg . "</p>
    </section></section>";
    }

    if (!$cartsuccess) {
        echo "<section class=\"middle\">
        <h1>" . $errorMsg . "</h1>
        </section>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/cartpage.css">
    <link rel="stylesheet" href="css/errorstyling.css">
    <script src="js/cartpage.js"></script>
</head>

<body>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include 'header.inc.php';
    ?>
    <main>
        <?php
        cartPageFunc();
        ?>
    </main>
    <?php
    include 'footer.inc.php';
    ?>
</body>

</html>