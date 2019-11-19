<?php

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function actionCartFunc() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $acc_id = $_SESSION['acc_id'];
    $errorMsg = "";
    $success = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST["updatecart"]) && !isset($_POST["deletecart"])) {
            $errorMsg = "Please submit the form from the cart page.<br>";
            $success = false;
        }

        if (isset($_POST["updatecart"])) {
            include 'dbcon.inc.php';
            if (empty($_POST["cartitemid"])) {
                $errorMsg .= "Invalid item.<br>";
                $success = false;
            } else {
                $item_id = sanitize_input($_POST["cartitemid"]);
                $existitem = false;
                if (!preg_match('/^[0-9]{1,2}$/', $item_id)) {
                    $errorMsg .= "Invalid item.<br>";
                    $success = false;
                } else {
                    $checkitem = "SELECT item_id FROM item WHERE item_id = '$item_id'";
                    $result = $conn->query($checkitem);
                    if ($result->num_rows != 1) {
                        $errorMsg .= "Invalid item.<br>";
                        $success = false;
                    }
                    $result->free_result();
                }
            }

            if (empty($_POST["cartquantity"])) {
                $errorMsg .= "Invalid quantity.<br>";
                $success = false;
            } else {
                $cartquantity = sanitize_input($_POST["cartquantity"]);
                if (!preg_match('/^[0-9]{1,2}$/', $cartquantity)) {
                    $errorMsg .= "Invalid quantity.<br>";
                    $success = false;
                }
            }

            if ($success == true) {
                if ($cartquantity <= 0) {
                    $errorMsg .= "Invalid quantity.<br>";
                    $success = false;
                } else if ($cartquantity >= 99) {
                    $cartquantity = 99;
                    $sql = "UPDATE cart SET quantity = '$cartquantity' WHERE acc_id = '$acc_id' AND item_id = '$item_id'";
                    $result = $conn->query($sql);
                    $conn->close();
                    header("location:cartpage.php");
                } else {
                    $sql = "UPDATE cart SET quantity = '$cartquantity' WHERE acc_id = '$acc_id' AND item_id = '$item_id'";
                    $result = $conn->query($sql);
                    $conn->close();
                    header("location:cartpage.php");
                }
            } else {
                $conn->close();
            }
        }


        if (isset($_POST["deletecart"])) {
            include 'dbcon.inc.php';
            if (empty($_POST["cartitemid"])) {
                $errorMsg .= "Invalid item.<br>";
                $success = false;
            } else {
                $item_id = sanitize_input($_POST["cartitemid"]);
                if (!preg_match('/^[0-9]{1,2}$/', $item_id)) {
                    $errorMsg .= "Invalid item.<br>";
                    $success = false;
                } else {
                    $checkitem = "SELECT item_id FROM item WHERE item_id = '$item_id'";
                    $result = $conn->query($checkitem);
                    if ($result->num_rows != 1) {
                        $errorMsg .= "Invalid item.<br>";
                        $success = false;
                    }
                    $result->free_result();
                }
            }

            if (empty($_POST["cartquantity"])) {
                $errorMsg .= "Invalid quantity.<br>";
                $success = false;
            } else {
                $cartquantity = sanitize_input($_POST["cartquantity"]);
                if (!preg_match('/^[0-9]{1,2}$/', $cartquantity)) {
                    $errorMsg .= "Invalid quantity.<br>";
                    $success = false;
                }
            }

            if ($success == true) {
                $sql = "DELETE FROM cart WHERE acc_id = '$acc_id' AND item_id = '$item_id'";
                $conn->query($sql);
                $conn->close();
                header("location:cartpage.php");
            } else {
                $conn->close();
            }
        }
    } else {
        $errorMsg = "Please submit the form from the cart page.<br>";
        $success = false;
    }

    if (!$success) {
        echo "<section class=\"middle\">
    <h4>The following input errors were detected:</h4>
    <p> $errorMsg </p>
    </section>";
    }
}
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <title>DELTA - CART</title>
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <meta name = "description" content = "Top 1 self-designed fashion in Singapore">
        <meta name = "keyword" content = "fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.css"> 
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/errorstyling.css">
    </head>

    <body>
        <main>
            <?php
            include 'header.inc.php';
            actionCartFunc();
            include 'footer.inc.php';
            ?>
        </main>
    </body>
</html>
