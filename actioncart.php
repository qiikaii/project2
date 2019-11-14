<?php

session_start();
$acc_id = $_SESSION['acc_id'];

if (isset($_POST["updatecart"])) {

    if (empty($_POST["cartitemid"])) {
        $errorMsg .= "Invalid item.<br>";
        $success = false;
    } else {
        $item_id = sanitize_input($_POST["cartitemid"]);
        if (!preg_match('/^[0-9]{0,2}$/', $item_id)) {
            $errorMsg .= "Invalid item.<br>";
            $success = false;
        }
    }

    if (empty($_POST["cartquantity"])) {
        $errorMsg .= "Invalid quantity.<br>";
        $success = false;
    } else {
        $cartquantity = sanitize_input($_POST["cartquantity"]);
        if (!preg_match('/^[0-9]{0,2}$/', $cartquantity)) {
            $errorMsg .= "Invalid quantity.<br>";
            $success = false;
        }
    }

    // Check stock of item purchased
    include 'dbcon.php';
    $sql = "SELECT quantity FROM item WHERE item_id = '$item_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $result->free_result();
    $stock = $row['quantity'];

    // If item requested to place in cart more than stock, you can only request to what the stock avail.
    if ($cartquantity > $stock) {
        $cartquantity = $stock;
    }

    // If cart quantity less than or equal to 0, delete from cart
    if ($cartquantity <= 0) {
        $sql = "DELETE FROM cart WHERE acc_id = '$acc_id' AND item_id = '$item_id'";
        $result = $conn->query($sql);
        $conn->close();
        header("location:cartpage.php");
    }

    // Cannot update more than 99 values
    if ($cartquantity >= 99) {
        $cartquantity = 99;
        $sql = "UPDATE cart SET quantity = '$cartquantity' WHERE acc_id = '$acc_id' AND item_id = '$item_id'";
        $result = $conn->query($sql);
        $conn->close();
        header("location:cartpage.php");
    }

    // Update item quantity in cart
    else {
        $sql = "UPDATE cart SET quantity = '$cartquantity' WHERE acc_id = '$acc_id' AND item_id = '$item_id'";
        $result = $conn->query($sql);
        $conn->close();
        header("location:cartpage.php");
    }
} else if (isset($_POST["deletecart"])) {

    if (empty($_POST["cartitemid"])) {
        $errorMsg .= "Invalid item.<br>";
        $success = false;
    } else {
        $item_id = sanitize_input($_POST["cartitemid"]);
        if (!preg_match('/^[0-9]{0,2}$/', $item_id)) {
            $errorMsg .= "Invalid item.<br>";
            $success = false;
        }
    }

    if (empty($_POST["cartquantity"])) {
        $errorMsg .= "Invalid quantity.<br>";
        $success = false;
    } else {
        $cartquantity = sanitize_input($_POST["cartquantity"]);
        if (!preg_match('/^[0-9]{0,2}$/', $cartquantity)) {
            $errorMsg .= "Invalid quantity.<br>";
            $success = false;
        }
    }

    include 'dbcon.php';
    $sql = "DELETE FROM cart WHERE acc_id = '$acc_id' AND item_id = '$item_id'";
    $result = $conn->query($sql);
    $conn->close();
    header("location:cartpage.php");
    
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
?>
